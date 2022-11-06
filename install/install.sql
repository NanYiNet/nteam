SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+8:00";

DROP TABLE IF EXISTS `nteam_admin`;
CREATE TABLE `nteam_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adminUser` varchar(255) NOT NULL COMMENT '管理员账号',
  `adminPwd` char(32) NOT NULL COMMENT '管理员密码',
  `adminQq` bigint(20) DEFAULT '2322796106' COMMENT '管理员QQ',
  `adminLoginIp` varchar(15) DEFAULT NULL COMMENT '管理员IP',
  `adminRank` int(11) NOT NULL COMMENT '管理员等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `nteam_admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 2322796106, '127.0.0.1', 1);

DROP TABLE IF EXISTS `nteam_config`;
CREATE TABLE `nteam_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SiteName` varchar(255) NOT NULL COMMENT '网站名称',
  `Name` varchar(255) NOT NULL COMMENT '网站简称',
  `Descriptison` varchar(255) NOT NULL COMMENT '网站描述',
  `Keywords` varchar(255) NOT NULL COMMENT '网站关键词',
  `Url` varchar(255) NOT NULL COMMENT '网址',
  `Mail_Smtp` varchar(255) NOT NULL COMMENT 'SMTP地址',
  `Mail_Port` varchar(255) NOT NULL COMMENT 'SMTP端口',
  `Mail_Name` varchar(255) NOT NULL COMMENT '邮箱账号',
  `Mail_Pwd` varchar(255) NOT NULL COMMENT '邮箱密码（授权码）',
  `Vaptcha_Open` int(11) NOT NULL DEFAULT 0 COMMENT '系统人机验证开关',
  `Vaptcha_Vid` varchar(88) NOT NULL COMMENT '验证码单元Vid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nteam_config` VALUES (1, '南逸网络-工作室|南逸网络官网', 'NanYi Team-Nteam', '南逸网络-工作室-是一个个由几名热爱网络的中学生联合起来的一个小团队，我们一直在前进，一直在进步。不管如何，我们的初心不变。', '南逸网络,云互联-EP,加密,Blog', 'www.nanyinet.com', '', '', '', '', 0, '');

DROP TABLE IF EXISTS `nteam_config_theme`;
CREATE TABLE `nteam_config_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Index_About` varchar(255) NOT NULL COMMENT '首页的About模块',
  `Index_Services_t1` varchar(255) NOT NULL COMMENT '首页服务第一个板块的标题',
  `Index_Services_d1` varchar(255) NOT NULL COMMENT '首页服务第一个板块的内容',
  `Index_Services_t2` varchar(255) NOT NULL COMMENT '首页服务第二个板块的标题',
  `Index_Services_d2` varchar(255) NOT NULL COMMENT '首页服务第二个板块的内容',
  `Index_Services_t3` varchar(255) NOT NULL COMMENT '首页服务第三个板块的标题',
  `Index_Services_d3` varchar(255) NOT NULL COMMENT '首页服务第三个板块的内容',
  `Index_Services_t4` varchar(255) NOT NULL COMMENT '首页服务第四个板块的标题',
  `Index_Services_d4` varchar(255) NOT NULL COMMENT '首页服务第四个板块的内容',
  `Index_Qq` varchar(255) NOT NULL COMMENT '显示的QQ',
  `Index_Email` varchar(255) NOT NULL COMMENT '显示的邮箱',
  `Index_Phone` varchar(255) NOT NULL COMMENT '显示的电话',
  `Index_Place` varchar(255) NOT NULL COMMENT '显示的地点',
  `Index_Fang` int(11) NOT NULL DEFAULT 1 COMMENT '首页防xxs的Js开关',
  `Index_Style` varchar(800) NOT NULL COMMENT '首页自定义样式',
  `Index_Links` text NOT NULL COMMENT '首页友情链接',
  `Index_Slide1` VARCHAR(255) NOT NULL COMMENT '幻灯片1内容',
  `Index_Slide2` VARCHAR(255) NOT NULL COMMENT '幻灯片2内容',
  `Index_Slide3` VARCHAR(255) NOT NULL COMMENT '幻灯片3内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nteam_config_theme` VALUES (1, '南逸网络-工作室-是一个由几名热爱网络的中学生联合起来的一个小团队，我们一直在前进，一直在进步，不管如何，我们的初心不变。', '自行修改', '自行修改.', '自行修改', '自行修改.', '自行修改', '自行修改.', '自行修改', '自行修改.', '2322796106', '2322796106@qq.com', '', '银河系,地球', 0, '', '<li><i class=\"bx bx-chevron-right\"></i><a href=\"//www.nanyinet.cn/\">南逸网络</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li> <li><i class=\"bx bx-chevron-right\"></i><a href=\"#\">待添加</a></li>', '代码改变世界', '你想知道谁才是我们的成员吗？赶紧来查一下吧~', '点击下方按钮<br>即可立即申请加入！！！');

DROP TABLE IF EXISTS `nteam_leave_messages`;
CREATE TABLE `nteam_leave_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '留言人',
  `email` varchar(255) NOT NULL COMMENT '留言邮箱',
  `subject` varchar(255) NOT NULL COMMENT '留言主题',
  `message` varchar(255) NOT NULL COMMENT '留言内容',
  `intime` varchar(255) NOT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `nteam_log`;
CREATE TABLE `nteam_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminUser` varchar(255) NOT NULL COMMENT '操作者',
  `type` varchar(255) NOT NULL COMMENT '操作内容',
  `data` varchar(255) NOT NULL COMMENT '操作时间',
  `ip` varchar(255) NOT NULL COMMENT '操作ip',
  `city` varchar(255) NOT NULL COMMENT '操作地点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `nteam_project_list`;
CREATE TABLE `nteam_project_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '项目名',
  `url` varchar(255) NOT NULL COMMENT '项目网址',
  `img` varchar(255) NOT NULL COMMENT '项目图片地址',
  `sketch` varchar(255) NOT NULL COMMENT '项目简述（显示于首页）',
  `descriptison` varchar(255) NOT NULL COMMENT '项目描述',
  `type` varchar(255) NOT NULL COMMENT '项目类型',
  `is_show` int(11) NOT NULL DEFAULT 0 COMMENT '是否显示首页',
  `Audit_status` int(11) NOT NULL DEFAULT 0 COMMENT '审核状态',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '项目运行状态',
  `intime` varchar(255) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `nteam_project_list` (`id`, `name`, `url`, `img`, `sketch`, `descriptison`, `type`, `is_show`, `Audit_status`, `status`, `intime`) VALUES
(1, '南逸博客', 'www.nanyinet.com', 'https://www.nanyinet.com/wp-content/uploads/2022/09/home-1024x436.png', '南逸博客-专注于资源分享，编程教程、PHP源码、技术学习、游戏攻略、建站教程、机器人教程、实用软件、软件源码，年轻人的潮流文化社区', '南逸博客-专注于资源分享，编程教程、PHP源码、技术学习、游戏攻略、建站教程、机器人教程、实用软件、软件源码，年轻人的潮流文化社区', 'web', 1, 1, 1, '2020年6月16日');

DROP TABLE IF EXISTS `nteam_team_member`;
CREATE TABLE IF NOT EXISTS `nteam_team_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '成员名称',
  `qq` varchar(255) NOT NULL COMMENT '成员QQ',
  `describe` varchar(255) NOT NULL COMMENT '成员简述',
  `is_show` int(11) NOT NULL DEFAULT 0 COMMENT '是否显示首页',
  `Audit_status` int(11) NOT NULL DEFAULT 0 COMMENT '审核状态',
  `intime` varchar(255) NOT NULL COMMENT '加入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `nteam_team_member` (`id`, `name`, `qq`, `describe`, `is_show`, `Audit_status`, `intime`) VALUES
(1, 'Mr.南逸', '2322796106', '团队创始人<br>Mr.南逸', 1, 1, '2020-06-16');