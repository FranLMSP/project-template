<?php

use Illuminate\Database\Seeder;

use App\MethodModuleUser;
use App\Module;
use App\Method;

class UsersPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->autoInsertPermissions();
    }

    private function autoInsertPermissions()
    {
        //Insertar permisos API
        $modules = Module::where('api', true)->get();
        $methods = Method::get();

        foreach($modules as $module) {
            if(
                strpos('create', $module->url) !== false || 
                strpos('edit', $module->url) !== false
            ) {
                factory(MethodModuleUser::class)->create([
                    'method_id' => $this->findMethod($methods, 'GET')->id,
                    'module_id' => $module->id,
                    'user_id' => 1,
                ]);
            } else {
                foreach($methods as $method) {
                    factory(MethodModuleUser::class)->create([
                        'method_id' => $method->id,
                        'module_id' => $module->id,
                        'user_id' => 1,
                    ]);

                }
            }
        }

        //Insertar permisos FRONT
        $modules = Module::where('api', false)->get();

        foreach($modules as $module) {

            factory(MethodModuleUser::class)->create([
                'method_id' => $this->findMethod($methods, 'GET')->id,
                'module_id' => $module->id,
                'user_id' => 1,
            ]);

        }
    }

    private function findMethod($methods, $name)
    {
        foreach($methods as $method) {
            if($method->name == $name) {
                return $method;
            }
        }
        return false;
    }

}
