<?php

namespace Database\Seeders\Local;

use App\Models\HearAboutUs;
use App\Models\HearAboutUsData;
use Illuminate\Database\Seeder;

class HearAboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'en' => [
                'Nurse recommendation',
                'Recommendation from client',
                'Google Search',
                'Medical services',
                'eBay Classifieds',
                'Job advertisement',
                'Advertising',
                'Event',
            ],
            'de' => [
                'Empfehlung von pflegekraft',
                'Empfehlung von nutzern',
                'Google suche',
                'Medizinische services',
                'eBay kleinanzeigen',
                'Stellenanzeigen',
                'Werbung',
                'Veranstaltung',

            ]
        ];

        if (HearAboutUs::all()->count() === 0) {
            foreach ($arr['en'] as $key => $string) {
                $hearAboutUs = new HearAboutUs();
                $hearAboutUs->save();
                $id = $hearAboutUs->id;
                foreach (['en', 'de'] as $lang) {
                    $heraAboutAsData = new HearAboutUsData();
                    $heraAboutAsData->near_about_us_id = $id;
                    $heraAboutAsData->lang = $lang;
                    $heraAboutAsData->data = $arr[$lang][$key];
                    $heraAboutAsData->save();

                }
            }
        }
    }
}
