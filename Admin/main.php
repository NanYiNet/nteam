<?php
$mod = 'admin';
include('../Common/Core_brain.php');
$member_nums=$DB->getColumn("SELECT count(*) from nteam_team_member WHERE 1");
$leave_nums=$DB->getColumn("SELECT count(*) from nteam_leave_messages WHERE 1");
if ($leave_nums == null) {
  $leave_nums = 0;
}
$leave_numss=$DB->getColumn("SELECT count(*) from nteam_leave_messages WHERE `intime` = '".$date."'");
  $mysqlversion=$DB->query("select VERSION()")->fetch();

?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>后台首页 - <?php echo conf('Name');?> - 后台管理中心</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta content="<?php echo conf('Descriptison');?>" name="descriptison">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<meta name="author" content="<?php echo conf('Name');?>">
<link href="../assets/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/admin/css/materialdesignicons.min.css" rel="stylesheet">
<link href="../assets/admin/css/style.min.css" rel="stylesheet">
</head>
  
<body>
<div class="container-fluid p-t-15">
  
  <div class="row">
    <div class="col-sm-6 col-md-3">
      <div class="card bg-info">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white m-t-0">实时时间</p>
            <p class="h3 text-white m-b-0" id="clock"></p>
          </div>
          <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-rocket fa-1-5x"></i></span> </div>
        </div>
      </div>
    </div>
    
    <div class="col-sm-6 col-md-3">
      <div class="card bg-danger">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white m-t-0">成员总数</p>
            <p class="h3 text-white m-b-0"><?php echo $member_nums;?> 位</p>
          </div>
          <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-account fa-1-5x"></i></span> </div>
        </div>
      </div>
    </div>
    
    <div class="col-sm-6 col-md-3">
      <div class="card bg-success">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white m-t-0">总留言</p>
            <p class="h3 text-white m-b-0"><?php echo $leave_nums;?> 条</p>
          </div>
          <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-rocket fa-1-5x"></i></span> </div>
        </div>
      </div>
    </div>
    
    <div class="col-sm-6 col-md-3">
      <div class="card bg-purple">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white m-t-0">新增留言</p>
            <p class="h3 text-white m-b-0"><?php echo $leave_numss;?> 条</p>
          </div>
          <div class="pull-left"> <span class="img-avatar img-avatar-48 bg-translucent"><i class="mdi mdi-comment-outline fa-1-5x"></i></span> </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-6"> 
      <div class="card">
        <div class="card-header">
          <h4>服务器信息</h4>
        </div>
        <div class="card-body">
          <ul class="list-group" style="margin-bottom: 0px;">
            <li class="list-group-item" style="border: 0px solid #ddd;">
              <b>PHP 版本：</b><?php echo phpversion() ?>
              <?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
            </li>
            <li class="list-group-item" style="border: 0px solid #ddd;">
              <b>MySQL 版本：</b><?php echo $mysqlversion[0] ?>
            </li>
            <li class="list-group-item" style="border: 0px solid #ddd;">
              <b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
            </li>
            <li class="list-group-item" style="border: 0px solid #ddd;">
			  <b>程序最大运行时间：</b><?php echo ini_get('max_execution_time') ?>s
            </li>
            <li class="list-group-item" style="border: 0px solid #ddd;">
              <b>POST许可：</b><?php echo ini_get('post_max_size'); ?>
            </li>
            <li class="list-group-item" style="border: 0px solid #ddd;">
              <b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?>
            </li>
          </ul>
        </div>
      </div>
    </div>

     
<div class="container-fluid">
<div class="row">
<div class="col-md-6">
<div class="card">
<div class="card-header"><h4>轮播图</h4></div>
<div class="card-body">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
</ol>
<div class="carousel-inner">
<div class="item active"><a href="http://www.nanyinet.com" target="_blank" rel="nofollow">
    <img src="https://www.nanyinet.com/wp-content/uploads/2022/09/home-1024x436.png" alt="nanyinet"></a></div>
<a class="left carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev"><span class="icon-left-open-big icon-prev" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
<a class="right carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next"><span class="icon-right-open-big icon-next" aria-hidden="true"></span><span class="sr-only">Next</span></a>

<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/main.min.js"></script>

<!--图表插件-->
<script type="text/javascript" src="../assets/admin/js/Chart.js"></script>
</body>
</html>
