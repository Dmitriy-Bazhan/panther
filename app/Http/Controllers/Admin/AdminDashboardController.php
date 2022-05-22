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
use App\Models\Media;
use App\Models\Nurse;
use App\Models\Page;
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

    public function approveNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'yes',
                'change_info' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function dismissNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function savePage($page)
    {
//        if (!in_array($page, ['home'])) {
//            //todo:hmm
//            abort(409);
//        }

        $pageData = request('pageData');
        $lang = request('lang');

        Page::where('lang', $lang)->where('page', $pageData['page'])->delete();

        if ($pageData['page'] != '') {
            $newBlock = new Page();
            $newBlock->page = $pageData['page'];
            $newBlock->lang = $lang;
            $newBlock->data = json_encode($pageData['data']);
            $newBlock->save();
        }

        return response()->json(['success' => true]);
    }

    public function getPage($page)
    {
//        if (!in_array($page, ['home'])) {
//            //todo:hmm
//            abort(409);
//        }

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

                $media = new Media();
                $media->path = '/storage/' . $original_path;
                $media->file_name = $file_name;
                $media->size = $fileSize / 1000;
                $media->extension = $extension;
                $media->type = $fileType;
                $media->media_type = 'pages_image';
                $media->save();
            }
        }

        $media = Media::orderByDesc('id')->where('media_type', 'pages_image')->paginate(12);
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

            $media = new Media();
            $media->path = '/storage/' . $original_path;
            $media->file_name = $file_name;
            $media->size = $fileSize / 1000;
            $media->extension = $extension;
            $media->type = $fileType;
            $media->media_type = 'pages_image';
            $media->save();
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

    public function getNurses()
    {
        $nurses = $this->nursesRepo->search();
        return NurseResource::collection($nurses);
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
            TypesOfLearningData::where('id', $item['data'][0]['id'])->update([
                'data' => $item['data'][0]['data']
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
            'listing_paginate' => 'required|numeric|min:1',
            'facebook_link' => 'required|active_url',
            'twitter_link' => 'required|active_url',
            'instagram_link' => 'required|active_url',
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

        $settings = new Setting();
        $settings->listing_paginate = request()->post('site_settings')['listing_paginate'];
        $settings->site_email = request()->post('site_settings')['site_email'];
        $settings->facebook_link = request()->post('site_settings')['facebook_link'];
        $settings->twitter_link = request()->post('site_settings')['twitter_link'];
        $settings->instagram_link = request()->post('site_settings')['instagram_link'];

        if (!$settings->save()) {
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
            Log::error('AdminDashboardController@setTimeInterval not validate request time_intervals');
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
