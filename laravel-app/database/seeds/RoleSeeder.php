<?php

use Illuminate\Database\Seeder;
Use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesData = array(
            array('id' => 1, 'name' => 'Supper admin'),
            array('id' => 2, 'name' => 'Normal user'),
        );
        foreach ($rolesData as $key => $roleData) {
            $roleId = $roleData['id'];
            $role = Role::updateOrCreate(['id' => $roleId], $roleData);
        }
    }
}
