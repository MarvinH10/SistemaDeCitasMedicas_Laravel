<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Promotion;
use App\Models\Blog;

class LlamadoController extends Controller
{
    // Mostrar promociones, testimonios y blogs
    public function index()
    {
        $promotions = Promotion::all();
        $testimonials = Testimonial::all();
        $blogs = Blog::all();

        return view('welcome', compact('promotions', 'testimonials', 'blogs'));
    }

    public function create()
    {
        return view('blogs.testimonials.create');
    }

    public function about()
    {
        return view('web.about.index');
    }

    public function services()
    {
        $testimonials = Testimonial::all();

        return view('web.services.index', compact('testimonials'));
    }

    public function packages()
    {
        $promotions = Promotion::all();

        return view('web.packages.index', compact('promotions'));
    }

    public function contacts()
    {
        return view('web.contacts.index');
    }

    public function store(Request $request)
    {
        // Valida y almacena el testimonio en la base de datos
        $request->validate([
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Comprueba si el usuario está autenticado
        if (auth()->check()) {
            Testimonial::create([
                'user_id' => auth()->user()->id, // Asigna el usuario actual
                'testimonial' => $request->input('testimonial'),
                'rating' => $request->input('rating'),
            ]);
        } else {
            Testimonial::create([
                'name' => $request->input('name'), // Nombre del usuario no autenticado
                'testimonial' => $request->input('testimonial'),
                'rating' => $request->input('rating'),
            ]);
        }

        return redirect()->route('blogs.testimonials.index')
            ->with('success', 'Testimonio agregado exitosamente');
    }
}
