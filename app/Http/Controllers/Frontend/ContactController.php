<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /** Handle contact-form submission */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        // 1. Save to DB
        $contact = Contact::create($validated);

        // 2. Notify site owner (adjust address in .env or here)
        Mail::to(config('mail.from.address'))
            ->send(new ContactMessageMail($contact));

        // 3. Redirect or return JSON
        return redirect()->back()->with('status', __('Your message has been sent successfully. I\'ll be in touch soon!'));
    }
}