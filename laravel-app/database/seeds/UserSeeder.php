<?php

use Illuminate\Database\Seeder;
Use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersData = array(
            array('id' => 1, 'name' => 'Super admin', 'role_id' => config('roles.SUPPER_ADMIN'), 'email' => 'user@admin.com', 'password' => Hash::make('123456')),
        );
        foreach ($usersData as $key => $userData) {
            $userId = $userData['id'];
            unset($userData['id']);
            $user = User::updateOrCreate(['id' => $userId], $userData);
        }
    }
}
