<?php

namespace Database\Seeders;

use App\Models\TypesOfLearning;
use App\Models\TypesOfLearningData;
use Illuminate\Database\Seeder;

class TypeOfLearningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(TypesOfLearning::count() == 0){
            $arr = [
                'en' => [
                    'Registered nurse',
                    'Self education'
                ],
                'de' => [
                    'Staatlich geprüfte Krankenschwester',
                    'Selbsterziehung'
                ],
            ];

            for ($i = 0; $i <= 1; $i++) {
                $typeOfLearning = new TypesOfLearning();
                $typeOfLearning->save();
                $id = $typeOfLearning->id;

                $typeOfLearningData = new TypesOfLearningData();
                $typeOfLearningData->type_of_learning_id = $id;
                $typeOfLearningData->lang = 'en';
                $typeOfLearningData->data = $arr['en'][$i];
                $typeOfLearningData->save();

                $typeOfLearningData = new TypesOfLearningData();
                $typeOfLearningData->type_of_learning_id = $id;
                $typeOfLearningData->lang = 'de';
                $typeOfLearningData->data = $arr['de'][$i];
                $typeOfLearningData->save();
            }
        }
    }
}
