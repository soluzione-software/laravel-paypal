<?php

namespace SoluzioneSoftware\Laravel\PayPal\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SoluzioneSoftware\Laravel\PayPal\Api\NotificationsApi;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class VerifyWebhookSignature
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     *
     * @throws AccessDeniedHttpException|Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        $verified = NotificationsApi::verifyWebhookSignature(
            (string) $request->header('Paypal-Auth-Algo'),
            (string) $request->header('Paypal-Cert-Url'),
            (string) $request->header('Paypal-Transmission-Id'),
            (string) $request->header('Paypal-Transmission-Sig'),
            new DateTime((string) $request->header('Paypal-Transmission-Time')),
            json_decode($request->getContent(), true)

        );

        throw_unless($verified, new AccessDeniedHttpException());

        return $next($request);
    }
}
