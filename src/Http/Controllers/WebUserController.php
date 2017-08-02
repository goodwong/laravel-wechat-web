<?php

namespace Goodwong\LaravelWechatWeb\Http\Controllers;

use Goodwong\LaravelWechatWeb\Entities\WechatWebUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = WechatWebUser::getModel();
        // order by
        $query = $query->orderBy('id', 'desc');
        // get all wechatWebUsers
        if (!$request->has('users')) {
            return $query->paginate();
        }
        // where
        $ids = explode(',', $request->input('users'));
        $query = $query->whereIn('user_id', $ids);
        return $query->paginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Goodwong\LaravelWechatWeb\Entities\WechatWebUser  $wechatWebUser
     * @return \Illuminate\Http\Response
     */
    public function show(WechatWebUser $wechatWebUser)
    {
        return $wechatWebUser;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Goodwong\LaravelWechatWeb\Entities\WechatWebUser  $wechatWebUser
     * @return \Illuminate\Http\Response
     */
    public function edit(WechatWebUser $wechatWebUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Goodwong\LaravelWechatWeb\Entities\WechatWebUser  $wechatWebUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WechatWebUser $wechatWebUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Goodwong\LaravelWechatWeb\Entities\WechatWebUser  $wechatWebUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(WechatWebUser $wechatWebUser)
    {
        //
    }
}
