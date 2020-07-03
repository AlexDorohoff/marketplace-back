<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use test\Mockery\Stubs\Animal;

class ImageController extends Controller
{

    //добавить проверки на пренодлкжность пользователю

    public function list(Request $request)
    {
        $user = Auth::user();
        return response()->json(Image::all()->where('user_id', '=', $user->id));
    }

    public function show($id)
    {
        return response()
            ->json(Image::findOrFail($id));
    }

    public function create(Request $request)
    {
        if(Auth::user()->type !== 'teacher') {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $path = $this->uploadImage($request);
        if ($path) {

            $validated['path'] = $path;
            $validated['user_id'] = Auth::user()->id;
            $validated['is_public'] = false;

            $image = Image::create($validated);

            $image->save();
            $image->refresh();
            return response()->json($image);
        }
    }

    public function update($id, Request $request)
    {
        $image = Image::findOrFail($id);
        if(!Auth::user()->hasOwnership($image->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $path = $this->uploadImage($request);
        $validated['path'] = $path;
        $image->save();

        return response()->json($image);
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);

        if (!Auth::user()->hasOwnership($image->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        if (!$image->delete()) {
            return response()->json([
                'error_code' => 501,
                'error_message' => 'Not delete',
            ], 501);
        }

        return response()->json([
            'error_code' => 200,
            'error_message' => 'Deleted',
        ], 200);
    }

    public function getByUser()
    {
        $user = Auth::user();
        if ($user->type == 'teacher') {
            return response()->json($user->images);
        }
        throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'pdf', 'gif'])) {
                $url = '/path/' . $file->hashName();
                $file->move(public_path() . '/path', $file->hashName());
                return $url;
            }
        }
        return response()->json([
            'error_code' => 200,
            'error_message' => 'File does not image',
        ], 200);
    }
}
