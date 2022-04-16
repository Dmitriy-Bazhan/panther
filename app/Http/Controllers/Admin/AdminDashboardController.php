<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\ClientResource;
use App\Http\Resources\NurseResource;
use App\Models\AdditionalInfo;
use App\Models\HearAboutUs;
use App\Models\Media;
use App\Models\Nurse;
use App\Models\Page;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

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
        $data['data']['incoming_new_user_info'] = null;
        if (Nurse::where('info_is_full', 'yes')->where('is_approved', 'no')->first() || Nurse::where('change_info', 'yes')->first()) {
            $data['data']['incoming_new_user_info'] = true;
        }

        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
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

        Page::where('page', $pageData['page'])->delete();

        if ($pageData['page'] != '') {
            $newBlock = new Page();
            $newBlock->page = $pageData['page'];
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

        $page = Page::where('page', $page)->first();
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

        $media = Media::where('media_type', 'pages_image')->paginate(12);
        return response()->json(['success' => true, 'media' => $media]);
    }

    public function saveMedia(Request $request)
    {
        $rules = [
            'file' => 'required|file|mimes:jpeg,bmp,png'
        ];

        if ($request->file('file')) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()]);
            }
        }

        if ($request->file('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $file_name = time() . '_' .$request->file('file')->getClientOriginalName();
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
            $media->size = $fileSize;
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

        return response()->json(['success' => true, 'media' => $media]);
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

    public function getNurses()
    {
        $nurses = $this->nursesRepo->search();
        return NurseResource::collection($nurses);
    }

    public function getClients()
    {
        $clients = $this->clientRepo->search();
        return ClientResource::collection($clients);
    }

    public function hearAboutUs()
    {
        $hearAboutUs = HearAboutUs::with('data')->get();
        return response()->json(['hear_about_us' => $hearAboutUs]);
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
}
