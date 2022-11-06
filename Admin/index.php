<?php
$mod = 'admin';
include('../Common/Core_brain.php');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo conf('Name');?> - 后台管理中心</title>
<link rel="icon" href="../assets/img/favicon.png" type="image/ico">
<meta content="<?php echo conf('Descriptison');?>" name="descriptison">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<meta name="author" content="<?php echo conf('Name');?>">
<link href="../assets/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/admin/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/admin/js/bootstrap-multitabs/multitabs.min.css">
<link href="../assets/admin/css/style.min.css" rel="stylesheet">
</head>
  
<body>
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="index.php"><img src="../assets/admin/images/logo-sidebar.png" title="<?php echo conf('name');?>" alt="<?php echo conf('name');?>" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">
            <li class="nav-item active"> <a class="multitabs" href="main.php"><i class="mdi mdi-home"></i> <span>后台首页</span></a> </li>
            <?php if($adminData['adminRank']==1){?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-account"></i> <span>管理员管理</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="alist.php">管理员列表</a> </li>
                <li> <a class="multitabs" href="aset.php?my=add">添加管理员</a> </li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-account"></i> <span>成员管理</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="tlist.php">成员列表</a> </li>
                <li> <a class="multitabs" href="tset.php?my=add">添加成员</a> </li>
              </ul>
            </li>
            <?php } if($adminData['adminRank']==1 || $adminData['adminRank']==2 ){ ?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-book-multiple-variant"></i> <span>项目管理</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="plist.php">项目列表</a> </li>
                <li> <a class="multitabs" href="pset.php?my=add">添加项目</a> </li>
              </ul>
            </li>
            <li class="nav-item"> <a class="multitabs" href="leave_list.php"><i class="mdi mdi-comment-text-outline"></i> <span>留言列表</span></a> </li>
            <?php } if($adminData['adminRank']==1){ ?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-settings"></i> <span>网站配置</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="web_config.php?mod=base">基本配置</a> </li>
                <li> <a class="multitabs" href="web_config.php?mod=indexmk">首页模块</a> </li>
                <li> <a class="multitabs" href="web_config.php?mod=emailset">邮箱配置</a> </li>
              </ul>
            </li>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-all-inclusive"></i> <span>扩展功能</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="team_approval.php">成员审批</a> </li>
                <li> <a class="multitabs" href="project_approval.php">项目审批</a> </li>
                <li> <a class="multitabs" href="system_log.php">系统日志</a> </li>
              </ul>
	<li class="nav-item"> <a href="http://wpa.qq.com/msgrd?v=3&uin=2322796106&site=qq&menu=yes"><i class="mdi mdi-qqchat"></i>联系作者</a> </li>
              	<li class="nav-item"> <a href="https://jq.qq.com/?_wv=1027&k=pijHv9ns"><i class="mdi mdi-comment-alert-outline"></i>加入群聊</a> </li>
            </li>
            <?php } ?>
          </ul>
        </nav>
        
        <div class="sidebar-footer">
          <p class="copyright">Copyright &copy; 2018-2020. <a target="_blank" href="http://<?php echo conf('Url');?>"><?php echo conf('Name');?></a> All rights reserved.</p>
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->
    
    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar navbar-default">
        <div class="topbar">
          
          <div class="topbar-left">
            <div class="lyear-aside-toggler">
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
            </div>
          </div>
          
          <ul class="topbar-right">
            <li class="dropdown dropdown-profile">
              <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" src="//q1.qlogo.cn/g?b=qq&nk=<?=$_SESSION['adminQq']?>&s=100" alt="<?=$_SESSION['adminUser']?>" />
                <span><?=$_SESSION['adminUser']?> <span class="caret"></span></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li> <a class="multitabs" data-url="edit_pwd.php" href="javascript:void(0)"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li>
                <li> <a class="multitabs" data-url="web_config.php?mod=base" href="javascript:void(0)"><i class="mdi mdi-settings"></i> 网站配置</a></li>
                <li class="divider"></li>
                <li> <a href="./login.php?logout"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
              </ul>
            </li>
            <!--切换主题配色-->
		    <li class="dropdown dropdown-skin">
			  <span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
			  <ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
			    <li class="drop-title"><p>LOGO</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
                    <label for="logo_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                    <label for="logo_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                    <label for="logo_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                    <label for="logo_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
                    <label for="logo_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                    <label for="logo_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                    <label for="logo_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                    <label for="logo_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>头部</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
                    <label for="header_bg_1"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                    <label for="header_bg_2"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                    <label for="header_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                    <label for="header_bg_4"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_5" id="header_bg_5">
                    <label for="header_bg_5"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                    <label for="header_bg_6"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                    <label for="header_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                    <label for="header_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>侧边栏</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
                    <label for="sidebar_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                    <label for="sidebar_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                    <label for="sidebar_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                    <label for="sidebar_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
                    <label for="sidebar_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                    <label for="sidebar_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                    <label for="sidebar_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                    <label for="sidebar_bg_8"></label>
                  </span>
				</li>
			  </ul>
			</li>
            <!--切换主题配色-->
          </ul>
          
        </div>
      </nav>
      
    </header>
    <!--End 头部信息-->
    
    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div id="iframe-content"></div>
      
    </main>
    <!--End 页面主要内容-->
  </div>
</div>

<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap-multitabs/multitabs.js"></script>
<script type="text/javascript" src="../assets/admin/js/index.min.js"></script>
</body>
</html>