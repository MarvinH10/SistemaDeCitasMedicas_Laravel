<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
    	$promotions = Promotion::promotions()->paginate(6);
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

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/promotion_images');
            $promotion->image = str_replace('public/', 'storage/', $imagePath);
        } else {
            // Establecer una imagen predeterminada (ajusta la ruta según tu estructura)
            $promotion->image = 'img/storage/default_image.png';
        }

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

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            Storage::delete($promotion->image);

            $imagePath = $request->file('image')->store('public/promotion_images');
            $promotion->image = str_replace('public/', 'storage/', $imagePath);
        } else {
            // Establecer una imagen predeterminada (ajusta la ruta según tu estructura)
            $promotion->image = 'img/storage/default_image.png';
        }

    	$promotion->save(); // UPDATE

        $notification = 'La promoción se ha actualizado correctamente';
    	return redirect('/promociones')->with(compact('notification'));
    }

    // public function destroy(Promotion $promotion)
    // {
    //     $deletedPromotion = $promotion->name;
    //     $promotion->estado = false;
    //     $promotion->save();

    //     $notification = 'La promoción '. $deletedPromotion .' se ha marcado como inactiva.';
    //     return redirect('/promociones')->with(compact('notification'));
    // }

    public function inactivate(int $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['msg' => 'Promoción no encontrada', 'icono' => 'error']);
        }

        $promotion->estado = 0;
        $promotion->save();

        return response()->json(['msg' => 'Promoción inactivada con éxito', 'icono' => 'success']);
    }

    public function reactivate(int $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['msg' => 'Promoción no encontrada', 'icono' => 'error']);
        }

        $promotion->estado = 1;
        $promotion->save();

        return response()->json(['msg' => 'Promoción reactivada con éxito', 'icono' => 'success']);
    }
}
