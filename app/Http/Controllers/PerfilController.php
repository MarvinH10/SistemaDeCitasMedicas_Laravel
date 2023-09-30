<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index(){
        return view('includes.panel.optionsUser.perfil');
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'perfil_image' => ['nullable', 'image', 'max:10048', new \App\Rules\Validation],
        ]);

        $data = $request->only('name', 'email', 'address', 'phone');
        $password = $request->input('password');

        if($password) {
            $data['password'] = bcrypt($password);
        }

        if ($request->hasFile('perfil_image')) {
            // Elimina la imagen anterior si existe
            if ($user->image) {
                // Obtén la ruta real del archivo almacenado en storage
                $oldImagePath = str_replace('storage/', 'public/', $user->image);
                Storage::delete($oldImagePath);
            }

            $imagePath = $request->file('perfil_image')->store('public/perfil_images');
            // Almacena la ruta completa de la imagen en la base de datos
            $user->image = str_replace('public/', 'storage/', $imagePath);
        }elseif (!$user->image) {
            $user->image = 'storage/perfil_default.jpg';
        }

        $user->fill($data);
        $user->save();

        $notification = 'Perfil actualizado exitosamente.';
        return redirect('/myperfil')->with(compact('notification'));
    }
}
