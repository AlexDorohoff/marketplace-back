<?php

namespace App\Http\Controllers;

use Auth;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
	public function list(Request $request)
	{
        $query = Tag::query();

		if($request->has('is_persistent')) {
            $query = $query->where('is_persistent', $request->input('is_persistent'));
        }

        $tags = $this->applyOffsetAndLimit($request, $query)->get();
        return response()->json($tags);
	}

    public function show($id) 
    {
        return response()
            ->json(Tag::findOrFail($id));
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            	'name' => 'max:255',
        	]);

        $tag = Tag::create([
        		'user_id' => Auth::user()->id,
        		'name' => $validated['name'],
        		'is_persistent' => false
        	]);

        $tag->save();
        return response()->json($tag, 201);
    }

    public function update($id, Request $request)
    {
        $validated = $this->validate($request, [
            	'name' => 'max:255',
        	]);

        $tag = Tag::findOrFail($id);
        if($tag->user->id != Auth::user()->id) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $tag->name = $validated['name'];
        if($request->has('is_persistent') && Auth::user()->type === 'admin') {
        	$tag->is_persistent = $request->input('is_persistent', false);
        }

        $tag->save();
        return response()->json($tag);
    }

    public function delete($id)
    {
        return response()->json([
            'error_code' => 501,
            'error_message' => 'Not implemented',
        ], 501);
    }
}
