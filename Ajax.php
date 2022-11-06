<?php
include("./Common/Core_brain.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

switch ($act) {
	case 'contact':
		$name=daddslashes(htmlspecialchars(strip_tags(trim($_POST['name']))));
		$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
		$subject=daddslashes(htmlspecialchars(strip_tags(trim($_POST['subject']))));
		$message=daddslashes(htmlspecialchars(strip_tags(trim($_POST['message']))));
		if ($name==null || $email==null || $subject==null || $message==null) {
			exit('{"code":-1,"msg":"请确保每项都不为空"}');
		}
	    if(conf('Mail_Name') == '' || conf('Mail_Pwd') == ''){exit('{"code":-1,"msg":"请先配置邮箱信息"}');}
		$admins=$DB->query("SELECT * FROM nteam_admin WHERE id=1");
		while($admin = $admins->fetch()){
			$email = $admin['adminQq'].'@qq.com';
		}
		$sub = '网页收到新留言啦~~';
		$msg = "姓名：".$name."
		        邮件：".$email."
		        主题：".$subject."
		        内容：".$message;      // 邮件正文
		$result = send_mail($email, $sub, $msg);
		if($result===true){// 发送邮件
			if ($DB->exec("INSERT INTO `nteam_leave_messages` (`name`,`email`,`subject`,`message`,`intime`) values ('".$name."','".$email."','".$subject."','".$message."','".$date."')")) {
				echo 'OK';
			};
		}else{
			file_put_contents('mail.log',$result);
			exit('{"code":-1,"msg":"留言发送失败"}');
		}
		break;
	case 'subscribe':
	@header('Content-Type: application/json; charset=UTF-8');
		$email=daddslashes(htmlspecialchars(strip_tags(trim($_POST['email']))));
		if (conf('Vaptcha_Open') == 1) {
			$token = $_POST['token'];
		}
		if ($email=='') {
			exit('{"code":-1,"msg":"请确保每项都不为空"}');
		}
		if (conf('Vaptcha_Open') == 1 && $token=='') {
			exit('{"code":-1,"msg":"请先完成人机验证"}');
		}else{
		    if(conf('Mail_Name') == '' || conf('Mail_Pwd') == ''){exit('{"code":-1,"msg":"请先配置邮箱信息"}');}
    		$admins=$DB->query("SELECT * FROM nteam_admin WHERE id=1");
    		while($admin = $admins->fetch()){
    			$email = $admin['adminQq'].'@qq.com';
    		}
    		$sub = '官网有需要订阅的小伙伴哦~~';
    		$msg = "邮箱：".$email;
    		$result = send_mail($email, $sub, $msg);
    		if($result===true){// 发送邮件
    			$email = $_POST['email'];
    			$sub = '成功订阅~~';
    			$msg = '感谢订阅'.conf('Name').'新闻！';
    			$result = send_mail($email, $sub, $msg);
    			if ($result===true) {
    				exit('{"code":1,"msg":"订阅成功！"}');
    			}else{
    				exit('{"code":-1,"msg":"订阅失败！"}');
    			}
    		}
		}
		break;
	case 'Query_submit':
		@header('Content-Type: application/json; charset=UTF-8');
		$qq = $_POST['qq'];
		if (conf('Vaptcha_Open') == 1) {
			$token = $_POST['token'];
		}
		if ($qq=='') {
			exit('{"code":-1,"msg":"请确保每项都不为空"}');
		}
		if (conf('Vaptcha_Open') == 1 && $token=='') {
			exit('{"code":-1,"msg":"请先完成人机验证"}');
		}else{
			$rows=$DB->getRow("SELECT * FROM nteam_team_member WHERE qq = '$qq' limit 1");
			if(!$rows){
				exit('{"code":-1,"msg":"非本团队成员！"}');
			}else{
				exit('{"code":0,"msg":"该QQ是我们团队的成员的哦！"}');
			}
		}
		break;
	case 'Join_submit':
		@header('Content-Type: application/json; charset=UTF-8');
		$name = $_POST['name'];
		$qq = $_POST['qq'];
		$describe = $_POST['describe'];
		if (conf('Vaptcha_Open') == 1) {
			$token = $_POST['token'];
		}
		if(isset($_SESSION['Join_submit']) && $_SESSION['Join_submit']>time()-300){
			exit('{"code":-1,"msg":"请勿频繁申请"}');
		}
		if ($name=='' || $qq=='' || $describe=='') {
			exit('{"code":-1,"msg":"请确保每项都不为空"}');
		}
		if (conf('Vaptcha_Open') == 1 && $token=='') {
			exit('{"code":-1,"msg":"请先完成人机验证"}');
		}else{
	        if(conf('Mail_Name') == '' || conf('Mail_Pwd') == ''){exit('{"code":-1,"msg":"当前未配置邮箱信息，无法发送邮件！"}');}
			$sds=$DB->exec("INSERT INTO `nteam_team_member` (`name`, `qq`, `describe`, `is_show`, `Audit_status`, `intime`) VALUES ('{$name}', '{$qq}', '{$describe}', 0, 0, NOW())");
			$id=$DB->lastInsertId();
			if(!$sds){
				exit('{"code":-1,"msg":"申请提交失败！"}');
			}else{
				$admins=$DB->query("SELECT * FROM nteam_admin WHERE id=1");
				while($admin = $admins->fetch()){
					$email = $admin['adminQq'].'@qq.com';
				}
				$sub = '有小伙伴想加入我们哦！';
				$msg = "赶紧前往后台查看吧！！！";
				$result = send_mail($email, $sub, $msg);
				if ($result===true) {
				    $_SESSION['Join_submit']=time();
					exit('{"code":0,"msg":"申请提交成功！"}');
				}else{
					exit('{"code":-1,"msg":"申请提交失败！"}');
				}
			}
		}
		break;
	default:
		exit('{"code":-4,"msg":"No Act"}');
		break;
}
?>