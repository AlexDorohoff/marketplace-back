<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

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
}
