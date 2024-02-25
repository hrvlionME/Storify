<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewStoryNotification;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Story::class, 'story');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stories = Story::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Stories', [
            'stories' => $stories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return Inertia::render('Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|min:10|max:50|unique:stories',
            'body' => 'required|min:50',
            'type' => 'required',
            'status' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png'
        ]);

        $story = auth()->user()->stories()->create([
            'title' => $request->title,
            'body' => $request->body,
            'type' => $request->type,
            'status' => $request->status,
            'user_id' => auth()->user()->id
        ]);

        if ($request->hasFile('image')) {
            $this->_uploadImage($request, $story);
        }

        Mail::to('admin@localhost.com')->send(new NewStoryNotification($story->title));
        return redirect('/stories')->with(["success" => "Story added successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        //
        return Inertia::render('Show', [
            'story' => $story
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        //
        Mail::to('hrvlionme@gmail.com')->send(new NewStoryNotification($story->title));
        return Inertia::render('Edit', [
            'story' => $story
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        //
        $request->validate([
            'title' => 'required|min:10|max:50|unique:stories',
            'body' => 'required|min:50',
            'type' => 'required',
            'status' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png'
        ]);

        $story->update([
            'title' => $request->title,
            'body' => $request->body,
            'type' => $request->type,
            'status' => $request->status,
            'user_id' => auth()->user()->id
        ]);
        if ($request->hasFile('image')) {
            $this->_uploadImage($request, $story);
        }
        return redirect('/stories')->with(["success" => "Story updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        //
        $story->delete();
        return redirect('/stories')->with(["success" => "Story deleted successfully"]);
    }

    private function _uploadImage($request, $story)
    {

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $img = \Intervention\Image\ImageManagerStatic::make($image)->resize(225, 100)->save(public_path('storage/' . $filename));
        $story->image = $filename;
        $story->save();
    }
}
