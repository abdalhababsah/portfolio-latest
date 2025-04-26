<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    /** The saved contact record */
    public Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function build(): self
    {
        return $this->subject('New contact message: ' . $this->contact->subject)
                    ->view('emails.contact_message')          // plain-HTML view
                    ->with([
                        'contact' => $this->contact,
                    ]);
    }
}