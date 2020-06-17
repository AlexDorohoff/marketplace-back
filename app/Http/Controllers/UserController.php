<?php

namespace App\Http\Controllers;

use Auth;
use Carbon;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function create(Request $request)
    {
        return response()->json(($this->createUser($request))
            ->toResponse(), 201
        );
    }

    public function list(Request $request)
    {
        $users = $this->applyOffsetAndLimit($request, User::query())
            ->get()
            ->map(function ($u) { 
                return $u->toResponse();
            });

        return response()->json($users);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id)
            ->toResponse()
    );
    }

    public function update($id, Request $request)
    {
		return response()->json(($this->updateUser(User::findOrFail($id), $request, true))
            ->toResponse()
        );
	}

    public function updateImage($id, Request $request)
    {
        return response()->json(($this->updateUserImage(User::findOrFail($id), $request))
            ->toResponse()
        );
    }

    public function delete($id)
    {
        return response()->json([
        	'error_code' => 501,
        	'error_message' => 'Not implemented',
        ], 501);
    }

    public function createUser(Request $request)
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|max:255',
            'type' => 'required|in:teacher,student'
        ]);

        $user = new User;
        $user->fill($validated);
        $user->password = app('hash')->make($validated['password']);
        $user->is_active = true;
        $user->save();
        $user->refresh();

        return $user;
    }

    public function updateUser(User $user, Request $request, $checkAndSetActive = false)
    {
        $validated = $this->validate($request, [
            'phone' => 'filled|numeric|unique:users',
            'name' => 'filled|max:255',
        ]);

        $user->fill($validated);
        
        if($checkAndSetActive && $request->filled('is_active')) {
        	$user->is_active = $request->input('is_active');
        }

        if($request->filled('password')) {
            $user->password = app('hash')->make($request->input('password'));
        }
        
        if($user->type === "teacher" && $request->has('profile')) {
            $user->profile = $request->input('profile');
        }

        $user->save();
        return $user;
    }

    public function updateUserImage(User $user, Request $request)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = md5($user->email) . '.jpg';
            
            $manager = new ImageManager(['driver' => 'gd']);
            $manager->make($image)
                //->crop($request->input('width'), $request->input('height'), $request->input('offset-x'), $request->input('offset-y'))
                //->resize(300, 300)
                ->encode('jpg', 100)
                ->save(public_path('avatars/' . $filename));
            $user->image = $filename;
            $user->save();
        }

        return $user;
    }
}
