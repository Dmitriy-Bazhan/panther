<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Mail\AdminAnswerByContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminContactsController extends Controller
{
    public function index()
    {

        $status = request('status');

        if ($status == '') {
            $contacts = Contact::orderBY('status_of_view')->paginate(config('settings.listing_paginate'));
        } else {
            $contacts = Contact::orderBy('status_of_view')->where('status_of_answer', $status)->paginate(config('settings.listing_paginate'));
        }


        $contacts = ContactResource::collection($contacts)->response()->getData();

        return response()->json(['success' => true, 'contacts' => $contacts]);
    }

    public function show($id)
    {
        Contact::where('id', $id)->update([
            'status_of_view' => 'yes'
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $answer = $request->post('answer');

        if (empty($answer)) {
            return response()->json(['success' => false]);
        }

        if (config('settings.mail_use_queue')) {
            Mail::mailer('smtp')->to($contact->email)
                ->queue(new AdminAnswerByContact($contact, $answer));
        } else {
            Mail::mailer('smtp')->to($contact->email)
                ->send(new AdminAnswerByContact($contact, $answer));
        }

        Contact::where('id', $id)->update([
            'status_of_answer' => 'yes',
            'answer' => $answer
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Contact::where('id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
