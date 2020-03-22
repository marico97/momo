<?php
namespace app\api\controller;
use app\api\Validate\UsersValidate;
use think\Db;
use app\api\Model\Users as UsersModel;
class Users extends BaseController
{
//                $token = Token::createToken($mobile); //创建一个
//$result = Token::checkToken($mobile); //解析token
//           $token = Token::getToken();    //从http请求头获取


    public function registPag()//注册页面验证
    {
        $data = input('post.');
        if(in_array('', $data))
        {
            return parent::NoNoNo("请输入内容");
        }else{
            $res = UsersModel::checkRegistMsg($data);
//            ->toArray();返回为对象的时候  用来激活所有获取器
//            $res = UsersModel::with(['items','items.img'])->get($data);//关联查询以及 关联嵌套查询，嵌套的items模型中要定义belongsto img
//            $res = UsersModel::where($data)->all([],['items','items.img']);
            if ($res)
            {
                return parent::NoNoNo("已存在");
            }else {
                return parent::ojbk("可以创建");
            }
        }

    }

//    public function codejudge($code,$telphone) //不需要了 没有验证码表
//    {//用于校验验证码是否正确
//            if(isset($code,$telphone))
//            {
//            $info = Db::name('?')
//                      ->where('telphone',$telphone)
//                      ->where('status',0)
//                      ->find();
//            if(abs($info['时间戳'])-time()<=300)
//                {//十分钟内 有效
//            Db::name('?')->delete($info);
//            return parrent::ojbk('验证成功');
//            }
//            return parrent::NoNoNo('验证码失效');
//        }else{
//            return parrent::NoNoNo('手机号及验证码错误');
//        }
//    }


    public function upload()//图片上传接口
    {
        $file =request()->file('image');
        if ($file){//上传图片 返回为图片路径
            return parent::file_upload($file,md5(time().$_FILES['image']['name']));
        }

    }
    //注册页面验证信息
    public function register()//注册->验证->入库
    {
        $data = (new UsersValidate())->gocheck();

       $result = UsersModel::registerUser($data);
        if ($result){
            return parent::ojbk('注册成功');
        }
        else {
            return parent::NoNoNo('注册失败,联系客服');
        }
    }

    public function login()
    {

        $input_info = input('post.');

        if ($input_info['email']){
            $username = Db::name('users')->
            where('email',$input_info['email'])->find();
            if (!$username){
                return parent::NoNoNo('email不存在');
            }

            $user = Db::name('users')->
            where('email',$input_info['email'])->
            where('password',md5($input_info['password']))
                      ->find();

            if ($user){
                $a = Db::name('users')->where('email',$input_info['email'])->update(
                    ['lang'=>$input_info['lang']]);
                return parent::ojbk($user['token']);
            }
            else{
                return parent::NoNoNo('密码错误');
            }
        }
    }
    public function getEmail()
    {

        $input_info = input('post.');

        if ($input_info['email']){
            $username = Db::name('users')->
            where('email',$input_info['email'])->find();
            if (!$username){
                return parent::NoNoNo('email不存在');
            }
            else{
                return parent::ojbk();
            }

        }
    }
}
