<?php

namespace Goodwong\WechatWeb\Events;

use Goodwong\WechatWeb\Entities\WechatWebUser;
use Illuminate\Queue\SerializesModels;

class WebUserCreated
{
    use SerializesModels;

    public $webUser;

    /**
     * Create a new event instance.
     *
     * @param  WechatWebUser  $webUser
     * @return void
     */
    public function __construct(WechatWebUser $webUser)
    {
        $this->webUser = $webUser;
    }
}
