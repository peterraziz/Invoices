<?php
namespace Database\Seeders;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

        $user = ModelsUser::create([
        'name' => 'Peter', 
        'email' => 'peter@gmail.com',
        'password' => bcrypt('12345678'),
        'roles_name' => ["Owner"],
        // 'roles_name' => json_encode(["owner"]), // Convert the array to a JSON string
        'Status' => 'مفعل',
        ]);

        $role = Role::create(['name' => 'Owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

}
}