<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$airports = M('airports')->order('code')->select();
        $this->assign("airports",$airports);
        $this->display();
    }
    public function data(){
        $con = array('dep' => I("post.indep"),'arr' => I("post.inarr"));
    	if ($con['dep'] == "" OR $con['arr'] == "") {
    		$data['status'] = 1;
    		$data['error'] = "出发或到达机场为空";
    		$json = json_encode($data);
    		echo $json;
    		exit;
    	}/**
    	*if (I("post.inair") == "") {
    	*	$data['status'] = 1;
    	*	$data['error'] = "机型为空";
    	*	$json = json_encode($data);
    	*	echo $json;
    	*	exit;
    	*}
    	**/
    	$list = M('route')->where($con)->order('submittime desc')->field('id,route,uid,submittime,status')->select();
    	if(!$list){
    		$data['status'] = 1;
    		$data['error'] = "没有找到记录！";
    		$json = json_encode($data);
    		echo $json;
    		exit;
    	}
    	foreach ($list as $l) {
            $d['route'] = $l['route'];
    		$d['username'] = M('users')->where('id='.$l['uid'])->getField('name');
            $d['submittime'] = $l['submittime'];
            if ($l['status'] == 1) {
                $d['outdate'] = '<button type="button" class="btn btn-success" onclick="outdate('.$l['id'].');">航路过期？</button>';
            }elseif ($l['status'] == 3) {
                $d['outdate'] = '<span class="label label-danger">可能过期，正在审核中</span>';
            }elseif ($l['status'] == 2) {
                $d['outdate'] = '<span class="label label-warning">刚刚提交，正在审核中</span>';
            }elseif ($l['status'] == 0) {
                $d['outdate'] = '<span class="label label-danger">已经被验证过期，请慎重使用</span>';
            }
            $datalist[] = $d;
    	}
    	$data['route'] = '<table id="plan-table" class="table table-striped"><thead><tr><th>#</th><th>航路</th><th>提交者</th><th>提交时间</th><th>反馈</th></tr></thead><tbody>';
    	$i = 0;
    	foreach ($datalist as $dl) {
            $i = $i+1;
            $data['route'] = $data['route'].'<tr><th scope="row">'.$i.'</th><td>'.$dl['route'].'</td><td>'.$dl['username'].'</td><td>'.$dl['submittime'].'</td><td id="outdate-td">'.$dl['outdate'].'</td></tr>';
    	}
    	$data['route'] = $data['route']."</tbody></table>";
    	$data['status'] = 0;
    	$data['dep'] = I("post.indep");
    	$data['arr'] = I("post.inarr");
    	$json = json_encode($data);
    	echo $json;
    }

    public function submit()
    {
    	$con = array();
    	$con['name'] = I("post.name");
    	$user = M("users")->where($con)->find();
    	if (is_null($user)) {
    		$result = M("users")->data($con)->add();
    		if (!$result) {
    			$data['status'] = 1;
    			$data['error'] = "无法写入到数据库，请重试！";
    			$json = json_encode($data);
    			echo $json;
    			exit;
    		}
    	}elseif (!$user) {
    		$data['status'] = 1;
    		$data['error'] = "无法连接到数据库，请联系服务器管理员！";
    		$json = json_encode($data);
    		echo $json;
    		exit;
    	}
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
        $con = array();
        $con['name'] = I("post.name");
    	$d = array(
    		'dep' => I("post.indep"),
    		'arr' => I("post.inarr"),
    		'route' => I("post.route"),
    		'uid' => M('users')->where($con)->getField('id'),
    		'status' => 2,
    	);
    	$result = M("route")->data($d)->add();
    	if (!$result) {
    		$data['status'] = 1;
    		$data['error'] = "无法写入到数据库，请重试！";
    		$json = json_encode($data);
    		echo $json;
    		exit;
    	}else{
    		$data['status'] = 0;
    		$json = json_encode($data);
    		echo $json;
    	}
    }

    public function outdate($id)
    {
        $con['id'] = $id;
        $res = M("route")->where($con)->save(array('status' => 3));
        if (!$res) {
            $data['status'] = 1;
            $data['error'] = "数据库出错！";
            echo json_encode($data);
            exit;
        }else{
            $data['status'] = 0;
            echo json_encode($data);
            exit;
        }
    }
}