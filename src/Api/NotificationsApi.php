<?php

namespace SoluzioneSoftware\Laravel\PayPal\Api;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use RuntimeException;
use Throwable;

class NotificationsApi extends AbstractApi
{
    /**
     * @param  string  $autAlgo
     * @param  string  $certUrl
     * @param  string  $transmissionId
     * @param  string  $transmissionSig
     * @param  DateTime  $transmissionTime
     * @param $webhookEvent
     * @return bool
     * @throws GuzzleException
     * @throws RuntimeException|Throwable
     */
    public static function verifyWebhookSignature(
        string $autAlgo,
        string $certUrl,
        string $transmissionId,
        string $transmissionSig,
        DateTime $transmissionTime,
        $webhookEvent
    ): bool {
        $payload = [
            'auth_algo' => $autAlgo,
            'cert_url' => $certUrl,
            'transmission_id' => $transmissionId,
            'transmission_sig' => $transmissionSig,
            'transmission_time' => $transmissionTime->format('Y-m-d\TH:i:s\Z'),
            'webhook_id' => Config::get('paypal.webhook_id'),
            'webhook_event' => $webhookEvent,
        ];

        $response = static::callApi('POST', static::getEndPoint(), null, [], $payload);

        $statusCode = $response->getStatusCode();
        throw_if($statusCode !== 200, new RuntimeException("Expected response status code 200. Got $statusCode."));

        $body = json_decode($response->getBody(), true);
        return $body['verification_status'] === 'SUCCESS';
    }

    protected static function getEndPoint(): string
    {
        return '/notifications/verify-webhook-signature';
    }
}
