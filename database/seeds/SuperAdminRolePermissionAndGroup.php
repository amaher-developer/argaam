<?php

use App\Modules\Access\Models\Group;
use App\Modules\Access\Models\Permission;
use App\Modules\Access\Models\Role;
use App\Modules\Access\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminRolePermissionAndGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        /** Create super admin role (if not already exist) */
        $role = Role::firstOrCreate([
            'id' => 1,
            'display_name' => 'System Admin',
            'name' => 'system-admin',
            'description' => 'System Admin Have All Privilege For Backend'
        ]);


        /** Create first permission group (if not already exist) */
        $group = Group::firstOrCreate([
            'id' => 1,
            'name' => 'Access',
        ]);


        /** Create super admin permission (if not already exist) and assign it to the System Admin Role */
        $super_permission = Permission::firstOrCreate([
            'id' => 1,
            'display_name' => 'super',
            'name' => 'super',
            'description' => 'Super Permission',
            'group_id' => $group->id
        ]);

        $role->savePermissions($super_permission);


        /** Create dashboard permission (if not already exist) and assign it to the System Admin Role */
         Permission::firstOrCreate([
            'id' => 2,
            'display_name' => 'dashboard',
            'name' => 'dashboard-show',
            'description' => 'Dashboard Permission',
            'group_id' => $group->id
        ]);


        /**  collect permissions from routes */

        $routeCollection = Route::getRoutes();

        $separated_data = [];
        foreach ($routeCollection as $key => $route) {
            $uri = $route->uri;

            foreach ((array)$route->middleware() as $middleware) {
                if (strpos($middleware, 'permission:') !== FALSE) {

                    $action_ = explode('@', $route->getActionName());
                    $controller = explode('\\', $action_[0]);
                    $controller_name = $controller[sizeof($controller) - 1];

                    if (in_array($controller_name, ['Crud', 'Generic'])) {
                        continue;
                    }
                    $data[$key]['action_name'] = $action_[1];
                    $data[$key]['controller_name'] = substr($controller_name, 0, strlen($controller_name) - 10);
                    $data[$key]['controller_name'] = $data[$key]['controller_name'] == 'AdminAdmin' ? str_replace('AdminAdmin', 'Admin', $data[$key]['controller_name']) : str_replace('Admin', '', $data[$key]['controller_name']);

                    $permissions = str_replace('permission:', '', $middleware);
                    $permissions = (array)explode('|', $permissions);
                    $permissions = array_except($permissions, array_search('super', $permissions));
                    $data[$key]['permissions'] = $permissions;
                    $data[$key]['uri'] = $uri;
                    $data[$key]['method'] = $route->methods[0];
                    $data[$key]['name'] = $route->getName();

                    $separated_data[$data[$key]['controller_name']][] = $data[$key];
                }
            }


        }



        /** Create permissions (if not already exist) and assign it to the Role */

        foreach ($separated_data as $key => $separated_group) {

            foreach ($separated_group as $route) {
                if ($route['method'] != "POST") {
                    try {
                        $perms = $route['permissions'];
                        foreach ($perms as $perm) {

                            $permission = Permission::firstOrCreate([
                                'display_name' => str_replace('index', 'List', str_replace('destroy', 'Delete', $route['action_name'] . ' ' . $route['controller_name'])),
                                'name' => $perm,
                                'description' => $route['controller_name'] . ' ' . $route['action_name'],
                                'group_id' => $group->id
                            ]);

//                            $role->perms()->sync($permission);
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }


        }


        $admin = User::find(1);
        if (!$admin) {
            /** Create Admin (if not already exist) and assign it to the System Admin Role */
            $admin = User::firstOrCreate([
                'id'=>1,
                'name' => 'Admin',
                'phone' => '01234567890',
                'email' => 'admin@argaam.com',
                'password' => '123456'
            ]);

        }
        $admin->roles()->sync($role);

    }
}
