<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCustomerInformation extends Mailable implements ShouldQueue
{
    use SerializesModels;

    public $queue = 'system-email';

    public $payload;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = collect($payload)->toArray();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->payload['payment_type'] === 'cc') {
            return $this->subject('New Community Signup')->markdown('email.system.signup');
        }

        return $this->subject('New ACH Signup')->markdown('email.system.signup');
    }
}
