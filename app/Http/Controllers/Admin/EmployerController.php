<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $query = DB::table('users')
            ->select('id', 'name', 'email', 'address', 'phone')
            ->where('role', 'empleado')
            ->where(function ($query) use ($texto) {
                $query->where('name', 'LIKE', '%' . $texto . '%')
                    ->orWhere('email', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('created_at', 'desc');
        $employers = $query->paginate(10);

        //$employers = User::employers()->paginate(10);
        return view('employers.index', compact('employers', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employers.create');
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
            'name.required' => 'El nombre del empleado es obligatorio!',
            'name.min' => 'El nombre del empleado debe tener más de 3 caracteres!',
            'email.required' => 'El correo electrónico es obligatorio!',
            'email.email' => 'Ingresa una dirección de correo electrónico válido!',
            'address.min' => 'La dirección debe tener al menos 6 caracteres!',
            'phone.required' => 'El número de teléfono es obligatorio!',
        ];
        $this->validate($request, $rules, $messages);

        $user = User::create(
            $request->only('name', 'email', 'address', 'phone')
            + [
                'role' => 'empleado',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $user->promotions()->attach($request->input('promotions'));

        $notification = 'El empleado se ha registrado correctamente.';
        return redirect('/empleados')->with(compact('notification'));
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
        $employer = User::employers()->findOrFail($id);

        $promotions = Promotion::all();

        return view('employers.edit', compact('employer', 'promotions'));
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
            'name.required' => 'El nombre del empleado es obligatorio!',
            'name.min' => 'El nombre del empleado debe tener más de 3 caracteres!',
            'email.required' => 'El correo electrónico es obligatorio!',
            'email.email' => 'Ingresa una dirección de correo electrónico válido!',
            'address.min' => 'La dirección debe tener al menos 6 caracteres!',
            'phone.required' => 'El número de teléfono es obligatorio!',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::employers()->findOrFail($id);

        $data = $request->only('name', 'email', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();

        $notification = 'La información del empleado se actualizó correctamente.';
        return redirect('/empleados')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::employers()->findOrFail($id);
        $employerName = $user->name;
        $user->delete();

        $notification = "El empleado $employerName se eliminó correctamente";

        return redirect('/empleados')->with(compact('notification'));
    }
}
