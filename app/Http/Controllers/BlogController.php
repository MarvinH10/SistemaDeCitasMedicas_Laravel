<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\DetailBlog;
use Laracasts\Flash\Flash;

class BlogController extends Controller
{
    public function bloggrid(Request $request)
    {
        $blogs = Blog::paginate(6);

        if ($request->ajax()) {
            if ($blogs->isEmpty()) {
                return '';
            }

            return view('web.blogs.grid.blogs', compact('blogs'));
        }

        if ($blogs->isEmpty()) {
            $noMoreBlogs = true;
        } else {
            $noMoreBlogs = false;
        }

        return view('web.blogs.grid.index', compact('blogs', 'noMoreBlogs'));
    }

    public function showLatest(Request $request)
    {
        $primerBlog = Blog::latest()->first();
        if ($primerBlog) {
            $comments = $primerBlog->comments;
            $userHasVisited = false;

            if ($request->user()) {
                $userHasVisited = $primerBlog->userViews->contains('user_id', $request->user()->id);
            }

            if (!$userHasVisited && $request->user()) {
                $primerBlog->userViews()->create([
                    'user_id' => $request->user()->id,
                ]);
            }
        } else {
            $comments = [];
            $userHasVisited = false;
        }
        $detailBlogs = DetailBlog::all();
        $recentBlogs = Blog::latest()->take(5)->get();

        return view('web.blogs.detail.index', compact('primerBlog', 'detailBlogs', 'comments', 'userHasVisited', 'recentBlogs'));
    }

    public function showdetails(Request $request, $id)
    {
        $primerBlog = Blog::findOrFail($id);
        $comments = $primerBlog->comments;
        $detailBlogs = DetailBlog::all();
        $recentBlogs = Blog::latest()->take(5)->get();

        $userHasVisited = false;

        if ($request->user()) {
            $userHasVisited = $primerBlog->userViews->contains('user_id', $request->user()->id);
        }

        if (!$userHasVisited && $request->user()) {
            $primerBlog->userViews()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return view('web.blogs.detail.index', compact('primerBlog', 'detailBlogs', 'comments', 'userHasVisited', 'recentBlogs'));
    }

    public function addComment(Request $request, $id){
        $request->validate([
            'content' => 'required',
        ]);

        $blog = Blog::find($id);

        if(auth()->check()){
            $comment = new Comment();
            $comment->content = $request->input('content');
            $comment->user_id = auth()->user()->id;
            $comment->blog_id = $blog->id;

            $parent_id = $request->input('parent_id');

            if($parent_id){
                $parentComment = Comment::find($parent_id);
                if (!$parentComment) {
                    return redirect()->back();
                }

                $parentComment->replies()->save($comment);
            }else{
                $blog->comments()->save($comment);
            }

            return redirect()->back();
        }else{
            return redirect()->route('login');
        }
    }

    public function appointment()
    {
        return view('web.blogs.appointment.index');
    }
}
