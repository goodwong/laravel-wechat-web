<?php

Route::group([
    'namespace' => 'Goodwong\WechatWeb\Http\Controllers',
], function () {
    Route::resource('wechat-web-users', 'WebUserController');
});
