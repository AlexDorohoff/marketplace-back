<?php

namespace App\Http\Controllers;

use App\Document;
use App\User;
use Illuminate\Http\Request;
use Auth;

class DocumentController extends Controller
{
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
        return response()->json([
            'error_code' => 501,
            'error_message' => 'Not implemented',
        ], 501);
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
            $file->move(public_path() . '/path', 'filename.img');
        }
    }
}
