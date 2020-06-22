<?php

namespace App\Http\Controllers;

use App\Course;
use App\PurchaseStatus;
use App\User;
use Auth;
use App\Request as AppRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        $user_selector = ($user->type == 'teacher') ? 'teacher_id' : 'user_id';

        $query = AppRequest::with(['user', 'teacher', 'course', 'purchase'])
            ->where($user_selector, $user->id);

        $requests = $this->applyOffsetAndLimit($request, $query)
            ->latest(10)
            ->get()
            ->map(function ($r) {
                return $r->toResponse();
            });

        return response()->json($requests);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user_request = AppRequest::findOrFail($id);
        $user = Auth::user();
        $this->validateOwnership($user, $user_request);
        $user_request->load('user', 'teacher', 'course', 'purchase');

        if (!$user_request->is_seen && $user->id == $user_request->teacher_id) {
            $user_request->is_seen = 1;
            $user_request->save();
        }

        return response()->json($user_request->toResponse());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->type != 'student') {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $validated = $this->validate($request, [
            'teacher_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'requested_date' => 'required|date',
            'message' => 'max:255',
        ]);

        $validated['user_id'] = $user->id;
        if (!empty($request['purchase_status'])) {
            $validated['purchase_status'] = 1;
        }
        $new_request = AppRequest::create($validated);
        $new_request->save();
        $new_request->refresh();

        return response()->json($new_request->toResponse());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_request = AppRequest::findOrFail($id);
        $user = Auth::user();

        $this->validateOwnership($user, $user_request);
        $validated = $this->validate($request, [
            'message' => 'max:255',
            'response' => 'max:255',
        ]);

        $user_request->load('user', 'teacher', 'course');
        if ($user->id == $user_request->user_id) {
            unset($validated['response']);
        } else {
            unset($validated['message']);
            $validated['is_seen'] = 1;
            $validated['is_answered'] = 1;
        }

        $user_request->update($validated);
        return response()->json($user_request->toResponse());
    }

    public function approve(Request $request, $id)
    {
        $user_request = AppRequest::findOrFail($id);
        $user = Auth::user();

        if ($user->id != $user_request->teacher_id) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $user_request->load('user', 'teacher', 'course');
        $user_request->is_approved = 1;
        $user_request->is_answered = 1;
        if ($request->filled('response')) {
            $user_request->response = $request->input('response');
        }
        return response()->json($user_request->toResponse());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $user_request = AppRequest::findOrFail($id);
        $user = Auth::user();

        if ($user->id != $user_request->teacher_id) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $user_request->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Deleted',
        ], 501);

    }

    private function validateOwnership($auth_user, $user_request)
    {
        if ($auth_user->id != $user_request->user_id &&
            $auth_user->id != $user_request->teacher_id) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }
    }
}
