<?php

namespace SoluzioneSoftware\Laravel\PayPal\Responses\Subscriptions;

use DateTime;
use Exception;
use SoluzioneSoftware\Laravel\PayPal\Enums\SubscriptionStatus;

class CreateResponse
{
    /**
     * @var SubscriptionStatus
     */
    private $status;

    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $createTime;

    /**
     * @var array
     */
    private $links;

    /**
     * @param  SubscriptionStatus  $status
     * @param  string  $id
     * @param  DateTime  $createTime
     * @param  array  $links
     */
    public function __construct(SubscriptionStatus $status, string $id, DateTime $createTime, array $links)
    {
        $this->status = $status;
        $this->id = $id;
        $this->createTime = $createTime;
        $this->links = $links;
    }

    /**
     * @param  array  $data
     * @return static
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        return new CreateResponse(
            SubscriptionStatus::create($data['status']),
            $data['id'],
            new DateTime($data['create_time']), // todo: set timezone
            $data['links']
        );
    }

    public function getStatus(): SubscriptionStatus
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreateTime(): DateTime
    {
        return $this->createTime;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
