<?php

namespace SoluzioneSoftware\Laravel\PayPal;

use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use SoluzioneSoftware\Laravel\PayPal\Api\SubscriptionsApi;
use SoluzioneSoftware\Laravel\PayPal\Responses\Subscriptions\CreateResponse;
use Throwable;

class SubscriptionBuilder extends AbstractBuilder
{
    /**
     * The id of the plan being subscribed to.
     *
     * @var string
     */
    protected $planId;

    /**
     * @var DateTime|null
     */
    private $startTime = null;

    /**
     * @var mixed|null
     */
    private $quantity = null;

    /**
     * @var array|null
     */
    private $shippingAmount = null;

    /**
     * @var array|null
     */
    private $subscriber = null;

    /**
     * @var bool|null
     */
    private $autoRenewal = null;

    /**
     * @var array|null
     */
    private $applicationContext = null;
    /**
     * @var string|null
     */
    private $customId = null;

    /**
     * @var array|null
     */
    private $plan = null;

    /**
     * @param  string  $planId  The ID of the plan.
     */
    public function __construct(string $planId)
    {
        $this->planId = $planId;
    }

    /**
     * The date and time when the subscription started.
     *
     * @param  DateTime  $dateTime
     * @return $this
     */
    public function startTime(DateTime $dateTime): self
    {
        $this->startTime = $dateTime;
        return $this;
    }

    /**
     * The quantity of the product in the subscription.
     *
     * @param  mixed  $quantity
     * @return $this
     */
    public function quantity($quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * The shipping charges.
     *
     * @param  array  $shippingAmount
     * @return $this
     * @link https://developer.paypal.com/docs/api/subscriptions/v1/#definition-money
     */
    public function shippingAmount(array $shippingAmount): self
    {
        $this->shippingAmount = $shippingAmount;
        return $this;
    }

    /**
     * The subscriber request information.
     *
     * @param  array  $subscriber
     * @return $this
     * @link https://developer.paypal.com/docs/api/subscriptions/v1/#definition-subscriber_request
     */
    public function subscriber(array $subscriber): self
    {
        $this->subscriber = $subscriber;
        return $this;
    }

    /**
     * Indicates whether the subscription auto-renews after the billing cycles complete.
     *
     * @param  bool  $autoRenewal
     * @return $this
     * @deprecated
     */
    public function autoRenewal(bool $autoRenewal): self
    {
        $this->autoRenewal = $autoRenewal;
        return $this;
    }

    /**
     * The application context, which customizes the payer experience during the subscription approval process with PayPal.
     *
     * @param  array  $applicationContext
     * @return $this
     * @link https://developer.paypal.com/docs/api/subscriptions/v1/#definition-application_context
     */
    public function applicationContext(array $applicationContext): self
    {
        $this->applicationContext = $applicationContext;
        return $this;
    }

    /**
     * The custom id for the subscription. Can be invoice id.
     *
     * @param  string  $customId
     * @return $this
     */
    public function customId(string $customId): self
    {
        $this->customId = $customId;
        return $this;
    }

    /**
     * An inline plan object to customise the subscription. You can override plan level default attributes by providing
     * customised values for the subscription in this object.
     *
     * @param  array  $plan
     * @return $this
     * @link https://developer.paypal.com/docs/api/subscriptions/v1/#definition-plan_override
     */
    public function plan(array $plan): self
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * Create a new PayPal subscription.
     *
     * @return CreateResponse
     * @throws Exception
     * @throws GuzzleException
     * @throws RuntimeException|Throwable
     */
    public function create(): CreateResponse
    {
        return SubscriptionsApi::create($this->planId, $this->startTime, $this->quantity, $this->shippingAmount,
            $this->subscriber, $this->autoRenewal, $this->applicationContext, $this->customId, $this->plan);
    }
}
