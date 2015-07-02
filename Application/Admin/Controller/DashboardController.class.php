<?php
namespace Admin\Controller;
use Think\Controller;
class DashBoardController extends Controller {
    public function index(){
        if (!cookie("pid")) {
            $this->error("您还没登陆",'/Admin/Index');
        }else{
            $user = M("users")->where("pid=".cookie("pid"))->find();
            if ($user['level'] == 1) {
            	$user['leveltext'] = "系统管理员";
            }else{
            	$user['leveltext'] = "航路管理员";
            }
            unset($user['password']);
            $airports = M("airports")->select();
            $this->assign("airports",$airports);
            $this->assign("user",$user);
            $this->display();
        }
    }

    public function route(){
        if (!cookie("pid")) {
            $this->error("您还没登陆",'/Admin/Index');
        }else{
            $user = M("users")->where("pid=".cookie("pid"))->find();
            if ($user['level'] == 1) {
            	$user['leveltext'] = "系统管理员";
            }else{
            	$user['leveltext'] = "航路管理员";
            }
            unset($user['password']);
            $routes = M("route")->order('status desc,dep,arr')->select();
            $this->assign("routes",$routes);
            $this->assign("user",$user);
            $this->display();
        }
    }

    public function user(){
        if (!cookie("pid")) {
            $this->error("您还没登陆",'/Admin/Index');
        }else{
            $user = M("users")->where("pid=".cookie("pid"))->find();
            if ($user['level'] == 1) {
            	$user['leveltext'] = "系统管理员";
            }else{
            	$user['leveltext'] = "航路管理员";
            }
            unset($user['password']);
            $users = M("users")->select();
            $this->assign("users",$users);
            $this->assign("user",$user);
            $this->display();
        }
    }

    public function newairport(){
        $data['code'] = I("post.code");
        $data['text'] = I("post.text");
        $res = M("airports")->add($data);
        if (!$res) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function editairport(){
        $code = I("post.code");
        $data['text'] = I("post.text");
        $res = M("airports")->where(array('code'=>$code))->save($data);
        if (!$res) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function delairport($code){
        $res = M("airports")->where(array('code'=>$code))->delete();
        if (!$res) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function newroute()
    {
        $con = array();
        $con['code'] = I('post.indep');
        $dep = M('airports')->where($con)->find();
        if (!$dep) {
            M("airports")->data($con)->add();
        }
        $con['code'] = I('post.inarr');
        $arr = M('airports')->where($con)->find();
        if (!$arr) {
            M("airports")->data($con)->add();
        }
        $d = array(
            'dep' => I("post.indep"),
            'arr' => I("post.inarr"),
            'route' => I("post.route"),
            'uid' => M('users')->where("pid=".$_COOKIE['pid'])->getField('id'),
            'status' => 1,
        );
        $result = M("route")->data($d)->add();
        if (!$result) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function editroute($id)
    {
        $data['route'] = I("post.route");
        $data['status'] = I("post.status");
        $result = M("route")->where("id=".$id)->save($data);
        if (!$result) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function delroute($id)
    {
        $result = M("route")->where("id=".$id)->delete();
        if (!$result) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function edituser($uid)
    {
        $data['name'] = I("post.name");
        $res = M("users")->where(array('id'=>$uid))->save($data);
        if (!$res) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }

    public function deluser($uid)
    {
        $data['pid'] = "";
        $data['password'] = "";
        $data['vatlevel'] = "";
        $res = M("users")->where(array('id'=>$uid))->save($data);
        if (!$res) {
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }
}