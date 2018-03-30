<?php

namespace Goodwong\WechatWeb\Middleware;

use Log;
use Closure;
use Illuminate\Http\Request;
use Goodwong\WechatWeb\Handlers\WebUserHandler;
use Goodwong\WechatWeb\Events\WebUserAuthorized;
use Goodwong\WechatWeb\Repositories\WebUserRepository;
use EasyWeChat\Foundation\Application as EasyWechatApplication;

class OAuthAuthenticate
{
    /**
     * construct
     * 
     * @param  WebUserHandler  $webUserHandler
     * @param  WebUserRepository  $webUserRepository
     * @return void
     */
    public function __construct(WebUserHandler $webUserHandler, WebUserRepository $webUserRepository)
    {
        $this->webUserHandler = $webUserHandler;
        $this->webUserRepository = $webUserRepository;

        $config = [
            'app_id' => config('wechat_web_oauth.app_id'),
            'secret' => config('wechat_web_oauth.secret'),
        ];
        $this->wechat = new EasyWechatApplication($config);
    }

    /**
     * Handle an incoming request.
     * 
     * @param Request  $request
     * @param \Closure  $next
     * @param string|null  $scopes
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $scopes = null)
    {
        $redirect = config('wechat_web_oauth.auto_redirect');
        $useSession = config('wechat_web_oauth.use_session');

        // 已登录用户
        if ($request->user()) {
            return $next($request);
        }
        // 微信，跳过
        if ($this->isWeChatBrowser($request)) {
            return $next($request);
        }

        if (!$request->has('code')) {
            // 如果不强制登录，则直接通过
            if (!$redirect) {
                return $next($request);
            }
            // 2. 有缓存
            if ($useSession && session('wechat_web.oauth_user')) {
                return $next($request);
            }
            // 3. 转去扫码
            return $this->wechat->oauth->scopes(['snsapi_login'])->redirect($request->fullUrl());
        }

        // HANDLE
        $info = $this->wechat->oauth->user()->getOriginal();
        Log::info('[wechat_web_login] original info: ', (array)$info);

        $webUser = $this->webUserRepository->findBy('openid', $info['openid']);
        if (!$webUser) {
            $webUser = $this->webUserHandler->create($info);
        }

        event(new WebUserAuthorized($webUser));

        if ($useSession) {
            session(['wechat_web.oauth_user' => $webUser]);
        }

        return redirect()->to($this->getTargetUrl($request));
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);
        return $request->url().(empty($queries) ? '' : '?'.http_build_query($queries));
    }

    /**
     * Detect current user agent type.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isWeChatBrowser($request)
    {
        return stripos($request->header('user_agent'), 'MicroMessenger') !== false;
    }

    /**
     * Detect current user agent type.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isMobile($request)
    {
        return stripos($request->header('user_agent'), 'Mobile') !== false;
    }
}
