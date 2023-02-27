<?php

namespace Api\V1_0_0\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitorInformation extends Mailable
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
            ->from(config('mail.from.address'), 'Visitor Information')
            ->subject('Visitor Information')
            ->to($this->data['email'])
            ->view('v1_0_0.emails.visitor-information')
            ->with([
                "data" => $this->data
            ]);
    }
}