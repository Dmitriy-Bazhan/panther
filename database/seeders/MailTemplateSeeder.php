<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'AdminAddNewUserMail',
            'ClientVerificationBookingMail',
            'MailThatYouHaveNewMessagesMail',
            'SendNurseNewBookingMail',
            'SendWarningToUser',
            'VerificationMail',
        ];

        foreach ($array as $item){
            MailTemplate::create([
                'name' => $item,
                'content' => $this->content($item),
            ]);
        }
    }

    private function content($item){
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid architecto corporis cum
                    cupiditate dolore dolorem, enim eum expedita magni maiores mollitia pariatur quidem quos recusandae
                    temporibus totam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid
                    architecto corporis cum cupiditate dolore dolorem, enim eum expedita magni maiores mollitia
                    pariatur quidem quos recusandae temporibus totam?';

        return $item . ' ' . $lorem;
    }
}
