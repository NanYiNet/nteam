<?php
$mod = 'admin';
include('../Common/Core_brain.php');
if($adminData['adminRank']== 2) {
  echo "您的账号没有权限使用此功能";
  exit;
}

if(isset($_GET['value']) && !empty($_GET['value'])) {
  if ($_GET['column'] == 1) {
    $sql=" Audit_status=0";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_project_list WHERE{$sql}");
  }elseif ($_GET['value'] == '程序') {
    $sql=" `{$_GET['column']}` LIKE '%app%' and Audit_status=0";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_project_list WHERE{$sql}");
  }elseif ($_GET['value'] == '单页') {
    $sql=" `{$_GET['column']}` LIKE '%web%' and Audit_status=0";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_project_list WHERE{$sql}");
  }else{
    $sql=" `{$_GET['column']}` LIKE '%{$_GET['value']}%' and Audit_status=0";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_project_list WHERE{$sql}");
  }
  $link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
  $numrows=$DB->getColumn("SELECT count(*) from nteam_project_list WHERE Audit_status=0");
  $sql=" Audit_status=0";
}
?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>项目名</th>
                  <th>项目网址</th>
                  <th>项目图片</th>
                  <th>项目简述</th>
                  <th>项目描述</th>
                  <th>项目类型</th>
                  <th>添加时间</th>
                  <th>操作</th>
                </tr>
            </thead>
            <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM nteam_project_list WHERE{$sql} order by id limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '
              <tr>
                <td><b>'.$res['id'].'</b></td>
                <td>'.$res['name'].'</td>
                <td>'.$res['url'].'</td>
                <td>'.$res['img'].'</td>
                <td>'.$res['sketch'].'</td>
                <td>'.$res['descriptison'].'</td>
                <td>'.($res['type']=='web'?'单页':'程序').'</td>
                <td>'.$res['intime'].'</td>
                <td><a href="javascript:setAudit_status('.$res['id'].',1)" class="btn btn-xs btn-info">通过</a>&nbsp;<a href="javascript:delProject('.$res['id'].')" class="btn btn-xs btn-danger">删除</a></td>
                </tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<div class="text-center"><ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$first.$link.'\')">首页</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$prev.$link.'\')">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$i.$link.'\')">'.$i .'</a></li>';
if ($page<$pages)
{
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$next.$link.'\')">&raquo;</a></li>';
echo '<li><a href="javascript:void(0)" onclick="listTable(\'page='.$last.$link.'\')">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul></div>';
