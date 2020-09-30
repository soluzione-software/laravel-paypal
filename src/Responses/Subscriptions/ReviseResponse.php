<?php

namespace SoluzioneSoftware\Laravel\PayPal\Responses\Subscriptions;

use DateTime;
use Exception;
use Illuminate\Support\Arr;

class ReviseResponse
{
    /**
     * @var string|null
     */
    private $planId;

    /**
     * @var string|null
     */
    private $quantity;

    /**
     * @var DateTime|null
     */
    private $effectiveTime;

    /**
     * @var array|null
     */
    private $shippingAmount;

    /**
     * @var array|null
     */
    private $shippingAddress;

    /**
     * @var array|null
     */
    private $plan;

    /**
     * @var bool
     */
    private $planOverridden;

    /**
     * @var array
     */
    private $links;

    /**
     * @param  array  $links
     * @param  bool  $planOverridden
     * @param  string|null  $planId
     * @param  string|null  $quantity
     * @param  DateTime|null  $effectiveTime
     * @param  array|null  $shippingAmount
     * @param  array|null  $shippingAddress
     * @param  array|null  $plan
     */
    public function __construct(
        array $links,
        bool $planOverridden,
        ?string $planId,
        ?string $quantity,
        ?DateTime $effectiveTime,
        ?array $shippingAmount,
        ?array $shippingAddress,
        ?array $plan
    ) {
        $this->links = $links;
        $this->planId = $planId;
        $this->quantity = $quantity;
        $this->effectiveTime = $effectiveTime;
        $this->shippingAmount = $shippingAmount;
        $this->shippingAddress = $shippingAddress;
        $this->plan = $plan;
        $this->planOverridden = $planOverridden;
    }

    /**
     * @param  array  $data
     * @return static
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        return new ReviseResponse(
            $data['links'],
            Arr::get($data, 'plan_overridden'),
            Arr::get($data, 'plan_id'),
            Arr::get($data, 'quantity'),
            Arr::has($data, 'effective_time') ? new DateTime($data['effective_time']) : null, // todo: set timezone
            Arr::get($data, 'shipping_amount'),
            Arr::get($data, 'shipping_address'),
            Arr::get($data, 'plan')
        );
    }

    /**
     * @return string|null
     */
    public function getPlanId(): ?string
    {
        return $this->planId;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @return DateTime|null
     */
    public function getEffectiveTime(): ?DateTime
    {
        return $this->effectiveTime;
    }

    /**
     * @return array|null
     */
    public function getShippingAmount(): ?array
    {
        return $this->shippingAmount;
    }

    /**
     * @return array|null
     */
    public function getShippingAddress(): ?array
    {
        return $this->shippingAddress;
    }

    /**
     * @return array|null
     */
    public function getPlan(): ?array
    {
        return $this->plan;
    }

    /**
     * @return bool
     */
    public function isPlanOverridden(): bool
    {
        return $this->planOverridden;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
