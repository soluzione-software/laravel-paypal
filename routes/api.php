<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhooks', 'WebhooksController')->name('webhooks');
