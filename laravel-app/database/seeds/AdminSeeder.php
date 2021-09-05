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
            array('id' => 1, 'name' => 'Super admin', 'username' => 'user@admin.com', 'password' => Hash::make('123456')),
        );
        foreach ($adminsData as $key => $adminData) {
            $adminId = $adminData['id'];
            $admin = Admin::updateOrCreate(['id' => $adminId], $adminData);
        }
    }
}
