<?php

// H5 高级 API 鉴权
Route::get('dingding/jsapi-signature', [\Smartymoon\DingTalk\Controllers\DingDingController::class, 'jsapiSignature']);

// 钉钉事件回调
\Route::post('dingding/event/callback', [\Smartymoon\DingTalk\Controllers\DingDingController::class, 'serve']);