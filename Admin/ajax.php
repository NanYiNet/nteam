<?php
$notLogin = true;
include('../Common/Core_brain.php');

$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
    case 'login':
        $adminUser = addslashes($_POST['adminUser']);
        $adminPwd = md5($_POST['adminPwd']);
        if (conf('Vaptcha_Open') == 1) {
            $token = $_POST['token'];
        }
        if ($adminUser=='' || $adminPwd=='') {
            exit('{"code":0,"msg":"请确保每项都不为空"}');
        }
        if (conf('Vaptcha_Open') == 1 && $token=='') {
            exit('{"code":0,"msg":"请先完成人机验证"}');
        }else{
            $adminData = $Admin->getAdmin($adminUser);
            
            if(empty($adminData))exit('{"code":0,"msg":"管理员不存在"}');
            if($adminPwd != $adminData['adminPwd'])exit('{"code":0,"msg":"密码错误"}');
    
            $Admin->loginAdmin($adminUser);
            $_SESSION['adminUser'] = $adminUser;
            $_SESSION['adminQq'] = $adminData['adminQq'];
            $ip = $Gets->ip();
            $city = $Gets->get_city($ip);
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','登录后台中心', NOW(), '".$ip."', '".$city."')");
            exit('{"code":1,"msg":"登录成功，请稍后..."}');
        }
    break;
    case 'admininfo':
        if(!$isLogin)exit('{"code":0,"msg":"未登录"}');
        $id = $adminData['id'];
        if (conf('Vaptcha_Open') == 1) {
            $token = $_POST['token'];
        }
        $adminUser = $adminData['adminUser'];
        $adminQq = addslashes($_POST['adminQq']);
        if (conf('Vaptcha_Open') == 1 && $token=='') {
            exit('{"code":0,"msg":"请先完成人机验证"}');
        }else{
            $adminData = $Admin->getAdmin($adminUser);
            $AdminData = $Admin->getAdminName($adminUser);
            if ($adminQq == $adminData['adminQq']) {
                exit('{"code":0,"msg":"未修改数据，无需保存！"}');
            }
            
            $sql = "UPDATE `nteam_admin` SET `adminUser` = '$adminUser',`adminQq` = '$adminQq' WHERE `id` = '$id'";
            if(!empty($_POST['adminPwd'])){
                $adminPwd = md5($_POST['adminPwd']);
                if($adminPwd == $adminData['adminPwd'])exit('{"code":0,"msg":"与原密码相同！"}');
                $sql = "UPDATE `nteam_admin` SET `adminPwd` = '$adminPwd',`adminUser` = '$adminUser',`adminQq` = '$adminQq' WHERE `id` = '$id'";
            }
            $admininfo = $DB->exec($sql);
            if(!$admininfo)exit('{"code":0,"msg":"修改失败，未知错误。"}');
            if(!empty($_POST['adminPwd'])){$DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改账号信息', NOW(), '".$ip."', '".$city."')");unset($_SESSION['adminUser']);}
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改账号信息', NOW(), '".$ip."', '".$city."')");
            if(!empty($_POST['adminPwd'])){
                exit('{"code":2,"msg":"修改成功"}');
            }else{
                exit('{"code":1,"msg":"修改成功"}');
            }
        }
    break;
    case 'setProject':
        $type=addslashes($_GET['type']);
        $id=intval($_GET['id']);
        $status=intval($_GET['status']);
        $num=intval($_GET['num']);
        if ($type == 'Status') {
            $sql = "UPDATE nteam_project_list SET status='$status' WHERE id='$id'";
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了项目ID为".$id."的网站状态', NOW(), '".$ip."', '".$city."')");
            if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改网站状态成功！"}');
            else exit('{"code":-1,"msg":"修改网站状态失败['.$DB->error().']"}');
        }elseif ($type == 'Show') {
            $sql = "UPDATE nteam_project_list SET is_show='$num' WHERE id='$id'";
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了项目ID为".$id."的显示状态', NOW(), '".$ip."', '".$city."')");
            if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改成功！"}');
            else exit('{"code":-1,"msg":"修改网站状态失败['.$DB->error().']"}');
        }elseif ($type == 'Audit_status') {
            $sql = "UPDATE nteam_project_list SET Audit_status='$status' WHERE id='$id'";
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了项目ID为".$id."的审核状态', NOW(), '".$ip."', '".$city."')");
            if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改审核状态成功！"}');
            else exit('{"code":-1,"msg":"修改网站状态失败['.$DB->error().']"}');
        }elseif ($type == 'Del') {
            $id=intval($_POST['id']);
            $rows=$DB->getRow("select * from nteam_project_list where id='$id' limit 1");
            if(!$rows)exit('{"code":-1,"msg":"项目不存在"}');
            $sql="DELETE FROM nteam_project_list WHERE id='$id'";
            if(!$DB->exec($sql)){exit('{"code":-1,"msg":"删除项目失败！"}');}else{
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','删除了ID为".$id."的项目', NOW(), '".$ip."', '".$city."')");
            exit('{"code":0,"msg":"删除项目成功！"}');}
        }elseif ($type == 'Add') {
            $name=$_POST['name'];
            $url=$_POST['url'];
            $img=$_POST['img'];
            $sketch=$_POST['sketch'];
            $descriptison=$_POST['descriptison'];
            $type=$_POST['type'];
            $is_show=$_POST['is_show'];
            $Audit_status=$_POST['Audit_status'];
            $status=$_POST['status'];
            if($adminData['adminRank']==2){
                if ($name==NULL || $url==NULL || $img==NULL || $sketch==NULL || $descriptison==NULL || $type==NULL || $is_show==NULL || $status==NULL) {
                    exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
                }
                $sds=$DB->exec("INSERT INTO `nteam_project_list` (`name`, `url`, `img`, `sketch`, `descriptison`, `type`, `intime`, `status`, `Audit_status`, `is_show`) VALUES ('{$name}', '{$url}', '{$img}', '{$sketch}', '{$descriptison}', '{$type}', '{$date}', '{$status}', '0', '{$is_show}')");
                $id=$DB->lastInsertId();
                if($sds){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','申请了名为".$name."的项目', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"添加项目成功！"}');
                }else{
                    exit('{"code":-1,"msg":"添加项目失败！"}');
                }
            }elseif ($adminData['adminRank']==1) {
                if ($name==NULL || $url==NULL || $img==NULL || $sketch==NULL || $descriptison==NULL || $type==NULL || $is_show==NULL || $Audit_status==NULL || $status==NULL) {
                    exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
                }
                $sds=$DB->exec("INSERT INTO `nteam_project_list` (`name`, `url`, `img`, `sketch`, `descriptison`, `type`, `intime`, `status`, `Audit_status`, `is_show`) VALUES ('{$name}', '{$url}', '{$img}', '{$sketch}', '{$descriptison}', '{$type}', '{$date}', '{$status}', '{$Audit_status}', '{$is_show}')");
                $id=$DB->lastInsertId();
                if($sds){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','添加了名为".$name."的项目', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"添加项目成功！"}');
                }else{
                    exit('{"code":-1,"msg":"添加项目失败！"}');
                }
            }
        }elseif ($type == 'Edit') {
            $id=$_GET['id'];
            $rows=$DB->getRow("select * from nteam_project_list where id='$id' limit 1");
            if(!$rows)exit('{"code":-1,"msg":"当前项目不存在！"}');
            $name=$_POST['name'];
            $url=$_POST['url'];
            $img=$_POST['img'];
            $sketch=$_POST['sketch'];
            $descriptison=$_POST['descriptison'];
            $type=$_POST['type'];
            $is_show=$_POST['is_show'];
            $Audit_status=$_POST['Audit_status'];
            $status=$_POST['status'];
            if($adminData['adminRank']==2){
                if($name==NULL || $url==NULL || $img==NULL || $sketch==NULL || $descriptison==NULL || $type==NULL || $is_show==NULL || $status==NULL){
                    exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
                }
                $sql="update `nteam_project_list` set `name` ='{$name}',`url` ='{$url}',`img` ='{$img}',`sketch` ='{$sketch}',`descriptison` ='{$descriptison}',`type` ='{$type}',`status` ='{$status}',`is_show` ='{$is_show}' where `id`='$id'";
                if($DB->exec($sql)!==false||$sqs){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了ID为".$id."的项目', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"修改项目信息成功！"}');
                }else{
                    exit('{"code":-1,"msg":"修改项目信息失败！"}');
                }
            }elseif ($adminData['adminRank']==1) {
                if($name==NULL || $url==NULL || $img==NULL || $sketch==NULL || $descriptison==NULL || $type==NULL || $is_show==NULL || $Audit_status==NULL || $status==NULL){
                    exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
                }
                $sql="update `nteam_project_list` set `name` ='{$name}',`url` ='{$url}',`img` ='{$img}',`sketch` ='{$sketch}',`descriptison` ='{$descriptison}',`type` ='{$type}',`status` ='{$status}',`Audit_status` ='{$Audit_status}',`is_show` ='{$is_show}' where `id`='$id'";
                if($DB->exec($sql)!==false||$sqs){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了ID为".$id."的项目', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"修改项目信息成功！"}');
                }else{
                    exit('{"code":-1,"msg":"修改项目信息失败！"}');
                }
            }
        }else{
            exit('{"code":-1,"msg":"你在想Peach？"}');
        }
    break;
    case 'setMember':
        if($adminData['adminRank']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        $type=addslashes($_GET['type']);
        $id=intval($_GET['id']);
        $status=intval($_GET['status']);
        $num=intval($_GET['num']);
        if ($type == 'Status') {
            $sql = "UPDATE nteam_team_member SET Audit_status='$status' WHERE id='$id'";
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了成员ID为".$id."的审核状态', NOW(), '".$ip."', '".$city."')");
            if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改审核状态成功！"}');
            else exit('{"code":-1,"msg":"修改网站状态失败['.$DB->error().']"}');
        }elseif ($type == 'Show') {
            $sql = "UPDATE nteam_team_member SET is_show='$num' WHERE id='$id'";
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了成员ID为".$id."的显示状态', NOW(), '".$ip."', '".$city."')");
            if($DB->exec($sql)!==false)exit('{"code":0,"msg":"修改成功！"}');
            else exit('{"code":-1,"msg":"修改网站状态失败['.$DB->error().']"}');
        }elseif ($type == 'Del') {
            $id=intval($_POST['id']);
            $rows=$DB->getRow("select * from nteam_team_member where id='$id' limit 1");
            if(!$rows)exit('{"code":-1,"msg":"成员不存在"}');
            $sql="DELETE FROM nteam_team_member WHERE id='$id'";
            if(!$DB->exec($sql)){exit('{"code":-1,"msg":"删除成员失败！"}');}else{
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','删除了ID为".$id."的成员', NOW(), '".$ip."', '".$city."')");
            exit('{"code":0,"msg":"删除成员成功！"}');}
        }elseif ($type == 'Add') {
            $name=$_POST['name'];
            $qq=$_POST['qq'];
            $describe=$_POST['describe'];
            $is_show=$_POST['is_show'];
            $Audit_status=$_POST['Audit_status'];
            if($name==NULL || $qq==NULL || $describe==NULL || $is_show==NULL || $Audit_status==NULL){
                exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
            } else {
                $sds=$DB->query("INSERT INTO `nteam_team_member` (`name`, `qq`, `describe`, `is_show`, `Audit_status`, `intime`) VALUES ('{$name}', '{$qq}', '{$describe}', '{$is_show}', '{$Audit_status}', NOW())");
                $id=$DB->lastInsertId();
                if($sds){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','添加了一位名为".$name."的成员', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"添加成员成功！"}');
                }else{
                    exit('{"code":-1,"msg":"添加成员失败！"}');
                }
            }
        }elseif ($type == 'Edit') {
            $id=$_GET['id'];
            $rows=$DB->getRow("select * from nteam_team_member where id='$id' limit 1");
            if(!$rows)
              exit('{"code":-1,"msg":"当前成员不存在！"}');
            $name=$_POST['name'];
            $qq=$_POST['qq'];
            $describe=$_POST['describe'];
            $is_show=$_POST['is_show'];
            $Audit_status=$_POST['Audit_status'];
            if($name==NULL || $qq==NULL || $describe==NULL || $is_show==NULL || $Audit_status==NULL){
                exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
            } else {
                $sql="update `nteam_team_member` set `name` ='{$name}',`qq` ='{$qq}',`describe` ='{$describe}',`is_show` ='{$is_show}',`Audit_status` ='{$Audit_status}' where `id`='$id'";
                if($DB->exec($sql)!==false||$sqs){
                    $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了一位名为".$name."的成员信息', NOW(), '".$ip."', '".$city."')");
                    exit('{"code":0,"msg":"修改成员信息成功！"}');
                }else{
                    exit('{"code":-1,"msg":"修改成员信息失败！"}');
                }
            }
        }else{
            exit('{"code":-1,"msg":"你在想Peach？"}');
        }
    break;
    case 'set':
        if($adminData['adminRank']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        foreach($_POST as $k=>$v){
            saveSetting($k, $v);
        }
        if(saveSetting($k, $v) !== false){$DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了网站配置', NOW(), '".$ip."', '".$city."')");exit('{"code":0,"msg":"设置保存成功！"}');
        }else{ exit('{"code":-1,"msg":"修改设置失败['.$DB->error().']"}');}
    break;
    case 'sets':
        if($adminData['id']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        foreach($_POST as $k=>$v){
            saveSettings($k, $v);
        }
        if(saveSettings($k, $v) !== false){$DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改了首页配置', NOW(), '".$ip."', '".$city."')");exit('{"code":0,"msg":"设置保存成功！"}');
        }else{ exit('{"code":-1,"msg":"修改设置失败['.$DB->error().']"}');}
    break;
    case 'AddAdmin':
        if($adminData['adminRank']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        $data['adminUser'] = addslashes($_POST['adminUser']);
        $data['adminPwd'] = md5($_POST['adminPwd']);
        $data['adminQq'] = $_POST['adminQq'];
        $data['adminRank'] = $_POST['adminRank'];
        if($data['adminUser']==NULL || $data['adminPwd']==NULL || $data['adminQq']==NULL || $data['adminRank']==NULL){
            exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
        } else {
        $AdminData = $Admin->getAdminName($data['adminUser']);
        if(!empty($AdminData))exit('{"code":-1,"msg":"账号已存在"}');

        if(!$Admin->AddAdmin($data))exit('{"code":-1,"msg":"添加管理员失败！"}');
        $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','添加了一位账号为".$data['adminUser']."管理员', NOW(), '".$ip."', '".$city."')");
        exit('{"code":0,"msg":"添加管理员成功！"}');
        }
    break;
    case 'EditAdmin':
        if($adminData['adminRank']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        $ids=$Admin->getAdminName($_POST['adminUser']);
        $id=$ids['id'];
        $rows=$DB->getRow("select * from nteam_admin where id='$id' limit 1");
        if($adminData['id']!='1'){
            exit('{"code":-1,"msg":"去你的 别人信息是你想改就改的？<br>要改自己的请到修改密码页面修改"}');
        }
        if(!$rows)exit('{"code":-1,"msg":"当前管理员不存在！"}');
        $adminUser = addslashes($_POST['adminUser']);
        $adminQq = addslashes($_POST['adminQq']);
        $adminRank = addslashes($_POST['adminRank']);
        $adminData = $Admin->getAdmin($adminUser);
        if($_POST['adminUser']==NULL || $_POST['adminQq']==NULL || $_POST['adminRank']==NULL){
            exit('{"code":-1,"msg":"保存错误,请确保每项都不为空!"}');
        } else {
            if($adminRank>2){
                exit('{"code":-1,"msg":"数据非法！"}');
            }
            $sql = "UPDATE `nteam_admin` SET `adminUser` = '$adminUser',`adminQq` = '$adminQq',`adminRank` = '$adminRank' WHERE `id` = '$id'";
            if(!empty($_POST['adminPwd'])){
                $adminPwd = md5($_POST['adminPwd']);
                if($adminPwd == $adminData['adminPwd'])exit('{"code":-1,"msg":"与原密码相同！"}');
                $sql = "UPDATE `nteam_admin` SET `adminPwd` = '$adminPwd',`adminUser` = '$adminUser',`adminQq` = '$adminQq',`adminRank` = '$adminRank' WHERE `id` = '$id'";
            }
            $admininfo = $DB->exec($sql);
            if(!$admininfo)exit('{"code":-1,"msg":"修改失败。"}');
            $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','修改账号为".$adminUser."的管理员信息', NOW(), '".$ip."', '".$city."')");
            exit('{"code":0,"msg":"修改成功！！"}');
        }
    break;
    case 'DelAdmin':
        if($adminData['adminRank']!=1){exit('{"code":-1,"msg":"您的账号没有权限使用此功能！"}');}
        $id=$_POST['id'];
        $rows=$DB->getRow("select * from nteam_admin where id='$id' limit 1");
        if(!$rows)exit('{"code":-1,"msg":"当前管理员不存在"}');
        if(!$Admin->delAdmin($id)){exit('{"code":-1,"msg":"删除管理员失败！"}');}else{
        $DB->query("insert into `nteam_log` (`adminUser`,`type`,`data`,`ip`,`city`) values ('" . $_SESSION['adminUser'] . "','删除了账号为".$AdminData['adminUser']."的管理员', NOW(), '".$ip."', '".$city."')");
        exit('{"code":0,"msg":"删除管理员成功！"}');}
        break;
    case 'adminfk':
        if(isset($_SESSION['Tg_submit']) && $_SESSION['Tg_submit']>time()-300){
            exit('{"code":-1,"msg":"请勿频繁提交，要再次申请请等待5分钟!"}');
        }
        $sub = addslashes($_POST['sub']);
        $msg = addslashes($_POST['msg']);
        $qq = addslashes($_POST['qq']);
        $token = addslashes($_POST['token']);
        $yun_url= "https://www.nanyinet.cn/Ajax.php?act=admintg&sub=".$sub."&msg=".$msg."&qq=".$qq."&token=".$token;
        $yun_get= file_get_contents($yun_url);
        $yun_json= json_decode($yun_get,true);
        if ($yun_json['code'] == 0){
            $_SESSION['Tg_submit']=time();
            exit('{"code":1,"msg":"'.$yun_json['msg'].'"}');
        }else{
            exit('{"code":0,"msg":"'.$yun_json['msg'].'"}');
        }
        break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
    break;
}