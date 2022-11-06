<?php
include("./Common/Core_brain.php");

$id=$_GET['id'];

$sql = "SELECT * FROM nteam_project_list WHERE id='$id' LIMIT 1";
$rows=$DB->getRow($sql);
if(!$rows){exit("该项目不存在！");}
$projects=$DB->query($sql);
while($project = $projects->fetch()){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?php echo $project['name'];?> - <?php echo conf('Name') ?> - <?php echo conf('SiteName') ?></title>
<meta content="<?php echo conf('Descriptison');?>" name="description">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<!-- Vendor CSS Files -->
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="http://at.alicdn.com/t/font_1886590_v6zxjghcwli.css" rel="stylesheet">
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<!-- ======= Header ======= --><header id="header">
<div class="container d-flex">
  <div class="logo mr-auto">
    <h1 class="text-light"><a href="index.php"><span><?php echo conf('Name') ?></span></a></h1>
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.php"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
  </div>
  <nav class="nav-menu d-none d-lg-block">
  <ul>
    <li class="active"><a href="index.php#header">首页</a></li>
    <li><a href="index.php#about">关于</a></li>
    <li><a href="index.php#services">服务</a></li>
    <li><a href="index.php#portfolio">项目</a></li>
    <li><a href="index.php#team">成员</a></li>
    <li><a href="index.php#contact">联系</a></li>
  </ul>
  </nav><!-- .nav-menu -->
</div>
</header><!-- End Header --><main id="main"><!-- ======= Breadcrumbs Section ======= --><section class="breadcrumbs">
<div class="container">
  <div class="d-flex justify-content-between align-items-center">
    <h2><?php echo $project['name'];?></h2>
    <ol>
      <li><a href="index.php">首页</a></li>
      <li><a href="index.php#portfolio">项目</a></li>
      <li><?php echo $project['name'];?></li>
    </ol>
  </div>
</div>
</section><!-- Breadcrumbs Section --><!-- ======= Portfolio Details Section ======= --><section class="portfolio-details">
<div class="container">
  <div class="portfolio-details-container">
    <div class="owl-carousel portfolio-details-carousel">
      <img src="<?php echo $project['img'];?>" class="img-fluid" alt="">
    </div>
    <div class="portfolio-info">
      <h3>项目信息</h3>
      <ul>
        <li><strong>类型</strong>: <?php if ($project['type'] == 'web') {echo "网页";}else{echo "程序";}?></li>
        <li><strong>项目名称</strong>: <?php echo $project['name'];?></li>
        <li><strong>添加时间</strong>: <?php echo $project['intime'];?></li>
        <li><strong>项目网址</strong>: <a href="//<?php echo $project['url'];?>"><?php echo $project['url'];?></a></li>
        <?php if ($project['status'] == 1) {  echo "<li><strong>运营状态</strong>: <font color='green'>正常运营</font></li>";}else{  echo "<li><strong>运营状态</strong>: <font color='red'>暂停运营</font></li>";}        ?>
      </ul>
    </div>
  </div>
  <div class="portfolio-description">
    <h2>项目介绍</h2>
    <p>
            <?php echo $project['descriptison'];?>
    </p>
  </div>
</div>
</section><!-- End Portfolio Details Section --></main><!-- End #main -->
<?php require 'foot.php';?>
<?php
}
?>