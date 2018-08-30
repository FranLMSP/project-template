<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Module;
use App\Method;
use App\MethodModuleUser;

class UserPermissionController extends Controller
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
            'email'
        )->with([
            'permissions.module' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description',
                    'api',
                    'active',
                    'url'
                );
            },
            'permissions.method',
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
        $modules = Module::where('module_id', NULL)->get();
        $methods = Method::get();

        return response()->json([
            'modules' => $modules,
            'methods' => $methods
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
        //
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
            'permissions.module' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description',
                    'api',
                    'active',
                    'url'
                );
            },
            'permissions.method',
        ])->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'user' => $user
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
        $modules = Module::where('module_id', NULL)->get();
        $methods = Method::get();

        $user->load([
            'permissions.module' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description',
                    'api',
                    'active',
                    'url'
                );
            },
            'permissions.method',
        ])->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'modules' => $modules,
            'methods' => $methods,
            'user' => $user
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
            'permissions' => 'present|array|min:0',
            'permissions.*.module_id' => 'required|exists:modules,id',
            'permissions.*.method_id' => 'required|exists:methods,id'
        ], [
            'permissions.required' => 'Debe especificar los permisos',

            'permissions.*.module_id.required' => 'Debe especificar el módulo/ruta',
            'permissions.*.module_id.exists' => 'Uno de los módulos o rutas especificadas no existe',

            'permissions.*.method_id.required' => 'Debe especificar la acción',
            'permissions.*.method_id.exists' => 'Una de las acciones especificadas no existe',
        ]);

        //Borramos todos los permisos existentes
        MethodModuleUser::where('user_id', $user->id)->delete();

        $data = [];
        //Iteramos los permisos otorgados por el usuario
        foreach($request->permissions as $permission) {
            $data[] = [
                'method_id' => $permission['method_id'],
                'module_id' => $permission['module_id'],
                'user_id' => $user->id,
            ];
        }

        //Insertamos multiples permisos
        MethodModuleUser::insert($data);

        return response()->json([
            'mensaje' => 'Permisos asignados correctamente'
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
