<?php

namespace App\Http\Controllers\Admin;

use App\Console\Commands\SetDefaultTimeInterval;
use App\Exports\TranslateExport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\ClientResource;
use App\Http\Resources\NurseResource;
use App\Imports\TranslateImport;
use App\Models\HearAboutUs;
use App\Models\HearAboutUsData;
use App\Models\MailTemplate;
use App\Models\Media;
use App\Models\Nurse;
use App\Models\Page;
use App\Models\PaymentApiSetting;
use App\Models\Setting;
use App\Models\TimeInterval;
use App\Models\Translate;
use App\Models\TypesOfLearning;
use App\Models\TypesOfLearningData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller
{
    protected $nursesRepo;
    protected $clientRepo;

    public function __construct(NurseRepository $nursesRepo, ClientRepository $clientRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
        $this->clientRepo = $clientRepo;
    }

    public function index()
    {
        $data = siteData();

        $data['data']['incoming_new_user_info'] = null;
        if (Nurse::where('info_is_full', 'yes')->where('is_approved', 'no')->first() || Nurse::where('change_info', 'yes')->first()) {
            $data['data']['incoming_new_user_info'] = true;
        }

        return view('dashboard', $data);
    }

    public function savePage($page)
    {
        $pageData = request('pageData');
        $lang = request('lang');

        Page::where('lang', $lang)->where('page', $pageData['page'])->delete();

        if ($pageData['page'] != '') {
            Page::create([
                'page' => $pageData['page'],
                'lang' => $lang,
                'data' => json_encode($pageData['data']),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getPage($page)
    {
        $lang = request('lang');

        $page = Page::where('lang', $lang)->where('page', $page)->first();
        $result = [];
        if (!is_null($page)) {
            $result['page'] = $page->page;
            $result['data'] = json_decode($page->data, true);
        } else {
            $result['page'] = '';
            $result['data'] = [];
        }

        return response()->json(['success' => true, 'page' => $result]);
    }

    public function getMedia()
    {
        if (count(Media::where('media_type', 'pages_image')->get()) == 0 && count(File::files('storage/media/')) == 0) {
            $path = public_path('images/fake/');
            $files = File::files($path);
            foreach ($files as $file) {
                $extension = $file->getExtension();
                $file_name = time() . '_' . $file->getFilename();
                $fileSize = $file->getSize();
                $fileType = $file->getType();
                $directory_name = 'media';
                $original_path = Storage::disk('public')->putFileAs($directory_name, $file, $file_name);

                Media::create([
                    'path' => '/storage/' . $original_path,
                    'file_name' => $file_name,
                    'size' => $fileSize / 1000,
                    'extension' => $extension,
                    'type' => $fileType,
                    'media_type' => 'pages_image',
                ]);
            }
        }

        $media = Media::orderByDesc('id')->where('media_type', 'pages_image')->paginate(config('settings.listing_paginate'));
        return response()->json(['success' => true, 'media' => $media]);
    }

    public function saveMedia(Request $request)
    {
        $rules = [
            'file' => 'required|file|mimes:jpeg,bmp,png,svg'
        ];

        if ($request->file('file')) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }
        }

        if ($request->file('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $file_name = time() . '_' . $request->file('file')->getClientOriginalName();
            $fileSize = $request->file('file')->getSize();
            $fileType = $request->file('file')->getClientMimeType();
            $directory_name = 'media';
            $original_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);

            //make thumbnail or avatar
//            $img = Image::make('storage/' . $thumbnail_path)->resize(40, 40, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//
//            $img->save();

            Media::create([
                'path' => '/storage/' . $original_path,
                'file_name' => $file_name,
                'size' => $fileSize / 1000,
                'extension' => $extension,
                'type' => $fileType,
                'media_type' => 'pages_image',
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function deleteMedia()
    {
        $id = key(request()->post());

        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        if (!$media = Media::find($id)) {
            return response()->json(['success' => false]);
        }

        $path = 'media/' . $media->file_name;
        Storage::disk('public')->delete($path);
        Media::where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function getHearAboutUs()
    {
        $lang = request('lang');
        $hearAboutUs = HearAboutUs::with(['data' => function ($query) use ($lang) {
            return $query->where('lang', $lang);
        }])->get();
        return response()->json(['success' => true, 'hear_about_us' => $hearAboutUs]);
    }

    public function getTypeOfLearning()
    {
        $lang = request('lang');
        $typeOfLearning = TypesOfLearning::with(['data' => function ($query) use ($lang) {
            return $query->where('lang', $lang);
        }])->get();
        return response()->json(['success' => true, 'type_of_learning' => $typeOfLearning]);
    }

    public function setTypeOfLearning()
    {
        $typeOfLearning = request('type_of_learning');

        foreach ($typeOfLearning as $item) {
            TypesOfLearningData::where('id', $item['data']['id'])->update([
                'data' => $item['data']['data']
            ]);
        }

        $lang = request('lang');
        $secondLang = $lang == 'de' ? 'en' : 'de';
        $newTypeOfLearning = request('new_type_of_learning');
        if (count($newTypeOfLearning) > 0) {
            foreach ($newTypeOfLearning as $item) {
                $new = new TypesOfLearning();
                $new->save();
                $id = $new->id;

                $newData = new TypesOfLearningData();
                $newData->type_of_learning_id = $id;
                $newData->lang = $lang;
                $newData->data = $item['data'];
                $newData->save();

                $newData = new TypesOfLearningData();
                $newData->type_of_learning_id = $id;
                $newData->lang = $secondLang;
                $newData->data = $item['data'];
                $newData->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function setHearAboutUs()
    {
        $hearAboutUs = request('hear_about_us');

        foreach ($hearAboutUs as $item) {
            HearAboutUsData::where('id', $item['data'][0]['id'])->update([
                'data' => $item['data'][0]['data']
            ]);
        }

        $lang = request('lang');
        $secondLang = $lang == 'de' ? 'en' : 'de';
        $newHearAboutAs = request('new_hear_about_us');
        if (count($newHearAboutAs) > 0) {
            foreach ($newHearAboutAs as $item) {
                $new = new HearAboutUs();
                $new->save();
                $id = $new->id;

                $newData = new HearAboutUsData();
                $newData->near_about_us_id = $id;
                $newData->lang = $lang;
                $newData->data = $item['data'];
                $newData->save();

                $newData = new HearAboutUsData();
                $newData->near_about_us_id = $id;
                $newData->lang = $secondLang;
                $newData->data = $item['data'];
                $newData->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function removeTypeOfLearning($id)
    {
        if (!is_null($id) && !is_numeric($id)) {
            //todo::hmm
            return response()->json(['success' => false, 'errors' => ['Something wrong with id']]);
        }

        if (!$typeOfLearning = TypesOfLearning::where('id', $id)->with('data')->first()) {
            //todo::hmm
            return response()->json(['success' => false, 'errors' => ['Not exists item']]);
        }

        $typeOfLearning->delete();

        Nurse::where('type_of_learning', $id)->update([
            'type_of_learning' => 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function removeHearAboutUs($id)
    {
        if (!is_null($id) && !is_numeric($id)) {
            //todo::hmm
            return response()->json(['success' => false, 'errors' => ['Something wrong with id']]);
        }

        if (!$hearAboutUs = HearAboutUs::where('id', $id)->with('data')->first()) {
            //todo::hmm
            return response()->json(['success' => false, 'errors' => ['Not exists item']]);
        }

        $hearAboutUs->delete();

        User::where('hear_about_us', $id)->update([
            'hear_about_us' => null,
        ]);

        return response()->json(['success' => true]);
    }

    public function getSiteSettings()
    {
        $siteSettings = Setting::first();
        return response()->json(['success' => true, 'site_settings' => $siteSettings]);
    }

    public function setSiteSettings()
    {
        $rules = [
            'site_email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'country' => 'required|alpha',
            'listing_paginate' => 'required|numeric|min:1',
            'facebook_link' => 'required|active_url',
            'twitter_link' => 'required|active_url',
            'instagram_link' => 'required|active_url',
            'regularity_of_email_about_new_messages' => 'required|numeric|min:1',
            'mail_use_queue' => 'required|boolean',
        ];

        $validator = Validator::make(request()->post('site_settings'), $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        Setting::truncate();

        $settings = Setting::create([
            'listing_paginate' => request()->post('site_settings')['listing_paginate'],
            'site_email' => request()->post('site_settings')['site_email'],
            'phone' => request()->post('site_settings')['phone'],
            'address' => request()->post('site_settings')['address'],
            'country' => request()->post('site_settings')['country'],
            'mail_use_queue' => request()->post('site_settings')['mail_use_queue'],
            'facebook_link' => request()->post('site_settings')['facebook_link'],
            'twitter_link' => request()->post('site_settings')['twitter_link'],
            'instagram_link' => request()->post('site_settings')['instagram_link'],
            'regularity_of_email_about_new_messages' => request()->post('site_settings')['regularity_of_email_about_new_messages'],
        ]);

        if (!$settings) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }

    public function changeHearAboutUsShow($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        if (!$hearAboutUs = HearAboutUs::where('id', $id)->first()) {
            return response()->json(['success' => false]);
        }

        $is_show = 'yes';
        if ($hearAboutUs->is_show == 'yes') {
            $is_show = 'no';
        }

        $hearAboutUs->is_show = $is_show;
        if (!$hearAboutUs->save()) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'is_show' => $is_show]);
    }

    public function setTimeIntervals()
    {
        if (request()->filled('time_intervals') && is_array(request('time_intervals'))) {
            $timeIntervals = request('time_intervals');
        } else {
            //todo::hmm
            Log::channel('app_logs')->error('AdminDashboardController@setTimeInterval not validate request time_intervals');
            return response()->json(['success' => false]);
        }

        TimeInterval::truncate();

        foreach ($timeIntervals as $item) {
            $timeInterval = new TimeInterval();
            $timeInterval->id = $item['id'];
            $timeInterval->interval = $item['interval'];
            $timeInterval->start = $item['start'];
            $timeInterval->end = $item['end'];
            $timeInterval->type = $item['type'];
            $timeInterval->value = json_encode($item['value']);
            $timeInterval->save();
        }

        return response()->json(['success' => 'true']);
    }

    public function setDefaultTimeIntervals()
    {
        $defaultTimeInterval = new SetDefaultTimeInterval();
        $defaultTimeInterval->handle();

        $timeIntervals = TimeInterval::all();
        $timeIntervals->map(function ($value) {
            $value->value = json_decode($value->value, true);
        });

        return response()->json(['success' => true, 'time_intervals' => $timeIntervals]);
    }

    public function exportTranslate()
    {
        return Excel::download(new TranslateExport(), 'translates_' . time() . '.xlsx');
    }

    public function importTranslate(Request $request)
    {
        $file = $request->file('file');

        if ($file->getClientOriginalExtension() !== 'xlsx') {
            return response()->json(['success' => false, 'error' => 'Not xlsx file']);
        }

        Translate::truncate();
        Excel::import(new TranslateImport(), $file);

        return response()->json(['success' => true]);
    }

    public function getTemplates()
    {
        $templates = MailTemplate::all();
        return response()->json(['success' => true, 'templates' => $templates]);
    }

    public function updateTemplate()
    {
        $template = request()->post('template');

        $success = MailTemplate::where('id', $template['id'])->update([
            'content' => $template['content']
        ]);

        if ($success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getPaymentApiSettings(){
        $payment_api_settings = PaymentApiSetting::first();
        return response()->json(['success'=>true, 'payment_api_settings' => $payment_api_settings]);
    }

    public function setPaymentApiSettings(Request $request){

        $payment_api_settings = $request->post('payment_api_settings');

        $rules = [
            //stripe
            'stripe_key' => 'required|alpha_dash',
            'stripe_secret' => 'required|alpha_dash',
            'stripe_currency' => 'required|alpha',

            //paypal
            'paypal_mode' => 'required|alpha',
            'paypal_sandbox_client_id' => 'required|alpha_dash',
            'paypal_sandbox_client_secret' => 'required|alpha_dash',
            'paypal_sandbox_app_id' => 'required|alpha_dash',
            'paypal_live_client_id' => 'sometimes|nullable|alpha_dash',
            'paypal_live_client_secret' => 'sometimes|nullable|alpha_dash',
            'paypal_live_app_id' => 'sometimes|nullable|alpha_dash',

            'paypal_payment_action' => 'required|alpha',
            'paypal_currency' => 'required|alpha',
            'paypal_notify_url' => 'sometimes',
            'paypal_locale' => 'required|nullable|alpha_dash',
            'paypal_validate_ssl' => 'required|boolean',
        ];

        Validator::make($payment_api_settings, $rules)->validate();

        PaymentApiSetting::where('id', $payment_api_settings['id'])->update([
            'stripe_key' => $payment_api_settings['stripe_key'],
            'stripe_secret' => $payment_api_settings['stripe_secret'],
            'stripe_currency' => $payment_api_settings['stripe_currency'],

            'paypal_mode' => $payment_api_settings['paypal_mode'],
            'paypal_sandbox_client_id' => $payment_api_settings['paypal_sandbox_client_id'],
            'paypal_sandbox_client_secret' => $payment_api_settings['paypal_sandbox_client_secret'],
            'paypal_sandbox_app_id' => $payment_api_settings['paypal_sandbox_app_id'],
            'paypal_live_client_id' => $payment_api_settings['paypal_live_client_id'],
            'paypal_live_client_secret' => $payment_api_settings['paypal_live_client_secret'],
            'paypal_live_app_id' => $payment_api_settings['paypal_live_app_id'],
            'paypal_payment_action' => $payment_api_settings['paypal_payment_action'],
            'paypal_currency' => $payment_api_settings['paypal_currency'],
            'paypal_notify_url' => $payment_api_settings['paypal_notify_url'],
            'paypal_locale' => $payment_api_settings['paypal_locale'],
            'paypal_validate_ssl' => $payment_api_settings['paypal_validate_ssl'],
        ]);

        return response()->json(['success'=>true]);
    }
}
