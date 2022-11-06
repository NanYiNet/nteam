<?php
$mod = 'admin';
include('../Common/Core_brain.php');
if (conf('Vaptcha_Vid') == '' || conf('Vaptcha_Open') != 1) {
exit('您还未配置人机验证信息或未打开人机验证开关，请前往设置后再来访问！');
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>问题反馈 - <?php echo conf('Name');?> - 后台管理中心</title>
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
          <form method="post" action="./wtfk.php" class="site-form">
            <div class="form-group">
              <label for="adminUser">反馈主题</label>
              <input type="text" name="sub" placeholder="请输入反馈主题" class="form-control text-primary font-size-sm" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="new-password">反馈内容</label>
              <input type="text" name="msg" placeholder="请输入反馈内容" class="form-control text-primary font-size-sm" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="confirm-password">反馈人QQ</label>
              <input type="text" name="qq" value="<?=$adminData['adminQq']?>" placeholder="请输入反馈人QQ" class="form-control text-primary font-size-sm" autocomplete="off">
            </div>
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
            <button type="submit" id="submit" class="btn btn-primary">提交反馈</button>
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
$(document).ready(function(){
  $("#submit").click(function(){
    var token = obj.getToken();
    var sub = $("input[name='sub']").val();
    var msg = $("input[name='msg']").val();
    var qq = $("input[name='qq']").val();
    var fk = $("button[type='submit']");
    if(sub.length < 1 || msg.length < 1 || qq.length < 1){
        layer.alert('请保证每项都不为空，请补充完整！',{icon:2,shade:0.8});
        return false;
    }
    fk.attr('disabled', 'true');
    layer.msg('正在提交中，请稍后...');
    $.ajax({
      type: "POST",
      url: "ajax.php?act=adminfk",
      data: {sub:sub,msg:msg,qq:qq,token:token},
      dataType: "json",
      success: function (data) {
        if(data.code == 1){
            fk.removeAttr('disabled');
            layer.alert(data.msg,{icon:1,shade:0.8});
        }else{
            fk.removeAttr('disabled');
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