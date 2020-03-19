<?php
namespace app\api\Model;
/**
 * Created by PhpStorm.
 * Users: moqintao
 * Date: 2020/3/14
 * Time: 10:08
 */

class Users extends BaseModel
{
    protected $hidden = [];
    protected $visible = [];
    public function items()
    {
        return $this->hasMany('','','');
    }

    public static function checkRegistMsg($data)
    {
        $data = self::get($data);
        return $data;

    }

    public function getImageAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }
    public static function registerUser($data)
    {

        if (isset($data['hobby'])) {
            if (is_array($data['hobby'])) {
                $hobby = implode(",", $data['hobby']);
            }
            else {
                return parent::NoNoNo('异常操作非数组');
            }
        }
        if (empty($data['belonguid'])) {//推荐码默认为空
            $data['belonguid'] = null;
        }

//给用户密码加盐
//                $intermediateSalt = md5(uniqid(mt_rand(), true));
//                $salt = substr($intermediateSalt, 0, 6);
//                $salts = md5($salt);

//                $password=md5($data['password']).$salts;  //把密码进行md5加密然后和salt连接
        $data['password'] = md5($data['password']);  //执行MD5散列
//                密码是  md5（用户密码.(md5(盐))）
//                token是 md5（用户ID.(md5(盐))）

//                $salt=base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM));
//                $password=sha1($register_password.$salt);第二种加盐方法

        $data['applydate'] = date('Y-m-d H:i:s', time());
//拼接数据
//        $data = [
////            'hobby'     => $hobby,
//            // 'salt'=>$salt 盐值必须添加到库要做比对用的
//        ];
//插入数据库
        $uid =self::insertGetId($data);
        if ($uid) {
            $token = md5($data['username'] . time());//生成token存入
            $result = self::where('uid', $uid)->setField(['token' => $token]);
            return $result;
        }
    }
}