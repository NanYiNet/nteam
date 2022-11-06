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
<title>网站配置 - <?php echo conf('Name');?> - 后台管理中心</title>
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
<?php
$mod=isset($_GET['mod'])?$_GET['mod']:null;
$mods=['base'=>'基本','indexmk'=>'首页模块','emailset'=>'邮箱配置'];
?>
        <ul class="nav nav-tabs page-tabs">
  <?php foreach($mods as $key=>$name){echo '<li class="'.($key==$mod?'active':null).'"><a href="web_config.php?mod='.$key.'">'.$name.'</a></li>';} ?>
        </ul>
<?php
if($mod=='base'){
?>
        <div class="tab-content">
          <div class="tab-pane active">
            <form onsubmit="return saveSetting(this)" method="post" name="edit-form" class="edit-form">
              <div class="form-group">
                <label for="SiteName">网站名称</label>
                <input class="form-control" type="text" name="SiteName" value="<?php echo conf('SiteName');?>" placeholder="请输入网站名称" >
                <small class="help-block">调用方式：<code>conf('SiteName')</code></small>
              </div>
              <div class="form-group">
                <label for="Name">网站简称</label>
                <input class="form-control" type="text" name="Name" value="<?php echo conf('Name');?>" placeholder="请输入网站简称" >
                <small class="help-block">调用方式：<code>conf('Name')</code></small>
              </div>
              <div class="form-group">
                <label for="Url">网站域名</label>
                <input class="form-control" type="text" id="Url" name="Url" value="<?php echo conf('Url');?>" placeholder="请输入网站域名" >
                <small class="help-block">调用方式：<code>conf('Url')</code></small>
              </div>
              <div class="form-group">
                <label for="Keywords">站点关键词</label>
                <input class="form-control" type="text" name="Keywords" value="<?php echo conf('Keywords');?>" placeholder="请输入站点关键词" >
                <small class="help-block">网站搜索引擎关键字</small>
              </div>
              <div class="form-group">
                <label for="Descriptison">站点描述</label>
                <textarea class="form-control" rows="5" name="Descriptison" placeholder="请输入站点描述" ><?php echo conf('Descriptison');?></textarea>
                <small class="help-block">网站描述，有利于搜索引擎抓取相关信息</small>
                <small class="help-block">调用方式：<code>conf('Descriptison')</code></small>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Vaptcha_Open">系统人机验证开关</label>
                  <div class="clearfix">
                    <label class="lyear-radio radio-inline radio-primary">
                      <input type="radio" name="Vaptcha_Open" value="0" <?=conf('Vaptcha_Open')==0?"checked":""?>><span>禁用</span>
                    </label>
                    <label class="lyear-radio radio-inline radio-primary">
                      <input type="radio" name="Vaptcha_Open" value="1" <?=conf('Vaptcha_Open')==1?"checked":""?>><span>启用</span>
                    </label>
                  </div>
                <small class="help-block">调用方式：<code>conf('Vaptcha_Open')</code>则直接输出代码，<code>conf('Vaptcha_Opens');$Vaptcha_Opens;</code>输出1或0</small>
              </div>
              <div class="form-group col-xs-6">
                <label for="Vaptcha_Vid">人机验证单元Vid</label>
                <input class="form-control" type="text" id="Vaptcha_Vid" name="Vaptcha_Vid" value="<?php echo conf('Vaptcha_Vid');?>" placeholder="请输入人机验证单元Vid" >
                <small class="help-block">前往<a href="https://www.vaptcha.com/">Vaptcha</a>免费注册开通</small>
              </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary m-r-5">确 定</button>
                <button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
              </div>
            </form>
          </div>
        </div>
<?php
}elseif($mod=='indexmk'){
?>
        <div class="tab-content">
          <div class="tab-pane active">
            <form onsubmit="return saveSettings(this)" method="post" name="edit-form" class="edit-form" role="form">
              <div class="form-group">
                <label for="Index_About">About模块内容</label>
                <textarea class="form-control" rows="5" name="Index_About" placeholder="请输入About模块内容" ><?php echo conf_index('Index_About');?></textarea>
              </div>
              <div class="form-group">
                <label for="Index_About">首页友情链接</label>
                <textarea class="form-control" rows="5" name="Index_Links" placeholder="请输入友情链接内容" ><?php echo conf_index('Index_Links');?></textarea>
                <small class="help-block">请按照代码格式编写</small>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Services_t1">Services第一个板块标题</label>
                <input class="form-control" type="text" name="Index_Services_t1" value="<?php echo conf_index('Index_Services_t1');?>" placeholder="请输入Services第一个板块标题">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Services_d1">Services第一个板块内容</label>
                <input class="form-control" type="text" name="Index_Services_d1" value="<?php echo conf_index('Index_Services_d1');?>" placeholder="请输入Services第一个板块内容">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Services_t2">Services第二个板块标题</label>
                <input class="form-control" type="text" name="Index_Services_t2" value="<?php echo conf_index('Index_Services_t2');?>" placeholder="请输入Services第二个板块标题">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Services_d2">Services第二个板块内容</label>
                <input class="form-control" type="text" name="Index_Services_d2" value="<?php echo conf_index('Index_Services_d2');?>" placeholder="请输入Services第二个板块内容">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Services_t3">Services第三个板块标题</label>
                <input class="form-control" type="text" name="Index_Services_t3" value="<?php echo conf_index('Index_Services_t3');?>" placeholder="请输入Services第三个板块标题">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Services_d3">Services第三个板块内容</label>
                <input class="form-control" type="text" name="Index_Services_d3" value="<?php echo conf_index('Index_Services_d3');?>" placeholder="请输入Services第三个板块内容">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Services_t4">Services第四个板块标题</label>
                <input class="form-control" type="text" name="Index_Services_t4" value="<?php echo conf_index('Index_Services_t4');?>" placeholder="请输入Services第四个板块标题">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Services_d4">Services第四个板块内容</label>
                <input class="form-control" type="text" name="Index_Services_d4" value="<?php echo conf_index('Index_Services_d4');?>" placeholder="请输入Services第四个板块内容">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Qq">前台显示QQ</label>
                <input class="form-control" type="text" name="Index_Qq" value="<?php echo conf_index('Index_Qq');?>" placeholder="请输入要显示的QQ号">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Email">前台显示邮箱</label>
                <input class="form-control" type="text" name="Index_Email" value="<?php echo conf_index('Index_Email');?>" placeholder="请输入要显示的邮箱">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Phone">前台显示手机号</label>
                <input class="form-control" type="text" name="Index_Phone" value="<?php echo conf_index('Index_Phone');?>" placeholder="请输入要显示的手机号">
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Place">前台显示地址</label>
                <input class="form-control" type="text" name="Index_Place" value="<?php echo conf_index('Index_Place');?>" placeholder="请输入要显示的地址">
              </div>
              </div>
              <div class="row show-grid">
              <div class="form-group col-xs-6">
                <label for="Index_Fang">首页防xxs的Js开关</label>
                  <div class="clearfix">
                    <label class="lyear-radio radio-inline radio-primary">
                      <input type="radio" name="index_fang" value="0" <?=conf_index('Index_Fang')==0?"checked":""?>><span>禁用</span>
                    </label>
                    <label class="lyear-radio radio-inline radio-primary">
                      <input type="radio" name="index_fang" value="1" <?=conf_index('Index_Fang')==1?"checked":""?>><span>启用</span>
                    </label>
                  </div>
                <small class="help-block">调用方式：<code>conf_index('Index_Fang')</code>输出1或0</small>
              </div>
              <div class="form-group col-xs-6">
                <label for="Index_Style">前台自定义样式</label>
                <textarea class="form-control" rows="3" name="Index_Style" placeholder="请输入自定义样式内容" ><?php echo conf_index('Index_Style');?></textarea>
                <small class="help-block">调用方式：<code>conf_index('Index_Style')</code></small>
              </div>
              </div>
              <div class="form-group">
                <label for="Index_Style">前台幻灯片1号内容</label>
                <input class="form-control" type="text" name="Index_Slide1" value="<?php echo conf_index('Index_Slide1');?>" placeholder="请输入幻灯片1号内容">
              </div>
              <div class="form-group">
                <label for="Index_Style">前台幻灯片2号内容</label>
                <input class="form-control" type="text" name="Index_Slide2" value="<?php echo conf_index('Index_Slide2');?>" placeholder="请输入幻灯片2号内容">
              </div>
              <div class="form-group">
                <label for="Index_Style">前台幻灯片3号内容</label>
                <input class="form-control" type="text" name="Index_Slide3" value="<?php echo conf_index('Index_Slide3');?>" placeholder="请输入幻灯片3号内容">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary m-r-5">确 定</button>
                <button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
              </div>
            </form>
          </div>
        </div>
<?php
}elseif($mod=='emailset'){
?>
        <div class="tab-content">
          <div class="tab-pane active">
            <form onsubmit="return saveSetting(this)" method="post" name="edit-form" class="edit-form">
              <div class="form-group">
                <label for="Mail_Smtp">SMTP地址</label>
                <input class="form-control" type="text" name="Mail_Smtp" value="<?php echo conf('Mail_Smtp');?>" placeholder="请输入SMTP地址" >
              </div>
              <div class="form-group">
                <label for="Mail_Port">SMTP端口</label>
                <input class="form-control" type="text" name="Mail_Port" value="<?php echo conf('Mail_Port');?>" placeholder="请输入SMTP端口" >
              </div>
              <div class="form-group">
                <label for="Mail_Name">邮箱账号</label>
                <input class="form-control" type="text" name="Mail_Name" value="<?php echo conf('Mail_Name');?>" placeholder="请输入邮箱账号" >
              </div>
              <div class="form-group">
                <label for="Mail_Pwd">邮箱密码（授权码）</label>
                <input class="form-control" type="text" name="Mail_Pwd" value="<?php echo conf('Mail_Pwd');?>" placeholder="请输入邮箱密码（授权码）" >
                <small class="help-block">QQ邮箱非QQ密码</small>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary m-r-5">确 定</button>
                <button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
              </div>
            </form>
          </div>
        </div>
<?php
}
?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/main.min.js"></script>
<script src="../assets/layer/layer.js"></script>
<script>
function checkURL(obj)
{
  var url = $(obj).val();

  if (url.indexOf(" ")>=0){
    url = url.replace(/ /g,"");
  }
  if (url.toLowerCase().indexOf("http://")<0 && url.toLowerCase().indexOf("https://")<0){
    url = "http://"+url;
  }
  if (url.slice(url.length-1)!="/"){
    url = url+"/";
  }
  $(obj).val(url);
}
function saveSetting(obj){
  var ii = layer.load(2, {shade:[0.1,'#fff']});
  $.ajax({
    type : 'POST',
    url : 'ajax.php?act=set',
    data : $(obj).serialize(),
    dataType : 'json',
    success : function(data) {
      layer.close(ii);
      if(data.code == 0){
        layer.alert(data.msg, {
          icon: 1,
          closeBtn: false
        }, function(){
          window.location.reload()
        });
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
function saveSettings(obj){
  var ii = layer.load(2, {shade:[0.1,'#fff']});
  $.ajax({
    type : 'POST',
    url : 'ajax.php?act=sets',
    data : $(obj).serialize(),
    dataType : 'json',
    success : function(data) {
      layer.close(ii);
      if(data.code == 0){
        layer.alert(data.msg, {
          icon: 1,
          closeBtn: false
        }, function(){
          window.location.reload()
        });
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