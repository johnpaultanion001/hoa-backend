<?php

namespace Api\V1_0_0\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.address'), 'Inquiry Reply')
            ->subject('Inquiry Reply')
            ->to($this->data['email'])
            ->view('v1_0_0.emails.inquiry-reply')
            ->with([
                "data" => $this->data
            ]);
    }
}