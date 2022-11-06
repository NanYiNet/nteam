<?php

//数据库更新文件


#首页模板数据库更新
$DB->exec("ALTER TABLE `nteam_config_theme` ADD `Index_Links` text NULL COMMENT '首页友情链接' AFTER `Index_Style`");
$DB->exec("ALTER TABLE `nteam_config_theme` ADD `Index_Slide1` VARCHAR(255) NULL COMMENT '幻灯片1内容' AFTER `Index_Links`");
$DB->exec("ALTER TABLE `nteam_config_theme` ADD `Index_Slide2` VARCHAR(255) NULL COMMENT '幻灯片2内容' AFTER `Index_Slide1`");
$DB->exec("ALTER TABLE `nteam_config_theme` ADD `Index_Slide3` VARCHAR(255) NULL COMMENT '幻灯片3内容' AFTER `Index_Slide2`");
if ($DB->getRow("select * from nteam_config_theme where Index_Links='' OR Index_Links is NULL limit 1")) {
$DB->exec("UPDATE `nteam_config_theme` SET `Index_Links` = '<li><i class=\"bx bx-chevron-right\"></i><a href=\"//www.nanyinet.cn/\">南逸网络</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> ' WHERE `nteam_config_theme`.`id` = 1");
}elseif ($DB->getRow("select * from nteam_config_theme where Index_Slide1='' OR Index_Slide1 is NULL limit 1")) {
$DB->exec("UPDATE `nteam_config_theme` SET `Index_Slide1` = '代码改变世界' WHERE `nteam_config_theme`.`id` = 1");
}elseif ($DB->getRow("select * from nteam_config_theme where Index_Slide2='' OR Index_Slide2 is NULL limit 1")) {
$DB->exec("UPDATE `nteam_config_theme` SET `Index_Slide2` = '你想知道谁才是我们的成员吗？赶紧来查一下吧~' WHERE `nteam_config_theme`.`id` = 1");
}elseif ($DB->getRow("select * from nteam_config_theme where Index_Slide3='' OR Index_Slide3 is NULL limit 1")) {
$DB->exec("UPDATE `nteam_config_theme` SET `Index_Slide3` = '点击下方按钮<br>即可立即申请加入！！！' WHERE `nteam_config_theme`.`id` = 1");
}

#系统数据库更新
$DB->exec("ALTER TABLE `nteam_config` ADD `Vaptcha_Open` int(11) NULL COMMENT '系统人机验证开关' AFTER `Mail_Pwd`");
$DB->exec("ALTER TABLE `nteam_config` ADD `Vaptcha_Vid` varchar(88) NULL COMMENT '验证码单元Vid' AFTER `Vaptcha_Open`");