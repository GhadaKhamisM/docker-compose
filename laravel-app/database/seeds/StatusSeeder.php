<?php

use Illuminate\Database\Seeder;
Use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusesData = array(
            array('id' => 1),
            array('id' => 2),
            array('id' => 3),
        );
        foreach ($statusesData as $key => $statusData) {
            $statusId = $statusData['id'];
            $status = Status::updateOrCreate(['id' => $statusId], $statusData);
        }
    }
}
