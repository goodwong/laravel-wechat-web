<?php

/**
 * 微信扫码登录的配置
 * 
 * 参考：https://easywechat.org/zh-cn/docs/configuration.html
 */

return [
    /**
     * 当未登录时，是否跳转？
     */
    'auto_redirect' => env('WECHAT_WEB_AUTO_REDIRECT', true),

    /**
     * 是否使用session缓存微信资料
     * 
     * 若不缓存，又强制登录时，需要在WechatWebUserAuthorized事件中
     * 设置为登录状态，否则仍然会循环扫码
     */
    'use_session' => env('WECHAT_WEB_USE_SESSION', true),

    /**
     * 配置参数，在开放平台里获取
     */
    'app_id' => env('WECHAT_WEB_APPID', 'your-app-id'),
    'secret' => env('WECHAT_WEB_SECRET', 'your-app-secret'),
];