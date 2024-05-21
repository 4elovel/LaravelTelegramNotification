<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostMailNotification;
use App\Notifications\PostTelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('posts-index', compact('posts'));
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        return view('post-show', compact('post'));
    }

    public function create()
    {
        return view('create-post');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        $post->save();
        $users = User::query()->where('notification_allowed',true)->get();
        $link = (url('/')) . '/posts/' . DB::table('posts')->latest('created_at')->first()->id;

        Notification::send($users,new PostTelegramNotification($post,$link));
        Notification::send($users,new PostMailNotification($post,$link));



        return redirect()->route('posts.create')->with('success', 'Пост створено успішно!');
    }
}
