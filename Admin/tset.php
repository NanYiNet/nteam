<?php
$mod = 'admin';
include('../Common/Core_brain.php');
if($adminData['adminRank']== 2) {
  echo "您的账号没有权限使用此功能";
  exit;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>成员综合管理 - <?php echo conf('Name');?> - 后台管理中心</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta content="<?php echo conf('Descriptison');?>" name="descriptison">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<meta name="author" content="<?php echo conf('Name');?>">
<link href="../assets/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/admin/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/admin/js/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link href="../assets/admin/css/style.min.css" rel="stylesheet">
<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script src="../assets/layer/layer.js"></script>
</head>
  
<body>
<div class="container-fluid p-t-15">
<?php
$my=isset($_GET['my'])?$_GET['my']:null;
if($my=='add'){
?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<form onsubmit="return addMember(this)" method="POST" class="row">
<div class="form-group col-md-12">
<label for="name">名称</label>
<input type="text" class="form-control" name="name" value="" placeholder="请输入成员名称" />
</div>
<div class="form-group col-md-12">
<label for="qq">QQ</label>
<input type="text" class="form-control" name="qq" value="" placeholder="请输入QQ号" />
</div>
<div class="form-group col-md-12">
<label for="describe">描述</label>
<textarea class="form-control" name="describe" rows="5" placeholder="请输入描述，换行用<br>"></textarea>
</div>
<div class="form-group col-md-12">
<label for="status">显示首页</label>
<select class="form-control" name="is_show"><option value="1">正常</option><option value="0">暂停</option></select>
</div>
<div class="form-group col-md-12">
<label for="status">审核状态</label>
<select class="form-control" name="Audit_status"><option value="1">通过</option><option value="0">未通过</option></select>
</div>
<div class="form-group col-md-12">
<button type="submit" class="btn btn-primary ajax-post" target-form="add-form">确 定</button>
<button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
</div>
</form>
</div>
</div>
</div>
</div>
<?php
}elseif($my=='edit'){
$id=intval($_GET['id']);
$row=$DB->getRow("select * from nteam_team_member where id='$id' limit 1");
if(!$row){echo "<script>layer.ready(function(){layer.msg('该成员不存在', {icon: 2, time: 1500}, function(){window.location.href='javascript:history.go(-1)'});});</script>";exit();}
?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<?php echo '<form onsubmit="return editMember(this,'.$id.')" method="POST" class="row">';?>
<div class="form-group col-md-12">
<label for="name">名称</label>
<input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" placeholder="请输入成员名称" />
</div>
<div class="form-group col-md-12">
<label for="qq">QQ</label>
<input type="text" class="form-control" name="qq" value="<?php echo $row['qq'];?>" placeholder="请输入QQ号" />
</div>
<div class="form-group col-md-12">
<label for="describe">描述</label>
<textarea class="form-control" name="describe" rows="5" placeholder="请输入描述，换行用<br>"><?php echo $row['describe'];?></textarea>
</div>
<div class="form-group col-md-12">
<label for="status">显示首页</label>
<select class="form-control" name="is_show"><?php if($row['is_show'] == 1){echo '<option value="1" selected>正常</option><option value="0">暂停</option>'; }else{ echo '<option value="1">正常</option><option value="0" selected>暂停</option>';}?></select>
</div>
<div class="form-group col-md-12">
<label for="status">审核状态</label>
<select class="form-control" name="Audit_status"><?php if($row['Audit_status'] == 1){echo '<option value="1" selected>通过</option><option value="0">未通过</option>'; }else{ echo '<option value="1">通过</option><option value="0" selected>未通过</option>';}?></select>
</div>
<div class="form-group col-md-12">
<button type="submit" class="btn btn-primary ajax-post" target-form="add-form">确 定</button>
<button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
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
<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script src="../assets/admin/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="../assets/admin/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/main.min.js"></script>
<script>
	function addMember(obj){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=setMember&type=Add',
	    data : $(obj).serialize(),
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 0){
	        layer.alert(data.msg, {icon: 1,closeBtn: false}, function(){window.location.reload()});
	      }else{
	        layer.alert(data.msg, {icon: 2})
	      }
	    },
	    error:function(data){
	      layer.msg('服务器错误');
	      return false;
	    }
	  });
	  return false;
	}
	function editMember(obj,id){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});

	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=setMember&type=Edit&id='+id,
	    data : $(obj).serialize(),
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 0){
	        layer.alert(data.msg, {icon: 1,closeBtn: false}, function(){window.location.reload()});
	      }else{
	        layer.alert(data.msg, {icon: 2})
	      }
	    },
	    error:function(data){
	      layer.msg('服务器错误');
	      return false;
	    }
	  });
	  return false;
	}
</script>
</body>
</html>