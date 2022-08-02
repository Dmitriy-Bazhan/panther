<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {

        if (auth()->check()) {
            if (auth()->user()->is_admin) {
                $status = ['nurse', 'client', 'guest', 'all'];
            } elseif (auth()->user()->is_nurse) {
                $status = ['nurse', 'all'];
            } elseif (auth()->user()->is_client) {
                $status = ['client', 'all'];
            }
        } else {
            $status = ['guest', 'all'];
        }


        $faqs = Faq::whereIn('type', $status)->where('title', 'LIKE', '%' . request('search') . '%')->get();

        return response()->json(['success' => true, 'faqs' => $faqs]);
    }

    public function saveFaqs()
    {
        $faqs = request()->post('faqs');
        $new_faqs = request()->post('new_faqs');

        Faq::truncate();

        foreach ($faqs as $faq) {
            Faq::create([
                'title' => $faq['title'],
                'type' => $faq['type'],
                'content' => $faq['content']
            ]);
        }

        foreach ($new_faqs as $faq) {
            Faq::create([
                'title' => $faq['title'],
                'type' => $faq['type'],
                'content' => $faq['content']
            ]);
        }

        return response()->json(['success' => true]);
    }
}
