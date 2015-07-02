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

    <title>模拟飞行助手在线版 - 航路查询 - 飞行计划生成器</title>

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
      function  plansubmit() {
        var AjaxURL= "/Index/data";
        var formdata = $('#planform').serialize();
        $.ajax({
          type: "POST",
          dataType: "json",
          url: AjaxURL,
          data: formdata,
          success: function (data) {
            if (data.status == 0) {
              obj = document.getElementById("error-msg");
              if (obj){
                obj.parentNode.removeChild(obj);
              };
              $("#plan-title").html($("#airport-"+data.dep).html()+" 到 "+$("#airport-"+data.arr).html()+" 的飞行计划");
              $("#container-plan").remove();
              $("#plan-heading").after(data.route);
              //$("#container-plan").html(data.route);
            }else{
              obj = document.getElementById("error-msg");
              if (obj){
                obj.innerHTML = data.error;
              }else{
                $("#planform").after("<div id=\"error-msg\" class=\"alert alert-danger\" role=\"alert\">"+data.error+"</div>");
              };
            };
          },
          error: function(data) {
            alert(data.responseText);
            obj = document.getElementById("error-msg");
            if (obj){
              obj.innerHTML = data.responseText;
            }else{
              $("#planform").after("<div id=\"error-msg\" class=\"alert alert-danger\" role=\"alert\"> 连接错误！ "+data.responseText+"</div>");
            };
          }
        });
      }
       function  newroute() {
        var AjaxURL= "/Index/submit";
        var formdata = $('#newrouteform').serialize();
        $.ajax({
          type: "POST",
          dataType: "json",
          url: AjaxURL,
          data: formdata,
          success: function (data) {
            if (data.status == 0) {
              obj = document.getElementById("c_error-msg");
              if (obj){
                obj.parentNode.removeChild(obj);
              };
              $("#newrouteform").after("<div class=\"alert alert-success\" role=\"alert\">提交成功，请等待审核！</div>");
            }else{
              obj = document.getElementById("c_error-msg");
              if (obj){
                obj.innerHTML = data.error;
              }else{
                $("#newrouteform").after("<div id=\"c_error-msg\" class=\"alert alert-danger\" role=\"alert\">"+data.error+"</div>");
              };
            };
          },
          error: function(data) {
            obj = document.getElementById("c_error-msg");
            if (obj){
              obj.innerHTML = data.responseText;
            }else{
              $("#newrouteform").after("<div id=\"c_error-msg\" class=\"alert alert-danger\" role=\"alert\"> 连接错误！ "+data.responseText+"</div>");
            };
          }
        });
      }
      function outdate (id) {
        var AjaxURL= "/Index/outdate/id/"+id;
        $.ajax({
          type: "GET",
          dataType: "json",
          url: AjaxURL,
          success: function (data) {
            if (data.status == 0) {
              obj = document.getElementById("p_error-msg");
              if (obj){
                obj.parentNode.removeChild(obj);
              };
              $("#plan-table").after("<div class=\"alert alert-success\" role=\"alert\">提交成功，请等待审核！</div>");
              $("#outdate-td").html("<span class=\"label label-danger\">可能过期，正在审核中</span>");
            }else{
              obj = document.getElementById("p_error-msg");
              if (obj){
                obj.innerHTML = data.error;
              }else{
                $("#plan-table").after("<div id=\"p_error-msg\" class=\"alert alert-danger\" role=\"alert\">"+data.error+"</div>");
              };
            };
          },
          error: function(data) {
            obj = document.getElementById("p_error-msg");
            if (obj){
              obj.innerHTML = data.responseText;
            }else{
              $("#plan-table").after("<div id=\"p_error-msg\" class=\"alert alert-danger\" role=\"alert\"> 连接错误！ "+data.responseText+"</div>");
            };
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
            <li role="presentation" class="active"><a href="/">在线版</a></li>
            <li role="presentation"><a href="http://fsassistant.bmob.cn/">APP首页</a></li>
            <li role="presentation"><a href="/Admin/index">后台管理</a></li>
            <li role="presentation"><a href="/Api/index">API</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">模拟飞行助手在线版<span class="label label-danger">Preview</span></h3>
      </div>

      <div class="panel panel-primary">
  		<div class="panel-heading" id="plan-heading">
    		<h3 class="panel-title" id="plan-title">生成飞行计划</h3>
  		</div>
  	    <div class="panel-body" id="container-plan">
    	    <form id="planform" class="form-horizontal col-sm-offset-3 col-sm-6">
  				<div class="form-group">
    				<label for="indep" class="col-sm-3 control-label">出发机场</label>
    				<div class="col-sm-9">
      				<select class="form-control" id="indep" name="indep">
  							<option value="" selected="selected">请选择出发机场</option>
                    <?php if(is_array($airports)): foreach($airports as $key=>$a): ?><option value="<?php echo ($a["code"]); ?>" id="airport-<?php echo ($a["code"]); ?>"><?php echo ($a["code"]); ?> | <?php echo ($a["text"]); ?></option><?php endforeach; endif; ?>
  						</select>
    				</div>
  				</div>
  				<div class="form-group">
    				<label for="inarr" class="col-sm-3 control-label">到达机场</label>
    				<div class="col-sm-9">
      				<select class="form-control" id="inarr" name="inarr">
  							<option value="" selected="selected">请选择到达机场</option>
                    <?php if(is_array($airports)): foreach($airports as $key=>$a): ?><option value="<?php echo ($a["code"]); ?>"><?php echo ($a["code"]); ?> | <?php echo ($a["text"]); ?></option><?php endforeach; endif; ?>
  						</select>
    				</div>
  				</div>
          <!--
  				<div class="form-group">
    				<label for="inair" class="col-sm-2 control-label">机型</label>
    				<div class="col-sm-10">
      				<select class="form-control" id="inair" name="inair" aria-describedby="helpBlock">
  							<option value="" selected="selected">请选择您的机型</option>
  						</select>
              <span id="helpBlock" class="help-block">数据由<a href="http://www.fuelplanner.com">FuelPlanner</a>提供，正在开发中，机型选项暂不可用</span>
    				</div>
  				</div>
          -->
  				<div class="form-group">
    				<div class="col-sm-offset-3 col-sm-9">
      				<button type="button" class="btn btn-success" onclick="plansubmit();">生成计划</button>
    				</div>
  				</div>
			</form>
  	    </div>
	  </div>

	  <div class="panel panel-primary">
  		<div class="panel-heading">
    		<h3 class="panel-title">贡献航路</h3>
  		</div>
  	    <div class="panel-body">
    	    <form class="form-inline" id="newrouteform">
    	    	<div class="form-group">
    	    		<input type="text" class="form-control col-sm-3" id="cindep" name="indep" placeholder="出发机场四字码" required="required">
    	    	</div>
    	    	<div class="form-group">
    	    		<input type="text" class="form-control col-sm-3" id="cinarr" name="inarr" placeholder="到达机场四字码" required="required">
    	    	</div>
    	    	<div class="form-group">
    	    		<input type="text" class="form-control col-sm-6" id="croute" name="route" placeholder="航路" required="required">
    	    	</div>
            <div class="form-group">
              <input type="text" class="form-control col-sm-6" id="cname" name="name" placeholder="请键入您的姓名" required="required">
            </div>
    	    	<button type="button" class="btn btn-success" onclick="newroute();">提交审核</button>
    	    </form>
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