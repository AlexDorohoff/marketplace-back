<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
	public function list(Request $request)
	{
        $query = User::with('courses', 'tags', 'categories')
            ->where('is_active', 1)
            ->where('type', 'teacher');

        $teachers = $this->applyOffsetAndLimit($request, $query)
            ->get();

        return response()->json($teachers);
	}

    public function show($id) 
    {
        $teacher = User::findOrFail($id);
        if(!$teacher->is_active || $teacher->type !== 'teacher') {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Specified teacher not found');
        }
        $teacher->load('courses', 'tags');
        return response()->json($teacher);
    }
}
