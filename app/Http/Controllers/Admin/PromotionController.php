<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
    	$promotions = Promotion::all();
    	return view('promotions.index', compact('promotions'));
    }

    public function create()
    {
    	return view('promotions.create');
    }

    private function performValidation(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'description' => 'nullable',
            'price' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre de la promoción es obligatorio!',
            'name.min' => 'El nombre de la promoción debe tener más de 3 caracteres!',
            'price.required' => 'El campo precio es obligatorio!',
        ];
        $this->validate($request, $rules, $messages);
    }

    public function store(Request $request)
    {
    	// dd($request->all());
        $this->performValidation($request);

    	$promotion = new Promotion();
    	$promotion->name = $request->input('name');
    	$promotion->description = $request->input('description');
        $promotion->price = $request->input('price');
    	$promotion->save(); // INSERT

        $notification = 'La promoción se ha registrado correctamente';
    	return redirect('/promociones')->with(compact('notification'));
    }

    public function edit(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
    	$this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required',
        ]);

    	$promotion->name = $request->input('name');
    	$promotion->description = $request->input('description');
        $promotion->price = $request->input('price');
    	$promotion->save(); // UPDATE

        $notification = 'La promoción se ha actualizado correctamente';
    	return redirect('/promociones')->with(compact('notification'));
    }

    public function destroy(Promotion $promotion)
    {
        $deletedPromotion = $promotion->name;
        $promotion->delete();

        $notification = 'La promoción '. $deletedPromotion .' se ha eliminado correctamente.';
        return redirect('/promociones')->with(compact('notification'));
    }
}
