<?php

namespace Database\Seeders;

use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use Illuminate\Database\Seeder;

class AdditionalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'postoperative_care' => [
                'Postoperative Versorgung',
                'Postoperative care'
            ],                            // Послеоперационный уход - Postoperative Versorgung (Postoperative care;)

            'rehabilitation' => [
                'Rehabilitation',
                'Rehabilitation'
            ],                            //Реабилитация - Rehabilitation (rehabilitation;)
            'cardiac_diseases' => [
                'Herzerkrankungen', 'Cardiac diseases'
            ],                            //Сердечные заболевания - Herzerkrankungen (cardiac diseases;)
            'stroke' => [
                'Schlaganfall', 'Stroke'
            ],                            //Инсульт - Schlaganfall (stroke;)
            'diabetes' => [
                'Diabetes', 'Diabetes'
            ],                            //Сахарный диабет - Diabetes (diabetes;)
            'cancer' => [
                'Krebsleiden', 'Cancer'
            ],                            //Рак - Krebsleiden (cancer;)
            'dementia' => [
                'Demenz', 'Dementia'
            ],                            //Слабоумие - Demenz (dementia;)
            'depression' => [
                'Depression', 'Depression'
            ],                            //Депрессия - Depression (depression;)
            'hospice' => [
                'Hospiz', 'Hospice'
            ],                            //Хоспис - Hospiz (hospice;)
            'multiple_sclerosis' => [
                'Multiple Sklerose', 'Multiple sclerosis'
            ],                          //Рассеянный склероз - Multiple Sklerose (multiple sclerosis;)
            'parkinsons_disease' => [
                'Parkinson', 'Parkinson`s disease'
            ],                          //Болезнь Паркинсона - Parkinson (Parkinson`s disease;)
            'incontinence' => [
                'Inkontinenz', 'Incontinence'
            ],                          //Недержание мочи - Inkontinenz (Incontinence;)
            'allergies' => [
                'Allergien', 'Allergies'
            ],                          //Аллергии - Allergien (Allergies;)
        ];

        if (AdditionalInfo::all()->count() === 0) {
            foreach ($arr as $key => $value) {
                $additionalInfo = new AdditionalInfo();
                $additionalInfo->alias = $key;
                $additionalInfo->save();
                $id = $additionalInfo->id;

                $additionalInfoData = new AdditionalInfoData();
                $additionalInfoData->additional_info_id = $id;
                $additionalInfoData->lang = 'de';
                $additionalInfoData->data = $value[0];
                $additionalInfoData->save();

                $additionalInfoData = new AdditionalInfoData();
                $additionalInfoData->additional_info_id = $id;
                $additionalInfoData->lang = 'en';
                $additionalInfoData->data = $value[1];
                $additionalInfoData->save();

            }
        }
    }
}
