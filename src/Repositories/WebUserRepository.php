<?php

namespace Goodwong\LaravelWechatWeb\Repositories;

use Goodwong\LaravelWechatWeb\Entities\WechatWebUser;

class WebUserRepository
{
    /**
     * find by
     * 
     * @param  string  $key
     * @param  string  $value
     * @return WechatWebUser
     */
    public function findBy($key, $value)
    {
        return WechatWebUser::where($key, $value)->first();
    }

    /**
     * create
     * 
     * @param  array  $attributes
     * @return WechatWebUser
     */
    public function create($attributes)
    {
        return WechatWebUser::create($attributes);
    }
}