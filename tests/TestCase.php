<?php

namespace SoluzioneSoftware\Laravel\PayPal\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SoluzioneSoftware\Laravel\PayPal\ServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
