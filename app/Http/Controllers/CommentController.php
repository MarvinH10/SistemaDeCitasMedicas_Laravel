<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();

        return view('web.blogs.grid.index', compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        return view('web.blogs.grid.index', compact('comment'));
    }
}
