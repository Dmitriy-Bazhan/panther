<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Translate;
use App\Models\UserPref;
use Illuminate\Http\Request;

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
}
