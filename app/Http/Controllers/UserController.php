<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\MethodModuleUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id', 'name', 'description')
            ->get();

        return response()->json([
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'repeatPassword' => 'same:password',
            'role_id' => 'required|exists:roles,id'
        ], [
            'username.required' => 'Debe especificar el nombre de usuario',
            'username.unique' => 'El nombre de usuario ya está en uso',

            'email.required' => 'Debe especificar el email',
            'email.unique' => 'El email ya está en uso',
            'email.email' => 'El email no es válido',

            'password.required' => 'Debe especificar la contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',

            'repeatPassword.same' => 'Las contraseñas no coinciden',

            'role_id.required' => 'Debe especificar el rol del usuario',
            'role_id.exists' => 'El rol especificado no existe'
        ]);

        //obtener rol para heredar sus permisos
        $role = Role::with(['permissions'])->find($request->role_id);

        $user = new User($request->all());
        $user->save();

        $data = [];
        foreach($role->permissions as $permission) {
            $data[] = [
                'method_id' => $permission->method_id,
                'module_id' => $permission->module_id,
                'user_id' => $user->id,
            ];
        }

        MethodModuleUser::insert($data);

        return response()->json([
            'message' => 'Usuario creado correctamente'
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|min:8',
            'repeatPassword' => 'same:password',
            'role_id' => 'required|exists:roles,id'
        ], [
            'username.required' => 'Debe especificar el nombre de usuario',
            'username.unique' => 'El nombre de usuario ya está en uso',

            'email.required' => 'Debe especificar el email',
            'email.unique' => 'El email ya está en uso',
            'email.email' => 'El email no es válido',

            'password.required' => 'Debe especificar la contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',

            'repeatPassword.same' => 'Las contraseñas no coinciden',

            'role_id.required' => 'Debe especificar el rol del usuario',
            'role_id.exists' => 'El rol especificado no existe'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
