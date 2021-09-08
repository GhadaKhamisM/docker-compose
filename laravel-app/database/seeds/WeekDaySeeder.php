<?php

use Illuminate\Database\Seeder;
Use App\Models\WeekDay;

class WeekDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daysData = array(
            array('id' => 1, 'name_english' => 'Saturday', 'name_arabic' => 'السبت'),
            array('id' => 2, 'name_english' => 'Sunday', 'name_arabic' => 'الأحد'),
            array('id' => 3, 'name_english' => 'Monday', 'name_arabic' => 'الأثنين'),
            array('id' => 4, 'name_english' => 'Tuesday', 'name_arabic' => 'الثلاثاء'),
            array('id' => 5, 'name_english' => 'Wednesday', 'name_arabic' => 'الأربعاء'),
            array('id' => 6, 'name_english' => 'Thursday', 'name_arabic' => 'الخميس'),
            array('id' => 7, 'name_english' => 'Friday', 'name_arabic' => 'الجمعة'),
        );
        foreach ($daysData as $key => $dayData) {
            $dayId = $dayData['id'];
            $weekDay = WeekDay::updateOrCreate(['id' => $dayId], $dayData);
        }
    }
}
