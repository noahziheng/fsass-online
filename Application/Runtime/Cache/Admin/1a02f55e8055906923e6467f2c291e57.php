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
    function savenew (code) {
      $.post("/Admin/Dashboard/newairport",
      {
        code:$("#incode").val(),
        text:$("#intext").val()
      },function(data){
        if (data == "1") {
          $("#newaiport-form").after("<span class=\"label label-danger\">保存失败</span>");
        }else if (data == "0") {
          $("#newaiport-form").after("<span class=\"label label-success\">保存成功，刷新可见</span>");
        }else{
          alert(data);
        }
      });
    }
    function save (code) {
      $.post("/Admin/Dashboard/editairport",
      {
        code:code,
        text:$("#text-"+code).val()
      },function(data){
        if (data == "1") {
          $("#"+code+"-btn").html("保存失败");
          $("#"+code+"-btn").removeClass("btn-default");
          $("#"+code+"-btn").removeClass("btn-success");
          $("#"+code+"-btn").addClass("btn-danger");
        }else if (data == "0") {
          $("#"+code+"-btn").html("保存成功");
          $("#"+code+"-btn").removeClass("btn-default");
          $("#"+code+"-btn").removeClass("btn-danger");
          $("#"+code+"-btn").addClass("btn-success");
        }else{
          alert(data);
        }
      });
    }
    function del (code) {
      $.get("/Admin/Dashboard/delairport/code/"+code,function(data){
        if (data == "1") {
          $("#"+code+"-btn-del").html("删除失败");
        }else if (data == "0") {
          $("#row-"+code).remove();
        }else{
          alert(data);
        }
      });
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
          <li role="presentation" class="active"><a href="/Admin/Dashboard/index">机场管理</a></li>
          <li role="presentation"><a href="/Admin/Dashboard/route">航路管理</a></li>
          <?php if($user["level"] == 1 ): ?><li role="presentation"><a href="/Admin/Dashboard/user">用户管理</a></li><?php endif; ?>
        </ul>

        <div class="panel panel-primary">
          <div class="panel-heading" id="newairport-heading">
            <h3 class="panel-title" id="newairport-title">添加新机场</h3>
          </div>
          <div class="panel-body" id="container-newairport">
            <form class="form-inline" id="newaiport-form">
              <div class="form-group">
                <label for="incode">机场代码</label>
                <input type="text" class="form-control" id="incode" required="required">
              </div>
              <div class="form-group">
                <label for="intext">机场名</label>
                <input type="text" class="form-control" id="intext" required="required">
              </div>
              <button type="button" class="btn btn-default" onclick="savenew($('#incode').val());">保存</button>
            </form>
          </div>
        </div>

        <div class="panel panel-primary">
          <div class="panel-heading" id="airport-heading">
            <h3 class="panel-title" id="airport-title">机场列表</h3>
          </div>
          <div class="panel-body" id="container-airport">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>机场代码</th>
                  <th>机场名称</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?php if(is_array($airports)): foreach($airports as $key=>$ap): ?><tr id="row-<?php echo ($ap["code"]); ?>">
                    <th scope="row"><?php echo ($ap["id"]); ?></th>
                    <td><?php echo ($ap["code"]); ?></td>
                    <td><input type="text" class="form-control" id="text-<?php echo ($ap["code"]); ?>" value="<?php echo ($ap["text"]); ?>" ></td>
                    <td>
                      <button id="<?php echo ($ap["code"]); ?>-btn" class="btn btn-default" type="button" onclick="save('<?php echo ($ap["code"]); ?>');">保存</button>
                      <button id="<?php echo ($ap["code"]); ?>-btn-del" class="btn btn-danger" type="button" onclick="del('<?php echo ($ap["code"]); ?>');">删除</button>
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