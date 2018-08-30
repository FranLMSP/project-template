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
        $result = User::select(
            'id',
            'username',
            'email',
            'role_id'
        )->with([
            'role' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description'
                );
            },
        ])->paginate(10);

        $users = $result->items();

        $pagination = [
            'total'        => $result->total(),
            'current_page' => $result->currentPage(),
            'per_page'     => $result->perPage(),
            'last_page'    => $result->lastPage(),
            'from'         => $result->firstItem(),
            'to'           => $result->lastItem()
        ];

        return response()->json([
            'users' => $users,
            'pagination' => $pagination
        ]);
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
        $user->load([
            'role' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description'
                );
            },
        ])->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load([
            'role' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description'
                );
            },
        ])->makeHidden(['created_at', 'updated_at']);

        $roles = Role::select('id', 'name', 'description')
            ->get();

        return response()->json([
            'user' => $user,
            'roles' => $roles
        ]);
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
        $user->delete();

        return response()->json([
            'Usuario borrado correctamente'
        ]);
    }

    public function password(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8',
            'repeatPassword' => 'same:password',
        ], [
            'password.required' => 'Debe especificar la contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',

            'repeatPassword.same' => 'Las contraseñas no coinciden',
        ]);

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Contraseña cambiada correctamente'
        ]);
    }
}
