<?php

namespace SoluzioneSoftware\Laravel\PayPal\Api;

use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use SoluzioneSoftware\Laravel\PayPal\Responses\Subscriptions\CreateResponse;
use SoluzioneSoftware\Laravel\PayPal\Responses\Subscriptions\ReviseResponse;
use Throwable;

class SubscriptionsApi extends AbstractApi
{
    /**
     * @param  string  $planId
     * @param  DateTime|null  $startTime
     * @param  mixed|null  $quantity
     * @param  array|null  $shippingAmount
     * @param  array|null  $subscriber
     * @param  bool|null  $autoRenewal
     * @param  array|null  $applicationContext
     * @param  string|null  $customId
     * @param  array|null  $plan
     * @return CreateResponse
     * @throws GuzzleException
     * @throws RuntimeException|Throwable
     */
    public static function create(
        string $planId,
        ?DateTime $startTime = null,
        $quantity = null,
        ?array $shippingAmount = null,
        ?array $subscriber = null,
        ?bool $autoRenewal = null,
        ?array $applicationContext = null,
        ?string $customId = null,
        ?array $plan = null
    ): CreateResponse {
        $payload = array_filter([
            'plan_id' => $planId,
            'start_time' => $startTime ? $startTime->format('Y-m-d\TH:i:s\Z') : null,
            'quantity' => $quantity,
            'shipping_amount' => $shippingAmount,
            'subscriber' => $subscriber,
            'auto_renewal' => $autoRenewal,
            'application_context' => $applicationContext,
            'custom_id' => $customId,
            'plan' => $plan,
        ]);

        $response = static::callApi('POST', static::getEndPoint(), null, [], $payload);

        $statusCode = $response->getStatusCode();
        throw_if($statusCode !== 201, new RuntimeException("Expected response status code 201. Got $statusCode."));

        return static::buildCreateResponse(json_decode($response->getBody(), true));
    }

    protected static function getEndPoint(string $path = ''): string
    {
        return "/billing/subscriptions{$path}";
    }

    /**
     * @param  array  $response
     * @return CreateResponse
     * @throws Exception
     */
    private static function buildCreateResponse(array $response): CreateResponse
    {
        return CreateResponse::fromArray($response);
    }

    /**
     * @param  string  $id
     * @param  string  $planId
     * @param  null  $quantity
     * @param  array|null  $shippingAmount
     * @param  array|null  $shippingAddress
     * @param  array|null  $applicationContext
     * @param  array|null  $plan
     * @return ReviseResponse
     * @throws GuzzleException
     * @throws Exception
     * @throws RuntimeException|Throwable
     */
    public static function revise(
        string $id,
        string $planId,
        $quantity = null,
        ?array $shippingAmount = null,
        ?array $shippingAddress = null,
        ?array $applicationContext = null,
        ?array $plan = null
    ): ReviseResponse {
        $payload = array_filter([
            'plan_id' => $planId,
            'quantity' => $quantity,
            'shipping_amount' => $shippingAmount,
            'shipping_address' => $shippingAddress,
            'application_context' => $applicationContext,
            'plan' => $plan,
        ]);

        $response = static::callApi('POST', static::getEndPoint("/$id/revise"), null, [], $payload ?: null);

        $statusCode = $response->getStatusCode();
        throw_if($statusCode !== 200, new RuntimeException("Expected response status code 200. Got $statusCode."));

        return static::buildReviseResponse(json_decode($response->getBody(), true));
    }

    /**
     * @param  array  $response
     * @return ReviseResponse
     * @throws Exception
     */
    private static function buildReviseResponse(array $response): ReviseResponse
    {
        return ReviseResponse::fromArray($response);
    }

    /**
     * @param  string  $id
     * @param  string|null  $reason
     * @return bool
     * @throws GuzzleException
     */
    public static function cancel(string $id, ?string $reason = null): bool
    {
        $payload = array_filter([
            'reason' => $reason,
        ]);

        $response = static::callApi('POST', static::getEndPoint("/$id/cancel"), null, [], $payload ?: null);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 204) {
            Log::warning("Expected response status code 204. Got $statusCode.");
            return false;
        }
        return true;
    }
}
