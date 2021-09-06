<?php

use Illuminate\Database\Seeder;
Use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminsData = array(
            array('id' => 1, 'name' => 'Super admin', 'username' => config('admin.SUPPER_ADMIN_USERNAME'), 'password' => Hash::make(config('admin.SUPPER_ADMIN_PASSWORD'))),
        );
        foreach ($adminsData as $key => $adminData) {
            $adminId = $adminData['id'];
            $admin = Admin::updateOrCreate(['id' => $adminId], $adminData);
        }
    }
}
