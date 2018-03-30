# Laravel 5 Wechat Web

微信网站扫码登录

> **注意：** 本模块不依赖用户模块，数据表里的`user_id`可以由开发者通过事件关联到用户表
> **注意：** 依赖`overtrue/wechat`作服务层


## 特别注意：
> 因为微信扫码对浏览器没有判断能力（像钉钉扫码可以限制在UserAgent含有Dingtalk时显示），
建议在设置`middleware`时顺序放最后面，
比如放在`goodowng/laravel-dingtalk-oauth`后面，
因为dingtalk可以根据UserAgent判断是否符合钉钉扫码条件，
不符合钉钉再显示微信二维码，不容易冲突或者拦截掉本该显示钉钉二维码的场景。



## 原理

1. 当用户满足以下条件时，解析微信信息：

	1. `未登录`
	1. 且`非微信客户端`
	1. url中有`code`参数时

2. middleware解析该请求，获得该登录者微信信息；

3. 根据该微信信息，查找或创建`WechatWebUser`身份；

4. 若是新用户，则触发`WebUserCreated($wechatWebUser)`事件

5. 触发`WebUserAuthorized($wechatWebUser)`事件


> **注意：**本模块不会自动创建`User`用户，更不会自动登录。若有类似需求，需要监听以下事件并写相应逻辑的代码：
> - 监听`WebUserCreated`事件，创建`User`对象
> - 监听`WebUserAuthorized`事件，进行登录用户的逻辑




## 安装

1. 安装依赖模块
    ```shell
    composer require "goodwong/laravel-wechat-web"
    ```

2. 打开config/app.php，在providers数组里注册服务：
    ```php
    // Application Service Providers...
    Goodwong\WechatWeb\WechatWebServiceProvider::class,
    ```

3. 创建数据库表
    ```shell
    php artisan migrate
    ```

4. 设置 appid / appsecret
    在.env文件中，增加下面内容：
    ```ini
    WECHAT_WEB_APPID=
    WECHAT_WEB_SECRET=
    WECHAT_WEB_AUTO_REDIRECT=
    WECHAT_WEB_USE_SESSION=
    ```

## OAuth 中间件
有两种方式设置中间件：

- 设置 middleware
    在app/Http/Kernel.php里添加：
    ```php
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // ...

        'wechat_web_oauth' => \Goodwong\WechatWeb\Middleware\OAuthAuthenticate::class,
    ];
    ```

- 直接在web.php的路由规则里添加：
    ```php
    // user auth
    Route::group([
        'middleware' => [
            \Goodwong\WechatWeb\Middleware\OAuthAuthenticate::class,
        ],
    ], function () {
        // ...
    });

    ```

## 配置
在.env文件中，配置以下信息：

- 微信平台
    ```ini
    WECHAT_WEB_APPID=
    WECHAT_WEB_SECRET=
    ```
    > 这些信息可以在开放平台里注册获取

- 当用户未登录时，是否跳转路由到微信扫码登录网站？默认不跳转（由开发者自己发起跳转，或者在前端页面中显示二维码）
    ```ini
    WECHAT_WEB_AUTO_REDIRECT=true
    ```

- 是否使用session缓存微信扫码结果？默认不缓存
    ```ini
    WECHAT_WEB_USE_SESSION=0
    ```
