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

    <title>后台管理模拟飞行助手在线版</title>

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
    <script type="text/javascript">
    function savenew () {
      var indep = $("#indep").val();
      var inarr = $("#inarr").val();
      var route = $("#inroute").val();
      $.post("/Admin/Dashboard/newroute",
      {
        indep:indep,
        inarr:inarr,
        route:route
      },function(data){
        if (data == "1") {
          $("#newroute-form").after("<span class=\"label label-danger\">保存失败</span>");
        }else if (data == "0") {
          $("#newroute-form").after("<span class=\"label label-success\">保存成功</span>");
          var time = new Date();
          var row = "<tr><th scope=\"row\">0</th><td>"+indep+"</td><td>"+inarr+"</td><td><textarea class=\"form-control\" id=\"0-route\">"+route+"</textarea></td><td>Ziheng Gao</td><td>"+time+"</td> <td><select id=\"0-status\" class=\"form-control\"><option>过期</option><option selected=\"selected\">正常</option><option>待审核</option><option>可能过期</option></select></td><td><button id=\"0-btn\" class=\"btn btn-default\" type=\"button\" onclick=\"save(0);\">保存</button><button id=\"0-btn-del\" class=\"btn btn-danger\" type=\"button\" onclick=\"del(0);\">删除</button></td></tr>";
          $("#tablebody").prepend(row);
        };
      });
    };
    function save (id) {
      if (id==0) {
        alert("新增加的航路暂不能修改，请彻底刷新后再试");
      }else{
        $.post("/Admin/Dashboard/editroute/id/"+id,
        {
          route:$("#"+id+"-route").val(),
          status:$("#"+id+"-status").val()
        },function(data){
          if (data == "1") {
            $("#"+id+"-btn").html("保存失败");
            $("#"+id+"-btn").removeClass("btn-default");
            $("#"+id+"-btn").removeClass("btn-success");
            $("#"+id+"-btn").addClass("btn-danger");
          }else if (data == "0") {
            $("#"+id+"-btn").html("保存成功");
            $("#"+id+"-btn").removeClass("btn-default");
            $("#"+id+"-btn").removeClass("btn-danger");
            $("#"+id+"-btn").addClass("btn-success");
            if ($("#"+id+"-status").val() == 0) {
              $("#row-"+id).addClass("danger");
            }else{
              $("#row-"+id).removeClass("danger");
              $("#row-"+id).removeClass("warning");
            }
          }else{
            alert(data);
          }
        });
      }
    }
    function del (id) {
      if (id==0) {
        alert("新增加的航路暂不能修改，请彻底刷新后再试");
      }else{
        $.get("/Admin/Dashboard/delroute/id/"+id,function(data){
          if (data == "1") {
            $("#"+id+"-btn-del").html("删除失败");
          }else if (data == "0") {
            $("#row-"+id).remove();
          }else{
            alert(data);
          }
        });
      }
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
        <div class="panel-heading" id="user-heading">
          <h3 class="panel-title" id="user-title">用户信息</h3>
        </div>
        <div class="panel-body" id="container-user">
          <div class="row">
            <div class="col-md-10">
              <h4>欢迎您，<?php echo ($user["vatlevel"]); ?> 管制员 <?php echo ($user["name"]); ?>,您的身份是 <?php echo ($user["leveltext"]); ?></h4>
            </div>
            <div class="col-md-2">
              <a href="/Admin/Index/logout" class="btn btn-success" role="button">登出</a>
            </div>
          </div>
        </div>
      </div>

        <ul class="nav nav-pills">
          <li role="presentation"><a href="/Admin/Dashboard/index">机场管理</a></li>
          <li role="presentation" class="active"><a href="/Admin/Dashboard/route">航路管理</a></li>
          <?php if($user["level"] == 1 ): ?><li role="presentation"><a href="/Admin/Dashboard/user">用户管理</a></li><?php endif; ?>
        </ul>

        <div class="panel panel-primary">
          <div class="panel-heading" id="newroute-heading">
            <h3 class="panel-title" id="newroute-title">添加新航路</h3>
          </div>
          <div class="panel-body" id="container-newroute">
            <form class="form-inline" id="newroute-form">
              <div class="form-group">
                <input type="text" class="form-control" id="indep" placeholder="出发机场四字码" required="required">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="inarr" placeholder="到达机场四字码" required="required">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="inroute" placeholder="航路(不含首尾标识符)" required="required">
              </div>
              <button type="button" class="btn btn-default" onclick="savenew();">保存</button>
            </form>
          </div>
        </div>

        <div class="panel panel-primary">
          <div class="panel-heading" id="route-heading">
            <h3 class="panel-title" id="route-title">航路列表</h3>
          </div>
          <div class="panel-body" id="container-route">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>出发机场</th>
                  <th>到达机场</th>
                  <th>航路</th>
                  <th>提交者</th>
                  <th>提交时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody id="tablebody">
                <?php if(is_array($routes)): foreach($routes as $key=>$r): ?><tr id="row-<?php echo ($r["id"]); ?>" <?php if($r["status"] == 0 OR $r["status"] == 3): ?>class="danger"<?php endif; if($r["status"] == 2 ): ?>class="warning"<?php endif; ?>>
                  <th scope="row"><?php echo ($r["id"]); ?></th>
                  <td><?php echo ($r["dep"]); ?></td>
                  <td><?php echo ($r["arr"]); ?></td>
                  <td><textarea class="form-control" id="<?php echo ($r["id"]); ?>-route"><?php echo ($r["route"]); ?></textarea></td>
                  <td>Ziheng Gao</td>
                  <td><?php echo ($r["submittime"]); ?></td> 
                  <td>
                    <select id="<?php echo ($r["id"]); ?>-status" class="form-control">
                      <option value="0" <?php if($r["status"] == 0 ): ?>selected="selected"<?php endif; ?>>过期</option>
                      <option value="1" <?php if($r["status"] == 1 ): ?>selected="selected"<?php endif; ?>>正常</option>
                      <option value="2" <?php if($r["status"] == 2 ): ?>selected="selected"<?php endif; ?>>待审核</option>
                      <option value="3" <?php if($r["status"] == 3 ): ?>selected="selected"<?php endif; ?>>可能过期</option>
                    </select>
                  </td>
                  <td>
                    <button id="<?php echo ($r["id"]); ?>-btn" class="btn btn-default" type="button" onclick="save(<?php echo ($r["id"]); ?>);">保存</button>
                    <button id="<?php echo ($r["id"]); ?>-btn-del" class="btn btn-danger" type="button" onclick="del(<?php echo ($r["id"]); ?>);">删除</button>
                  </td>
                </tr><?php endforeach; endif; ?>
              </tbody>
            </table>
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