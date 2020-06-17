<?php

namespace App\Http\Controllers;
use Auth;

use App\Course;
use App\Tag;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class CourseController extends Controller
{
    public const DEFAULT_COURSE_IMAGE = 'course-placeholder.png';

    public function list(Request $request)
    {
        // tag_ids = select id from tags where name in ('a', 'b')
        // select * from courses where 
        // (is_published or user_id = 'user_id') 
        // and (title like 'abcde%') 
        // and (id in select link_id from tag_links where tag_id in (tag_ids) and reference_type = 'courses')
        $query = Course::where('is_published', true)
            ->with(['user', 'documents', 'tags']);

        $courses = $this->applyOffsetAndLimit($request, $query)
            ->get();

        return response()->json($courses);
    }

    public function show($id) 
    {
        $course = Course::findOrFail($id);
        if(!$course->is_published && !Auth::user()->hasOwnership($course->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }
        $course->load('user', 'tags', 'documents');
        return response()->json($course);
    }

    public function create(Request $request)
    {
        if(Auth::user()->type !== 'teacher') {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $validated = $this->validate($request, [
            'title' => 'required|max:255',
            'price' => 'required|between:0,999999.99', 
            'duration' => 'required|integer', 
            'annotation' => 'required|max:255', 
            'description' => 'required', 
            'contents' => 'required'      
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['is_published'] = true;

        $course = Course::create($validated);
        $this->storeCourseImage($course, $request);

        $course->save();
        $course->refresh();

        return response()->json($course);
    }

    public function update($id, Request $request)
    {
        $course = Course::findOrFail($id);
        if(!Auth::user()->hasOwnership($course->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $validated = $this->validate($request, [
           'title' => 'filled|max:255',
           'price' => 'filled|between:0,999999.99', 
           'duration' => 'filled|integer', 
           'annotation' => 'filled|max:255', 
           'description' => 'filled', 
           'contents' => 'filled'            
       ]);

        $this->storeCourseImage($course, $request);
        $course->fill($validated);
        $course->save();

        return response()->json($course);
    }

    public function updateImage($id, Request $request)
    {
        $course = Course::findOrFail($id);
        if(!Auth::user()->hasOwnership($course->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $this->storeCourseImage($course, $request);
        $course->save();
        return response()->json($course);
    }

    public function delete($id)
    {
        return response()->json([
            'error_code' => 501,
            'error_message' => 'Not implemented',
        ], 501);
    }

    public function addTag($id, $tag_id)
    {
        $course = Course::findOrFail($id);
        if(!Auth::user()->hasOwnership($course->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $tag = Tag::findOrFail($tag_id);
        DB::insert('insert into taggables (tag_id, taggable_id, taggable_type) values (?, ?, ?)', 
            [$tag->id, $course->id, 'App\Course']);

        return response()->json([
            'tags' => $course->tags,
        ]);
    }

    public function removeTag($id, $tag_id)
    {
        $course = Course::findOrFail($id);
        if(!Auth::user()->hasOwnership($course->user_id)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access denied');
        }

        $tag = Tag::findOrFail($tag_id);
        DB::delete('delete from taggables where tag_id=? AND taggable_id=? AND taggable_type=?',
            [$tag->id, $course->id, 'App\Course']);

        return response()->json([
            'tags' => $course->tags,
        ]);
    }

    protected function getCourseImageName($course) 
    {
        if($course->image == null || $course->image === CourseController::DEFAULT_COURSE_IMAGE) {
            return md5('C'.$course->user_id.':'.$course->title.':'.time()) . '.jpg';
        }

        return $course->image;
    }

    protected function storeCourseImage($course, Request $request) 
    {
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $this->getCourseImageName($course);
            $manager = new ImageManager(['driver' => 'gd']);
            $manager->make($image)
                //->crop($request->input('width'), $request->input('height'), $request->input('offset-x'), $request->input('offset-y'))
                //->resize(300, 300)
            ->encode('jpg', 100)
            ->save(public_path('courses/' . $filename));
            $course->image = $filename;
        }
    }

}
