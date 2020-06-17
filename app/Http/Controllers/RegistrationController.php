<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $user = (new UserController)->createUser($request);
        if($user instanceof User) {
            $hash = md5('H' . $user->id . $user->email);
            DB::table('users_registrations')->insert([
                'hash' => $hash,
                'user_id' => $user->id,
                'created_at' => Carbon::now()
            ]);

            $response = $user->toResponse();
            $response['registration_id'] = $hash;
            return response()->json($response, 201);
        }
        return response()->json([
            'error_code' => 500,
            'error_message' => 'Error registering new user',
        ], 500);
    }

    public function validated($id)
    {
        $record = DB::table('users_registrations')->where('hash', $id)->first();
        if($record) {
            $user = User::findOrFail($record->user_id);
            $user->is_active = 1;
            $user->save();

            DB::table('users_registrations')->where('hash', $id)->delete();

            $account = new \App\FinanceAccount([
                'user_id' => $user->id,
            ]);
            $account->save();

            $response = $user->toResponse();
            $response['message'] = 'Registration was successful';
            return response()->json($response);
        }

        return response()->json([
            'error_code' => 404,
            'error_message' => 'Registration data not found',
        ], 404);
    }
}
