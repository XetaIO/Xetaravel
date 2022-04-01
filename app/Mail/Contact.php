<?php

namespace Xetaravel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *  The details of the mail.
     *
     * @var array
     */
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->from('contact@xetaravel.com', 'Contact - Xetaravel')
                    ->subject($this->details['subject'])
                    ->view('emails.contact');
    }
}
