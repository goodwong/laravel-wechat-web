<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatWebUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_web_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('openid')->unique();
            $table->string('nickname', 32)->nullable();
            $table->string('sex', 8)->nullable();
            $table->string('province', 8)->nullable();
            $table->string('city', 16)->nullable();
            $table->string('country', 16)->nullable();
            $table->string('headimgurl')->nullable();
            $table->string('privilege')->nullable();
            $table->string('unionid')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('user_id')
            // ->references('id')->on('users')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wechat_web_users', function (Blueprint $table) {
            // $table->dropForeign('wechat_web_users_user_id_foreign');
        });

        Schema::dropIfExists('wechat_web_users');
    }
}
