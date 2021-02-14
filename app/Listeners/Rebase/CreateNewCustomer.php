<?php

namespace App\Listeners\Rebase;

use League\Pipeline\Pipeline;
use App\Mail\Rebase\NewCustomer;
use Illuminate\Support\Facades\Mail;
use App\Events\Rebase\StartCustomerSignup;
use App\Pipelines\Registration\AddCustomer;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Exceptions\CustomerRegistrationException;
use App\Mail\NewCustomerInformation;
use App\Pipelines\Registration\SubscribeCustomer;
use App\Pipelines\Registration\AddCustomerWorkspace;
use App\Pipelines\Registration\AddFirstMemberToWorkspace;
use App\Pipelines\Registration\CreateWorkspace;

class CreateNewCustomer implements ShouldQueue
{
    public $queue = 'general';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(StartCustomerSignup $event): void
    {
        $payload = collect($event->payload);

        try {
            $pipeline = (new Pipeline())
                ->pipe(new AddCustomer())
                ->pipe(new SubscribeCustomer())
                ->pipe(new CreateWorkspace())
                ->pipe(new AddCustomerWorkspace())
                ->pipe(new AddFirstMemberToWorkspace());

            $pipeData = $pipeline->process($payload);
        } catch (CustomerRegistrationException $e) {
            //     event(new FailedCustomerSignup(['mesaage' => $e->message, 'request_data' => $event->payload]));
        }

        Mail::to($payload->get('email'))->send(new NewCustomer($pipeData));
        Mail::to(config('mail.admins'))->send(new NewCustomerInformation($pipeData));
    }
}
