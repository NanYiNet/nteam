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
<title>成员列表 - <?php echo conf('Name');?> - 后台管理中心</title>
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
        <div class="card-toolbar clearfix">
          <form class="pull-right search-bar" method="get" onsubmit="return searchTeam()" role="form">
            <div>
              <div class="form-group" style="display: inline-block;float: left;">
              <select name="column" class="form-control"><option value="1">搜索</option><option value="name">名称</option><option value="qq">QQ</option></select>
              </div>
              <div class="form-group" style="display: inline-block;float: right;">
                <input type="text" class="form-control" name="value" placeholder="搜索内容">
              </div>
            </div>
          </form>
          <div class="toolbar-btn-action">
            <a class="btn btn-primary m-r-5" href="./tset.php?my=add"><i class="mdi mdi-plus"></i> 新增</a>
          </div>
        </div>
        <div id="listTable" class="card-body"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="../assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/admin/js/main.min.js"></script>
<script src="../assets/layer/layer.js"></script>
<script>
function listTable(query){
  var url = window.document.location.href.toString();
  var queryString = url.split("?")[1];
  query = query || queryString;
  if(query == 'start' || query == undefined){
    query = '';
    history.replaceState({}, null, './tlist.php');
  }else if(query != undefined){
    history.replaceState({}, null, './tlist.php?'+query);
  }
  layer.closeAll();
  var ii = layer.load(2, {shade:[0.1,'#fff']});
  $.ajax({
    type : 'GET',
    url : 'tlist-table.php?'+query,
    dataType : 'html',
    cache : false,
    success : function(data) {
      layer.close(ii);
      $("#listTable").html(data)
    },
    error:function(data){
      layer.msg('服务器错误');
      return false;
    }
  });
}
function searchTeam(){
  var column=$("select[name='column']").val();
  var value=$("input[name='value']").val();
  if(value==''){
    listTable();
  }else{
    listTable('column='+column+'&value='+value);
  }
  return false;
}
function setStatus(id,status) {
  $.ajax({
    type : 'GET',
    url : 'ajax.php?act=setMember&type=Status&id='+id+'&status='+status,
    dataType : 'json',
    success : function(data) {
      if(data.code == 0){
        listTable();
        layer.msg(data.msg, {icon:1, time:1500});
      }else{
        layer.msg(data.msg, {icon:2, time:1500});
      }
    },
    error:function(data){
      layer.msg('服务器错误');
      return false;
    }
  });
  return false;
}
function setShow(id,num) {
  $.ajax({
    type : 'GET',
    url : 'ajax.php?act=setMember&type=Show&id='+id+'&num='+num,
    dataType : 'json',
    success : function(data) {
      if(data.code == 0){
        listTable();
        layer.msg(data.msg, {icon:1, time:1500});
      }else{
        layer.msg(data.msg, {icon:2, time:1500});
      }
    },
    error:function(data){
      layer.msg('服务器错误');
      return false;
    }
  });
  return false;
}
function delMember(id){
  layer.confirm('您确定要删除吗？', {
    btn: ['确定','取消'] //按钮
  }, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=setMember&type=Del',
      data: {id:id},
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
  }, function() {});
  return false;
}
$(document).ready(function(){
  listTable();
})
</script>
</body>
</html>