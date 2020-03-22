<?php
/**
 * Created by PhpStorm.
 * Author: moqintao
 * Date: 2020/3/15
 * Time: 14:26
 */

namespace app\api\Validate;
class IDMustBePostiveInt extends BaseValidate
{

    protected $rule = [
        'id'=> 'require|isPositiveIntegers',

    ];

    protected function isPositiveIntegers($value,$rule = '',
        $data = '',$field = '')
    {
        $this->isPositiveInteger($value,$rule='',$data='',$field='');
    }
}