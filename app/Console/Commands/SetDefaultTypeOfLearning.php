<?php

namespace App\Console\Commands;

use App\Models\TypesOfLearning;
use App\Models\TypesOfLearningData;
use Illuminate\Console\Command;

class SetDefaultTypeOfLearning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:type_of_learning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set default type of learning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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

        return 0;
    }
}
