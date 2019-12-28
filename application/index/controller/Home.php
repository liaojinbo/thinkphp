<?php

namespace app\index\controller;

use \think\Controller;

use \think\Request;

use \think\Db;

use \think\Validate;

class Home extends controller
{
        public function index(){  
            
            $navData = Db::table('column')
            ->where(['is_play'=>1])
            ->order('id Asc')
            ->select();  
            $this->assign('navData',$navData);
            
            if(Request::instance()->isPost()){
                $kk = input('post.search');
            }else{
                $kk = '';
            }
            $where['title']=['like',"%$kk%"];
            $data = Db::table("tourism")
            ->where($where)
            ->select();
            $this->assign('data',$data);

            return $this->fetch("home/index");
        }

        public function list(){

            $navData = Db::table('column')
            ->where(['is_play'=>1])
            ->order('id Asc')
            ->select();
            $this->assign('navData',$navData);

            $data = Db::table("tourism")->select();
            $this->assign('data',$data);

            $navId = input('param.navId');
            switch($navId){
                case 1:
                    return $this->fetch('home/index');
                break;
                case 2:
                    return $this->fetch('home/information');
                break;
                case 3:
                    return $this->fetch('home/ticket');
                break;
                case 4:
                    return $this->fetch('home/scenery');
                break;
                case 5:
                    return $this->fetch('home/about');
                break;

            }         
        }
        public function details(){

            $navData = Db::table('column')
            ->where(['is_play'=>1])
            ->order('id Asc')
            ->select();
            $this->assign('navData',$navData);

            $data = Db::table("tourism")->select();
            $this->assign('data',$data);
            
            $id = input('param.id');
            $row = Db::table('tourism')->where(["id"=>$id])->find();
            $this->assign('row',$row);
            // echo count($row);
            return $this->fetch('home/details');
        }


}
