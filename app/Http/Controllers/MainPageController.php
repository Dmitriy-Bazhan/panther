<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInfo;
use App\Models\ProvideSupport;
use App\Models\Rate;
use App\Models\Translate;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $data = [];
        if (auth()->check()) {
            $data['data']['provider_supports'] = ProvideSupport::all();
            $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
        }
        return view('main', $data);
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

    public function changeLang($lang)
    {
        if (!in_array($lang, ['en', 'de'])) {
            return redirect()->to('404');
        }

        \App\Models\UserPref::where('user_id', auth()->id())->update([
            'pref_lang' => $lang
        ]);

        return response()->json(['success' => true]);
    }

    public function setUserRate()
    {

        if (!request()->filled('new_rate')) {
            return response()->json(['success' => false]);
        }
        $data = request('new_rate');

        $result = Rate::updateOrCreate(
            ['user_id' => $data['user_id'], 'creator_id' => auth()->id()],
            ['rate' => $data['new_rate']]
        );

        $newRate = new \stdClass();
        $rate = Rate::where('user_id', $data['user_id'])->get();

        $newRate->count = count($rate);

        $average = $rate->sum(function ($value) {
                return $value->rate;
            }) / $newRate->count;

        $newRate->round = round ($average);
        $newRate->real = round ($average , 2);

        return response()->json(['success' => true, 'newRate' => $newRate]);
    }

    public function getTranslate($lang = null){

        if(!is_null($lang)){
            $langs = Translate::where('lang', $lang)->get();
            $translates[$lang] = [];
            foreach ($langs as $item){
                $record[$item->name] = $item->data;
                $translates[$lang] = $record;
            }

        }else{
            $langs = Translate::orderBy('name')->get()->groupBy('lang');
            foreach ($langs as $key => $lang){
                $translates[$key] = [];
                $record = [];
                foreach ($lang as $item){
                    $record[$item->name] = $item->data;
                    $translates[$key] = $record;
                }
            }

        }
        return response()->json(['success' => true, 'langs' => $translates]);
    }

    public function saveTranslates(){
        Translate::truncate();
        $langs = request('langs');
        foreach ($langs as $lang => $items) {
            foreach ($items as $name => $data){
                $newTranslate = new Translate();
                $newTranslate->name = $name;
                $newTranslate->lang = $lang;
                $newTranslate->data = $data;
                $newTranslate->save();
            }
        }

        return response()->json(['success' => true, 'langs' => $langs]);
    }
}
