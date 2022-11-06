<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=UTF-8');
if(file_exists('install.lock')){echo "<script type='text/javascript' src='/assets/admin/js/jquery.min.js'></script><script src='/assets/layer/layer.js'></script><script>layer.ready(function(){layer.msg('安装过了哦！！！', {icon: 2, time: 2000}, function(){window.location.href='javascript:history.go(-1)'});});</script>";exit();}
$readme_file = file('../readme.txt');
for ( $i = 0; $i < count($readme_file); $i++ ) {
	$readme .= $readme_file[$i] . "<br/>";
}
$do = $_REQUEST['do'];
if ($do == "save_info") {
	$db_host = isset($_POST['db_host']) ? $_POST['db_host'] : null;
	$db_port = isset($_POST['db_port']) ? $_POST['db_port'] : null;
	$db_user = isset($_POST['db_user']) ? $_POST['db_user'] : null;
	$db_pwd = isset($_POST['db_pwd']) ? $_POST['db_pwd'] : null;
	$db_name = isset($_POST['db_name']) ? $_POST['db_name'] : null;
	if ($db_host == null || $db_port == null || $db_user == null || $db_pwd == null || $db_name == null) {
		$json = array("code" => "1", "msg" => "保存错误,请确保每项都不为空");
	} else {
		$config = "<?php".PHP_EOL."\$dbconfig=array(".PHP_EOL."	'host' =>  '{$db_host}',".PHP_EOL."    'port' =>  '{$db_port}',".PHP_EOL."    'user' =>  '{$db_user}',".PHP_EOL."    'pwd' =>  '{$db_pwd}',".PHP_EOL."    'dbname' =>  '{$db_name}',".PHP_EOL."    'dbqz' =>  'nteam'".PHP_EOL.");";
		try{
			$db=new PDO("mysql:host=".$dbconfig['host'].";dbname=".$dbconfig['dbname'].";port=".$dbconfig['port'],$dbconfig['user'],$dbconfig['pwd']);
		}catch(Exception $e){
			$json = array("code" => "1", "msg" => "链接数据库失败:".$e->getMessage());
		}
		if (file_put_contents('../Common/Database_Config.php', $config)) {
			$json = array("code" => "0", "msg" => "文件保存成功，点击Next进行下一步");
		} else {
			$json = array("code" => "1", "msg" => "请确保网站根目录有写入权限");
		}
	}
	exit(json_encode($json));
} elseif ($do == "check_step_2") {
	if (!is_file('../Common/Database_Config.php')) {
		$json = array("code" => "1", "msg" => "数据库文件不存在，请先写入数据库文件");
	} else {
		require '../Common/Database_Config.php';
		if (!$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname']) json_error("数据库不完整");
		try{
			$db=new PDO("mysql:host=".$dbconfig['host'].";dbname=".$dbconfig['dbname'].";port=".$dbconfig['port'],$dbconfig['user'],$dbconfig['pwd']);
		}catch(Exception $e){
			$json = array("code" => "1", "msg" => "链接数据库失败:".$e->getMessage());
		}
		if (!$db->query("SELECT * FROM nteam_config limit 1")) {
			$data = '<div class="list-group-item list-group-item-info">开始安装Nteam</div>
				<div class="list-group-item">
				<div class="form-group">
                      <div class="radio-list text-center">
                        <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="step3" id="install" value="install" checked>
                          <label for="install">开始安装</label>
                        </div>
                        </label>
                      </div>
                    </div>
				</div>';
		} else {
			$data = '<div class="list-group-item list-group-item-info">系统检测到你已安装过Nteam</div>
				<div class="list-group-item">
				<div class="form-group">
                      <div class="radio-list text-center">
                        <label class="radio-inline p-0">
                        <div class="radio radio-info">
                          <input type="radio" name="step3" id="jump" value="jump" required>
                          <label for="jump">跳过安装</label>
                        </div>
                        </label>
                        <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="step3" id="install" value="install" checked>
                          <label for="install">强制重新安装</label>
                        </div>
                        </label>
                      </div>
                    </div>
				</div>';
		}
		$json = array("code" => "0", "data" => $data);
	}
	exit(json_encode($json));
} elseif ($do == 'check_step_3') {
	$type = $_REQUEST['type'];
	if ($type == 'install') {
		//继续安装
		if (!is_file('../Common/Database_Config.php')) {
			$json = array("code" => "1", "msg" => "数据库文件不存在");
		} else {
			require '../Common/Database_Config.php';
			if (!$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname']) json_error("数据库不完整");
			try{
				$db=new PDO("mysql:host=".$dbconfig['host'].";dbname=".$dbconfig['dbname'].";port=".$dbconfig['port'],$dbconfig['user'],$dbconfig['pwd']);
			}catch(Exception $e){
				$json = array("code" => "1", "msg" => "链接数据库失败:".$e->getMessage());
			}
			$db->exec("set sql_mode = ''");
			$db->exec("set names utf8");
			$sql=file_get_contents('install.sql');
			$sql=explode(';', $sql);

			$success=0;$error=0;$errorMsg=null;
			foreach ($sql as $value) {
				$value=trim($value);
				if(!empty($value)){
					$value = str_replace('nf_',$dbconfig['dbqz'].'_',$value);
					if($db->exec($value)===false){
						$error++;
						$dberror=$db->errorInfo();
						$errorMsg.=$dberror[2]."<br>";
					}else{
						$success++;
					}
				}
			}
			if ($error > 0) {
				$data .= '<br/><a data-toggle="collapse" href="#error">点击查看错误信息</a>
						<div id="error" class="panel-collapse collapse face">' . $errorMsg . '</div>';
			}
			$json = array("code" => "0", "data" => $data, "url" => $url);
			file_put_contents("install.lock", '密码锁');
			$db=null;
			deldir('../assets/bower_components/');
			deldir('../install');
		}
	} elseif ($type == 'jump') {
		$json = array("code" => "0", "data" => $data);
		file_put_contents("install.lock", '密码锁');
		deldir('../assets/bower_components/');
		deldir('../install');
	} else {
		$json = array("code" => "1", "msg" => "无效的操作类型");
	}
	exit(json_encode($json));
}
function json_error($msg, $json = array())
{
	$json['code'] = "1";
	$json['msg'] = $msg;
	exit(json_encode($json));
}
function deldir($dir) {
  //先删除目录下的文件：
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
  closedir($dh);
  //删除当前文件夹：
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
?>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no,minimal-ui">
	<title>安装向导 - Nteam</title>
	<link href="//lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">
	<link href="/assets/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<link href="/assets/bower_components/css/animate.css" rel="stylesheet">
	<link href="/assets/bower_components/css/style.css" rel="stylesheet">
	<link href="/assets/bower_components/css/colors/blue.css" id="theme" rel="stylesheet">
	<link rel="stylesheet" href="/assets/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.css">
	<style type="text/css">
		body {
			background-color:#94c2cf;
		}

		.scroll {
			overflow-y: scroll;
			height: 50%;
		}
	</style>
</head>
<body>
<div class="container" style="padding-top:60px;">
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box" id="install">
				<h3 class="box-title m-b-0">程序安装[Install]</h3>
				<p class="text-muted m-b-30 font-13"> 将引导你完成程序的初始化.</p>
				<div id="install_wizard" class="wizard">
					<ul class="wizard-steps">
						<li><h4><span><i class="ti-more-alt"></i></span>安装说明</h4></li>
						<li><h4><span><i class="ti-server"></i></span>数据库配置</h4></li>
						<li><h4><span><i class="ti-dropbox"></i></span>开始安装</h4></li>
						<li><h4><span><i class="ti-check-box"></i></span>安装完成</h4></li>
					</ul>
					<input type="hidden" id="steps" value="1"/>
					<div class="wizard-content">
						<div class="wizard-pane scroll"><?php echo $readme; ?></div>
						<div class="wizard-pane">
							<div class="alert alert-info">如果已事先填写好Database_Config.php相关数据库配置，请跳过这一步[直接点击Next]</div>
							<form action="?do=save_info" class="form-ajax" method="post">
								<label for="name">数据库地址：</label>
								<input type="text" class="form-control" name="db_host" value="127.0.0.1">
								<label for="name">数据库端口：</label>
								<input type="text" class="form-control" name="db_port" value="3306">
								<label for="name">数据库用户名：</label>
								<input type="text" class="form-control" name="db_user">
								<label for="name">数据库密码：</label>
								<input type="text" class="form-control" name="db_pwd">
								<label for="name">数据库名：</label>
								<input type="text" class="form-control" name="db_name">
								<br><input type="submit" class="btn btn-warning btn-block" name="submit" value="写入数据库文件">
							</form>
						</div>
						<div class="wizard-pane" id="step2"></div>
						<div class="wizard-pane text-center" id="step3" style="display:none;">
							<i class="ti-check-box fa-4x text-success"></i>
							<h2>安装完成</h2>
							<div id="step3_data"></div>
							<h5>更多设置选项请登录后台管理进行修改</h5>
							<h5>管理账号和密码是:admin/admin</h5>
							<p><a href="../">网站首页</a> <<->> <a href="../Admin">后台管理</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<script src="/assets/bower_components/js/waves.js"></script>
<script src="/assets/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>
<script src="/assets/layer/layer.js"></script>
<script type="text/javascript">
	var $_GET = (function () {
		var url = window.document.location.href.toString();
		var u = url.split("?");
		if (typeof(u[1]) == "string") {
			u = u[1].split("&");
			var get = {};
			for (var i in u) {
				var j = u[i].split("=");
				get[j[0]] = j[1];
			}
			return get;
		} else {
			return {};
		}
	})();
	if ($_GET['code'] && $_GET['state']) {
		layer.load(2, {shade: [0.1, '#fff']});
		$("#install").hide();
		$.ajax({
			type: "POST",
			url: "index.php",
			data: {do: 'binding', code: $_GET['code'], state: $_GET['state']},
			dataType: 'json',
			success: function (result) {
				if (result.code == 0) {
					$("#installed_img").attr('src', result.img);
					$("#installed").slideDown();
				} else {
					layer.alert(result.msg, function () {
						window.location.href = 'index.php';
					});
				}
				layer.closeAll('loading');
			},
			error: function (XMLHttpRequest) {
				layer.alert("连接失败，请刷新重试！[" + XMLHttpRequest.status + "]");
				layer.closeAll('loading');
			}
		});
	}
	$(function () {
		$('.form-ajax').submit(function (e) {
			e.preventDefault();
			layer.load(2, {shade: [0.1, '#fff']});
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize() + '&form-ajax=yes',
				success: function (result) {
					layer.msg(result.msg);
					layer.closeAll('loading');
				},
				error: function (XMLHttpRequest) {
					layer.alert("连接失败，请刷新重试！[" + XMLHttpRequest.status + "]");
					layer.closeAll('loading');
				}
			});
		});
		$('#install_wizard').wizard({
			buttonLabels: {
				next: "下一步",
				back: "返回上一步"
			},
			onNext: function () {
				var steps = $("#steps").val();
				if (steps == 2) {
					layer.load(2, {shade: [0.1, '#fff']});
					$.ajax({
						url: 'index.php',
						type: 'POST',
						dataType: 'json',
						data: 'do=check_step_' + steps,
						success: function (result) {
							layer.closeAll('loading');
							if (result.code == '0') {
								$("#step2").html(result.data);
							} else {
								$("#install_wizard").wizard("back");
								layer.msg(result.msg);
							}
						},
						error: function (XMLHttpRequest) {
							$("#install_wizard").wizard("back");
							layer.alert("连接失败，请刷新重试！[" + XMLHttpRequest.status + "]");
							layer.closeAll('loading');
						}
					});
				} else if (steps == 3) {
					var step3 = $('input:radio[name="step3"]:checked').val();
					layer.load(2, {shade: [0.1, '#fff']});
					$.ajax({
						url: 'index.php',
						type: 'POST',
						dataType: 'json',
						data: 'do=check_step_' + steps + '&type=' + step3,
						success: function (result) {
							layer.closeAll('loading');
							if (result.code == '0') {
								$("[data-wizard=\"back\"]").hide();
								$("[data-wizard=\"finish\"]").hide();
								$(".wizard-steps").hide();
								$("#step3_data").html(result.data);
								$("#step3").slideDown();
							} else {
								$("#install_wizard").wizard("back");
								layer.alert(result.msg);
							}
						},
						error: function (XMLHttpRequest) {
							$("#install_wizard").wizard("back");
							layer.alert("连接失败，请刷新重试！[" + XMLHttpRequest.status + "]");
							layer.closeAll('loading');
						}
					});
				}
				$("#steps").val(Number(steps) + Number(1));
			},
			onBack: function () {
				var steps = $("#steps").val();
				$("#steps").val(Number(steps) - Number(1));
			}
		});
	});
</script>
</body>
</html>