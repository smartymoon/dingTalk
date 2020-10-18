<?php

\Route::post('dingding/event/callback', [\Smartymoon\DingTalk\Controllers\DingDingController::class, 'serve']);