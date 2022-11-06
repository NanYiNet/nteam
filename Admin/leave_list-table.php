<?php
$mod = 'admin';
include('../Common/Core_brain.php');

if(isset($_GET['value']) && !empty($_GET['value'])) {
	if ($_GET['column'] == 1) {
		$sql=" 1";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_leave_messages WHERE{$sql}");
	}else{
		$sql=" `{$_GET['column']}` LIKE '%{$_GET['value']}%'";
    $numrows=$DB->getColumn("SELECT count(*) from nteam_leave_messages WHERE{$sql}");
	}
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
  $numrows=$DB->getColumn("SELECT count(*) from nteam_leave_messages WHERE{$sql}");
	$sql=" 1";
}
?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                	<th>编号</th>
                	<th>留言人</th>
                	<th>留言邮箱</th>
                	<th>留言主题</th>
                	<th>留言内容</th>
                	<th>添加时间</th>
                </tr>
            </thead>
          	<tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM nteam_leave_messages WHERE{$sql} order by id limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['name'].'</td><td>'.$res['email'].'</td><td>'.$res['subject'].'</td><td>'.$res['message'].'</td><td>'.$res['intime'].'</td></tr>';
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
