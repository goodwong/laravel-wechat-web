<?php

namespace Goodwong\LaravelWechatWeb\Handlers;

use Goodwong\LaravelWechatWeb\Events\WebUserCreated;
use Goodwong\LaravelWechatWeb\Repositories\WebUserRepository;

class CreateWebUserHandler
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