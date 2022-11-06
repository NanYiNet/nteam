<?php
include('./Common/Core_brain.php');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>首页扩展功能 - <?php echo conf('Name');?></title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta content="<?php echo conf('Descriptison');?>" name="descriptison">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<meta name="author" content="<?php echo conf('Name');?>">
<link href="./assets/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="./assets/admin/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="./assets/admin/js/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link href="./assets/admin/css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid p-t-15">
<?php
$my=isset($_GET['my'])?$_GET['my']:null;
if($my=='Query')
{
?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<form method="POST" class="row" onsubmit="return QueryTeam()" role="form">
<div class="form-group col-md-12">
<label for="qq">QQ号</label>
<input type="text" class="form-control" name="qq" value="" placeholder="请输入您要查询的QQ号" />
</div>
<?php if(conf('Vaptcha_Open') == 1) {?>
<div id="vaptchaContainer" class="form-group col-md-12">
<div class="vaptcha-init-main">
<div class="vaptcha-init-loading">
<a href="/" target="_blank">
<img src="https://r.vaptcha.com/public/img/vaptcha-loading.gif"/>
</a>
<span class="vaptcha-text">人机验证启动中...</span>
</div>
</div>
</div>
<?php }?>
<div class="form-group col-md-12">
<input type="submit" class="btn btn-primary">
</div>
</form>
</div>
</div>
</div>
</div>
<?php
}
elseif($my=='Join')
{
?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<form method="POST" class="row" onsubmit="return JoinTeam()" role="form">
<div class="form-group col-md-12">
<label for="name">成员名称</label>
<input type="text" class="form-control" name="TeamName" value="" placeholder="请输入成员名称" />
</div>
<div class="form-group col-md-12">
<label for="qq">成员QQ</label>
<input type="text" class="form-control" name="TeamQq" value="" placeholder="请输入成员QQ" />
</div>
<div class="form-group col-md-12">
<label for="describe">成员简介</label>
<input type="text" class="form-control" name="TeamDescribe" value="" placeholder="请输入成员简介" />
</div>
<?php if(conf('Vaptcha_Open') == 1) {?>
<div id="vaptchaContainer" class="form-group col-md-12">
<div class="vaptcha-init-main">
<div class="vaptcha-init-loading">
<a href="/" target="_blank">
<img src="https://r.vaptcha.com/public/img/vaptcha-loading.gif"/>
</a>
<span class="vaptcha-text">人机验证启动中...</span>
</div>
</div>
</div>
<?php }?>
<div class="form-group col-md-12">
<input type="submit" class="btn btn-primary">
</div>
</form>
</div>
</div>
</div>
</div>
<?php
}
?>
</div>
<script type="text/javascript" src="./assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="./assets/admin/js/bootstrap.min.js"></script>
<script src="./assets/admin/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="./assets/admin/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script type="text/javascript" src="./assets/admin/js/main.min.js"></script>
<script src="./assets/layer/layer.js"></script>
<?php if(conf('Vaptcha_Open') == 1) {?>
<script src='https://v.vaptcha.com/v3.js'></script>
<script>
var obj;
vaptcha({
  vid: '<?php echo conf('Vaptcha_Vid')?>', 
  type: 'click', 
  scene: 0, 
  container: '#vaptchaContainer', 
  offline_server: '#', 
  lang: 'zh-CN',
  https: true,
  color: '#5c8af7'
}).then(function (vaptchaObj) {
  obj = vaptchaObj;
  vaptchaObj.render();
  vaptchaObj.listen('close', function () {
  })
})
</script>
<?php }?>
<script>
var vaptcha_open = 0;
	function QueryTeam(){
  		if($("#vaptchaContainer").length>0) vaptcha_open=1;
	    var query = $("button[type='submit']");
	  	var qq=$("input[name='qq']").val();
    	var data = {qq:qq};
		if(qq==''){layer.msg('请确保每项都不为空', {icon:2, time:1500});return false;}
	  	if(vaptcha_open==1){
		   	var token = obj.getToken();
		    if(token == ""){
		      	layer.msg('请先完成人机验证！'); return false;
		    }
		    var adddata = {token:token};
	  	}
	    query.attr('disabled', 'true');
        layer.msg('正在查询中，请稍后...');
		$.ajax({
			type : 'POST',
			url : 'Ajax.php?act=Query_submit',
            data: Object.assign(data, adddata),
			dataType : 'json',
			success : function(data) {
			  	if(data.code == 0){
		        	query.removeAttr('disabled');
			    	layer.msg(data.msg, {icon:1, time:1500});
                	obj.reset();
			  	}else{
		        	query.removeAttr('disabled');
			    	layer.msg(data.msg, {icon:2, time:1500});
			    	obj.reset();
			  	}
			},
		});
    	return false;
	}
	function JoinTeam(){
  		if($("#vaptchaContainer").length>0) vaptcha_open=1;
	    var join = $("button[type='submit']");
	  	var name=$("input[name='TeamName']").val();
	  	var qq=$("input[name='TeamQq']").val();
	  	var describe=$("input[name='TeamDescribe']").val();
    	var data = {name:name,qq:qq,describe:describe};
		if(name=='' || qq=='' || describe==''){ layer.msg('请确保每项都不为空', {icon:2, time:1500});}
	  	if(vaptcha_open==1){
		   	var token = obj.getToken();
		    if(token == ""){
		      	layer.msg('请先完成人机验证！'); return false;
		    }
		    var adddata = {token:token};
	  	}
	    join.attr('disabled', 'true');
        layer.msg('正在提交中，请稍后...');
		$.ajax({
			type : 'POST',
			url : 'Ajax.php?act=Join_submit',
            data: {name:name,qq:qq,describe:describe,token:token},
			dataType : 'json',
			success : function(data) {
			  if(data.code == 0){
			    layer.msg(data.msg, {icon:1, time:1500}, function(){window.location.reload()});
			  }else{
			    layer.msg(data.msg, {icon:2, time:1500});
		        join.removeAttr('disabled');
                obj.reset();
			  }
			},
		});
	return false;
}
</script>
</body>
</html>