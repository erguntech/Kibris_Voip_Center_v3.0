<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact.contact_index');
    }

    public function sendMessage(ContactRequest $request)
    {
        Mail::to('erguntech@gmail.com')->send(new ContactMail([
            'name' => 'EFE',
        ]));

        return redirect()->route('Contact.Index')
            ->with('result','success')
            ->with('title',__('messages.contact.alert.03'))
            ->with('content',__('messages.contact.alert.04'));
    }
}
