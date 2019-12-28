<?php

namespace app\index\controller;

use \think\Controller;

use \think\Request;

use \think\Db;

use \think\Validate;

class Index extends controller
{

    public function login()
    {
        // echo md5(123456);
        if(Request::instance()->isPost()){
            $username = input('post.username');
            $password = input('post.pwd');
            $password = md5($password);
        $res = Db::table('admin')->
        where(["user"=>$username,"password"=>$password])->
        find();

        if($res){
            $this->success("登陆成功","index");
        }else{
            $this->error("登陆失败");
        }
        }else{

            return $this->fetch("admin/login");
        }
    }
    public function index()
    {
        return $this->fetch("admin/index");
    }
    public function left()
    {
        return $this->fetch("admin/left");
    }
    public function bottom()
    {
        return $this->fetch("admin/bottom");
    }
    public function main()
    {
        return $this->fetch("admin/main");
    }
    public function main_info()
    {
        return $this->fetch("admin/main_info");
    }
    public function main_list()
    {
        return $this->fetch("admin/main_list");
    }
    public function main_menu()
    {
        return $this->fetch("admin/main_menu");
    }
    public function main_message()
    {
        return $this->fetch("admin/main_message");
    }
    public function message_info()
    {
        return $this->fetch("admin/message_info");
    }
    
    public function message_replay()
    {
        return $this->fetch("admin/message_replay");
    } 
       public function swich()
    {
        return $this->fetch("admin/swich");
    } 
       public function top()
    {
        return $this->fetch("admin/top");
    }
    public function add_user()
    {
        if (Request::instance()->isPost()) {
            $file = request()->file('image');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS .'uploads');
                if($info){
                    $data['img'] = $info->getSaveName();
                }else{//上传失败获取错误信息
                    echo $file->getError();
                    $data['img']='';
                }
            }

            $validate = new Validate([
                'user'  => 'require|max:12',
                'password' => 'require|max:32|min:6'
            ]);
            $data['user'] = input('post.user');
            $data['password'] = md5(input('post.pwd'));
            $data['updatetime'] = time();
            $data['rule'] = input('post.rule');
            $captcha = input("post.captcha");   

            if(!captcha_check($captcha)){
                $this->error('输入的验证码错误');
           }else{
            if (!$validate->check($data)) {
                dump($validate->getError());
                return $this->fetch("admin/add_user");// 先继承基类才能使用
            }else{
            $id = Db::name('admin')->insertGetId($data);
            if ($id) {
                $this->success('注册成功','user_list');
            }else{
                $this->error('注册失败');
            }
        }

           } 
 
    }else{

            return $this->fetch("admin\add_user");

        }
    }

    public function user_list(){
        $data = Db::table("admin")->paginate(3);

        $this->assign("data", $data);
        
        return $this->fetch("admin/user_list");
    }
    public function del(){
        if(Request::instance()->isGet()){
            $id = input('param.id');
            $re = Db::table('admin')->delete($id,1);
            if($re){
                $this->success("删除成功");
            }else{
                $this->error("删除失败");
            }
        }
    }
    public function user_update(){
        if(Request::instance()->isGet()){
            $id = input('param.id');
            $row = Db::table('admin')->where(["id"=>$id])->find();
            $this->assign('row',$row);
            return $this->fetch("admin/user_update");
            $file = request()->file('image');
        }
        if(Request::instance()->isPost()){
            $id = input('param.id');
            $file = request()->file('image');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS .'uploads');
                if($info){
                    $data['img'] = $info->getSaveName();
                }else{//上传失败获取错误信息
                    echo $file->getError();
                    $data['img']='';
                }
            }
            $validate = new Validate([
                'user'  => 'require|max:12',
                'password' => 'require|max:32|min:6',
                'updatetime' => 'require'
            ]);
            $data['user'] = input('post.user');
            $data['password'] = md5(input('post.pwd'));
            $data['updatetime'] = time();
            $data['rule'] = input('post.rule');
            if (!$validate->check($data)) {
                dump($validate->getError());
                return $this->fetch("admin/user_update");
            }else{
                $id = Db::table('admin')->where(["id"=>$id])->update($data);
                if ($id) {
                    $this->success('修改成功','user_list');
                }else{
                    $this->error('修改失败');
                }
            }
        }
    }



}
