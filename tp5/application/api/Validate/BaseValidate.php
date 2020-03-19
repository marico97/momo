<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 23:11
 */

namespace app\api\Validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function gocheck()
    {
        //获取http传入的参数
        //对这些参数进行校验
        $request = Request::instance();
        $params = $request->param();
        if (!$this->batch()->check($params)){
            $exception = new ParameterException([
                'msg' =>is_array($this->error)?implode(';',$this->error):$this->error,
            ]);

//            $as =json_decode(json_encode($exception,true));
//            $as =get_object_vars($as);
//            echo  (json_encode($as));die;
//            var_dump($as);die;
            throw  $exception;

        }

            return $params;


}}