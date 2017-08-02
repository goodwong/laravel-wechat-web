<?php

Route::group([
    'namespace' => 'Goodwong\LaravelWechatWeb\Http\Controllers',
], function () {
    Route::resource('wechat-web-users', 'WebUserController');
});
