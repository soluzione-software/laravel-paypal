<?php

namespace SoluzioneSoftware\Laravel\PayPal\Events;

use Illuminate\Foundation\Events\Dispatchable;

class WebhookReceived
{
    use Dispatchable;

    /**
     * The webhook payload.
     *
     * @var array
     */
    public $payload;

    /**
     * @param  array  $payload
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
