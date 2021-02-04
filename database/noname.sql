-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: 148.70.226.80    Database: noname
-- ------------------------------------------------------
-- Server version	5.7.32-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '管理员id',
  `ip_adress` varchar(255) DEFAULT '' COMMENT '登录id地址',
  `created_at` varchar(64) DEFAULT '' COMMENT '创建时间',
  `updated_at` varchar(64) DEFAULT '' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
INSERT INTO `admin_log` VALUES (1,5,'192.168.18.233','1608000578','1608000578'),(2,5,'127.0.0.1','1608186390','1608186390'),(3,5,'127.0.0.1','1608194289','1608194289'),(4,5,'127.0.0.1','1608271802','1608271802'),(5,5,'127.0.0.1','1608275106','1608275106'),(6,5,'127.0.0.1','1608530044','1608530044'),(7,5,'127.0.0.1','1608694023','1608694023'),(8,5,'127.0.0.1','1608713319','1608713319'),(9,5,'127.0.0.1','1609147043','1609147043'),(10,5,'127.0.0.1','1609149117','1609149117'),(11,5,'127.0.0.1','1609227510','1609227510'),(12,5,'127.0.0.1','1609293732','1609293732'),(13,5,'127.0.0.1','1609318368','1609318368'),(14,5,'127.0.0.1','1609400705','1609400705'),(15,5,'127.0.0.1','1609831424','1609831424'),(16,5,'127.0.0.1','1610961355','1610961355'),(17,5,'223.166.74.56','1611209912','1611209912'),(18,5,'223.166.75.32','1611643084','1611643084'),(19,5,'223.166.75.32','1611739921','1611739921'),(20,5,'112.38.96.86','1612422628','1612422628'),(21,5,'222.64.183.38','1612423005','1612423005');
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `account` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号（报名通知接收）',
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (5,'超级管理员','admin','18651984625','$2y$10$5rNcg7g7eWJ1DhlaoZV7PuOTogwobp3QydxQB1wY0q4MA5LY2JZ.6','1609149126','1609229222');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_physique`
--

DROP TABLE IF EXISTS `face_physique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `face_physique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(255) NOT NULL DEFAULT '' COMMENT '部位名称',
  `part_value` varchar(255) NOT NULL DEFAULT '' COMMENT '部位数据',
  `user_id` int(11) NOT NULL COMMENT '用户表id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `face_physique_face_user_id_fk` (`user_id`),
  KEY `face_physique_part_name_index` (`part_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='身体部位数据表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_physique`
--

LOCK TABLES `face_physique` WRITE;
/*!40000 ALTER TABLE `face_physique` DISABLE KEYS */;
/*!40000 ALTER TABLE `face_physique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_physique_setting`
--

DROP TABLE IF EXISTS `face_physique_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `face_physique_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(255) NOT NULL DEFAULT '' COMMENT '部位名称',
  `default_value` varchar(255) NOT NULL DEFAULT '' COMMENT '默认值',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `face_physique_setting_part_name_uindex` (`part_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='身体部位配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_physique_setting`
--

LOCK TABLES `face_physique_setting` WRITE;
/*!40000 ALTER TABLE `face_physique_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `face_physique_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_user`
--

DROP TABLE IF EXISTS `face_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `face_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nickname` varchar(32) NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '头像',
  `username` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '手机',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1男 0女',
  `subscribe_time` int(11) DEFAULT NULL COMMENT '关注时间',
  `city` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `province` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `country` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_subscribe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注 1关注 0未关注',
  `personal_signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个人签名',
  `user_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 1正常 2禁用',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户表（微信用户关联）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_user`
--

LOCK TABLES `face_user` WRITE;
/*!40000 ALTER TABLE `face_user` DISABLE KEYS */;
INSERT INTO `face_user` VALUES (2,'oLfzT6HKHJagFJm5GrS7w2WxEXFQ','低调的小香菇?','http://thirdwx.qlogo.cn/mmopen/fU6cXgFxgovYcP0sHjfc9ZoxXXfhCxkx8leZiccelWQSibuSCPMicJKmRg7T0EchQYttL7fxUa3ibebwfLNs2WquyHWcMM41fVDR/132','钱京','18651984625',1,1611646689,'','','冰岛',1,'',2,1611646689,1612424579),(3,'oLfzT6KHuSZojGYUyXKHvJcHtFYY','Sharon','http://thirdwx.qlogo.cn/mmopen/fU6cXgFxgovYcP0sHjfc9XczXNFYKhkxiapwrS6RA9SZbrsVZyV0ahqgobYqpnSyQLZDwTO3TJVmCPiciakVuWSXpy4sGzmwQYG/132','大宝','',2,1611726924,'','','中国',1,'',1,1611726924,1612424485),(4,'oLfzT6Hhlh8u88bq3rQ9PsJz5iMs','浅夏','http://thirdwx.qlogo.cn/mmopen/yUlN9bcicPLozw3RmaJ2Pb0GHk8XafE9gFz8uxxbYR0wmzPnj9oV5IUNAa5bHibCBT8cIlich9N3ic9UNejH3CvptAOVBhW4udyib/132','','',2,1612081392,'石家庄','河北','中国',1,'',1,1612081394,1612081394);
/*!40000 ALTER TABLE `face_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_menu`
--

DROP TABLE IF EXISTS `system_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统菜单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_menu`
--

LOCK TABLES `system_menu` WRITE;
/*!40000 ALTER TABLE `system_menu` DISABLE KEYS */;
INSERT INTO `system_menu` VALUES (263,0,'常规管理','fa fa-address-book','','_self',0,1,NULL,5,'1605757317','1607762921'),(264,263,'主页模板','fa fa-home','','_self',0,1,NULL,5,'1605757317','1607762921'),(265,264,'主页一','fa fa-tachometer','page/welcome-1.html','_self',0,1,NULL,5,'1605757317','1607762921'),(266,264,'主页二','fa fa-tachometer','page/welcome-2.html','_self',0,1,NULL,5,'1605757317','1607764154'),(267,264,'主页三','fa fa-tachometer','page/welcome-3.html','_self',0,1,NULL,5,'1605757317','1607762921'),(268,263,'菜单管理','fa fa fa fa-window-maximize','admin/menuList','_self',0,1,NULL,5,'1605757317','1609230330'),(269,263,'系统设置','fa fa fa fa-gears','','_self',0,1,'网站系统设置管理',5,'1605757317','1609230350'),(283,0,'组件管理','fa fa-lemon-o','','_self',0,1,NULL,5,'1605757317','1605757317'),(285,283,'图标选择','fa fa-adn','page/icon-picker.html','_self',0,1,NULL,5,'1605757317','1605757317'),(286,283,'颜色选择','fa fa-dashboard','page/color-select.html','_self',0,1,NULL,5,'1605757317','1605757317'),(288,283,'文件上传','fa fa-arrow-up','page/upload.html','_self',0,1,NULL,5,'1605757317','1605757317'),(289,283,'富文本编辑器','fa fa-edit','page/editor.html','_self',0,1,NULL,5,'1605757317','1605757317'),(290,283,'省市县区选择器','fa fa-rocket','page/area.html','_self',0,1,NULL,5,'1605757317','1605757317'),(296,0,'测试添加','fa fa-area-chart','','_self',0,1,'阿斯顿发斯蒂芬',5,'1608192228','1608192228'),(298,269,'基本设置','fa fa-cog','admin/setting','_self',0,1,'系统基本信息设置',5,'1609230393','1609230455'),(299,269,'登录日志','fa fa-file-text-o','admin/adminLog','_self',0,1,'管理员登录日志列表',5,'1609230889','1609230889'),(300,263,'用户管理','fa fa fa-user','','_self',0,1,'用户管理下拉菜单',5,'1611727124','1611727145'),(301,300,'用户列表','fa fa-align-left','admin/user/userList','_self',0,1,'用户列表页面',5,'1611823927','1611823927');
/*!40000 ALTER TABLE `system_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_setting`
--

DROP TABLE IF EXISTS `system_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_setting`
--

LOCK TABLES `system_setting` WRITE;
/*!40000 ALTER TABLE `system_setting` DISABLE KEYS */;
INSERT INTO `system_setting` VALUES (1,'noname','http://noname.test','不知名APP管理后台','大宝,不知名,不知名APP,不知名APP管理后台','大宝的不知名APP 也不知道有啥用 快乐就完事了','© 2020 noname.test MIT license',5,'1608538197','1608538234');
/*!40000 ALTER TABLE `system_setting` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-04 17:53:50
