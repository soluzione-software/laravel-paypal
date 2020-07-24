<?php

namespace SoluzioneSoftware\Laravel\PayPal;

class PayPal
{
    public static function newSubscription(string $planId): SubscriptionBuilder
    {
        return new SubscriptionBuilder($planId);
    }
}
