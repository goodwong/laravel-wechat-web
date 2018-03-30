<?php

namespace Goodwong\WechatWeb\Handlers;

use Goodwong\WechatWeb\Events\WebUserCreated;
use Goodwong\WechatWeb\Repositories\WebUserRepository;

class WebUserHandler
{
    /**
     * construct
     * 
     * @param  WebUserRepository  $webUserRepository
     * @return void
     */
    public function __construct(WebUserRepository $webUserRepository)
    {
        $this->webUserRepository = $webUserRepository;
    }

    /**
     * create
     * 
     * @param  array  $info
     * @return WechatWebUser
     */
    public function create($info)
    {
        $info['privilege'] = json_encode($info['privilege']);

        $webUser = $this->webUserRepository->create($info);

        event(new WebUserCreated($webUser));

        return $webUser;
    }
}
