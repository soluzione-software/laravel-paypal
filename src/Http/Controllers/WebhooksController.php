<?php

namespace SoluzioneSoftware\Laravel\PayPal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SoluzioneSoftware\Laravel\PayPal\Events\WebhookReceived;
use SoluzioneSoftware\Laravel\PayPal\Http\Middleware\VerifyWebhookSignature;

class WebhooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyWebhookSignature::class);
    }

    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        WebhookReceived::dispatch($payload);

        return new Response();
    }

}
