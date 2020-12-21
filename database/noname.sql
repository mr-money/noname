/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.5.53 : Database - noname
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`noname` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `noname`;

/*Table structure for table `admin_log` */

DROP TABLE IF EXISTS `admin_log`;

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '管理员id',
  `ip_adress` varchar(255) DEFAULT '' COMMENT '登录id地址',
  `created_at` varchar(64) DEFAULT '' COMMENT '创建时间',
  `updated_at` varchar(64) DEFAULT '' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `admin_log` */

insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (1,5,'192.168.18.233','1608000578','1608000578');
insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (2,5,'127.0.0.1','1608186390','1608186390');
insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (3,5,'127.0.0.1','1608194289','1608194289');
insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (4,5,'127.0.0.1','1608271802','1608271802');
insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (5,5,'127.0.0.1','1608275106','1608275106');
insert  into `admin_log`(`id`,`admin_id`,`ip_adress`,`created_at`,`updated_at`) values (6,5,'127.0.0.1','1608530044','1608530044');

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `account` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号（报名通知接收）',
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_users` */

insert  into `admin_users`(`id`,`avatar`,`nickname`,`account`,`phone`,`password`,`created_at`,`updated_at`) values (5,NULL,'超级管理员','admin','18651984625','$2y$10$5rNcg7g7eWJ1DhlaoZV7PuOTogwobp3QydxQB1wY0q4MA5LY2JZ.6','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `system_menu` */

DROP TABLE IF EXISTS `system_menu`;

CREATE TABLE `system_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `sort` int(11) DEFAULT '0' COMMENT '菜单排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注信息',
  `create_id` int(11) NOT NULL COMMENT '创建人id',
  `created_at` varchar(32) DEFAULT NULL COMMENT '创建时间',
  `updated_at` varchar(32) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `href` (`href`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统菜单表';

/*Data for the table `system_menu` */

insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (263,0,'常规管理','fa fa-address-book','','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (264,263,'主页模板','fa fa-home','','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (265,264,'主页一','fa fa-tachometer','page/welcome-1.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (266,264,'主页二','fa fa-tachometer','page/welcome-2.html','_self',0,1,NULL,5,'1605757317','1607764154');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (267,264,'主页三','fa fa-tachometer','page/welcome-3.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (268,263,'菜单管理','fa fa-window-maximize','admin/menuList','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (269,263,'系统设置','fa fa fa-gears','admin/setting','_self',0,1,'网站系统设置管理',5,'1605757317','1608272772');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (270,263,'表格示例','fa fa-file-text','page/table.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (271,263,'表单示例','fa fa-calendar','','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (272,271,'普通表单','fa fa-list-alt','page/form.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (273,271,'分步表单','fa fa-navicon','page/form-step.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (274,263,'登录模板','fa fa-flag-o','','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (275,274,'登录-1','fa fa-stumbleupon-circle','page/login-1.html','_blank',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (276,274,'登录-2','fa fa-viacoin','page/login-2.html','_blank',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (277,274,'登录-3','fa fa-tags','page/login-3.html','_blank',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (278,263,'异常页面','fa fa-home','','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (279,278,'404页面','fa fa-hourglass-end','page/404.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (280,263,'其它界面','fa fa-snowflake-o','','',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (281,280,'按钮示例','fa fa-snowflake-o','page/button.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (282,280,'弹出层','fa fa-shield','page/layer.html','_self',0,1,NULL,5,'1605757317','1607762921');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (283,0,'组件管理','fa fa-lemon-o','','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (284,283,'图标列表','fa fa-dot-circle-o','page/icon.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (285,283,'图标选择','fa fa-adn','page/icon-picker.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (286,283,'颜色选择','fa fa-dashboard','page/color-select.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (287,283,'下拉选择','fa fa-angle-double-down','page/table-select.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (288,283,'文件上传','fa fa-arrow-up','page/upload.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (289,283,'富文本编辑器','fa fa-edit','page/editor.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (290,283,'省市县区选择器','fa fa-rocket','page/area.html','_self',0,1,NULL,5,'1605757317','1605757317');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (291,0,'其它管理','fa fa-slideshare','','_self',0,1,NULL,5,'1605757317','1608191328');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (292,291,'多级菜单','fa fa-meetup','','',0,1,NULL,5,'1605757317','1608191328');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (293,292,'按钮1','fa fa-calendar','page/button.html?v=1','_self',0,1,NULL,5,'1605757317','1608191328');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (294,291,'失效菜单','fa fa-superpowers','page/error.html','_self',0,1,NULL,5,'1605757317','1608191328');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (296,0,'测试添加','fa fa-area-chart','','_self',0,1,'阿斯顿发斯蒂芬',5,'1608192228','1608192228');
insert  into `system_menu`(`id`,`pid`,`title`,`icon`,`href`,`target`,`sort`,`status`,`remark`,`create_id`,`created_at`,`updated_at`) values (297,296,'测试2226666','fa fa-bell-o','','_self',0,1,'咳咳444444444444',5,'1608192317','1608198457');

/*Table structure for table `system_setting` */

DROP TABLE IF EXISTS `system_setting`;

CREATE TABLE `system_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '网站域名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '首页标题',
  `keywords` text COMMENT 'META关键词',
  `descript` text COMMENT 'META描述',
  `copyright` varchar(100) NOT NULL DEFAULT '' COMMENT '版权信息',
  `create_id` int(11) NOT NULL,
  `created_at` varchar(32) NOT NULL,
  `updated_at` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `system_setting` */

insert  into `system_setting`(`id`,`sitename`,`domain`,`title`,`keywords`,`descript`,`copyright`,`create_id`,`created_at`,`updated_at`) values (1,'noname','http://noname.test','不知名APP管理后台','大宝,不知名,不知名APP,不知名APP管理后台','大宝的不知名APP 也不知道有啥用 快乐就完事了','© 2020 noname.test MIT license',5,'1608538197','1608538234');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
