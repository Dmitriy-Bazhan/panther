<?php

namespace App\Http\Controllers;

use App\Mail\AdminHaveNewContactMail;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Lang;
use App\Models\Translate;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MainPageController extends Controller
{
    public function index()
    {
        $data = [];
        if (auth()->check()) {
            $data = siteData();
        } else {
            $data['data']['settings'] = config('settings');
            $data['data']['languages'] = Lang::all();
        }
        return view('main', $data);
    }

    public function saveContact(Request $request)
    {
        $contact = $request->post();

        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'mail' => 'required|email',
            'comment' => 'required',
        ];

        Validator::make($contact, $rules)->validate();

        $new_contact = Contact::create([
            'name' => $contact['name'],
            'phone' => $contact['phone'],
            'email' => $contact['mail'],
            'comment' => $contact['comment'],
        ]);

        if (!$new_contact) {
            Log::channel('app_logs')->error('MainPageController@saveContact contact cant create');
        }

        $admins = User::where('entity_type', 'admin')->get();

        foreach ($admins as $admin) {
            app()->setLocale(User::find($admin->id)->prefs->pref_lang);

            $content = 'New contact';
            try {
                NotificationController::createNotification($admin->id, 'contact', $content, $new_contact->id);
            } catch (\Exception $exception) {

            }

            if (config('settings.mail_use_queue')) {
                Mail::mailer('smtp')->to($admin->email)
                    ->queue(new AdminHaveNewContactMail($admin, $new_contact));
            } else {
                Mail::mailer('smtp')->to($admin->email)
                    ->send(new AdminHaveNewContactMail($admin, $new_contact));
            }
        }

        return response()->json(['success' => true]);
    }

    public function changeLang($lang)
    {
        if (!in_array($lang, ['en', 'de'])) {
            return redirect()->to('404');
        }

        UserPref::where('user_id', auth()->id())->update([
            'pref_lang' => $lang
        ]);

        return response()->json(['success' => true]);
    }

    public function getTranslate($lang = null)
    {
        $translates = [];
        if (!is_null($lang)) {
            $langs = Translate::where('lang', $lang)->get();
            $translates[$lang] = [];
            foreach ($langs as $item) {
                $record[$item->name] = $item->data;
                $translates[$lang] = $record;
            }

        } else {
            $langs = Translate::orderBy('name')->get()->groupBy('lang');
            foreach ($langs as $key => $lang) {
                $translates[$key] = [];
                $record = [];
                foreach ($lang as $item) {
                    $record[$item->name] = $item->data;
                    $translates[$key] = $record;
                }
            }

        }
        return response()->json(['success' => true, 'langs' => $translates]);
    }

    public function saveTranslates()
    {
        Translate::truncate();
        $langs = request('langs');
        foreach ($langs as $lang => $items) {
            foreach ($items as $name => $data) {
                Translate::create([
                    'name' => $name,
                    'lang' => $lang,
                    'data' => $data
                ]);
            }
        }

        return response()->json(['success' => true, 'langs' => $langs]);
    }

    public function getTimeCalendarData()
    {
        $bookings = Booking::whereIn('id', request()->post('bookings'))
            ->with('time')
            ->get();

        return response()->json(['success' => true, 'bookings' => $bookings]);
    }
}
