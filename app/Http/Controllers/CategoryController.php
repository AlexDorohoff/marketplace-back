<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
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
}
