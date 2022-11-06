<?php
//php防注入和XSS攻击通用过滤. 
$_GET     && SafeFilter($_GET);
$_POST    && SafeFilter($_POST);
$_COOKIE  && SafeFilter($_COOKIE);
  
function SafeFilter (&$arr)
{
   $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
   if (is_array($arr))
   {
     foreach ($arr as $key => $value)
     {
        if (!is_array($value))
        {
          if (!get_magic_quotes_gpc())             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
          {
             $value  = addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
          }
          $value       = preg_replace($ra,'',$value);     //删除非打印字符，粗暴式过滤xss可疑字符串
          $arr[$key]     = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
        }
        else
        {
          SafeFilter($arr[$key]);
        }
     }
   }
}
?>

<?php
//查询禁止IP
$ip =$_SERVER['REMOTE_ADDR'];
$fileht=".htaccess2";
if(!file_exists($fileht))file_put_contents($fileht,"");
$filehtarr=@file($fileht);
if(in_array($ip."\r\n",$filehtarr))die("警告:"."<br>"."您的IP地址被某些原因禁止，如果您有任何问题请联系QQ2322796106！");
  
//加入禁止IP
$time=time();
$fileforbid="log/forbidchk.dat";
if(file_exists($fileforbid))
{ if($time-filemtime($fileforbid)>60)unlink($fileforbid);
else{
$fileforbidarr=@file($fileforbid);
if($ip==substr($fileforbidarr[0],0,strlen($ip)))
{
if($time-substr($fileforbidarr[1],0,strlen($time))>600)unlink($fileforbid);
elseif($fileforbidarr[2]>600){file_put_contents($fileht,$ip."\r\n",FILE_APPEND);unlink($fileforbid);}
else{$fileforbidarr[2]++;file_put_contents($fileforbid,$fileforbidarr);}
}
}
}
//防刷新
$str="";
$file="log/ipdate.dat";
if(!file_exists("log")&&!is_dir("log"))mkdir("log",0777);
if(!file_exists($file))file_put_contents($file,"");
$allowTime = 30;//防刷新时间
$allowNum=10;//防刷新次数
$uri=$_SERVER['REQUEST_URI'];
$checkip=md5($ip);
$checkuri=md5($uri);
$yesno=true;
$ipdate=@file($file);
foreach($ipdate as $k=>$v)
{ $iptem=substr($v,0,32);
$uritem=substr($v,32,32);
$timetem=substr($v,64,10);
$numtem=substr($v,74);
if($time-$timetem<$allowTime){
if($iptem!=$checkip)$str.=$v;
else{
$yesno=false;
if($uritem!=$checkuri)$str.=$iptem.$checkuri.$time."1\r\n";
elseif($numtem<$allowNum)$str.=$iptem.$uritem.$timetem.($numtem+1)."\r\n";
else
{
if(!file_exists($fileforbid)){$addforbidarr=array($ip."\r\n",time()."\r\n",1);file_put_contents($fileforbid,$addforbidarr);}
file_put_contents("log/forbided_ip.log",$ip."--".date("Y-m-d H:i:s",time())."--".$uri."\r\n",FILE_APPEND);
$timepass=$timetem+$allowTime-$time;
die("提示:"."<br>"."您的刷新频率过快，请等待 ".$timepass." 秒后继续使用!");
}
}
}
}
if($yesno) $str.=$checkip.$checkuri.$time."1\r\n";
file_put_contents($file,$str);
?>
<?php
$mod = 'admin';
$notLogin = true;
include('../Common/Core_brain.php');

if(isset($_GET['logout'])){
    unset($_SESSION['adminUser']);
    header('Location:./login.php');
}

if($isLogin)header('Location:./');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>后台登录 - <?php echo conf('Name');?> - 后台管理中心</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta content="<?php echo conf('Descriptison');?>" name="descriptison">
<meta content="<?php echo conf('Keywords');?>" name="keywords">
<meta name="author" content="<?php echo conf('Name');?>">
<link href="../assets/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/admin/css/materialdesignicons.min.css" rel="stylesheet">
<link href="../assets/admin/css/style.min.css" rel="stylesheet">
<style>
body {
    background-color: #fff;
}
.lyear-login-box {
    position: relative;
    overflow-x: hidden;
    width: 100%;
    height: 100%;
    -webkit-transition: 0.5s;
    -o-transition: 0.5s;
    transition: 0.5s;
}
.lyear-login-left {
    width: 50%;
    top: 0;
    left: 0;
    bottom: 0;
    position: fixed;
    height: 100%;
    z-index: 555;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
}
.lyear-overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10;
    background: rgba(0, 0, 0, 0.5);
}
.lyear-logo {
    margin-bottom: 50px;
}
.lyear-featured {
    z-index: 12;
    position: absolute;
    bottom: 0;
    padding: 30px;
    width: 100%;
}
.lyear-featured h4 {
    color: #fff;
    line-height: 32px;
}
.lyear-featured h4 small {
    color: #fff;
    display: block;
    text-align: right;
    margin-top: 15px;
}
.lyear-login-right {
    margin-left: 50%;
    position: relative;
    z-index: 999;
    padding: 100px;
    background-color: #fff;
}
@media screen and (max-width: 1024px) {
.lyear-login-right {
    padding: 50px;
}
}
@media screen and (max-width: 820px) {
.lyear-login-left {
    width: 100%;
    position: relative;
    z-index: 999;
    height: 300px;
}
.lyear-login-right {
    margin-left: 0;
}
}
@media screen and (max-width: 480px) {
.lyear-login-right {
    padding: 50px;
}
}
@media screen and (max-width: 320px) {
.lyear-login-right {
    padding: 30px;
}
}
</style>
</head>
  
<body>
<div class="lyear-login-box">
  <div class="lyear-login-left" style="background-image: url(https://api.dujin.org/pic/)">
    <div class="lyear-overlay"></div>
    <div class="lyear-featured">
      <h4><p id="hitokoto_text">:D 获取中...</p><small><p id="hitokoto_from">:D 获取中...</p></small></h4>
    </div>
  </div>
  <div class="lyear-login-right">
    
    <div class="lyear-logo text-center"> 
      <a href="#!"><img src="../assets/admin/images/logo-sidebar.png" alt="logo" /></a> 
    </div>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="username">用户名</label>
        <input type="text" class="form-control" name="adminUser" placeholder="请输入您的用户名">
      </div>

      <div class="form-group">
        <label for="password">密码</label>
        <input type="password" class="form-control" name="adminPwd" placeholder="请输入您的密码">
      </div>
      <?php if(conf('Vaptcha_Open') == 1) {?>
      <div id="vaptchaContainer" class="form-group">
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
      <div class="form-group">
        <button class="btn btn-block btn-primary" id="submit" type="submit">立即登录</button>
      </div>
      <footer class="text-center">
        <p class="m-b-0">Copyright © 2018-2020 <a href="http://<?php echo conf('Url');?>"><?php echo conf('Name');?></a>. All right reserved</p>
      </footer>
    </form>
    
  </div>
</div>
<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/main.min.js"></script>
<script src="../assets/layer/layer.js"></script>
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
$(document).ready(function(){
  if($("#vaptchaContainer").length>0) vaptcha_open=1;
  $("#submit").click(function(){
      var adminUser = $("input[name='adminUser']").val();
      var adminPwd = $("input[name='adminPwd']").val();
      var data = {adminUser:adminUser,adminPwd:adminPwd};
      var login = $("button[type='submit']");
      if(adminUser.length < 1 || adminPwd.length < 1){
          layer.alert('请确保每项项都不为空！', {icon: 2});
          return false;
      }
      if(vaptcha_open==1){
        var token = obj.getToken();
        if(token == ""){
          layer.msg('请先完成人机验证！'); return false;
        }
        var adddata = {token:token};
      }
      login.attr('disabled', 'true');
      layer.msg('正在登录中，请稍后...');
      $.ajax({
        type:'POST',
        url:'ajax.php?act=login',
        data: Object.assign(data, adddata),
        dataType:'json',
        success:function (data){
            if(data.code == 1){
              setTimeout(function (){
                  location.href = './'
              },1000);
              layer.alert(data.msg, {icon: 1});
            }else{
              login.removeAttr('disabled');
              layer.alert(data.msg, {icon: 2});
              obj.reset();
            }
          }
      });
      return false;
  });
});
</script>
<script>
  fetch('https://v1.hitokoto.cn')
    .then(response => response.json())
    .then(data => {
      const text = document.getElementById('hitokoto_text')
      text.innerText = data.hitokoto
      const from = document.getElementById('hitokoto_from')
      var author = !!data.from ? data.from : "无名氏";
      from.innerText = "—— " + (data.from_who || '') + "「" + author + "」"
    })
    .catch(console.error)
</script>
</body>
</html>