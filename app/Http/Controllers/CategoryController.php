<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryUser;
use App\Course;
use App\TeacherLesson;
use App\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        $query = Category::All();
        return response()->json($query);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function getByCourseId($course_id)//искать по товару
    {
        $course = Course::find($course_id);
        return response()->json($course->category);
    }

    public function getByTeacherId($teacher_id)//искать по продавцу
    {
        $user = User::find($teacher_id);

        if ($user->type == 'teacher') {
            return response()->json($user->categories);
        }
        throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
    }
}
