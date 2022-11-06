<?php
namespace lib;

class AdminClass
{
    public static function getAdmin($adminUser)
    {
        global $DB;
        return $DB->query("SELECT * FROM `nteam_admin` WHERE `adminUser` = '$adminUser'")->fetch();
    }
    public static function delAdmin($id)
    {
        global $DB;
        return $DB->exec("DELETE FROM `nteam_admin` WHERE `id` = '$id'");
    }
    public static function AddAdmin($data)
    {
        global $DB;
        global $Gets;
        $ip = $Gets->ip();
        $adminUser = $data['adminUser'];
        $adminPwd = $data['adminPwd'];
        $adminQq = $data['adminQq'];
        $adminRank = $data['adminRank'];
        return $DB->exec("INSERT INTO `nteam_admin`(`adminUser`,`adminPwd`,`adminQq`,`adminLoginIp`,`adminRank`)VALUES('$adminUser','$adminPwd','$adminQq','$ip','$adminRank')");
    }
    public static function getAdminName($adminUser)
    {
        global $DB;
        $data = $DB->query("SELECT * FROM `nteam_admin` WHERE `adminUser` = '$adminUser'")->fetch();
        return $data;
    }
    public static function getAdminId($id)
    {
        global $DB;
        return $DB->query("SELECT * FROM `nteam_admin` WHERE `id` = '$id' limit 1")->fetch();
    }
    public static function loginAdmin($adminUser)
    {
        global $DB;
        global $Gets;
        $ip = $Gets->ip();
        return $DB->exec("UPDATE `nteam_admin` SET `adminLoginIp` = '$ip' WHERE `adminUser` = '$adminUser'");
    }
    public static function get_os()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])){
            $os = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } else if (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } else if (preg_match('/linux/i', $os)) {
                $os = 'Android';
            } else if (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } else if (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return 'unknow';
        }
    }
    public static function browse_info()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])){
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknow';
        }
    }
    public static function detect_encoding($file='./login.php')
    {
        $list = array('GBK', 'UTF-8', 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1');
        $str = file_get_contents($file);
        foreach ($list as $item) {
            $tmp = mb_convert_encoding($str, $item, $item);
            if (md5($tmp) == md5($str)) {
                return $item;
            }
        }
        return null;
    }
}

