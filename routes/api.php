<?php

use Illuminate\Http\Request;

use App\Http\Middleware\CheckPermission;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

//Todas las rutas que van a estar protegidas por sesión
Route::group([
    'middleware' => 'jwt.auth',
], function ($router) {

    //Todas las rutas que van a estar protegidas por permisos
    Route::group([
        'middleware' => CheckPermission::class
    ], function ($router) {

        //Rutas de permisos
        Route::group([
            'prefix' => 'permissions'
        ], function($router) {

            Route::resources([
                'users' => 'UserPermissionController',
                'roles' => 'RolePermissionController',
            ]);

        });


        //Rutas generales de recursos
        Route::resources([
            'users' => 'UserController',
        ]);

    });

    //Esta ruta es usada para probar la sesión
    Route::get('protected', function() { 
        return response()->json([
            'message' => '¡Bienvenido!'
        ]); 
    });

});