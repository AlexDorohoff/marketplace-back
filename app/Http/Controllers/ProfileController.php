<?php

namespace App\Http\Controllers;

use Auth;
use App\Tag;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $response = [
            'user' => $user->toResponse(),
            'account' => $user->account,
            'documents' => $user->documents,
        ];
        if ($user->type === 'teacher') {
            $response['courses'] = $user->courses;
            $response['requests'] = \App\Request::where('teacher_id', $user->id)
                ->where('is_answered', false)
                ->get()
                ->map(function ($r) {
                    return $r->toResponse();
                });
            $response['lessons'] = \App\TeacherLesson::where('user_id', $user->id)
                ->where('status', 'scheduled')
                ->get();
            $response['tags'] = $user->tags;
            $response['owned_tags'] = $user->ownedTags;
        } else if ($user->type === 'student') {
            $response['requests'] = $user->requests
                ->map(function ($r) {
                    return $r->toResponse();
                });
            $ids = $user->lessons()->distinct()->pluck('teacher_id', 'course_id');
            $response['courses'] = \App\Course::whereIn('id', $ids->keys())->get();
            $response['teachers'] = User::whereIn('id', $ids->values())
                ->get()
                ->map(function ($u) {
                    return $u->toResponse();
                });
        }

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $user = (new UserController)->updateUser(Auth::user(), $request);

        return response()->json([
            'user' => $user->toResponse(),
            'account' => $user->account,
        ]);
    }

    public function updateImage(Request $request)
    {
        $user = (new UserController)->updateUserImage(Auth::user(), $request);

        return response()->json([
            'user' => $user->toResponse(),
            'account' => $user->account,
        ]);
    }

    public function addTag($id)
    {
        $tag = Tag::findOrFail($id);
        $user = Auth::user();

        DB::insert('insert into taggables (tag_id, taggable_id, taggable_type) values (?, ?, ?)',
            [$tag->id, $user->id, 'App\User']);

        return response()->json([
            'tags' => $user->tags,
        ]);
    }

    public function removeTag($id)
    {
        $tag = Tag::findOrFail($id);
        $user = Auth::user();

        DB::delete('delete from taggables where tag_id=? AND taggable_id=? AND taggable_type=?',
            [$tag->id, $user->id, 'App\User']);

        return response()->json([
            'tags' => $user->tags,
        ]);
    }
}
