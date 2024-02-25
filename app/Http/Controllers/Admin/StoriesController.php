<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\User;
use Inertia\Inertia;

class StoriesController extends Controller
{
    //
    public function index()
    {
        //
        $stories = Story::onlyTrashed()->get();
        $userIds = $stories->pluck('user_id')->unique()->toArray();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id'); 
        return Inertia::render('Admin/Stories', [
            'stories' => $stories,
            'users' => $users,
        ]); 
    }

    public function restore($id)
    {   
        $story = Story::withTrashed()->findOrFail($id);
        $story->restore();
        return redirect()->route('admin.stories.index')->with(["status" => "Story restored successfully"]);
    }

    public function delete($id)
    {
        $story = Story::withTrashed()->findOrFail($id);
        $story->forceDelete();
        return redirect()->route('admin.stories.index')->with(["status" => "Story deleted successfully"]);
    }
}
