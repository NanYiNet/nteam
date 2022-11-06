<?php
$mod = 'admin';
include('../Common/Core_brain.php');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>修改密码 - <?php echo conf('Name');?> - 后台管理中心</title>
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
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form method="post" action="./edit_pwd.php" class="site-form">
            <div class="form-group">
              <label for="id">管理员ID</label>
              <input type="text" value="<?=$adminData['id']?>" name="id" class="form-control text-primary font-size-sm" disabled>
            </div>
            <div class="form-group">
              <label for="adminUser">账号</label>
              <input type="text" value="<?=$adminData['adminUser']?>" name="adminUser" placeholder="请输入管理员账号" class="form-control text-primary font-size-sm" autocomplete="off">
              <small>账号不允许修改！</small>
            </div>
            <div class="form-group">
              <label for="new-password">新密码</label>
              <input type="text" name="adminPwd" placeholder="请输入管理员密码(不修改请留空)" class="form-control text-primary font-size-sm" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="confirm-password">管理员ＱＱ</label>
              <input type="text" name="adminQq" value="<?=$adminData['adminQq']?>" placeholder="请输入管理员ＱＱ" class="form-control text-primary font-size-sm" autocomplete="off">
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
            <button type="submit" id="submit" class="btn btn-primary">修改密码</button>
          </form>
        </div>
      </div>
    </div>
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
    var adminQq = $("input[name='adminQq']").val();
    var id = $("input[name='id']").val();
    var data = {adminUser:adminUser,adminPwd:adminPwd,adminQq:adminQq,id:id};
    var edit = $("button[type='submit']");
    if(adminUser.length < 1 || adminQq.length < 1){
        layer.alert('账号或者QQ号为空，请补充完整！',{icon:2,shade:0.8});
        return false;
    }
    if(vaptcha_open==1){
      var token = obj.getToken();
      var adddata = {token:token};
    }
    edit.attr('disabled', 'true');
    layer.msg('正在修改中，请稍后...');
    $.ajax({
      type: "POST",
      url: "ajax.php?act=admininfo",
      data: Object.assign(data, adddata),
      dataType: "json",
      success: function (data) {
        if(data.code == 1){
          edit.removeAttr('disabled');
          layer.alert(data.msg,{icon:1,shade:0.8});
          obj.reset();
        }else if(data.code == 2){
          setTimeout(function (){
              parent.location.href = './login.php'
          },1000);
          layer.alert(data.msg,{icon:1,shade:0.8});
        }else{
          edit.removeAttr('disabled');
          layer.alert(data.msg,{icon:2,shade:0.8});
          obj.reset();
        }
      },
    });
    return false;
  });
});
</script>
</body>
</html>