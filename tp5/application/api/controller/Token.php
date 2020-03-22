<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 15:09
 */

namespace app\api\controller;


use app\api\service\UserToken;
use app\api\Validate\TokenGet;

class Token extends BaseController
{

/*
 * get a token
 * @return null
 */
    public static function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return $token;
    }
}