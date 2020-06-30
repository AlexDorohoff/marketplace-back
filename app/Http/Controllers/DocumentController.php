<?php

namespace App\Http\Controllers;

use App\Document;
use App\User;
use Illuminate\Http\Request;
use Auth;

class DocumentController extends Controller
{

    //добавить проверки на пренодлежность пользователю

    public function list(Request $request)
    {
        return response()->json(Document::all());
    }

    public function show($id)
    {
        return response()
            ->json(Document::findOrFail($id));
    }

    public function create(Request $request)
    {
        /*if(Auth::user()->type !== 'teacher') {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }*/

        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'course_id' => 'required|integer',
        ]);

        //$validated['user_id'] = Auth::user()->id;
        $validated['user_id'] = 3;
        $validated['is_public'] = false;

        $document = Document::create($validated);

        $document->save();
        $document->refresh();

        return response()->json($document);
    }

    public function update($id, Request $request)
    {
        return response()->json([
            'error_code' => 501,
            'error_message' => 'Not implemented',
        ], 501);
    }

    public function delete($id)
    {
        return response()->json([
            'error_code' => 501,
            'error_message' => 'Not implemented',
        ], 501);
    }

    public function getByUser()
    {
        $user = Auth::user();
        return response()->json($user);
        if ($user->type == 'teacher') {
            return response()->json($user->documents);
        }
    }

    public function loadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'pdf', 'gif'])) {
                $url = '/path/'. $file->hashName();
                $file->move(public_path() . '/path', $file->hashName());

            }
        }
    }

    public function getFileName()
    {

    }
}
