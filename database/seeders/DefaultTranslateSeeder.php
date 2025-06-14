<?php

namespace Database\Seeders;

use App\Models\Translate;
use Illuminate\Database\Seeder;

class DefaultTranslateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Translate::all()->count() == 0){
        $translates = $this->langsArray();

        foreach ($translates as $lang => $items) {
            foreach ($items as $name => $data){
                $newTranslate = new Translate();
                $newTranslate->name = $name;
                $newTranslate->lang = $lang;
                $newTranslate->data = $data;
                $newTranslate->save();
            }
        }
    }
    }

    private function langsArray()
    {
        return [

            'en' => [
                'lang' => 'English',
                'email_wait_verify_text' => 'Thank you for registering, Shortly you will receive an email with the next steps. See you soon on PflegePanther!',
                'you_welcome' => 'Your tegistration has been completed. You can now log in and scarch for your nursc. Welcome on PflegePanther!',
                'society_and_care' => 'Society and care',
                'escort_and_transportation' => 'Escort and transportation',
                'food_and_drinks' => 'Food and drinks',
                'activity_and_exercise' => 'Activity and exercise',
                'housekeeping_and_laundry' => 'Housekeeping and laundry',
                'basic_care' => 'Basic care',
                'purchases_and_errands' => 'Purchases and errands',
                'technical_assistance' => 'Technical assistance',
                'welcome' => 'Welcome',
                'calendar' => 'Calendar',
                'unread_messages' => 'Unread messages',
                'overview' => 'Overview',
                'messages' => 'Messages',
                'ratings' => 'Ratings',
                'bookings' => 'Bookings',
                'payments' => 'Payments',
                'my_information' => 'My information',
                'help_and_service' => 'Help && service',
                'send' => 'Send',
                'mark_as_read' => 'Mark as read',
                'chat_have_unread_messages' => 'Chat have unread messages',
                'chat' => 'Chat',
                'store' => 'Store',
                'yes' => 'Yes',
                'no' => 'No',
                'hourly_payment' => 'Hourly payment',
                'weekend_surcharge' => 'Weekend surcharge',
                'weekend_surcharge_payment' => 'Weekend surcharge payment',
                'holiday_surcharge' => 'Holiday surcharge',
                'holiday_surcharge_payment' => 'Holiday surcharge payment',
                'fare_surcharge' => 'Fare surcharge',
                'fare_surcharge_payment' => 'Fare surcharge payment',
                'prices' => 'Prices',
                'name' => 'Name',
                'last_name' => 'Last name',
                'email' => 'Email',
                'phone' => 'Phone',
                'zip_code' => 'Zip code',
                'gender' => 'Gender',
                'male' => 'Male',
                'female' => 'Female',
                'no_matter' => 'No matter',
                'age' => 'Age',
                'experience' => 'Experience',
                'languages' => 'Languages',
                'english' => 'English',
                'german' => 'German',
                'preference_client_gender' => 'Preference client gender',
                'available_care_range' => 'Available care range',
                'not_sure' => 'Not sure',
                'multiple_bookings' => 'Allow multiple meetings per day',
                'provide_supports' => 'Provide supports',
                'description' => 'Description',
                'additional_info' => 'Additional info',
                'time_calendar' => 'Time calendar',
                'weekdays' => 'Weekdays',
                'weekends' => 'Weekends',
                'mon_fri' => 'Mon-Fri',
                'sat_sun' => 'Sat-Sun',
                'morning' => 'Morning',
                'afternoon' => 'Afternoon',
                'evening' => 'Evening',
                'overnight' => 'Overnight',
                'criminal_record' => 'Criminal record',
                'documentation_of_training' => 'Documentation of training',
                'CPR_course' => 'CPR course',
                'references' => 'References',
                'update' => 'Update',
                'message' => 'Message',
                'price' => 'Price',
                'distance' => 'Distance',
                'send_to_bookings' => 'Send to bookings',
                'how_does_the_booking_process_work_description' => 'When you book a nurse on our site, you specify exactly what you want to book them for.\n' .
                    '            That is, you specify your wishes in the areas in which Pflege Panther is active.\n' .
                    '            Here you also have the option of specifying whether you prefer a female or a male nurse.\n' .
                    '            With another click, your booking request is sent off. Our matching system then searches the database for nurses\n' .
                    '            who offer exactly what you are looking for, allowing you to select an individual nurse.\n' .
                    '            The matched nurse is informed about your request and asked to accept it. The first nurse who meets your\n' .
                    '            requirements and accepts your assignment will contact you by phone. This is usually within 24 hours of your\n' .
                    '            booking request.',
                'send_booking_message' => 'Congratulations! We forwarded your request to [name of selected nurse] and will get back ' .
                    'to you within 24h',
                'caregiver_finder' => 'Caregiver finder',
                'for_whom' => 'Who are you looking for help for?',
                'to_me' => 'For me',
                'for_a_relative' => 'For a relative',
                'information_about_person' => 'Information about the person in need of care',
                'age_range' => 'Age range',
                'what_support_looking' => 'What kind of support are you looking for',
                'disease' => 'Disease',
                'other_disease' => 'Other disease',
                'is_degree_of_care' => 'Is the degree of care available',
                'language_skills' => 'Language skills',
                'do_you_need_help_moving' => 'Do you need help moving/walking?',
                'unknown' => 'Unknown',
                'additional_transportation' => 'Additional means of transportation?',
                'need_help_with_walking' => 'Need help with walking',
                'wheelchair' => 'Wheelchair',
                'crutches' => 'Crutches',
                'nothing' => 'Nothing',
                'memory' => 'Memory',
                'good' => 'Good',
                'minor_difficulties' => 'Minor difficulties',
                'significant_difficulties' => 'Significant difficulties',
                'incontinence' => 'Suffer from urinary incontinence?',
                'preference_for_the_nurse' => 'Is there a gender preference for the nurse?',
                'hearing' => 'Hearing',
                'weak' => 'Weak',
                'difficulties' => 'Difficulties',
                'essential' => 'Essential',
                'vision' => 'Vision',
                'areas_help' => 'Areas where help is needed',
                'dressing' => 'Dressing',
                'mobility' => 'Mobility',
                'hygiene' => 'Hygiene',
                'preparation_of_medicines' => 'Preparation of medicines',
                'skin_care' => 'Skin care',
                'other_areas' => 'Other areas',
                'one_time_or_regular' => 'One-time or regular',
                'where_should_help_be_provided' => 'Where should help be provided?',
                'hear_about_us_other' => 'Hear about us other',
                'hear_about_us' => 'Hear about us',
                'password_confirm' => 'Password confirm',
                'find' => 'Find',
                'password' => 'Password',
                'nurse_register' => 'Nurse register',
                'client_register' => 'Client register',
                'one_or_regular' => 'One or regular order',
                'regular' => 'Regular',
                'one' => 'One',
                'weekdays_7_11' => 'Weekdays 7-11',
                'weekdays_11_14' => 'Weekdays 11-14',
                'weekdays_14_17' => 'Weekdays 14-17',
                'weekdays_17_21' => 'Weekdays 17-21',
                'weekends_7_11' => 'Weekends 7-11',
                'weekends_11_14' => 'Weekends 11-14',
                'weekends_14_17' => 'Weekends 14-17',
                'weekends_17_21' => 'Weekends 17-21',
                'contact_detail' => 'Contact details',
                'needed_time' => 'Needed time',
                'suggested_price_per_hour' => 'Suggested price per hour',
                'you_have_booking_to_this_nurse' => 'You have booking to this nurse. Want make new?',
                'go_to_my_bookings' => 'Go to my bookings',],

            'de' => [
                'lang' => 'Deutsche',
                'email_wait_verify_text' => 'Vielen Dank für Ihre Registrierung, Sie erhalten in Kürze eine E-Mail mit den nächsten Schritten. Bis bald auf PflegePanther!',
                'you_welcome' => 'Ihre Registrierung wurde abgeschlossen. Sie können sich nun einloggen und eine passende Pflegekraft suchen. Herzlichen Willkommen bei PflegePanther!',
                'society_and_care' => 'Gesellschaft und pflege',
                'escort_and_transportation' => 'Begleitung und transport',
                'food_and_drinks' => 'Essen und trinken',
                'activity_and_exercise' => 'Aktivität und bewegung',
                'housekeeping_and_laundry' => 'Haushalt und wäsche',
                'basic_care' => 'Grundversorgung',
                'purchases_and_errands' => 'Einkäufe und besorgungen',
                'technical_assistance' => 'Technische unterstützung',
                'welcome' => 'Willkommen',
                'calendar' => 'Kalender',
                'unread_messages' => 'Ungelesene nachrichten',
                'overview' => 'Übersicht',
                'messages' => 'Nachrichten',
                'ratings' => 'Bewertungen',
                'bookings' => 'Buchungen',
                'payments' => 'Zahlungen',
                'my_information' => 'Meine Informationen',
                'help_and_service' => 'Hilfe && service',
                'send' => 'Schicken',
                'mark_as_read' => 'Als gelesen markieren',
                'chat_have_unread_messages' => 'Chat hat ungelesene nachrichten',
                'chat' => 'Chat',
                'store' => 'Speichern',
                'yes' => 'Ja',
                'no' => 'Nein',
                'hourly_payment' => 'Stundenzahlung',
                'weekend_surcharge' => 'Wochenendzuschlag',
                'weekend_surcharge_payment' => 'Wochenendzuschlagszahlung',
                'holiday_surcharge' => 'Ferienzuschlag',
                'holiday_surcharge_payment' => 'Urlaubszuschlag bezahlen',
                'fare_surcharge' => 'Fahrpreiszuschlag',
                'fare_surcharge_payment' => 'Fahrpreiszuschlagszahlung',
                'prices' => 'Preise',
                'name' => 'Name',
                'last_name' => 'Nachname',
                'email' => 'Email',
                'phone' => 'Telefon',
                'zip_code' => 'Postleitzahl',
                'gender' => 'Geschlecht',
                'male' => 'Mann',
                'female' => 'Weiblich',
                'no_matter' => 'Egal',
                'age' => 'Alter',
                'experience' => 'Erfahrung',
                'languages' => 'Sprachen',
                'english' => 'Englisch',
                'german' => 'Deutsch',
                'preference_client_gender' => 'Präferenzkundengeschlecht',
                'available_care_range' => 'Verfügbare Pflegeserie',
                'not_sure' => 'Nicht sicher',
                'multiple_bookings' => 'Mehrere Termine pro Tag möglich ',
                'provide_supports' => 'Unterstützung bieten',
                'description' => 'Beschreibung',
                'additional_info' => 'Zusätzliche Informationen',
                'time_calendar' => 'Zeitkalender',
                'weekdays' => 'Wochentage',
                'weekends' => 'Wochenenden',
                'mon_fri' => 'Mon-Fre',
                'sat_sun' => 'Sam-Son',
                'morning' => 'Morgen',
                'afternoon' => 'Nachmittag',
                'evening' => 'Abend',
                'overnight' => 'Über Nacht',
                'criminal_record' => 'Vorstrafen register',
                'documentation_of_training' => 'Dokumentation des trainings',
                'CPR_course' => 'HLW kurs',
                'references' => 'Referenzen',
                'update' => 'Aktualisieren',
                'message' => 'Nachricht',
                'price' => 'Preis',
                'distance' => 'Distanz',
                'send_to_bookings' => 'An Buchungen senden',
                'how_does_the_booking_process_work_description' => 'Wenn Sie eine Krankenschwester auf unserer Website buchen, geben Sie genau an, wofür Sie sie buchen möchten.\n' .
                    '             Das heißt, Sie geben Ihre Wünsche in den Bereichen an, in denen Pflege Panther tätig ist.\n' .
                    '             Hier haben Sie auch die Möglichkeit anzugeben, ob Sie eine weibliche oder eine männliche Pflegekraft bevorzugen.\n' .
                    '             Mit einem weiteren Klick wird Ihre Buchungsanfrage abgeschickt. Unser Matching-System durchsucht dann die Datenbank nach Pflegekräften\n' .
                    '             die genau das bieten, wonach Sie suchen, sodass Sie eine individuelle Pflegekraft auswählen können.\n' .
                    '             Die passende Pflegekraft wird über Ihre Anfrage informiert und gebeten, diese anzunehmen. Die erste Krankenschwester, die Ihre trifft\n' .
                    '             Anforderungen erfüllt und Ihren Auftrag annimmt, wird sich telefonisch mit Ihnen in Verbindung setzen. Dies ist in der Regel innerhalb von 24 Stunden nach Ihrer\n' .
                    '             Buchungsanfrage.',
                'send_booking_message' => 'Herzlichen Glückwunsch! Wir haben Ihre Anfrage zu (Vorname der Pflegekraft) gesendet und ' .
                    'melden uns innerhalb 24 Stunden',
                'caregiver_finder' => 'Pflegekraft finder',

            ]
        ];
    }
}
