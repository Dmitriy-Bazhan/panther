<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class DefaultFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local' && Feedback::count() == 0) {
            $arr = [3, 5, 7, 9, 11, 101];
            $string = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aspernatur atque ducimus error ex explicabo ipsa labore, laudantium maiores modi molestiae mollitia placeat porro possimus praesentium recusandae, saepe tempore totam.';

            foreach ($arr as $item) {
                for ($i = 1; $i <= 5; $i++) {
                    $feedback = new Feedback();
                    $feedback->creator_id = 100;
                    $feedback->target_user_id = $item;
                    $feedback->type = 'nurse';
                    $feedback->description = $string;
                    $feedback->save();
                }
            }
        }
    }
}
