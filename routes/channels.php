<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('stock-channel', function () {
    return true;
});