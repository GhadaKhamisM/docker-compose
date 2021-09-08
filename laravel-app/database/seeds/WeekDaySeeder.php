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
            array('id' => 1, 'name_english' => 'Saturday', 'name_arabic' => 'السبت', 'day_index' => 6),
            array('id' => 2, 'name_english' => 'Sunday', 'name_arabic' => 'الأحد', 'day_index' => 0),
            array('id' => 3, 'name_english' => 'Monday', 'name_arabic' => 'الأثنين', 'day_index' => 1),
            array('id' => 4, 'name_english' => 'Tuesday', 'name_arabic' => 'الثلاثاء', 'day_index' => 2),
            array('id' => 5, 'name_english' => 'Wednesday', 'name_arabic' => 'الأربعاء', 'day_index' => 3),
            array('id' => 6, 'name_english' => 'Thursday', 'name_arabic' => 'الخميس', 'day_index' => 4),
            array('id' => 7, 'name_english' => 'Friday', 'name_arabic' => 'الجمعة', 'day_index' => 5),
        );
        foreach ($daysData as $key => $dayData) {
            $dayId = $dayData['id'];
            $weekDay = WeekDay::updateOrCreate(['id' => $dayId], $dayData);
        }
    }
}
