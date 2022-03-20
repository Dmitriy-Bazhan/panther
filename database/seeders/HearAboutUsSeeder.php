<?php

namespace Database\Seeders;

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
                'current Nurse',
                'current Client',
                'Google Search',
                'medical services',
                'eBay Kleinanzeigen or similar',
                'job advertisement',
                'Advertising',
                'event',
            ],
            'de' => [
                'Empfehlung von Pflegekraft',
                'Empfehlung von Nutzern',
                'Google Suche',
                'Medizinische Services',
                'eBay Kleinanzeigen',
                'Stellenanzeigen',
                'Werbung',
                'Veranstaltung',

            ]
        ];

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
