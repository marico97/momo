<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value,$data)
    {
        return config('setting.img_prefix').$value;
    }

    public static function getProductDetail($id)
    {
        //千万不能在with中加空格,否则你会崩溃的
        //        $product = self::with(['imgs' => function($query){
        //               $query->order('index','asc');
        //            }])
        //            ->with('properties,imgs.imgUrl')
        //            ->find($id);
        //        return $product;
        //关联嵌套查询中 可以用数组方式在值上写闭包，用query对嵌套的值执行操作
        $product = self::with(['imgs' => function ($query)
        {
                    $query->with(['imgUrl'])
                          ->order('order', 'asc');
                }])
                       ->with('properties')
                       ->find($id);
        return $product;
    }
}
