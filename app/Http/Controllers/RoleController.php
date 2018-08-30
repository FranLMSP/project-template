<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Role::select(
            'id',
            'name',
            'description'
        )->paginate(10);

        $roles = $result->items();

        $pagination = [
            'total'        => $result->total(),
            'current_page' => $result->currentPage(),
            'per_page'     => $result->perPage(),
            'last_page'    => $result->lastPage(),
            'from'         => $result->firstItem(),
            'to'           => $result->lastItem()
        ];

        return response()->json([
            'roles' => $roles,
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
        //
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
            'name' => 'required|unique:roles',
            'description' => '',
        ], [
            'name.required' => 'Debe especificar el nombre del rol',
            'name.unique' => 'Ya existe un rol con ese nombre',
        ]);

        $role = new Role($request->all());
        $role->save();

        return response()->json([
            'message' => 'Rol creado correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'role' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'description' => '',
        ], [
            'name.required' => 'Debe especificar el nombre del rol',
            'name.unique' => 'Ya existe un rol con ese nombre',
        ]);

        $role->update($request->all());

        return response()->json([
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Rol borrado correctamente'
        ]);
    }
}
