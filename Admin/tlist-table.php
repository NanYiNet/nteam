<?php
$mod = 'admin';
include('../Common/Core_brain.php');
if($adminData['adminRank']== 2) {
  echo "您的账号没有权限使用此功能";
  exit;
}

if(isset($_GET['value']) && !empty($_GET['value'])) {
	if ($_GET['column'] == 1) {
		$sql=" 1";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_team_member WHERE{$sql}");
	}else{
		$sql=" `{$_GET['column']}` LIKE '%{$_GET['value']}%'";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_team_member WHERE{$sql}");
	}
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
  $numrows=$DB->getColumn("SELECT count(*) from nteam_team_member WHERE 1");
	$sql=" 1";
}
?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                	<th>编号</th>
                	<th>名称</th>
                	<th>QQ</th>
                	<th>描述</th>
                  <th>显示首页</th>
<?php if($adminData['adminRank'] == 1) {?>
                  <th>审核状态</th>
<?php }?>
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

$rs=$DB->query("SELECT * FROM nteam_team_member WHERE{$sql} order by id limit $offset,$pagesize");
while($res = $rs->fetch())
{
?>
<tr><td><b><?php echo $res['id'];?></b></td><td><?php echo $res['name'];?></td><td><a href="tencent://message/?uin='.$res['qq'].'&amp;Menu=yes"><?php echo $res['qq'];?></a></td><td><?php echo $res['describe'];?></td><?php echo '<td>'.($res['is_show']==1?'<a href="javascript:setShow('.$res['id'].',0)" class="label label-success editable editable-click">正常</a>':'<a href="javascript:setShow('.$res['id'].',1)" class="label label-danger editable editable-click">暂停</a>').'</td>';?><?php if($adminData['adminRank'] == 1) {?><?php echo '<td>'.($res['Audit_status']==1?'<a href="javascript:setStatus('.$res['id'].',0)" class="label label-success editable editable-click">已通过</a>':'<a href="javascript:setStatus('.$res['id'].',1)" class="label label-danger editable editable-click">未通过</a>').'</td>';?><?php }?><?php echo '<td>'.$res['intime'].'</td><td><a href="./tset.php?my=edit&id='.$res['id'].'" class="btn btn-xs btn-info">编辑</a>&nbsp;<a href="javascript:delMember('.$res['id'].')" class="btn btn-xs btn-danger"">删除</a></td></tr>';
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
