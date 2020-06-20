<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PurchaseStatus;

class Request extends Model
{
    /* 
     *  $id
     *  $user_id
     *  $teacher_id
     *  $course_id
     *  $requested_date
     *  $message
     *  $response
     *  $is_seen
     *  $is_answered
     *  $is_approved
     *  $id_purchase_status
     */

    protected $fillable = [
        'user_id',
        'teacher_id',
        'course_id',
        'requested_date',
        'message',
        'response',
        'is_seen',
        'is_answered',
        'is_approved',
        'id_purchase_status'
    ];

    public function toResponse()
    {
        $response = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'teacher_id' => $this->teacher_id,
            'course_id' => $this->course_id,
            'requested_date' => $this->requested_date,
            'is_seen' => $this->is_seen,
            'is_answered' => $this->is_answered,
            'is_approved' => $this->is_approved,
        ];

        if ($this->message) {
            $response['message'] = $this->message;
        }

        if ($this->response) {
            $response['response'] = $this->response;
        }

        if (isset($this->relations['user'])) {
            $response['user'] = $this->user->toResponse();
        }

        if (isset($this->relations['teacher'])) {
            $response['teacher'] = $this->teacher->toResponse();
        }

        if (isset($this->relations['course'])) {
            $response['course'] = $this->course;
        }

        if (isset($this->relations['purchase'])) {
            $response['purchase'] = $this->purchase;
        }

        return $response;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function purchase()
    {
        return $this->hasOne('App\PurchaseStatus', 'id', 'id_purchase_status');
    }

}
