<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="FS模拟飞行助手在线版，完美的飞行计划生成器">
    <meta name="author" content="Ziheng Gao,VATPRC">
    <link rel="icon" href="/Public/favicon.ico">

    <title>后台管理 - 模拟飞行助手在线版</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="/Public/jumbotron-narrow.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/Public/md5.js"></script>
    <script type="text/javascript">
      function login() {
        var pid = $("#inputpid").val();
        var passwd = $("#inputPassword").val();
        if (pid == ""){
          alert("请填写您的VATSIM PID");
        }else if (passwd == ""){
          alert("请填写您的独立密码");
        }else{
          var hash = faultylabs.MD5(passwd);
          $.get("/Admin/Index/vali/pid/"+pid+"/hash/"+hash,function(data){
            if (data == "2") {
              $('#loginModal').modal('show');
            }else if(data == "1"){
              alert("密码错误！");
            }else if (data == "0") {
              setCookie("pid",pid,30);
              window.location.href="/Admin/Dashboard";
            }else{
              alert(data);
            }
          });
        }
      }
      function submit(){
        if ($("#inputPassword").val() == $("#inputPassword2").val()) {
          var pid = $("#inputpid").val();
          var passwd = faultylabs.MD5($("#inputPassword").val());
          var invite = $("#inputInviteword").val();
          $("#submit-btn").html("请稍等");
          $.get("/Admin/Index/reg/pid/"+pid+"/passwd/"+passwd+"/invite/"+invite,function(data){
            if (data == "1") {
              alert("邀请码错误");
              $("#inputInviteword").val("");
            }else if (data == "0") {
              setCookie("pid",pid,30);
              window.location.href="/Admin/Dashboard";
            }else{
              alert(data);
            }
          });
        }else{
          alert("两次输入的密码不一致！");
          $("#inputPassword").val("");
          $("#inputPassword2").val("");
          $("#inputInviteword").val("");
          $('#loginModal').modal('hide');
        }
      }
      function setCookie(c_name, value, expiredays){
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + expiredays);
        document.cookie=c_name+ "=" + escape(value) + ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
      }
    </script>
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="/Index/index">在线版</a></li>
            <li role="presentation"><a href="http://fsassistant.bmob.cn/">APP首页</a></li>
            <li role="presentation" class="active"><a href="/Admin/index">后台管理</a></li>
            <li role="presentation"><a href="/Api/index">API</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">模拟飞行助手在线版<span class="label label-danger">Preview</span></h3>
      </div>

      <div class="panel panel-primary">
  		<div class="panel-heading" id="login-heading">
    		<h3 class="panel-title" id="login-title">登陆</h3>
  		</div>
  	    <div class="panel-body" id="container-login">
          <form class="form-horizontal">
            <div class="form-group">
              <label for="inputpid" class="col-sm-2 control-label">VATSIM PID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputpid" placeholder="VATSIM PID" required="required">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-sm-2 control-label">密码</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" placeholder="独立密码" aria-describedby="helpBlock" required="required">
                <span id="helpBlock" class="help-block">如您是第一次登陆，本次填写的密码将作为您在本系统的登陆密码</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" onclick="login();">登录后台</button>
              </div>
            </div>
          </form>
  	    </div>

      <!-- Modal -->
      <div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">身份验证</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal">
                <div class="form-group">
                  <label for="inputpid" class="col-sm-2 control-label">请再输入一次密码</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword2" placeholder="重复输入密码" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword" class="col-sm-2 control-label">邀请码</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputInviteword" placeholder="邀请码" aria-describedby="helpBlock" required="required">
                    <span id="helpBlock" class="help-block">为确认您的身份，请输入邀请码，如您没有邀请码，请联系VATPRC管理员获取</span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">返回修改</button>
              <button id="submit-btn" type="button" class="btn btn-primary" onclick="submit();">提交</button>
            </div>
          </div>
        </div>
      </div>
	  </div>

      <footer class="footer">
        <p>© VATPRC 2015</p>
        <p>Coded by Ziheng Gao</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/Public/ie10-viewport-bug-workaround.js"></script>
  

</body></html>