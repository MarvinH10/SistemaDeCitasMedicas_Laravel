<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::blogs()->paginate(6);

        return view('blogs.publications.index', compact('blogs'));
    }

    public function create()
    {
    	return view('blogs.publications.create');
    }

    public function store(Request $request)
    {
    	$request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'archivo' => 'file|mimes:jpeg,jpg,png,gif,mp4,webm,quicktime|max:20480',
        ]);

        $blog = new Blog();
        $blog->titulo = $request->input('title');
        $descripcionSinTags = str_replace('<span class="br-tag"></span>', '', $request->input('description'));
        $blog->descripcion = $descripcionSinTags;

        $archivo = $request->file('archivo');
        if ($archivo) {
            $archivoNombre = $archivo->getClientOriginalName();
            $archivo->storeAs('public/blogs', $archivoNombre);
            $blog->archivo = 'storage/blogs/' . $archivoNombre;

            $extension = strtolower($archivo->getClientOriginalExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $blog->tipo = 'imagen';
            } elseif (in_array($extension, ['mp4', 'webm', 'quicktime'])) {
                $blog->tipo = 'video';
            }
        }

        $blog->save(); // INSERT

        $notification = 'La publicación se ha registrado correctamente';
        return redirect('/blogs')->with(compact('notification'));
    }

    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);

        return view('blogs.publications.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
    	$request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'archivo' => 'file|mimes:jpeg,jpg,png,gif,mp4,webm,quicktime|max:20480',
        ]);

        $blog->titulo = $request->input('title');
        $descripcionSinTags = str_replace('<span class="br-tag"></span>', '', $request->input('description'));
        $blog->descripcion = $descripcionSinTags;

        $archivo = $request->file('archivo');
        if ($archivo) {
            $archivoNombre = $archivo->getClientOriginalName();
            $archivo->storeAs('public/blogs', $archivoNombre);
            $blog->archivo = 'storage/blogs/' . $archivoNombre;

            $extension = strtolower($archivo->getClientOriginalExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $blog->tipo = 'imagen';
            } elseif (in_array($extension, ['mp4', 'webm', 'quicktime'])) {
                $blog->tipo = 'video';
            }
        }

        $blog->save(); // INSERT

        $notification = 'La publicación se ha actualizado correctamente';
        return redirect('/blogs')->with(compact('notification'));
    }

    public function destroy(Blog $blog)
    {
        $deletedBlog = $blog->titulo;
        $blog->delete();

        $notification = 'La publicación '. $deletedBlog .' se ha eliminado correctamente.';
        return redirect('/blogs')->with(compact('notification'));
    }
}
