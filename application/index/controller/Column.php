<?php

namespace app\index\controller;

use \think\Controller;

use \think\Request;

use \think\Db;

use \think\Validate;

class column extends controller
{
    public function index(){
        echo '123';
    }
   public function add_column(){

    if(Request::instance()->isPost()){

        $data['column_name']=input('param.column_name');
        $data['pid']=input('param.pid');
        $data['remark']=input('param.remark');
        $data['is_play']=input('param.is_play');
        $data['update_time']=time();
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
        $id = Db::name('column')->insertGetId($data);
        if ($id) {
            $this->success('添加成功','add_column');
        }else{
            $this->error('添加失败');
        }
    }
        $data = Db::table("column")->select();
        $this->assign('data',$data);
      return $this->fetch("admin/add_column");
   }
   public function column_list(){
    $data = Db::table("column")
    ->order('id desc')
    ->paginate(3);

    $this->assign("data", $data);
    
    return $this->fetch("admin/column_list");
       
   }

   public function del_column(){
    if(Request::instance()->isGet()){
        $id = input('param.id');
        $re = Db::table('column')->delete($id,1);
        if($re){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
   }

   public function column_update(){
 
    if(Request::instance()->isGet()){
        $data = Db::table("column")->select();
        $this->assign('data',$data);

        $id = input('param.id');
        $row = Db::table('column')->where(["id"=>$id])->find();
        $this->assign('row',$row);
        return $this->fetch("admin/column_update");
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
            'column_name'  => 'require',
            'remark' => 'require'

        ]);
        $data['column_name'] = input('post.column_name');
        $data['remark'] = input('post.remark');
        $data['update_time'] = time();
        $data['is_play'] = input('post.is_play');
        $data['pid'] = input('post.pid');
        if (!$validate->check($data)) {
            dump($validate->getError());
            return $this->fetch("admin/column_update");
        }else{
            $id = Db::table('column')->where(["id"=>$id])->update($data);
            if ($id) {
                $this->success('修改成功','column_list');
            }else{
                $this->error('修改失败');
            }
        }
    }

    }

    public function add_content(){
        if(Request::instance()->isPost()){

            $data['title']=input('param.title');
            $data['column_id']=input('param.column_id');
            $data['remark']=input('param.remark');
            $data['author']=input('param.author');
            $data['content']=input('param.content');
            $data['update_time']=time();
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
            $id = Db::name('content')->insertGetId($data);
            if ($id) {
                $this->success('添加成功','add_content');
            }else{
                $this->error('添加失败');
            }
        }
            $column_data = Db::table("column")->select();
            $this->assign('column_data',$column_data);

            $data = Db::table("content")->select();
            $this->assign('data',$data);
          return $this->fetch("admin/add_content");
       }

        public function content_list(){

            if(Request::instance()->isPost()){
                $kk = input('post.search');
            }else{
                $kk = '';
            }
            // var_dump($kk);
            $where['title']=['like',"%$kk%"];
            $data = Db::table("content")
            ->field('content.*,column.column_name')
            ->join('column','content.column_id=column.id')
            ->where($where)
            ->order('content.id desc')
            ->paginate(3);
        
            $this->assign("data", $data);
            
            return $this->fetch("admin/content_list");
               
           }
           public function del_content(){

            if(Request::instance()->isGet()){
                $id = input('param.id');
                $re = Db::table('content')->delete($id,1);
                if($re){
                    $this->success("删除成功");
                }else{
                    $this->error("删除失败");
                }
            }
           }

           public function content_update(){
            if(Request::instance()->isGet()){
            //栏目表数据 
            $column_data = Db::table("column")->select();
            $this->assign('column_data',$column_data);

                $data = Db::table("content")->select();
                $this->assign('data',$data);
        
                $id = input('param.id');
                $row = Db::table('content')->where(["id"=>$id])->find();
                $this->assign('row',$row);
                return $this->fetch("admin/content_update");
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
                    'title'  => 'require',
                    'remark' => 'require'
        
                ]);
                $data['title']=input('param.title');
                $data['column_id']=input('param.column_id');
                $data['remark']=input('param.remark');
                $data['author']=input('param.author');
                $data['content']=input('param.content');
                $data['update_time']=time();
                if (!$validate->check($data)) {
                    dump($validate->getError());
                    return $this->fetch("admin/content_update");
                }else{
                    $id = Db::table('content')->where(["id"=>$id])->update($data);
                    if ($id) {
                        $this->success('修改成功','content_list');
                    }else{
                        $this->error('修改失败');
                    }
                }
            }

           }

           public function tourism(){

            if(Request::instance()->isPost()){
                $kk = input('post.search');
            }else{
                $kk = '';
            }
            // var_dump($kk);
            $where['title']=['like',"%$kk%"];
            $data = Db::table("tourism")
            ->where($where)
            ->order('id desc')
            ->paginate(3);
        
            $this->assign("data", $data);
            
            return $this->fetch("admin/tourism");
               
           }

           public function add_tourism(){
            if(Request::instance()->isPost()){
    
                $data['title']=input('param.title');
                $data['remark']=input('param.remark');
                $data['price']=input('param.price');
                $data['degree']=input('param.degree');
                $data['content']=input('param.content');
                $data['update_time']=time();
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
                $id = Db::name('tourism')->insertGetId($data);
                if ($id) {
                    $this->success('添加成功','add_tourism');
                }else{
                    $this->error('添加失败');
                }
            }
                // $column_data = Db::table("column")->select();
                // $this->assign('column_data',$column_data);
              return $this->fetch("admin/add_tourism");
           }


           public function tourism_update(){
            if(Request::instance()->isGet()){
                $data = Db::table("tourism")->select();
                $this->assign('data',$data);
        
                $id = input('param.id');
                $row = Db::table('tourism')->where(["id"=>$id])->find();
                $this->assign('row',$row);
                return $this->fetch("admin/tourism_update");
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
                $data['title'] = input('post.title');
                $data['remark'] = input('post.remark');
                $data['update_time'] = time();
                $data['price'] = input('post.price');
                $data['degree'] = input('post.degree');
                $data['content'] = input('post.content');
                    $id = Db::table('tourism')->where(["id"=>$id])->update($data);
                    if ($id) {
                        $this->success('修改成功','tourism');
                    }else{
                        $this->error('修改失败');
                    }
            }
        }
        public function del_tourism(){
            if(Request::instance()->isGet()){
                $id = input('param.id');
                $re = Db::table('tourism')->delete($id,1);
                if($re){
                    $this->success("删除成功");
                }else{
                    $this->error("删除失败");
                }
            }
        }

}
