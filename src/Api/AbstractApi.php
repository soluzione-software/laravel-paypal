<?php

namespace SoluzioneSoftware\Laravel\PayPal\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Config;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApi
{
    /**
     * @param  string  $method
     * @param  string  $endpoint
     * @param  array|null  $query
     * @param  array  $headers
     * @param  array|null  $body
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected static function callApi(
        string $method,
        string $endpoint,
        ?array $query = null,
        array $headers = [],
        ?array $body = null
    ): ResponseInterface {
        $uri = static::getBaseUrl().$endpoint;

        $options = array_filter([
            'query' => $query,
            'headers' => array_merge(['Content-Type' => 'application/json'], $headers),
            'body' => json_encode($body),
            'auth' => [
                Config::get('paypal.client_id'),
                Config::get('paypal.secret'),
            ],
        ]);

        return static::getClient()->request($method, $uri, $options);
    }

    protected static function getBaseUrl(): string
    {
        return Config::get('paypal.base_url');
    }

    protected static function getClient(): ClientInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return Container::getInstance()->make('paypal.client');
    }
}
