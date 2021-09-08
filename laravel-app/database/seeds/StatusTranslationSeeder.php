<?php

use Illuminate\Database\Seeder;
Use App\Models\StatusTranslation;

class StatusTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusTranslationsData = array(
            array('id' => 1, 'name' => 'pending', 'locale' => 'en' , 'status_id' => 1),
            array('id' => 2, 'name' => 'قيد الأنتظار', 'locale' => 'ar' , 'status_id' => 1),
            array('id' => 3, 'name' => 'Accepted', 'locale' => 'en' , 'status_id' => 2),
            array('id' => 4, 'name' => 'تمت الموافقة', 'locale' => 'ar' , 'status_id' => 2),
            array('id' => 5, 'name' => 'canceled', 'locale' => 'en' , 'status_id' => 3),
            array('id' => 6, 'name' => 'إلغاء', 'locale' => 'ar' , 'status_id' => 3),
        );
        foreach ($statusTranslationsData as $key => $statusTranslationData) {
            $statusTranslationId = $statusTranslationData['id'];
            $statusTranslation = StatusTranslation::updateOrCreate(['id' => $statusTranslationId], $statusTranslationData);
        }
    }
}
