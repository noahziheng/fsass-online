<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if (!cookie("pid")) {
        	$this->display();
        }else{
        	$this->success("您已登录！","/Admin/Dashboard");
        }
    }

    public function vali($pid,$hash){
    	$res = M("users")->where('pid='.$pid)->find();
    	if (!$res) {
    		echo 2;
    		exit;
    	}else{
    		if (strtoupper($res['password']) != strtoupper($hash)){
    			echo 1;
    			exit;
    		}else{
    			echo 0;
    			exit;
    		}
    	}
    }
    public function reg($pid,$passwd,$invite){
        $code = "VATPRC12138";
        if ($invite != $code) {
    		echo 1;
    		exit;
    	}else{
    		$vdata = json_decode(file_get_contents("http://api.vateud.net/members/id/".$pid.".json"));
            if (!$vdata OR !$vdata->active) {
                echo "VATSIM账号不正确";
                exit;
            }else{
                $data['name'] = $vdata->firstname." ".$vdata->lastname;
                $User = M("users");
                $res = $User->where($data)->find();
                $con = $data;
                $data['vatlevel'] = $vdata->humanized_atc_rating;
                $data['pid'] = intval($pid);
                $data['password'] = $passwd;
                if (!$res) {
                    $res = $User->add($data);
                }else{
                    $res = $User->where($con)->save($data);
                }
                if (!$res) {
                    echo "写入错误！";
                    exit;
                }else{
                    echo 0;
                    exit;
                }
            }
   		}
    }

    public function logout()
    {
        setcookie("pid",$_COOKIE['pid'],time()-1,'/Admin/');
        setcookie("pid",$_COOKIE['pid'],time()-1,'/');
        setcookie("pid",$_COOKIE['pid'],time()-1,'/Admin/Index/');
        setcookie("pid",$_COOKIE['pid'],time()-1,'/Admin/Dashboard/');
        $this->success("成功登出！","/");
    }
}