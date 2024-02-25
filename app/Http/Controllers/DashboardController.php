<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifyAdmin;
use App\Mail\NewStoryNotification;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //
        $stories = Story::where('status', 1)->get();
        $userIds = $stories->pluck('user_id')->unique()->toArray(); // Get unique user ids
        $users = User::whereIn('id', $userIds)->get()->keyBy('id'); // Fetch users by ids
        return Inertia::render('dashboard/Dashboard', [
            'stories' => $stories,
            'users' => $users
        ]);
    }

    public function show(Story $story)
    {
        $user = User::find($story->user_id);
        $story = $story->append('footnote');
        return Inertia::render('dashboard/Show', [
            'story' => $story,
            'user' => $user,
        ]);
    }

    public function email(){
       /* Mail::raw('This is the Test Email', function($message){
            $message->to('admin@localhost.com')
            ->subject('A New Story was Added');
        });*/

        Mail::to('admin@localhost.com')->send(new NewStoryNotification("Title of the story"));
        dd("Here");
    }
}