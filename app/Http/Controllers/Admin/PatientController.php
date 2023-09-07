<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio!',
            'name.min' => 'El nombre del paciente debe tener más de 3 caracteres!',
            'email.required' => 'El correo electrónico es obligatorio!',
            'email.email' => 'Ingresa una dirección de correo electrónico válido!',
            'address.min' => 'La dirección debe tener al menos 6 caracteres!',
            'phone.required' => 'El número de teléfono es obligatorio!',
        ];
        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name', 'email', 'address', 'phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $notification = 'El paciente se ha registrado correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = User::patients()->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio!',
            'name.min' => 'El nombre del paciente debe tener más de 3 caracteres!',
            'email.required' => 'El correo electrónico es obligatorio!',
            'email.email' => 'Ingresa una dirección de correo electrónico válido!',
            'address.min' => 'La dirección debe tener al menos 6 caracteres!',
            'phone.required' => 'El número de teléfono es obligatorio!',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);
        
        $user->fill($data);
        $user->save();

        $notification = 'La información del paciente se actualizó correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::patients()->findOrFail($id);
        $patientName = $user->name;
        $user->delete();

        $notification = "El paciente $patientName se eliminó correctamente";

        return redirect('/pacientes')->with(compact('notification'));
    }
}
