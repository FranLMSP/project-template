<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Router;

use App\MethodModuleUser;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Metodo HTTP
        $method = $request->method();
        //ruta que buscaremos en la BD
        $path = $request->route()->uri;
        $path = str_replace('api/', '', $path);

        //Buscamos en la base de datos si tiene los permisos
        $permissions = MethodModuleUser::with([
            'user',
            'module',
            'method'
        ])->whereHas('user', function($query) {
            $query->where('id', Auth::id());
        })->whereHas('module', function($query) use ($path) {
            $query->where('url', $path);
        })->whereHas('method', function($query) use ($method) {
            $query->where('name', strtoupper($method));
        })->count();

        //Si hay cero resultados, quiere decir que no tiene permisos
        if($permissions <= 0) {
            return response()->json([
                'message' => 'No tiene los privilegios para realizar esta acción'
            ], 403);
        }

        //Si no, continúa con la petición
        return $next($request);
    }
}
