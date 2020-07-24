<?php

namespace SoluzioneSoftware\Laravel\PayPal\Enums;

use Konekt\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static APPROVAL_PENDING()
 * @method static static APPROVED()
 * @method static static CANCELLED()
 * @method static static EXPIRED()
 * @method static static SUSPENDED()
 */
class SubscriptionStatus extends Enum
{
    /**
     * The subscription is active.
     */
    const ACTIVE = 'ACTIVE';

    /**
     * The subscription is created but not yet approved by the buyer.
     */
    const APPROVAL_PENDING = 'APPROVAL_PENDING';

    /**
     * The buyer has approved the subscription.
     */
    const APPROVED = 'APPROVED';

    /**
     * The subscription is cancelled.
     */
    const CANCELLED = 'CANCELLED';

    /**
     * The subscription is expired.
     */
    const EXPIRED = 'EXPIRED';

    /**
     * The subscription is suspended.
     */
    const SUSPENDED = 'SUSPENDED';

    public const __default = self::APPROVAL_PENDING;
}
