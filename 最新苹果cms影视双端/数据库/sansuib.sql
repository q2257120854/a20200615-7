-- MySQL dump 10.13  Distrib 5.6.47, for Linux (x86_64)
--
-- Host: localhost    Database: v_aapea_cn
-- ------------------------------------------------------
-- Server version	5.6.47-log

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
-- Table structure for table `mac_actor`
--

DROP TABLE IF EXISTS `mac_actor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_actor` (
  `actor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `actor_name` varchar(255) NOT NULL DEFAULT '',
  `actor_en` varchar(255) NOT NULL DEFAULT '',
  `actor_alias` varchar(255) NOT NULL DEFAULT '',
  `actor_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_letter` char(1) NOT NULL DEFAULT '',
  `actor_sex` char(1) NOT NULL DEFAULT '',
  `actor_color` varchar(6) NOT NULL DEFAULT '',
  `actor_pic` varchar(255) NOT NULL DEFAULT '',
  `actor_blurb` varchar(255) NOT NULL DEFAULT '',
  `actor_remarks` varchar(100) NOT NULL DEFAULT '',
  `actor_area` varchar(20) NOT NULL DEFAULT '',
  `actor_height` varchar(10) NOT NULL DEFAULT '',
  `actor_weight` varchar(10) NOT NULL DEFAULT '',
  `actor_birthday` varchar(10) NOT NULL DEFAULT '',
  `actor_birtharea` varchar(20) NOT NULL DEFAULT '',
  `actor_blood` varchar(10) NOT NULL DEFAULT '',
  `actor_starsign` varchar(10) NOT NULL DEFAULT '',
  `actor_school` varchar(20) NOT NULL DEFAULT '',
  `actor_works` varchar(255) NOT NULL DEFAULT '',
  `actor_tag` varchar(255) NOT NULL DEFAULT '',
  `actor_class` varchar(255) NOT NULL DEFAULT '',
  `actor_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actor_time` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `actor_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `actor_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `actor_tpl` varchar(30) NOT NULL DEFAULT '',
  `actor_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `actor_content` text NOT NULL,
  PRIMARY KEY (`actor_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `type_id_1` (`type_id_1`) USING BTREE,
  KEY `actor_name` (`actor_name`) USING BTREE,
  KEY `actor_en` (`actor_en`) USING BTREE,
  KEY `actor_letter` (`actor_letter`) USING BTREE,
  KEY `actor_level` (`actor_level`) USING BTREE,
  KEY `actor_time` (`actor_time`) USING BTREE,
  KEY `actor_time_add` (`actor_time_add`) USING BTREE,
  KEY `actor_sex` (`actor_sex`),
  KEY `actor_area` (`actor_area`),
  KEY `actor_up` (`actor_up`),
  KEY `actor_down` (`actor_down`),
  KEY `actor_tag` (`actor_tag`),
  KEY `actor_class` (`actor_class`),
  KEY `actor_score` (`actor_score`),
  KEY `actor_score_all` (`actor_score_all`),
  KEY `actor_score_num` (`actor_score_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_actor`
--

LOCK TABLES `mac_actor` WRITE;
/*!40000 ALTER TABLE `mac_actor` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_actor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_admin`
--

DROP TABLE IF EXISTS `mac_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_admin` (
  `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(30) NOT NULL DEFAULT '',
  `admin_pwd` char(32) NOT NULL DEFAULT '',
  `admin_random` char(32) NOT NULL DEFAULT '',
  `admin_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_auth` text NOT NULL,
  `admin_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_login_num` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_admin`
--

LOCK TABLES `mac_admin` WRITE;
/*!40000 ALTER TABLE `mac_admin` DISABLE KEYS */;
INSERT INTO `mac_admin` VALUES (1,'admin','96e79218965eb72c92a549dd5a330112','7d24542b12e78588e7320ae6239dbc79',1,'',1586103106,1867904717,28,1585890175,0);
/*!40000 ALTER TABLE `mac_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_advertisement`
--

DROP TABLE IF EXISTS `mac_advertisement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_advertisement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `time` int(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `vod_id` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `patternn` int(1) DEFAULT '0',
  `type_id` int(20) NOT NULL,
  `vod_name` varchar(255) NOT NULL,
  `vod_area` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_advertisement`
--

LOCK TABLES `mac_advertisement` WRITE;
/*!40000 ALTER TABLE `mac_advertisement` DISABLE KEYS */;
INSERT INTO `mac_advertisement` VALUES (1,1,'《囧妈》2020贺岁喜剧片','电影推荐','http://qy.redlk.com/upload/site/20200229-1/ba26eae3765fad6e38ee73f7080eb592.jpg',1582986314,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'',''),(2,1,'《叶问4 终极一战》','电影推荐','http://qy.redlk.com/upload/site/20200229-1/fa97b1d60f1cdf70c54a0486e8d494dd.jpg',1582986331,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',555,1,0,3,'叶问4','美国'),(13,2,'美妆季','1','http://qy.redlk.com/upload/site/20200326-1/a6e141f9e75d1dbefa76c4134a06abe7.png',1585199166,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'',''),(14,2,'巨享福利','1','http://qy.redlk.com/upload/site/20200326-1/4368571c238206416714cd0946800241.png',1585199271,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'',''),(9,3,'想见你','电视剧 想见你','http://qy.redlk.com/upload/site/20200229-1/b7c22a3bc0fd7d458c8f40a391b22d4d.jpg',1582987490,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1111,1,0,0,'',''),(10,4,'寄生虫','电影 寄生虫','http://qy.redlk.com/upload/site/20200229-1/05196fb087ef85e814a3258f80d3dc07.jpg',1582987533,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'',''),(11,6,'瑞克和莫蒂 第二季','动漫瑞克和莫蒂 第二季','http://qy.redlk.com/upload/site/20200229-1/29fbd1b97ea7a0605cbac291b317ad4e.jpg',1582987581,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'',''),(12,5,'歌手 当打之年','歌手 当打之年','http://qy.redlk.com/upload/site/20200229-1/72458e90633692edcb0af4c02fe32d2d.jpg',1582987689,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',0,1,0,0,'','');
/*!40000 ALTER TABLE `mac_advertisement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_analysisurl`
--

DROP TABLE IF EXISTS `mac_analysisurl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_analysisurl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m3u8_url` varchar(255) NOT NULL,
  `tx_url` varchar(255) NOT NULL,
  `aqy_url` varchar(255) NOT NULL,
  `yk_url` varchar(255) NOT NULL,
  `mg_url` varchar(255) NOT NULL,
  `sh_url` varchar(255) NOT NULL,
  `ls_url` varchar(255) NOT NULL,
  `pptv_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_analysisurl`
--

LOCK TABLES `mac_analysisurl` WRITE;
/*!40000 ALTER TABLE `mac_analysisurl` DISABLE KEYS */;
INSERT INTO `mac_analysisurl` VALUES (1,'http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=','http://api.aapea.cn/?v=');
/*!40000 ALTER TABLE `mac_analysisurl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_art`
--

DROP TABLE IF EXISTS `mac_art`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_art` (
  `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_name` varchar(255) NOT NULL DEFAULT '',
  `art_sub` varchar(255) NOT NULL DEFAULT '',
  `art_en` varchar(255) NOT NULL DEFAULT '',
  `art_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_letter` char(1) NOT NULL DEFAULT '',
  `art_color` varchar(6) NOT NULL DEFAULT '',
  `art_from` varchar(30) NOT NULL DEFAULT '',
  `art_author` varchar(30) NOT NULL DEFAULT '',
  `art_tag` varchar(100) NOT NULL DEFAULT '',
  `art_class` varchar(255) NOT NULL DEFAULT '',
  `art_pic` varchar(255) NOT NULL DEFAULT '',
  `art_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `art_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `art_blurb` varchar(255) NOT NULL DEFAULT '',
  `art_remarks` varchar(100) NOT NULL DEFAULT '',
  `art_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `art_tpl` varchar(30) NOT NULL DEFAULT '',
  `art_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_points_detail` smallint(6) unsigned NOT NULL DEFAULT '0',
  `art_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_time` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `art_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `art_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `art_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `art_rel_art` varchar(255) NOT NULL DEFAULT '',
  `art_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `art_pwd` varchar(10) NOT NULL DEFAULT '',
  `art_pwd_url` varchar(255) NOT NULL DEFAULT '',
  `art_title` mediumtext NOT NULL,
  `art_note` mediumtext NOT NULL,
  `art_content` mediumtext NOT NULL,
  PRIMARY KEY (`art_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `type_id_1` (`type_id_1`) USING BTREE,
  KEY `art_level` (`art_level`) USING BTREE,
  KEY `art_hits` (`art_hits`) USING BTREE,
  KEY `art_time` (`art_time`) USING BTREE,
  KEY `art_letter` (`art_letter`) USING BTREE,
  KEY `art_down` (`art_down`) USING BTREE,
  KEY `art_up` (`art_up`) USING BTREE,
  KEY `art_tag` (`art_tag`) USING BTREE,
  KEY `art_name` (`art_name`) USING BTREE,
  KEY `art_enn` (`art_en`) USING BTREE,
  KEY `art_hits_day` (`art_hits_day`) USING BTREE,
  KEY `art_hits_week` (`art_hits_week`) USING BTREE,
  KEY `art_hits_month` (`art_hits_month`) USING BTREE,
  KEY `art_time_add` (`art_time_add`) USING BTREE,
  KEY `art_time_make` (`art_time_make`) USING BTREE,
  KEY `art_lock` (`art_lock`),
  KEY `art_score` (`art_score`),
  KEY `art_score_all` (`art_score_all`),
  KEY `art_score_num` (`art_score_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_art`
--

LOCK TABLES `mac_art` WRITE;
/*!40000 ALTER TABLE `mac_art` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_art` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_card`
--

DROP TABLE IF EXISTS `mac_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_no` varchar(16) NOT NULL DEFAULT '',
  `card_pwd` varchar(8) NOT NULL DEFAULT '',
  `card_money` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `card_use_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `card_sale_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `card_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `card_use_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`card_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `card_add_time` (`card_add_time`) USING BTREE,
  KEY `card_use_time` (`card_use_time`) USING BTREE,
  KEY `card_no` (`card_no`),
  KEY `card_pwd` (`card_pwd`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_card`
--

LOCK TABLES `mac_card` WRITE;
/*!40000 ALTER TABLE `mac_card` DISABLE KEYS */;
INSERT INTO `mac_card` VALUES (1,'SZ0S2O622R8WBQJ3','SD6PIWCG',10,10,1,1,8,1585120355,1585120374),(2,'NEGQXOK4A8HJXCWY','ALJS4DGD',10,10,0,0,0,1585128213,0),(3,'AAIK3C52MQ3X75WY','KRWU2GAM',10,10,1,1,11,1585128213,1585130331),(4,'S7RQXD3OD4JMHTMF','50352F6H',10,10,0,0,0,1585128213,0),(5,'M4IWKEO5496AO8U9','0VCOKOSU',10,10,0,0,0,1585128213,0);
/*!40000 ALTER TABLE `mac_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_cash`
--

DROP TABLE IF EXISTS `mac_cash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_cash` (
  `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cash_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `cash_money` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `cash_bank_name` varchar(60) NOT NULL DEFAULT '',
  `cash_bank_no` varchar(30) NOT NULL DEFAULT '',
  `cash_payee_name` varchar(30) NOT NULL DEFAULT '',
  `cash_time` int(10) unsigned NOT NULL DEFAULT '0',
  `cash_time_audit` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cash_id`),
  KEY `user_id` (`user_id`),
  KEY `cash_status` (`cash_status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_cash`
--

LOCK TABLES `mac_cash` WRITE;
/*!40000 ALTER TABLE `mac_cash` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_cash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_cj_content`
--

DROP TABLE IF EXISTS `mac_cj_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_cj_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nodeid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `url` char(255) NOT NULL,
  `title` char(100) NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodeid` (`nodeid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_cj_content`
--

LOCK TABLES `mac_cj_content` WRITE;
/*!40000 ALTER TABLE `mac_cj_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_cj_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_cj_history`
--

DROP TABLE IF EXISTS `mac_cj_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_cj_history` (
  `md5` char(32) NOT NULL,
  PRIMARY KEY (`md5`),
  KEY `md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_cj_history`
--

LOCK TABLES `mac_cj_history` WRITE;
/*!40000 ALTER TABLE `mac_cj_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_cj_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_cj_node`
--

DROP TABLE IF EXISTS `mac_cj_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_cj_node` (
  `nodeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `sourcecharset` varchar(8) NOT NULL,
  `sourcetype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `urlpage` text NOT NULL,
  `pagesize_start` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pagesize_end` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `page_base` char(255) NOT NULL,
  `par_num` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `url_contain` char(100) NOT NULL,
  `url_except` char(100) NOT NULL,
  `url_start` char(100) NOT NULL DEFAULT '',
  `url_end` char(100) NOT NULL DEFAULT '',
  `title_rule` char(100) NOT NULL,
  `title_html_rule` text NOT NULL,
  `type_rule` char(100) NOT NULL,
  `type_html_rule` text NOT NULL,
  `content_rule` char(100) NOT NULL,
  `content_html_rule` text NOT NULL,
  `content_page_start` char(100) NOT NULL,
  `content_page_end` char(100) NOT NULL,
  `content_page_rule` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_page` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_nextpage` char(100) NOT NULL,
  `down_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `watermark` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `coll_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `customize_config` text NOT NULL,
  `program_config` text NOT NULL,
  `mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`nodeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_cj_node`
--

LOCK TABLES `mac_cj_node` WRITE;
/*!40000 ALTER TABLE `mac_cj_node` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_cj_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_collect`
--

DROP TABLE IF EXISTS `mac_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collect_name` varchar(30) NOT NULL DEFAULT '',
  `collect_url` varchar(255) NOT NULL DEFAULT '',
  `collect_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `collect_appid` varchar(30) NOT NULL DEFAULT '',
  `collect_appkey` varchar(30) NOT NULL DEFAULT '',
  `collect_param` varchar(100) NOT NULL DEFAULT '',
  `collect_filter` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `collect_filter_from` varchar(255) NOT NULL DEFAULT '',
  `collect_opt` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`collect_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_collect`
--

LOCK TABLES `mac_collect` WRITE;
/*!40000 ALTER TABLE `mac_collect` DISABLE KEYS */;
INSERT INTO `mac_collect` VALUES (1,'卧龙','https://cj.sxylcy.cc/inc/api_mac_m3u8.php',1,1,'','','',0,'',0),(2,'八戒资源网 ','http://api.bbkdj.com/api',1,1,'','','',0,'',0),(3,'步步高优酷','http://api.bbkdj.com/json/youku',2,1,'','','',0,'',0),(4,'步步高腾讯','http://api.bbkdj.com/json/qq',2,1,'','','',0,'',0),(5,'步步高pptv','http://api.bbkdj.com/json/pptv',2,1,'','','',0,'',0),(6,'步步高芒果','http://api.bbkdj.com/json/mgtv',2,1,'','','',0,'',0),(9,'美剧','https://189.es/api.php/provide/vod/?ac=list',2,1,'','','',0,'',0),(8,'步步高爱奇艺','http://api.bbkdj.com/json/qiyi',2,1,'','','',0,'',0),(10,'酷云kkm3u8 ','http://caiji.kuyun98.com/inc/ldg_kkm3u8.php',1,1,'','','',0,'',0);
/*!40000 ALTER TABLE `mac_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_comment`
--

DROP TABLE IF EXISTS `mac_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_mid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment_name` varchar(60) NOT NULL DEFAULT '',
  `comment_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_time` int(10) unsigned NOT NULL DEFAULT '0',
  `comment_content` varchar(255) NOT NULL DEFAULT '',
  `comment_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_reply` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_report` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `comment_mid` (`comment_mid`) USING BTREE,
  KEY `comment_rid` (`comment_rid`) USING BTREE,
  KEY `comment_time` (`comment_time`) USING BTREE,
  KEY `comment_pid` (`comment_pid`),
  KEY `user_id` (`user_id`),
  KEY `comment_reply` (`comment_reply`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_comment`
--

LOCK TABLES `mac_comment` WRITE;
/*!40000 ALTER TABLE `mac_comment` DISABLE KEYS */;
INSERT INTO `mac_comment` VALUES (1,1,1821,0,0,1,'游客',1961412860,1584881601,'666666很不错',5,0,0,0),(2,1,1821,0,8,1,'17693102669',1961412860,1584881638,'很好看哦',16,7,0,1),(3,1,1821,2,8,1,'17693102669',1961412860,1584881649,'帆帆帆帆',0,0,0,1),(4,1,107159,0,8,1,'17693102669',1961412860,1584883367,'55555顶顶顶顶',12,8,0,1),(5,1,107159,4,8,1,'17693102669',1961412860,1584883491,'东孝数',2,1,0,0),(6,1,107159,4,8,1,'17693102669',1961412860,1584884840,'ffff顶顶顶顶顶',5,1,0,0),(7,1,48753,0,8,1,'17693102669',0,1585038321,'很不错的',2,8,0,0),(8,1,653,0,11,1,'17693103995',0,1585040052,'干活哈哈',0,0,0,0),(9,1,653,0,11,1,'17693103995',0,1585040067,'干活哈哈',1,1,0,0),(10,1,653,0,11,1,'17693103995',0,1585040094,'干活哈哈',0,0,0,0),(11,1,653,0,11,1,'17693103995',0,1585040139,'干活哈哈',0,0,0,0),(12,1,653,0,11,1,'17693103995',0,1585040139,'干活哈哈',1,0,0,0),(13,1,653,0,11,1,'17693103995',0,1585040139,'干活哈哈',0,0,0,0),(14,1,653,0,11,1,'17693103995',0,1585040787,'不好不好不好',1,1,0,0),(15,1,653,0,11,1,'17693103995',0,1585040797,'不好不好不好',1,0,0,0),(16,1,653,0,11,1,'17693103995',0,1585040799,'不好不好不好',1,0,0,0),(17,1,653,0,8,1,'17693102669',0,1585041057,'很优秀的',0,1,0,0),(18,1,653,0,8,1,'17693102669',0,1585041098,'很优秀的',0,0,0,0),(19,1,318,0,11,1,'17693103995',0,1585041194,'期待下部作品',0,3,0,0),(20,1,107774,0,8,1,'17693102669',0,1585235952,'哈哈哈哈',1,0,0,0),(21,1,108041,0,8,1,'17693102669',1867902209,1585275774,'漂亮很快就看',1,0,0,0),(22,1,107908,0,17,1,'13123606482',1867902209,1585283003,'搜索余罪',0,0,0,0),(23,1,106118,0,8,1,'17693102669',0,1585284488,'好棒棒哦',0,0,0,0),(24,1,555,0,25,1,'17612212593',1963628626,1585313776,'播放有点慢啊',2,0,0,0),(25,1,1821,0,25,1,'17612212593',1963628768,1585438616,'不能全屏',0,0,0,0),(26,1,108024,0,31,1,'15511712231',0,1585498133,'666可以的',1,0,0,0),(27,1,48753,0,8,1,'17693102669',1894860851,1585567683,' 不能投屏是个遗憾',0,0,0,0),(28,1,318,0,6,1,'17693103997',0,1585703907,'优秀的很啊',1,0,0,0),(29,1,48753,0,35,1,'13664211510',663754024,1585726496,'我也感觉是这样',0,0,0,0),(30,1,762,0,32,1,'17630032296',606080734,1585752377,'真好。。。。',0,0,0,0),(31,1,107999,0,26,1,'16608580856',827486646,1585897475,'不能全屏',0,0,0,0),(32,1,107838,0,37,1,'18815839980',2101948199,1585898672,'666看看',0,0,0,0),(33,1,107838,0,37,1,'18815839980',2101948199,1585898672,'666看看',0,0,0,0),(34,1,107838,0,37,1,'18815839980',2101948199,1585898672,'666看看',0,0,0,0),(35,1,107945,0,17,1,'13123606482',1867904587,1585898951,'搜索余罪',0,0,0,0),(36,1,108046,0,17,1,'13123606482',1867904587,1586028592,'测试测试测试',1,0,0,0);
/*!40000 ALTER TABLE `mac_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_comprehensive`
--

DROP TABLE IF EXISTS `mac_comprehensive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_comprehensive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `time` int(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_comprehensive`
--

LOCK TABLES `mac_comprehensive` WRITE;
/*!40000 ALTER TABLE `mac_comprehensive` DISABLE KEYS */;
INSERT INTO `mac_comprehensive` VALUES (1,2,'精选','http://qy.redlk.com/upload/site/20200326-1/09ffc7df7562766340e3f6f2d054415d.png',1585193390,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(2,2,'女装','http://qy.redlk.com/upload/site/20200326-1/c7376f62fbf63b0339540d320e562116.png',1585193680,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(3,2,'美食','http://qy.redlk.com/upload/site/20200326-1/e4ace181e1266094406879c9d9b49f16.png',1585193695,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(4,2,'美妆','http://qy.redlk.com/upload/site/20200326-1/a2a50597b86f0eecb83c062ffcf895f5.png',1585193732,'http://t.yinyoushiren.cn/index.php?r=index/cat&cid=1',1),(5,2,'居家日用','http://qy.redlk.com/upload/site/20200326-1/c3d3bb26357441ecdc25000ea6571afb.png',1585193744,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(6,2,'男装','http://qy.redlk.com/upload/site/20200326-1/cfea78337be9b26b10f1678a5b91ae97.png',1585193753,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(7,2,'鞋品','http://qy.redlk.com/upload/site/20200326-1/83a772717001c1693d15d552b949ac3b.png',1585193763,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1),(8,2,'9.9包邮','http://qy.redlk.com/upload/site/20200326-1/65f5a0748025d051b4e24d4617678b8a.png',1585193776,'https://jq.qq.com/?_wv=1027&k=5oKxxpB',1);
/*!40000 ALTER TABLE `mac_comprehensive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_config`
--

DROP TABLE IF EXISTS `mac_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appname` varchar(30) NOT NULL COMMENT '软件名称',
  `down_url` varchar(30) NOT NULL COMMENT '下载地址',
  `pattern` int(1) NOT NULL DEFAULT '0',
  `reg_limit` int(6) NOT NULL DEFAULT '10',
  `reg_givevip` int(10) NOT NULL DEFAULT '24' COMMENT '注册送会员/天',
  `safety_code` varchar(100) NOT NULL,
  `tixian_limit` int(10) NOT NULL DEFAULT '10',
  `tianxing_apikey` varchar(255) NOT NULL,
  `guanfang_qq` int(30) NOT NULL,
  `app_Invitation_slogans` varchar(255) NOT NULL COMMENT '宣传标语',
  `suo_key` varchar(255) NOT NULL COMMENT '短域名suo.im的key',
  `poster_img1` varchar(255) NOT NULL COMMENT '分享海报1',
  `poster_img2` varchar(255) NOT NULL COMMENT '分享海报2',
  `poster_img3` varchar(255) NOT NULL COMMENT '分享海报3',
  `poster_img` text NOT NULL,
  `launchImage_url` varchar(255) NOT NULL COMMENT '启动图地址',
  `launchImage_href` varchar(255) NOT NULL COMMENT '启动图跳转地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_config`
--

LOCK TABLES `mac_config` WRITE;
/*!40000 ALTER TABLE `mac_config` DISABLE KEYS */;
INSERT INTO `mac_config` VALUES (1,'阿离影视','http://qq.aapea.cn/',0,102,242,'603313839',102,'3333',1558310060,'全网影视免费看','5e843a12b1b63c47b6d82f05@0aacca297ea179c91b0e07a4f6d80879','http://i1.fuimg.com/710595/39a699254e7dcc18.png','http://i1.fuimg.com/710595/fc1af4df05a0a491.jpg','http://i1.fuimg.com/710595/4f98a1efe311dd54.jpg','[\"http://i1.fuimg.com/710595/39a699254e7dcc18.png\",\"http://i1.fuimg.com/710595/fc1af4df05a0a491.jpg\",\"http://i1.fuimg.com/710595/4f98a1efe311dd54.jpg\"]','http://i1.fuimg.com/710595/1c3e59dd6aca4ba9.png','');
/*!40000 ALTER TABLE `mac_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_gbook`
--

DROP TABLE IF EXISTS `mac_gbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_gbook` (
  `gbook_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gbook_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gbook_name` varchar(60) NOT NULL DEFAULT '',
  `gbook_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_reply_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gbook_content` varchar(255) NOT NULL DEFAULT '',
  `gbook_reply` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gbook_id`),
  KEY `gbook_rid` (`gbook_rid`) USING BTREE,
  KEY `gbook_time` (`gbook_time`) USING BTREE,
  KEY `gbook_reply_time` (`gbook_reply_time`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `gbook_reply` (`gbook_reply`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_gbook`
--

LOCK TABLES `mac_gbook` WRITE;
/*!40000 ALTER TABLE `mac_gbook` DISABLE KEYS */;
INSERT INTO `mac_gbook` VALUES (1,0,8,1,'17693102669',0,1585204584,1585205926,'还可输入196','顶顶顶顶顶'),(2,0,8,1,'17693102669',0,1585205703,0,'44444我',''),(3,0,11,1,'17693103995',0,1585206086,0,'尴尬哈哈哈哈',''),(4,0,11,1,'17693103995',0,1585206160,1585209726,'叭叭叭你呢么么么','gg是是是'),(5,0,8,1,'17693102669',0,1585236422,0,'哈哈哈哈不错不错',''),(6,0,17,1,'13123606482',1867902209,1585283194,0,'测试测试测试',''),(7,0,25,1,'17612212593',1963628626,1585316817,0,'播放器很卡，bug很多，x5还不如自带那个快点',''),(8,0,17,1,'13123606482',1867904587,1585899053,0,'测试雨中都是',''),(9,0,41,1,'15345866164',605494588,1585961822,0,'。。。？？？？','');
/*!40000 ALTER TABLE `mac_gbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_group`
--

DROP TABLE IF EXISTS `mac_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_group` (
  `group_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL DEFAULT '',
  `group_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `group_type` text NOT NULL,
  `group_popedom` text NOT NULL,
  `group_points_day` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_week` smallint(6) NOT NULL DEFAULT '0',
  `group_points_month` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_year` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_points_free` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `group_status` (`group_status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_group`
--

LOCK TABLES `mac_group` WRITE;
/*!40000 ALTER TABLE `mac_group` DISABLE KEYS */;
INSERT INTO `mac_group` VALUES (1,'游客',1,',1,6,7,8,9,10,11,12,2,13,14,15,16,3,4,5,17,18,','{\"1\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"6\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"7\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"8\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"9\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"10\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"11\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"12\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"2\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"13\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"14\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"15\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"16\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"3\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"4\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"5\":{\"1\":\"1\",\"2\":\"2\"},\"17\":{\"1\":\"1\",\"2\":\"2\"},\"18\":{\"1\":\"1\",\"2\":\"2\"}}',0,0,0,0,0),(2,'默认会员',1,',1,6,7,8,9,10,11,12,2,13,14,15,16,3,4,5,17,18,','{\"1\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"6\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"7\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"8\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"9\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"10\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"11\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"12\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"2\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"13\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"14\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"15\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"16\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"3\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"4\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"5\":{\"1\":\"1\",\"2\":\"2\"},\"17\":{\"1\":\"1\",\"2\":\"2\"},\"18\":{\"1\":\"1\",\"2\":\"2\"}}',0,0,0,0,0),(3,'VIP会员',1,',1,6,7,8,9,10,11,12,21,22,23,27,2,13,14,15,16,3,4,20,24,25,26,29,','{\"1\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"6\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"7\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"8\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"9\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"10\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"11\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"12\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"21\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"22\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"23\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"27\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"2\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"13\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"14\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"15\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"16\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"3\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"4\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"20\":{\"1\":\"1\",\"2\":\"2\"},\"24\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"25\":{\"1\":\"1\",\"2\":\"2\",\"3\":\"3\",\"4\":\"4\",\"5\":\"5\"},\"26\":{\"1\":\"1\",\"2\":\"2\"},\"29\":{\"1\":\"1\",\"2\":\"2\"}}',1,70,300,3600,0);
/*!40000 ALTER TABLE `mac_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_link`
--

DROP TABLE IF EXISTS `mac_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_link` (
  `link_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_name` varchar(60) NOT NULL DEFAULT '',
  `link_sort` smallint(6) NOT NULL DEFAULT '0',
  `link_add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_time` int(10) unsigned NOT NULL DEFAULT '0',
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_logo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_sort` (`link_sort`) USING BTREE,
  KEY `link_type` (`link_type`) USING BTREE,
  KEY `link_add_time` (`link_add_time`),
  KEY `link_time` (`link_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_link`
--

LOCK TABLES `mac_link` WRITE;
/*!40000 ALTER TABLE `mac_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_live`
--

DROP TABLE IF EXISTS `mac_live`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_live` (
  `live_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `live_name` varchar(60) NOT NULL DEFAULT '',
  `live_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `live_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `live_sort` int(10) NOT NULL DEFAULT '0',
  `live_jumpurl` varchar(255) NOT NULL DEFAULT '',
  `live_logo` varchar(255) NOT NULL DEFAULT '',
  `live_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `live_time` int(10) unsigned NOT NULL DEFAULT '0',
  `live_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `live_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `live_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `live_content` mediumtext NOT NULL,
  `live_epg` varchar(30) NOT NULL,
  PRIMARY KEY (`live_id`),
  KEY `type_id` (`type_id`),
  KEY `type_id_1` (`type_id_1`),
  KEY `live_name` (`live_name`),
  KEY `live_sort` (`live_sort`),
  KEY `live_lock` (`live_lock`),
  KEY `live_time` (`live_time`),
  KEY `live_time_add` (`live_time_add`),
  KEY `live_time_make` (`live_time_make`),
  KEY `live_level` (`live_level`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_live`
--

LOCK TABLES `mac_live` WRITE;
/*!40000 ALTER TABLE `mac_live` DISABLE KEYS */;
INSERT INTO `mac_live` VALUES (22,29,0,'CCTV-1综合',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000210103.m3u8','http://qy.redlk.com/upload/live/20200315-1/5edde29bfaac661363bd301cf0bc221a.png',0,1584277027,1584277027,0,0,'','CCTV-CCTV1'),(2,29,0,'CCTV-2财经',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000203603.m3u8','http://qy.redlk.com/upload/live/20200315-1/b007edba69ba4790a6b79696677bea5c.png',0,1584277091,1584263708,0,0,'','CCTV-CCTV2'),(3,29,0,'CCTV-3综艺',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000203803.m3u8','http://qy.redlk.com/upload/live/20200315-1/300201f5093f3444530295b09b73eef6.png',0,1584277099,1584263744,0,0,'','CCTV-CCTV3'),(4,29,0,'CCTV-4国际',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204803.m3u8','http://qy.redlk.com/upload/live/20200315-1/750a175522f73d0aba91ec5c242b96fe.png',0,1584277124,1584263811,0,0,'','CCTV-CCTV4'),(5,29,0,'CCTV-5体育',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000205103.m3u8','http://qy.redlk.com/upload/live/20200315-1/72bb2a186256278e71aebbdb6ba6d320.png',0,1584277144,1584263848,0,0,'','CCTV-CCTV5'),(6,29,0,'CCTV-5+赛事',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204503.m3u8','http://qy.redlk.com/upload/live/20200315-1/08e438d74320182226fb323a7aa5cbe5.png',0,1584277153,1584263882,0,0,'','CCTV-CCTV5-PLUS'),(7,29,0,'CCTV-6电影',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000203303.m3u8','http://qy.redlk.com/upload/live/20200315-1/eadcdc567b7b6b89f2a7abe68fac1715.png',0,1584277162,1584263914,0,0,'','CCTV-CCTV6'),(8,29,0,'CCTV-7国防军事',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000510003.m3u8','http://qy.redlk.com/upload/live/20200315-1/92197ddd4db87f2da742b7fa39ff3c4c.png',0,1584277178,1584263947,0,0,'','CCTV-CCTV7'),(9,29,0,'CCTV-8电视剧',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000203903.m3u8','http://qy.redlk.com/upload/live/20200315-1/cd2b68b956803c35d874bc30a240382e.png',0,1584277270,1584263973,0,0,'','CCTV-CCTV8'),(10,29,0,'CCTV-9纪录',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000499403.m3u8','http://qy.redlk.com/upload/live/20200315-1/ae53340885a201c001ad457faaf83537.png',0,1584277258,1584263998,0,0,'','CCTV-CCTV9'),(11,29,0,'CCTV-10科教',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000203503.m3u8','http://qy.redlk.com/upload/live/20200315-1/6375017be62cd15747281c42dd512a2d.png',0,1584277250,1584264020,0,0,'','CCTV-CCTV10'),(12,29,0,'CCTV-11戏曲',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204103.m3u8','http://qy.redlk.com/upload/live/20200315-1/f1454f4a937e21c16bd87f349cae075e.png',0,1584277190,1584264044,0,0,'','CCTV-CCTV11'),(13,29,0,'CCTV-12社会与法',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000202603.m3u8','http://qy.redlk.com/upload/live/20200315-1/978c58c23746269b31f0a0e23ad1ae13.png',0,1584277198,1584264079,0,0,'','CCTV-CCTV12'),(14,29,0,'CCTV-13新闻',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204603.m3u8','http://qy.redlk.com/upload/live/20200315-1/f88879cd6937ffb07eeb86d87a88105e.png',0,1584277207,1584264101,0,0,'','CCTV-CCTV13'),(15,29,0,'CCTV-14少儿',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204403.m3u8','http://qy.redlk.com/upload/live/20200315-1/d0499d5ed803d315cbc430d4cabe9a58.png',0,1584277227,1584264232,0,0,'','CCTV-CCTV15'),(16,29,0,'CCTV-15音乐',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000205003.m3u8','http://qy.redlk.com/upload/live/20200315-1/7e06635a4cc1d34c15a981fe9f2713dd.png',0,1584277218,1584264255,0,0,'','CCTV-CCTV16'),(17,29,0,'CCTV-17农业农村',1,0,0,'http://live-wcloud-cdn.ysp.cctv.cn/tlivecloud-cdn.ysp.cctv.cn/001/2000204203.m3u8','http://qy.redlk.com/upload/live/20200315-1/26aeb07e351ab5b5e344f4957cc82d05.png',0,1584277238,1584264296,0,0,'','CCTV-CCTV17NY'),(20,29,0,'CCTV-4K',1,0,0,'http://112.50.243.8/PLTV/88888888/224/3221226825/1.m3u8','http://qy.redlk.com/upload/live/20200315-1/51eeb491589944d372696005d55078d0.jpg',0,1584277356,1584275405,0,0,'','1');
/*!40000 ALTER TABLE `mac_live` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_msg`
--

DROP TABLE IF EXISTS `mac_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_to` varchar(30) NOT NULL DEFAULT '',
  `msg_code` varchar(10) NOT NULL DEFAULT '',
  `msg_content` varchar(255) NOT NULL DEFAULT '',
  `msg_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `msg_code` (`msg_code`),
  KEY `msg_time` (`msg_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_msg`
--

LOCK TABLES `mac_msg` WRITE;
/*!40000 ALTER TABLE `mac_msg` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_notice`
--

DROP TABLE IF EXISTS `mac_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `home_gg` varchar(255) NOT NULL,
  `hall_gg` varchar(255) NOT NULL,
  `agentzq_gg` varchar(255) NOT NULL,
  `agent_gg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_notice`
--

LOCK TABLES `mac_notice` WRITE;
/*!40000 ALTER TABLE `mac_notice` DISABLE KEYS */;
INSERT INTO `mac_notice` VALUES (1,'欢迎使用乐看影视','23','3','5');
/*!40000 ALTER TABLE `mac_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_order`
--

DROP TABLE IF EXISTS `mac_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order_code` varchar(30) NOT NULL DEFAULT '',
  `order_price` decimal(12,2) unsigned NOT NULL DEFAULT '0.00',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_points` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_pay_type` varchar(10) NOT NULL DEFAULT '',
  `order_pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_remarks` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`order_id`),
  KEY `order_code` (`order_code`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `order_time` (`order_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_order`
--

LOCK TABLES `mac_order` WRITE;
/*!40000 ALTER TABLE `mac_order` DISABLE KEYS */;
INSERT INTO `mac_order` VALUES (1,8,0,'PAY20200325150348581233',10.00,1585119828,10,'',0,''),(2,8,0,'PAY20200325151150621531',10.00,1585120310,10,'',0,''),(3,8,0,'PAY20200325152036170589',10.00,1585120836,10,'',0,'');
/*!40000 ALTER TABLE `mac_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_plog`
--

DROP TABLE IF EXISTS `mac_plog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_plog` (
  `plog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_1` int(10) NOT NULL DEFAULT '0',
  `plog_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `plog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `plog_time` int(10) unsigned NOT NULL DEFAULT '0',
  `plog_remarks` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`plog_id`),
  KEY `user_id` (`user_id`),
  KEY `plog_type` (`plog_type`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_plog`
--

LOCK TABLES `mac_plog` WRITE;
/*!40000 ALTER TABLE `mac_plog` DISABLE KEYS */;
INSERT INTO `mac_plog` VALUES (1,1,0,2,10,1582874098,''),(2,2,0,2,10,1582874159,''),(3,2,0,2,10,1582888868,''),(4,8,0,7,10,1585107491,''),(5,11,0,7,10,1585114117,''),(6,11,0,7,10,1585115468,''),(7,11,0,7,10,1585115521,''),(8,11,0,7,10,1585115581,''),(9,11,0,7,10,1585115583,''),(10,11,0,7,10,1585115584,''),(11,11,0,7,1,1585115813,''),(12,11,0,7,1,1585115832,''),(13,11,0,7,1,1585115869,''),(14,11,0,7,1,1585115895,''),(15,11,0,7,1,1585126842,''),(16,11,0,7,1,1585127039,''),(17,11,0,7,1,1585127046,''),(18,11,0,7,1,1585127140,''),(19,11,0,7,1,1585127286,''),(20,11,0,7,1,1585127342,''),(21,8,0,7,1,1585127429,''),(22,8,0,7,1,1585127634,''),(23,8,0,7,1,1585127801,''),(24,8,0,7,1,1585127817,''),(25,8,0,7,1,1585127959,''),(26,11,0,7,1,1585128070,''),(27,11,0,7,1,1585128076,''),(28,12,0,7,1,1585235870,''),(29,12,0,7,1,1585235872,''),(30,12,0,7,1,1585235872,''),(31,12,0,7,1,1585235872,''),(32,12,0,7,1,1585235873,''),(33,12,0,7,1,1585235873,''),(34,12,0,7,1,1585235873,''),(35,12,0,7,1,1585235873,''),(36,12,0,7,1,1585235873,''),(37,12,0,7,1,1585235874,''),(38,8,0,7,1,1585236066,''),(39,8,0,7,1,1585236135,''),(40,8,0,7,1,1585236311,''),(41,8,0,7,1,1585237595,''),(42,6,0,7,1,1585279053,''),(43,17,0,7,1,1585283139,''),(44,17,0,7,1,1585283141,''),(45,17,0,7,1,1585283141,''),(46,17,0,7,1,1585283141,''),(47,17,0,7,1,1585283141,''),(48,17,0,7,1,1585283142,''),(49,17,0,7,1,1585283142,''),(50,17,0,7,1,1585283142,''),(51,17,0,7,1,1585283142,''),(52,17,0,7,1,1585283142,''),(53,24,0,7,1,1585309965,''),(54,15,0,7,1,1585370349,''),(55,30,0,7,1,1585461296,''),(56,30,0,7,1,1585461297,''),(57,30,0,7,1,1585461298,''),(58,30,0,7,1,1585461298,''),(59,30,0,7,1,1585461298,''),(60,30,0,7,1,1585461298,''),(61,30,0,7,1,1585461298,''),(62,30,0,7,1,1585461298,''),(63,30,0,7,1,1585461299,''),(64,30,0,7,1,1585461299,''),(65,23,0,7,1,1585465088,''),(66,27,0,7,1,1585542229,''),(67,6,0,7,1,1585703877,''),(68,32,0,7,1,1585752336,''),(69,20,0,7,1,1585791993,''),(70,6,0,7,1,1585798198,''),(71,6,0,7,1,1585798222,''),(72,6,0,7,1,1585799023,''),(73,6,0,7,1,1585799122,''),(74,6,0,7,1,1585799178,''),(75,6,0,7,1,1585799182,''),(76,6,0,7,1,1585799185,''),(77,6,0,7,1,1585799189,''),(78,26,0,7,1,1585897439,''),(79,40,0,7,1,1585898770,''),(80,40,0,7,1,1585898773,''),(81,40,0,7,1,1585898777,''),(82,26,0,7,1,1585899603,''),(83,26,0,7,1,1585899606,''),(84,26,0,7,1,1585899607,''),(85,26,0,7,1,1585899607,''),(86,26,0,7,1,1585899608,''),(87,26,0,7,1,1585899608,''),(88,26,0,7,1,1585899609,''),(89,24,0,7,1,1585907883,''),(90,25,0,7,1,1585964335,'');
/*!40000 ALTER TABLE `mac_plog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_popupmessage`
--

DROP TABLE IF EXISTS `mac_popupmessage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_popupmessage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vod_name` varchar(30) NOT NULL,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `number` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `vod_id` int(10) NOT NULL DEFAULT '0',
  `vod_area` varchar(10) NOT NULL,
  `patternn` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_popupmessage`
--

LOCK TABLES `mac_popupmessage` WRITE;
/*!40000 ALTER TABLE `mac_popupmessage` DISABLE KEYS */;
INSERT INTO `mac_popupmessage` VALUES (1,'22','http://qy.redlk.com/upload/site/20200304-1/77f8c4d875c7545dec8fffe0c576e51b.jpg','',20,0,0,'美国',0);
/*!40000 ALTER TABLE `mac_popupmessage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_role`
--

DROP TABLE IF EXISTS `mac_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `role_name` varchar(255) NOT NULL DEFAULT '',
  `role_en` varchar(255) NOT NULL DEFAULT '',
  `role_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_letter` char(1) NOT NULL DEFAULT '',
  `role_color` varchar(6) NOT NULL DEFAULT '',
  `role_actor` varchar(255) NOT NULL DEFAULT '',
  `role_remarks` varchar(100) NOT NULL DEFAULT '',
  `role_pic` varchar(255) NOT NULL DEFAULT '',
  `role_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `role_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_time` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `role_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `role_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `role_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `role_tpl` varchar(30) NOT NULL DEFAULT '',
  `role_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `role_content` text NOT NULL,
  PRIMARY KEY (`role_id`),
  KEY `role_rid` (`role_rid`),
  KEY `role_name` (`role_name`),
  KEY `role_en` (`role_en`),
  KEY `role_letter` (`role_letter`),
  KEY `role_actor` (`role_actor`),
  KEY `role_level` (`role_level`),
  KEY `role_time` (`role_time`),
  KEY `role_time_add` (`role_time_add`),
  KEY `role_score` (`role_score`),
  KEY `role_score_all` (`role_score_all`),
  KEY `role_score_num` (`role_score_num`),
  KEY `role_up` (`role_up`),
  KEY `role_down` (`role_down`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_role`
--

LOCK TABLES `mac_role` WRITE;
/*!40000 ALTER TABLE `mac_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_tmplive`
--

DROP TABLE IF EXISTS `mac_tmplive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_tmplive` (
  `id1` int(10) unsigned DEFAULT NULL,
  `name1` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_tmplive`
--

LOCK TABLES `mac_tmplive` WRITE;
/*!40000 ALTER TABLE `mac_tmplive` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_tmplive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_tmpvod`
--

DROP TABLE IF EXISTS `mac_tmpvod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_tmpvod` (
  `id1` int(10) unsigned DEFAULT NULL,
  `name1` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_tmpvod`
--

LOCK TABLES `mac_tmpvod` WRITE;
/*!40000 ALTER TABLE `mac_tmpvod` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_tmpvod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_topic`
--

DROP TABLE IF EXISTS `mac_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_topic` (
  `topic_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(255) NOT NULL DEFAULT '',
  `topic_en` varchar(255) NOT NULL DEFAULT '',
  `topic_sub` varchar(255) NOT NULL DEFAULT '',
  `topic_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `topic_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `topic_letter` char(1) NOT NULL DEFAULT '',
  `topic_color` varchar(6) NOT NULL DEFAULT '',
  `topic_tpl` varchar(30) NOT NULL DEFAULT '',
  `topic_type` varchar(255) NOT NULL DEFAULT '',
  `topic_pic` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `topic_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `topic_key` varchar(255) NOT NULL DEFAULT '',
  `topic_des` varchar(255) NOT NULL DEFAULT '',
  `topic_title` varchar(255) NOT NULL DEFAULT '',
  `topic_blurb` varchar(255) NOT NULL DEFAULT '',
  `topic_remarks` varchar(100) NOT NULL DEFAULT '',
  `topic_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `topic_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `topic_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topic_time` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `topic_tag` varchar(255) NOT NULL DEFAULT '',
  `topic_rel_vod` text,
  `topic_rel_art` text,
  `topic_content` text,
  `topic_extend` text,
  PRIMARY KEY (`topic_id`),
  KEY `topic_sort` (`topic_sort`) USING BTREE,
  KEY `topic_level` (`topic_level`) USING BTREE,
  KEY `topic_score` (`topic_score`) USING BTREE,
  KEY `topic_score_all` (`topic_score_all`) USING BTREE,
  KEY `topic_score_num` (`topic_score_num`) USING BTREE,
  KEY `topic_hits` (`topic_hits`) USING BTREE,
  KEY `topic_hits_day` (`topic_hits_day`) USING BTREE,
  KEY `topic_hits_week` (`topic_hits_week`) USING BTREE,
  KEY `topic_hits_month` (`topic_hits_month`) USING BTREE,
  KEY `topic_time_add` (`topic_time_add`) USING BTREE,
  KEY `topic_time` (`topic_time`) USING BTREE,
  KEY `topic_time_hits` (`topic_time_hits`) USING BTREE,
  KEY `topic_name` (`topic_name`),
  KEY `topic_en` (`topic_en`),
  KEY `topic_up` (`topic_up`),
  KEY `topic_down` (`topic_down`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_topic`
--

LOCK TABLES `mac_topic` WRITE;
/*!40000 ALTER TABLE `mac_topic` DISABLE KEYS */;
INSERT INTO `mac_topic` VALUES (5,'变形金刚系列','bianxingjingangxilie','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PgJwq.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583823072,1583667733,0,0,'','19025,19944,1422,89594,762,14906','','',''),(4,'复仇者联盟系列','fuchouzhelianmengxilie','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PgwpF.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583823100,1583666134,0,0,'','3700,101069,1640,3989,17523,82673,33615,33154,28627,77249,75872,11256,59215,51047,48639,48204,47596,37555,37523,37457','','',''),(6,'没有看过比这更绝望的结局','meiyoukanguobizhegengjuewangdejieju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8Px4mR.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828204,1583828204,0,0,'','','','',''),(7,'了不起的匠人','liaobuqidejiangren','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8Px501.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828249,1583828249,0,0,'','','','',''),(8,'经典香港黑帮电影','jingdianxianggangheibangdianying','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxfX9.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828290,1583828290,0,0,'','','','',''),(9,'最伤感的Top20','zuishanggandeTop20','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxW6J.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828317,1583828317,0,0,'','','','',''),(10,'林正英的僵尸世界','linzhengyingdejiangshishijie','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxRl4.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828353,1583828353,0,0,'','','','',''),(11,'19禁韩剧','19jinhanju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxITx.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828413,1583828413,0,0,'','','','',''),(12,'周末在家看喜剧','zhoumozaijiakanxiju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxTk6.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828478,1583828478,0,0,'','','','',''),(13,'大尺度美剧','dachidumeiju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8Px7tK.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828566,1583828566,0,0,'','','','',''),(14,'宫廷大剧','gongtingdaju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzpAP.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828635,1583828635,0,0,'','','','',''),(15,'热血特工大片','rexuetegongdapian','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PxXXd.gif','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828700,1583828700,0,0,'','','','',''),(16,'视觉盛宴','shijueshengyan','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzZBn.gif','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828750,1583828750,0,0,'','','','',''),(17,'哆啦A梦陪我长大','duolaAmengpeiwochangda','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8Pz9tf.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828778,1583828778,0,0,'','','','',''),(18,'电影中的女神','dianyingzhongdenvshen','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzCh8.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828801,1583828801,0,0,'','','','',''),(19,'那些青春岁月','naxieqingchunsuiyue','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8Pzi9S.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828842,1583828842,0,0,'','','','',''),(20,'暴力美学','baolimeixue','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzF1g.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828861,1583828861,0,0,'','','','',''),(21,'神作美剧','shenzuomeiju','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzkcQ.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828879,1583828879,0,0,'','','','',''),(22,'感受战火中的硝烟','ganshouzhanhuozhongdexiaoyan','',1,0,'','','detail.html','','https://s2.ax1x.com/2020/03/10/8PzVns.jpg','','','','','','','',0,0,0,0.0,0,0,0,0,0,0,1583828919,1583828919,0,0,'','','','','');
/*!40000 ALTER TABLE `mac_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_type`
--

DROP TABLE IF EXISTS `mac_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_type` (
  `type_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(60) NOT NULL DEFAULT '',
  `type_en` varchar(60) NOT NULL DEFAULT '',
  `type_sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_mid` smallint(6) unsigned NOT NULL DEFAULT '1',
  `type_pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `type_tpl` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_list` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_detail` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `type_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `type_key` varchar(255) NOT NULL DEFAULT '',
  `type_des` varchar(255) NOT NULL DEFAULT '',
  `type_title` varchar(255) NOT NULL DEFAULT '',
  `type_union` varchar(255) NOT NULL DEFAULT '',
  `type_extend` text,
  `type_logo` varchar(255) NOT NULL DEFAULT '',
  `type_pic` varchar(255) NOT NULL DEFAULT '',
  `type_jumpurl` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`type_id`),
  KEY `type_sort` (`type_sort`) USING BTREE,
  KEY `type_pid` (`type_pid`) USING BTREE,
  KEY `type_name` (`type_name`),
  KEY `type_en` (`type_en`),
  KEY `type_mid` (`type_mid`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_type`
--

LOCK TABLES `mac_type` WRITE;
/*!40000 ALTER TABLE `mac_type` DISABLE KEYS */;
INSERT INTO `mac_type` VALUES (1,'电影','dianying',1,1,0,1,'type.html','show.html','detail.html','play.html','down.html','电影,电影大全,电影天堂,最新电影,好看的电影,电影排行榜','为您提供更新电影、好看的电影排行榜及电影迅雷下载，免费在线观看伦理电影、动作片、喜剧片、爱情片、搞笑片等全新电影。','电影','','{\"class\":\"\\u559c\\u5267,\\u7231\\u60c5,\\u6050\\u6016,\\u52a8\\u4f5c,\\u79d1\\u5e7b,\\u5267\\u60c5,\\u6218\\u4e89,\\u8b66\\u532a,\\u72af\\u7f6a,\\u52a8\\u753b,\\u5947\\u5e7b,\\u6b66\\u4fa0,\\u5192\\u9669,\\u67aa\\u6218,\\u6050\\u6016,\\u60ac\\u7591,\\u60ca\\u609a,\\u7ecf\\u5178,\\u9752\\u6625,\\u6587\\u827a,\\u5fae\\u7535\\u5f71,\\u53e4\\u88c5,\\u5386\\u53f2,\\u8fd0\\u52a8,\\u519c\\u6751,\\u513f\\u7ae5,\\u7f51\\u7edc\\u7535\\u5f71\",\"area\":\"\\u5927\\u9646,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u7f8e\\u56fd,\\u6cd5\\u56fd,\\u82f1\\u56fd,\\u65e5\\u672c,\\u97e9\\u56fd,\\u5fb7\\u56fd,\\u6cf0\\u56fd,\\u5370\\u5ea6,\\u610f\\u5927\\u5229,\\u897f\\u73ed\\u7259,\\u52a0\\u62ff\\u5927,\\u5176\\u4ed6\",\"lang\":\"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u6cd5\\u8bed,\\u5fb7\\u8bed,\\u5176\\u5b83\",\"year\":\"2018,2017,2016,2015,2014,2013,2012,2011,2010\",\"star\":\"\\u738b\\u5b9d\\u5f3a,\\u9ec4\\u6e24,\\u5468\\u8fc5,\\u5468\\u51ac\\u96e8,\\u8303\\u51b0\\u51b0,\\u9648\\u5b66\\u51ac,\\u9648\\u4f1f\\u9706,\\u90ed\\u91c7\\u6d01,\\u9093\\u8d85,\\u6210\\u9f99,\\u845b\\u4f18,\\u6797\\u6b63\\u82f1,\\u5f20\\u5bb6\\u8f89,\\u6881\\u671d\\u4f1f,\\u5f90\\u5ce5,\\u90d1\\u607a,\\u5434\\u5f66\\u7956,\\u5218\\u5fb7\\u534e,\\u5468\\u661f\\u9a70,\\u6797\\u9752\\u971e,\\u5468\\u6da6\\u53d1,\\u674e\\u8fde\\u6770,\\u7504\\u5b50\\u4e39,\\u53e4\\u5929\\u4e50,\\u6d2a\\u91d1\\u5b9d,\\u59da\\u6668,\\u502a\\u59ae,\\u9ec4\\u6653\\u660e,\\u5f6d\\u4e8e\\u664f,\\u6c64\\u552f,\\u9648\\u5c0f\\u6625\",\"director\":\"\\u51af\\u5c0f\\u521a,\\u5f20\\u827a\\u8c0b,\\u5434\\u5b87\\u68ee,\\u9648\\u51ef\\u6b4c,\\u5f90\\u514b,\\u738b\\u5bb6\\u536b,\\u59dc\\u6587,\\u5468\\u661f\\u9a70,\\u674e\\u5b89\",\"state\":\"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e\",\"version\":\"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248\"}','','',''),(2,'连续剧','lianxuju',2,1,0,1,'type.html','show.html','detail.html','play.html','down.html','电视剧,最新电视剧,好看的电视剧,热播电视剧,电视剧在线观看','为您提供2018新电视剧排行榜，韩国电视剧、泰国电视剧、香港TVB全新电视剧排行榜、好看的电视剧等热播电视剧排行榜，并提供免费高清电视剧下载及在线观看。','电视剧','','{\"class\":\"\\u53e4\\u88c5,\\u6218\\u4e89,\\u9752\\u6625\\u5076\\u50cf,\\u559c\\u5267,\\u5bb6\\u5ead,\\u72af\\u7f6a,\\u52a8\\u4f5c,\\u5947\\u5e7b,\\u5267\\u60c5,\\u5386\\u53f2,\\u7ecf\\u5178,\\u4e61\\u6751,\\u60c5\\u666f,\\u5546\\u6218,\\u7f51\\u5267,\\u5176\\u4ed6\",\"area\":\"\\u5185\\u5730,\\u97e9\\u56fd,\\u9999\\u6e2f,\\u53f0\\u6e7e,\\u65e5\\u672c,\\u7f8e\\u56fd,\\u6cf0\\u56fd,\\u82f1\\u56fd,\\u65b0\\u52a0\\u5761,\\u5176\\u4ed6\",\"lang\":\"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83\",\"year\":\"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2006,2005,2004\",\"star\":\"\\u738b\\u5b9d\\u5f3a,\\u80e1\\u6b4c,\\u970d\\u5efa\\u534e,\\u8d75\\u4e3d\\u9896,\\u5218\\u6d9b,\\u5218\\u8bd7\\u8bd7,\\u9648\\u4f1f\\u9706,\\u5434\\u5947\\u9686,\\u9646\\u6bc5,\\u5510\\u5ae3,\\u5173\\u6653\\u5f64,\\u5b59\\u4fea,\\u674e\\u6613\\u5cf0,\\u5f20\\u7ff0,\\u674e\\u6668,\\u8303\\u51b0\\u51b0,\\u6797\\u5fc3\\u5982,\\u6587\\u7ae0,\\u9a6c\\u4f0a\\u740d,\\u4f5f\\u5927\\u4e3a,\\u5b59\\u7ea2\\u96f7,\\u9648\\u5efa\\u658c,\\u674e\\u5c0f\\u7490\",\"director\":\"\\u5f20\\u7eaa\\u4e2d,\\u674e\\u5c11\\u7ea2,\\u5218\\u6c5f,\\u5b54\\u7b19,\\u5f20\\u9ece,\\u5eb7\\u6d2a\\u96f7,\\u9ad8\\u5e0c\\u5e0c,\\u80e1\\u73ab,\\u8d75\\u5b9d\\u521a,\\u90d1\\u6653\\u9f99\",\"state\":\"\\u6b63\\u7247,\\u9884\\u544a\\u7247,\\u82b1\\u7d6e\",\"version\":\"\\u9ad8\\u6e05\\u7248,\\u5267\\u573a\\u7248,\\u62a2\\u5148\\u7248,OVA,TV,\\u5f71\\u9662\\u7248\"}','https://s1.ax1x.com/2020/03/20/86L7hq.png','',''),(3,'综艺','zongyi',3,1,0,1,'type.html','show.html','detail.html','play.html','down.html','综艺,综艺节目,最新综艺节目,综艺节目排行榜','为您提供新综艺节目、好看的综艺节目排行榜，免费高清在线观看选秀、情感、访谈、搞笑、真人秀、脱口秀等热门综艺节目。','综艺','','{\"class\":\"\\u9009\\u79c0,\\u60c5\\u611f,\\u8bbf\\u8c08,\\u64ad\\u62a5,\\u65c5\\u6e38,\\u97f3\\u4e50,\\u7f8e\\u98df,\\u7eaa\\u5b9e,\\u66f2\\u827a,\\u751f\\u6d3b,\\u6e38\\u620f\\u4e92\\u52a8,\\u8d22\\u7ecf,\\u6c42\\u804c\",\"area\":\"\\u5185\\u5730,\\u6e2f\\u53f0,\\u65e5\\u97e9,\\u6b27\\u7f8e\",\"lang\":\"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83\",\"year\":\"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004\",\"star\":\"\\u4f55\\u7085,\\u6c6a\\u6db5,\\u8c22\\u5a1c,\\u5468\\u7acb\\u6ce2,\\u9648\\u9c81\\u8c6b,\\u5b5f\\u975e,\\u674e\\u9759,\\u6731\\u519b,\\u6731\\u4e39,\\u534e\\u5c11,\\u90ed\\u5fb7\\u7eb2,\\u6768\\u6f9c\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://ae01.alicdn.com/kf/H2a07128bb1a1496fa8d33090d46968d0K.png','https://s1.ax1x.com/2020/03/26/GSkQ61.jpg',''),(4,'动漫','dongman',4,1,0,1,'type.html','show.html','detail.html','play.html','down.html','动漫,动漫大全,最新动漫,好看的动漫,日本动漫,动漫排行榜','为您提供新动漫、好看的动漫排行榜，免费高清在线观看热血动漫、卡通动漫、新番动漫、百合动漫、搞笑动漫、国产动漫、动漫电影等热门动漫。','动画片','','{\"class\":\"\\u60c5\\u611f,\\u79d1\\u5e7b,\\u70ed\\u8840,\\u63a8\\u7406,\\u641e\\u7b11,\\u5192\\u9669,\\u841d\\u8389,\\u6821\\u56ed,\\u52a8\\u4f5c,\\u673a\\u6218,\\u8fd0\\u52a8,\\u6218\\u4e89,\\u5c11\\u5e74,\\u5c11\\u5973,\\u793e\\u4f1a,\\u539f\\u521b,\\u4eb2\\u5b50,\\u76ca\\u667a,\\u52b1\\u5fd7,\\u5176\\u4ed6\",\"area\":\"\\u56fd\\u4ea7,\\u65e5\\u672c,\\u6b27\\u7f8e,\\u5176\\u4ed6\",\"lang\":\"\\u56fd\\u8bed,\\u82f1\\u8bed,\\u7ca4\\u8bed,\\u95fd\\u5357\\u8bed,\\u97e9\\u8bed,\\u65e5\\u8bed,\\u5176\\u5b83\",\"year\":\"2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008,2007,2006,2005,2004\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"TV\\u7248,\\u7535\\u5f71\\u7248,OVA\\u7248,\\u771f\\u4eba\\u7248\"}','https://ae01.alicdn.com/kf/H8f50579535cc41858522fecff8e27f074.png','https://ae01.alicdn.com/kf/H929b1d7ccd744d8380cafe37cab6de96t.jpg',''),(27,'伦理片','lunlipian',0,1,1,0,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(7,'喜剧片','xijupian',2,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的喜剧片,最新喜剧片,经典喜剧片,国语喜剧片电影','2018最新喜剧片，好看的喜剧片大全和排行榜推荐，免费喜剧片在线观看和视频在线播放是由本网站整理和收录，欢迎喜剧片爱好者来到这里在线观看喜剧片','好看的喜剧片-最新喜剧片-经典喜剧片-最新喜剧片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qmse.png','https://s1.ax1x.com/2020/03/26/GSp3mF.jpg',''),(6,'动作片','dongzuopian',1,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的动作片,最新动作片,经典动作片,国语动作片电影','2018最新动作片，好看的动作片大全和排行榜推荐，免费动作片在线观看和视频在线播放是由本网站整理和收录，欢迎动作片爱好者来到这里在线观看动作片','好看的动作片-最新动作片-经典动作片-最新动作片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qnqH.png','https://ae01.alicdn.com/kf/Hb407dd7c9f1d48ab885d02a8e016368fb.jpg',''),(8,'爱情片','aiqingpian',3,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的爱情片,最新爱情片,经典爱情片,国语爱情片电影','2018最新爱情片，好看的爱情片大全和排行榜推荐，免费爱情片在线观看和视频在线播放是由本网站整理和收录，欢迎爱情片爱好者来到这里在线观看爱情片','好看的爱情片-最新爱情片-经典爱情片-最新爱情片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qVxO.png','https://s1.ax1x.com/2020/03/26/GSpo7Q.jpg',''),(9,'科幻片','kehuanpian',4,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的科幻片,最新科幻片,经典科幻片,国语科幻片电影','2018最新科幻片，好看的科幻片大全和排行榜推荐，免费科幻片在线观看和视频在线播放是由本网站整理和收录，欢迎科幻片爱好者来到这里在线观看科幻片','好看的科幻片-最新科幻片-经典科幻片-最新科幻片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qkPx.png','https://s1.ax1x.com/2020/03/26/GS9Iv6.jpg',''),(10,'恐怖片','kongbupian',5,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的恐怖片,最新恐怖片,经典恐怖片,国语恐怖片电影','2018最新恐怖片，好看的恐怖片大全和排行榜推荐，免费恐怖片在线观看和视频在线播放是由本网站整理和收录，欢迎恐怖片爱好者来到这里在线观看恐怖片','好看的恐怖片-最新恐怖片-经典恐怖片-最新恐怖片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qPaR.png','https://s1.ax1x.com/2020/03/26/GSCiVg.gif',''),(11,'剧情片','juqingpian',6,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的剧情片,最新剧情片,经典剧情片,国语剧情片电影','2018最新剧情片，好看的剧情片大全和排行榜推荐，免费剧情片在线观看和视频在线播放是由本网站整理和收录，欢迎剧情片爱好者来到这里在线观看剧情片','好看的剧情片-最新剧情片-经典剧情片-最新剧情片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qKZd.png','https://s1.ax1x.com/2020/03/26/GSC8i9.jpg',''),(12,'战争片','zhanzhengpian',7,1,1,1,'type.html','show.html','detail.html','play.html','down.html','好看的战争片,最新战争片,经典战争片,国语战争片电影','2018最新战争片，好看的战争片大全和排行榜推荐，免费战争片在线观看和视频在线播放是由本网站整理和收录，欢迎战争片爱好者来到这里在线观看战争片','好看的战争片-最新战争片-经典战争片-最新战争片推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86qQII.png','https://ae01.alicdn.com/kf/Hf331e4c8773642a8a7fa502557255a66g.jpg',''),(13,'国产剧','guochanju',1,1,2,1,'type.html','show.html','detail.html','play.html','down.html','好看的国产剧,最新国产剧,经典国产剧,国语国产剧电影','2018最新国产剧，好看的国产剧大全和排行榜推荐，免费国产剧在线观看和视频在线播放是由本网站整理和收录，欢迎国产剧爱好者来到这里在线观看国产剧','好看的国产剧-最新国产剧-经典国产剧-最新国产剧推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86OorD.png','https://s1.ax1x.com/2020/03/26/GSC2sf.jpg',''),(14,'港台剧','gangtaiju',2,1,2,1,'type.html','show.html','detail.html','play.html','down.html','好看的港台剧,最新港台剧,经典港台剧,国语港台剧电影','2018最新港台剧，好看的港台剧大全和排行榜推荐，免费港台剧在线观看和视频在线播放是由本网站整理和收录，欢迎港台剧爱好者来到这里在线观看港台剧','好看的港台剧-最新港台剧-经典港台剧-最新港台剧推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86LTNn.png','https://s1.ax1x.com/2020/03/26/GSFhdO.png',''),(15,'日韩剧','rihanju',3,1,2,1,'type.html','show.html','detail.html','play.html','down.html','好看的日韩剧,最新日韩剧,经典日韩剧,国语日韩剧电影','2018最新日韩剧，好看的日韩剧大全和排行榜推荐，免费日韩剧在线观看和视频在线播放是由本网站整理和收录，欢迎日韩剧爱好者来到这里在线观看日韩剧','好看的日韩剧-最新日韩剧-经典日韩剧-最新日韩剧推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86L57j.png','https://s1.ax1x.com/2020/03/26/GSFIFe.jpg',''),(16,'欧美剧','oumeiju',4,1,2,1,'type.html','show.html','detail.html','play.html','down.html','好看的欧美剧,最新欧美剧,经典欧美剧,国语欧美剧电影','2018最新欧美剧，好看的欧美剧大全和排行榜推荐，免费欧美剧在线观看和视频在线播放是由本网站整理和收录，欢迎欧美剧爱好者来到这里在线观看欧美剧','好看的欧美剧-最新欧美剧-经典欧美剧-最新欧美剧推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86Lhng.png','https://s1.ax1x.com/2020/03/26/GSFsJJ.jpg',''),(17,'公告','gonggao',1,2,5,1,'type.html','show.html','detail.html','','','最新公告-最新公告推荐','2018最新公告，公布本站最新发展动态','最新公告-最新公告推荐','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(18,'头条','toutiao',2,2,5,1,'type.html','show.html','detail.html','','','','','','','','','',''),(20,'头条','toutiao',0,2,0,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(21,'微电影','weidianying',0,1,1,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86q1it.png','https://ae01.alicdn.com/kf/Hecc8689691b343179c665317d84eb1e1f.jpg',''),(22,'纪录片','jilupian',0,1,1,1,'type.html','show.html','detail.html','play.html','down.html','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://s1.ax1x.com/2020/03/20/86q3JP.png','https://ae01.alicdn.com/kf/H86e459957c7a4d6eb86f6dfdc203c433X.jpg',''),(23,'动画片','donghuapian',0,1,1,0,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','https://ae01.alicdn.com/kf/H7e046f85f655452587fc92be8b65ab25T.png','https://ae01.alicdn.com/kf/H4d17cc838117403d9fdcefd2a08ef9a91.jpg',''),(24,'预告','yugao',0,1,0,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(25,'八卦','bagua',0,1,0,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(26,'资讯','zixun',0,2,0,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','',''),(29,'央视','yangshi',0,12,0,1,'type.html','show.html','detail.html','','','','','','','{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}','','','');
/*!40000 ALTER TABLE `mac_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_ulog`
--

DROP TABLE IF EXISTS `mac_ulog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_ulog` (
  `ulog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_mid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ulog_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '5下载4历史2收藏',
  `ulog_rid` int(10) unsigned NOT NULL DEFAULT '0',
  `ulog_sid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ulog_nid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ulog_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ulog_id`),
  KEY `user_id` (`user_id`),
  KEY `ulog_mid` (`ulog_mid`),
  KEY `ulog_type` (`ulog_type`),
  KEY `ulog_rid` (`ulog_rid`)
) ENGINE=MyISAM AUTO_INCREMENT=582 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_ulog`
--

LOCK TABLES `mac_ulog` WRITE;
/*!40000 ALTER TABLE `mac_ulog` DISABLE KEYS */;
INSERT INTO `mac_ulog` VALUES (1,6,1,1,20,0,0,0,1582987951),(2,6,1,1,669,0,0,0,1583053655),(3,6,1,1,1118,0,0,0,1583064797),(285,8,1,4,107999,1,1,0,1585236559),(284,8,1,4,1640,1,1,0,1585236501),(6,6,1,1,1144,0,0,0,1583060793),(14,6,1,4,1118,1,31,0,1583064800),(13,6,1,4,1113,1,24,0,1583064788),(9,6,1,1,1142,0,0,0,1583061041),(10,6,1,2,1142,0,0,0,1583061046),(12,6,1,1,1113,0,0,0,1583064754),(323,8,1,4,106118,1,1,0,1585294228),(281,8,1,4,1921,1,1,0,1585236463),(280,8,1,4,107957,1,1,0,1585294122),(279,8,1,4,1857,1,1,0,1585236054),(322,8,1,2,108040,0,0,0,1585284431),(275,8,1,4,80089,1,1,0,1585236054),(274,8,1,4,107774,1,1,0,1585235959),(273,12,1,4,1822,1,3,0,1585235955),(272,8,1,4,107782,1,1,0,1585235924),(271,12,1,4,48753,1,1,0,1585235898),(270,8,1,4,108041,1,1,0,1585275785),(269,8,1,4,186,1,1,0,1585391683),(268,8,1,4,19944,1,1,0,1585234310),(267,11,1,4,3651,1,1,0,1585231307),(266,11,1,4,1422,1,1,0,1585231187),(265,11,1,4,107854,1,1,0,1585231012),(264,11,1,4,108035,1,1,0,1585230756),(263,11,1,4,107625,1,1,0,1585231293),(262,11,1,4,107999,1,1,0,1585216646),(261,11,1,4,107980,1,1,0,1585216642),(260,11,1,4,108025,1,1,0,1585216636),(259,11,1,4,48753,1,1,0,1585216633),(258,11,1,4,108040,1,1,0,1585216273),(257,11,1,4,108001,1,1,0,1585216270),(256,11,1,4,186,1,1,0,1585231322),(255,11,1,4,108007,1,1,0,1585216752),(254,11,1,4,555,1,1,0,1585231313),(253,11,1,4,560,1,1,0,1585198554),(324,8,1,4,271,1,27,0,1585284557),(210,8,1,4,107202,1,2,0,1585014255),(211,8,1,1,48753,0,0,0,1585038296),(208,8,1,1,107202,0,0,0,1585012805),(252,11,1,4,32,1,1,0,1585143115),(251,11,1,4,47991,1,1,0,1585143104),(248,11,1,2,107181,0,0,0,1585060027),(250,11,1,4,374,1,1,0,1585143099),(249,11,1,4,653,1,1,0,1585215408),(202,6,1,4,48753,1,1,0,1585892836),(201,6,1,4,107512,1,1,0,1585279061),(200,6,1,4,107625,1,1,0,1585877627),(199,8,1,4,318,1,1,0,1585403659),(198,8,1,4,48753,1,1,0,1585901919),(197,8,1,4,87742,1,1,0,1584948435),(294,8,1,4,19025,1,1,0,1585449888),(293,8,1,4,101069,1,1,0,1585274716),(292,8,1,4,108001,1,1,0,1585403668),(291,8,1,4,82673,1,1,0,1585273678),(290,8,1,4,17523,1,1,0,1585275814),(289,8,1,4,107625,1,1,0,1585902624),(321,8,1,4,555,1,1,0,1585728236),(320,17,1,4,107948,1,1,0,1585911878),(196,8,1,4,107159,1,1,0,1584949256),(195,8,1,4,107557,1,1,0,1584948193),(194,8,1,1,107159,0,0,0,1584883805),(193,8,1,4,1821,1,1,0,1585282002),(192,8,1,4,653,1,1,0,1585897969),(191,8,1,4,107879,1,3,0,1584880737),(190,8,1,4,107902,1,1,0,1585903196),(189,8,1,4,107948,1,1,0,1585236222),(188,8,1,4,1822,1,1,0,1585427394),(187,8,1,4,107980,1,1,0,1585294322),(186,8,1,4,107801,1,12,0,1584880711),(185,8,1,4,107866,1,1,0,1585278639),(295,8,1,4,108040,1,1,0,1585284425),(296,8,1,4,108022,1,1,0,1585897895),(297,8,1,4,107864,1,1,0,1585276393),(298,8,1,4,89594,1,1,0,1585280224),(299,8,1,4,107903,1,1,0,1585396909),(300,8,1,4,1890,1,1,0,1585518962),(301,8,1,4,43,1,1,0,1585726844),(302,15,1,4,653,1,1,0,1585281088),(303,15,1,4,318,1,1,0,1585281107),(304,15,1,4,107980,1,1,0,1585281121),(305,16,1,4,108040,1,1,0,1585316906),(306,8,1,4,32,1,1,0,1585452766),(307,16,1,2,108040,0,0,0,1585281159),(308,15,1,4,19944,1,1,0,1585281264),(309,8,1,4,107512,1,1,0,1585281372),(310,8,1,4,108007,1,1,0,1585281474),(311,18,1,4,318,1,1,0,1585281604),(312,18,1,4,107980,1,1,0,1585281630),(313,19,1,4,48753,1,1,0,1585281780),(314,19,1,4,108001,1,1,0,1585281833),(315,15,1,4,108035,1,1,0,1585281933),(316,18,1,4,108022,1,1,0,1585282185),(317,15,1,4,108025,1,1,0,1585282534),(318,17,1,4,107908,1,1,0,1585445071),(319,17,1,4,48753,1,1,0,1586028549),(325,8,1,4,1657,1,1,0,1585284603),(326,17,1,4,108038,1,1,0,1585285905),(327,17,1,4,107864,1,1,0,1585921373),(328,17,1,4,107775,1,1,0,1585291174),(329,17,1,4,108041,1,1,0,1585285894),(330,17,1,4,555,1,1,0,1585560638),(331,17,1,4,186,1,1,0,1585681922),(332,17,1,4,1857,1,1,0,1585285957),(333,20,1,4,48753,1,1,0,1585288550),(334,20,1,4,5390,1,13,0,1585288654),(335,17,1,4,19944,1,1,0,1585291147),(336,17,1,4,32,1,5,0,1585386326),(337,17,1,2,32,0,0,0,1585291194),(338,17,1,4,107880,1,1,0,1585291656),(339,17,1,4,101069,1,1,0,1585291802),(340,17,1,4,653,1,1,0,1585291950),(342,17,1,2,653,0,0,0,1585291957),(343,8,1,4,17359,1,1,0,1585294039),(344,8,1,4,108025,1,1,0,1585797861),(345,8,1,4,107731,1,1,0,1585819850),(346,8,1,4,108021,1,1,0,1585294212),(347,8,1,4,65922,1,1,0,1585453090),(348,8,1,4,65962,1,3,0,1585294305),(349,8,1,4,105822,1,1,0,1585294341),(350,8,1,4,106593,1,1,0,1585294349),(351,8,1,4,65927,1,1,0,1585294357),(352,8,1,4,65760,1,1,0,1585294366),(353,8,1,4,62089,1,1,0,1585294371),(354,8,1,4,62056,1,1,0,1585294407),(355,8,1,4,281,1,2,0,1585294468),(356,8,1,4,194,1,2,0,1585294493),(357,22,1,4,318,1,1,0,1585296160),(358,22,1,4,108001,1,1,0,1585296249),(359,22,1,4,43,1,2,0,1585296289),(360,15,1,4,103257,1,1,0,1585301052),(361,23,1,4,107980,1,1,0,1585303832),(362,23,1,4,107999,1,1,0,1585303835),(363,23,1,4,19025,1,1,0,1585303926),(364,23,1,4,89594,1,1,0,1585304107),(365,23,1,4,108022,1,4,0,1585304149),(366,17,1,4,107960,1,1,0,1585306035),(367,17,1,4,107975,1,1,0,1585306046),(368,17,1,4,107976,1,1,0,1585306051),(369,17,1,4,108033,1,1,0,1585306053),(370,17,1,4,108032,1,1,0,1585386539),(371,24,1,4,106826,1,1,0,1585310008),(372,25,1,4,555,1,1,0,1585983895),(373,25,1,4,186,1,1,0,1585451912),(374,25,1,4,1890,1,1,0,1585983927),(375,25,1,4,271,1,1,0,1585313189),(376,25,1,4,32,1,1,0,1585313291),(377,25,1,4,5390,1,1,0,1585373559),(378,25,1,4,5398,1,1,0,1585312851),(379,25,1,4,93344,1,1,0,1585374122),(380,25,1,4,108025,1,1,0,1585983974),(381,25,1,4,108022,1,1,0,1585316874),(382,25,1,4,43,1,1,0,1585313119),(383,25,1,4,107509,1,1,0,1585313210),(384,25,1,4,107986,1,1,0,1585313220),(385,25,1,4,108006,1,1,0,1585313222),(386,25,1,4,107969,1,1,0,1585313249),(387,25,1,4,108032,1,1,0,1585313264),(388,23,1,4,318,1,1,0,1585313748),(389,23,1,4,271,1,1,0,1585313637),(390,23,1,4,108035,1,1,0,1585313640),(391,23,1,4,108032,1,1,0,1585313676),(392,23,1,4,108025,1,1,0,1585313694),(393,23,1,4,1890,1,29,0,1585313794),(394,25,1,4,2261,1,1,0,1585313835),(395,25,1,4,10103,1,1,0,1585313846),(396,25,1,4,762,1,1,0,1585313936),(397,25,1,4,107880,1,1,0,1585313963),(398,25,1,4,101069,1,1,0,1585316594),(399,25,1,4,1640,1,1,0,1585316615),(400,25,1,4,19025,1,1,0,1585984015),(401,25,1,2,19025,0,0,0,1585316693),(402,25,1,4,48753,1,1,0,1585378884),(403,25,1,4,107980,1,1,0,1585316847),(404,25,1,4,108043,1,1,0,1585316930),(405,25,1,4,107956,1,1,0,1585316891),(406,25,1,4,108005,1,1,0,1585316987),(407,25,1,4,107970,1,1,0,1585316958),(408,25,1,4,107753,1,1,0,1585317024),(409,6,1,4,108040,1,1,0,1585322848),(410,6,1,4,653,1,1,0,1585885039),(411,15,1,4,48753,1,1,0,1585370354),(412,15,1,4,108050,1,1,0,1585370384),(413,15,1,4,108027,1,1,0,1585370562),(414,25,1,4,653,1,1,0,1585994548),(415,25,1,4,108010,1,1,0,1585373419),(416,25,1,4,107731,1,1,0,1585373527),(417,17,1,4,1422,1,1,0,1585373902),(418,17,1,4,106071,1,1,0,1585718210),(419,17,1,2,106071,0,0,0,1585374027),(420,25,1,4,4261,1,1,0,1585374035),(421,25,1,4,90880,1,1,0,1585374071),(422,25,1,4,97558,1,1,0,1585374181),(423,17,1,4,318,1,1,0,1585560624),(424,17,1,4,1890,1,1,0,1585725869),(425,17,1,4,107512,1,1,0,1585579527),(426,25,1,4,103604,1,1,0,1585379017),(427,17,1,4,108040,1,1,0,1585386292),(428,17,1,4,107965,1,1,0,1585386362),(429,17,1,4,108011,1,1,0,1585386527),(430,17,1,4,108049,1,1,0,1585581883),(431,8,1,4,106636,1,1,0,1585397973),(433,25,1,4,108035,1,1,0,1585399524),(434,25,1,4,107976,1,1,0,1585983986),(435,25,1,4,108048,1,1,0,1585399317),(436,25,1,4,1822,1,2,0,1585399459),(437,6,1,4,107976,1,1,0,1585836705),(438,23,1,4,108056,1,1,0,1585401890),(439,26,1,4,3700,1,1,0,1585403271),(440,8,1,4,9698,1,1,0,1585403733),(441,25,1,4,1821,1,3,0,1585964339),(442,17,1,4,107838,1,1,0,1585449378),(443,17,1,4,108056,1,1,0,1585448620),(444,17,1,4,108035,1,1,0,1585448635),(445,17,1,4,108042,1,1,0,1585448644),(446,17,1,4,108046,1,2,0,1586028596),(447,8,1,4,63329,1,1,0,1585452946),(448,8,1,4,7036,1,4,0,1585452996),(449,8,1,4,107191,1,1,0,1585453149),(450,8,1,2,107191,0,0,0,1585453068),(451,8,1,4,62071,1,4,0,1585453127),(452,8,1,4,762,1,1,0,1585453175),(453,8,1,4,108052,1,1,0,1585453201),(454,20,1,4,108049,1,1,0,1585464869),(455,23,1,4,107903,1,1,0,1585465095),(456,23,1,4,107908,1,1,0,1585465137),(457,23,1,4,653,1,1,0,1585465209),(458,23,1,4,43,1,1,0,1585483878),(459,31,1,4,108028,1,1,0,1585498093),(460,31,1,4,108027,1,1,0,1585498117),(461,31,1,4,108024,1,1,0,1585498139),(463,31,1,2,108024,0,0,0,1585498152),(464,31,1,4,108012,1,1,0,1585498181),(465,31,1,4,107731,1,1,0,1585526766),(466,31,1,4,103257,1,1,0,1585526774),(467,27,1,4,107864,1,1,0,1585541799),(476,17,1,4,108050,1,1,0,1585581919),(469,27,1,4,108046,1,1,0,1585541812),(470,27,1,4,108050,1,1,0,1585541827),(471,27,1,4,108049,1,1,0,1585541840),(472,27,1,4,107625,1,1,0,1585541854),(473,27,1,4,107903,1,1,0,1585542233),(475,8,1,4,107181,1,1,0,1585557918),(477,23,1,4,186,1,1,0,1585610564),(478,32,1,4,762,1,1,0,1585752340),(479,34,1,4,48639,1,1,0,1585668883),(480,34,1,4,108035,1,1,0,1585668942),(481,6,1,4,318,1,1,0,1585884953),(482,6,1,4,108046,1,5,0,1585894021),(483,35,1,4,48753,1,1,0,1585756013),(484,35,1,2,48753,0,0,0,1585726481),(485,35,1,4,653,1,1,0,1585726774),(486,8,1,4,1422,1,1,0,1585727004),(487,17,1,4,1821,1,1,0,1585899094),(488,8,1,4,108035,1,1,0,1585735064),(489,35,1,4,1890,1,1,0,1585884741),(490,35,1,4,107731,1,1,0,1585749241),(491,35,1,4,32,1,1,0,1585749245),(492,32,1,4,48753,1,1,0,1585755097),(493,35,1,4,318,1,1,0,1585765442),(494,35,1,4,1954,1,1,0,1585765468),(495,8,1,4,107975,1,1,0,1585799001),(496,6,1,4,107516,1,1,0,1585826976),(497,6,1,4,107945,1,1,0,1585826984),(498,6,1,4,3651,1,1,0,1585831911),(499,6,1,4,108011,1,1,0,1585832567),(500,36,1,4,108050,1,1,0,1585835843),(501,36,1,4,108051,1,1,0,1585835908),(502,6,1,4,19025,1,1,0,1585835891),(503,36,1,4,108048,1,1,0,1585835920),(504,36,1,4,108045,1,3,0,1585835976),(505,36,1,4,108010,1,1,0,1585836008),(506,6,1,2,107625,0,0,0,1585877612),(507,6,1,4,186,1,1,0,1585892841),(508,6,1,4,1890,1,1,0,1585878253),(509,6,1,4,1822,1,1,0,1585878270),(510,6,1,4,103257,1,1,0,1585878275),(511,6,1,4,108001,1,1,0,1585878278),(512,6,1,4,43,1,1,0,1585878281),(513,6,1,4,108045,1,1,0,1585893213),(514,6,1,4,108025,1,1,0,1585879047),(515,6,1,4,108049,1,5,0,1585894004),(516,6,1,4,108050,1,1,0,1585892862),(517,6,1,2,48753,0,0,0,1585880047),(518,35,1,4,1822,1,1,0,1585884730),(519,6,1,4,107975,1,1,0,1585888208),(520,6,1,4,108028,1,1,0,1585888288),(521,6,1,4,107775,1,1,0,1585888939),(522,26,1,4,1422,1,1,0,1585897447),(523,26,1,4,107999,1,1,0,1585897451),(524,26,1,4,653,1,1,0,1585897650),(525,26,1,4,107903,1,1,0,1585897653),(526,37,1,4,1422,1,1,0,1585897842),(527,37,1,4,14906,1,2,0,1585897877),(528,8,1,4,108051,1,1,0,1585897891),(529,37,1,4,48753,1,1,0,1585897933),(531,37,1,4,653,1,1,0,1585897959),(532,38,1,4,43,1,42,0,1585897987),(533,37,1,4,1821,1,1,0,1585897978),(534,38,1,4,107731,1,1,0,1585898015),(535,38,1,4,96374,1,1,0,1585898071),(536,37,1,4,271,1,1,0,1585898371),(537,37,1,4,103604,1,1,0,1585898395),(538,37,1,4,318,1,1,0,1585898634),(539,37,1,4,107838,1,1,0,1585898688),(540,39,1,4,48753,1,1,0,1585898678),(541,39,1,4,318,1,1,0,1585898707),(542,40,1,4,48753,1,1,0,1585898858),(543,40,1,2,48753,0,0,0,1585898874),(544,40,1,4,108050,1,1,0,1585898883),(545,17,1,4,1822,1,1,0,1585898895),(549,40,1,4,653,1,1,0,1585898984),(548,17,1,4,107945,1,1,0,1585898955),(550,40,1,2,653,0,0,0,1585899007),(551,8,1,4,108050,1,1,0,1585924590),(552,24,1,4,48753,1,1,0,1585907890),(553,24,1,4,653,1,1,0,1585908103),(554,24,1,4,1890,1,1,0,1585908078),(555,41,1,4,48753,1,1,0,1585928289),(556,17,1,4,271,1,1,0,1585921238),(557,17,1,4,103257,1,1,0,1585921257),(558,8,1,4,107375,1,1,0,1585924627),(559,25,1,4,108053,1,1,0,1585964499),(560,36,1,4,653,1,1,0,1585972642),(561,38,1,4,318,1,1,0,1585978756),(562,25,1,4,108039,1,1,0,1585984047),(563,28,1,4,653,1,1,0,1585984200),(564,28,1,4,318,1,1,0,1585984212),(565,25,1,4,318,1,1,0,1585997662),(566,43,1,4,48753,1,1,0,1586004291),(568,43,1,4,43,1,1,0,1586004325),(569,43,1,4,32,1,1,0,1586004333),(570,43,1,4,108001,1,1,0,1586004361),(571,26,1,4,318,1,1,0,1586050106),(572,26,1,4,186,1,1,0,1586050136),(573,26,1,4,107625,1,1,0,1586050172),(574,26,1,4,107740,1,1,0,1586050210),(575,26,1,4,555,1,1,0,1586055408),(576,26,1,4,48753,1,1,0,1586055424),(577,44,1,4,107625,1,1,0,1586060796),(578,44,1,2,107625,0,0,0,1586060819),(579,44,1,4,107209,1,1,0,1586060841),(580,44,1,4,1640,1,1,0,1586060967),(581,17,1,4,118,1,1,0,1586104773);
/*!40000 ALTER TABLE `mac_ulog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_user`
--

DROP TABLE IF EXISTS `mac_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL DEFAULT '',
  `user_pwd` varchar(32) NOT NULL DEFAULT '',
  `user_nick_name` varchar(30) NOT NULL DEFAULT '',
  `user_qq` varchar(16) NOT NULL DEFAULT '',
  `user_email` varchar(30) NOT NULL DEFAULT '',
  `user_phone` varchar(16) NOT NULL DEFAULT '',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_portrait` varchar(100) NOT NULL DEFAULT '',
  `user_portrait_thumb` varchar(100) NOT NULL DEFAULT '',
  `user_openid_qq` varchar(40) NOT NULL DEFAULT '',
  `user_openid_weixin` varchar(40) NOT NULL DEFAULT '',
  `user_question` varchar(255) NOT NULL DEFAULT '',
  `user_answer` varchar(255) NOT NULL DEFAULT '',
  `user_points` int(10) unsigned NOT NULL DEFAULT '0',
  `user_points_froze` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_reg_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_last_login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `user_login_num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_extend` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_random` varchar(32) NOT NULL DEFAULT '',
  `user_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_2` int(10) unsigned NOT NULL DEFAULT '0',
  `user_pid_3` int(10) unsigned NOT NULL DEFAULT '0',
  `user_uuid` varchar(255) NOT NULL COMMENT '设备标识',
  `user_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `type_id` (`group_id`) USING BTREE,
  KEY `user_name` (`user_name`),
  KEY `user_reg_time` (`user_reg_time`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_user`
--

LOCK TABLES `mac_user` WRITE;
/*!40000 ALTER TABLE `mac_user` DISABLE KEYS */;
INSERT INTO `mac_user` VALUES (1,2,'111111','96e79218965eb72c92a549dd5a330112','','','','',1,'','','','','','',121,0,0,0,1582967455,1700635231,1582870443,0,2,0,'66fa596c9d3c54899b6b3bd789e9e458',1582870740,0,0,0,'','网站注册用户'),(2,2,'222222','e3ceb5881a0a1fdaad01296d7554868d','','','','',1,'','','','','','',30,0,1582874098,0,1582874098,0,0,0,1,0,'eaadf89c94a587eecd53bb8483177487',0,1,0,0,'','网站注册用户'),(3,2,'333333','1a100d2c0dab19c4430e7d73762b3423','rr','','','',1,'upload/user/3/3.jpg','','','','','',10,0,1582874159,0,1582874159,0,0,0,1,0,'afc1a4cd4e01f02f73c41ca4dfaed93c',0,2,1,0,'','网站注册用户'),(4,2,'22','d41d8cd98f00b204e9800998ecf8427e','','','','',1,'','','','','','',10,0,1582880280,0,0,0,0,0,0,0,'',1582966680,0,0,0,'','网站注册用户'),(5,2,'','d41d8cd98f00b204e9800998ecf8427e','','','','',1,'','','','','','',10,0,1582881865,0,1582990333,1700635231,1582990311,1700635231,6,0,'871b971d65edd24770c760bd6d801bac',1582968265,0,0,0,'',NULL),(6,3,'17693103997','f379eaf3c831b04de153469d1bec345e','小哥哥乖乖','','','17693103997',1,'http://qy.redlk.com/upload/user/6/bb2c86ba033f7c23d2d94073e43172f8.jpg','','','','','',0,0,1582888455,1700635231,1585723769,0,1585322845,1961412860,5,0,'e92d228d60a1760b353b793eb299b8de',1586489398,0,0,0,'','App注册用户'),(7,3,'17693103998','96e79218965eb72c92a549dd5a330112','17693103998','','','17693103998',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxz6gmitj20b40b4js2.jpg','','','','','',10,0,1582888868,1700635231,1582890480,1700635231,1582890232,1700635231,2,0,'2a8eea95469861791e9ac67889f5d5a6',1582975268,2,1,0,'','App注册用户'),(8,2,'17693102669','96e79218965eb72c92a549dd5a330112','小宝宝','','','17693102669',1,'http://qy.redlk.com/upload/user/8/b1ce4dbb3365c2f7dff05f723bb73d09.jpg','','','','','',1,0,1582893048,1700635231,1585974350,1918163198,1585901911,0,767,0,'c28bba9748d5c28f6ab98c7e9a6da19b',1585971490,0,0,0,'59bb2f130e70052e','App注册用户'),(33,3,'18840105227','4702df682e5eac87de9542e916c19a02','18840105227','','','18840105227',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1fzjxyqlvb0j20b40b40t9.jpg','','','','','',10,0,1585668697,1911276920,0,0,0,0,0,0,'',1585755097,0,0,0,'029d2c1308f6241a','App注册用户'),(9,3,'6666','e9510081ac30ffa83f10b68cde1cac07','6666','','','6666',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1g1p9pnd6ybj20b40b4gm1.jpg','','','','','',10,0,1584955046,0,0,0,0,0,0,0,'',1585041445,0,0,0,'yyyyyy','66'),(10,3,'66667','e9510081ac30ffa83f10b68cde1cac07','66667','','','66667',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1g1p9qjav32j20b40b4dgt.jpg','','','','','',10,0,1584955128,0,0,0,0,0,0,0,'',1585041528,0,0,0,'yyyyyy','66'),(11,3,'17693103995','96e79218965eb72c92a549dd5a330112','17693103995','','','17693103995',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1g1p9al87bqj20b40b4q3h.jpg','','','','','',28,0,1584955276,0,1584969497,1961412860,0,0,1,0,'2ff32c04f9f868ad9d0f7d6b4b30f6bb',1586669317,0,0,0,'ff4400305ab1b552','App注册用户'),(12,3,'123110','96e79218965eb72c92a549dd5a330112','','','','',1,'','','','','','',0,0,1585235791,0,1585235842,0,1585235824,0,3,0,'d89a8ab0736d67bd87d8d722e1650a7a',1586099870,0,0,0,'',NULL),(13,3,'17693105665','96e79218965eb72c92a549dd5a330112','17693105665','','','17693105665',1,'https://tva1.sinaimg.cn/large/9bd9b167ly1g1p9ponfjoj20b40b4aai.jpg','','','','','',10,0,1585277190,0,0,0,0,0,0,0,'',1585363590,0,0,0,'d1090c9efcaaa2bc','App注册用户'),(14,3,'17586321524','5b1b68a9abf4d2cd155c81a9225fd158','17586321524','','','17586321524',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxynnu8nj20b40b40t8.jpg','','','','','',10,0,1585277585,0,0,0,0,0,0,0,'',1585363985,0,0,0,'d1090c9efcaaa2bc','App注册用户'),(15,3,'15545594696','e10adc3949ba59abbe56e057f20f883e','15545594696','','','15545594696',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1fzjxyiihakj20b40b4jru.jpg','','','','','',9,0,1585281031,0,1585370274,0,1585281040,0,2,0,'6246986402a2d567a70f358ddde55475',1585456749,0,0,0,'BCBE1853-6F31-4272-8C5A-F389B60B3377','App注册用户'),(16,3,'18772683566','937addf1d4c6016b3e82b7b3c640af3a','18772683566','','','18772683566',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxyoduq9j20b40b40t8.jpg','','','','','',10,0,1585281069,0,1585281081,0,0,0,1,0,'0303bb0c48b739c1561c7cbf808074d1',1585367469,0,0,0,'1441a20ca514318b','App注册用户'),(17,3,'13123606482','25f9e794323b453885f5181f1b624d0b','雨中漫步','','','13123606482',1,'http://qy.redlk.com/upload/user/7/61fdf91166f15e263a28bda2bfa822c8.jpg','','','','','',0,0,1585281401,1867902209,1585969395,1867904587,1585920968,1867904587,5,0,'4aa9aeb96b18e840e26a705e32651810',1586231801,0,0,0,'869033020767209','App注册用户'),(18,3,'13587336668','e10adc3949ba59abbe56e057f20f883e','13587336668','','','13587336668',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxzlgf8uj20b40b40to.jpg','','','','','',10,0,1585281418,0,1585281429,0,0,0,1,0,'a258cb233d1bce27672aecf974301506',1585367818,0,0,0,'77187e3c570913d1','App注册用户'),(19,3,'13930953264','5763317dd725182093ea049d0e9e8bef','13930953264','','','13930953264',1,'https://tva1.sinaimg.cn/large/9bd9b167gy1g1p9pzy524j20b40b4aam.jpg','','','','','',10,0,1585281683,2031875813,1585281691,2031875813,0,0,1,0,'7bbbaff45c005cd89bdc7281d29b0c77',1585368082,0,0,0,'c71e80d72fc71836','App注册用户'),(20,3,'13333858850','e10adc3949ba59abbe56e057f20f883e','13333858850','','','13333858850',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1fzjxy7sbqpj20b40b4jrn.jpg','','','','','',9,0,1585288465,0,1585288547,0,1585288514,0,3,0,'04a5335a26bd5832bec8f6216d707da0',1585878393,0,0,0,'867568041083708','App注册用户'),(21,3,'13333858850','e10adc3949ba59abbe56e057f20f883e','13333858850','','','13333858850',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1g1p9vzfbygj20b40b40tg.jpg','','','','','',10,0,1585288465,0,1585288547,0,1585288514,0,3,0,'04a5335a26bd5832bec8f6216d707da0',1585374864,0,0,0,'867568041083708','App注册用户'),(22,3,'18539610253','71cd8f985ebc954d4c9f4701c2d110ac','18539610253','','','18539610253',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1g1p9ankcgyj20b40b4gm7.jpg','','','','','',10,0,1585296140,1932789665,1585296157,1932789665,0,0,1,0,'522c5e5f2094cabdf47a61afb0b6303d',1585382540,0,0,0,'748f52facaaac07a','App注册用户'),(23,3,'13094630120','e10adc3949ba59abbe56e057f20f883e','13094630120','','','13094630120',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1g1p9b9t15bj20b40b4757.jpg','','','','','',9,0,1585303336,1866233462,1585303345,1866233462,0,0,1,0,'c6dc8d0df6ebfbaf4843dc14592cceb3',1585551488,0,0,0,'C3680BF4-2924-487C-A331-1616A07C1816','App注册用户'),(24,3,'13144468641','e10adc3949ba59abbe56e057f20f883e','13144468641','','','13144468641',1,'https://tva1.sinaimg.cn/large/9bd9b167ly1fzjxysrugcj20b40b4mxp.jpg','','','','','',8,0,1585309898,1885467658,1585907874,1885446341,1585309910,1885467658,2,0,'d0c9cafd16efd9520d2be6c9733d6518',1585994283,0,0,0,'6d17473e846a25','App注册用户'),(25,3,'17612212593','e10adc3949ba59abbe56e057f20f883e','17612212593','','','17612212593',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1g1p9pkcfo5j20b40b4t93.jpg','','','','','',9,0,1585312635,1963628626,1585964319,0,1585312648,1963628626,2,0,'e66453b46e7ad6fc83b554b5eedb5201',1586050735,0,0,0,'863026037494086','App注册用户'),(26,3,'16608580856','96e79218965eb72c92a549dd5a330112','16608580856','','','16608580856',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxyepjewj20b40b4dg9.jpg','','','','','',2,0,1585403230,0,1585897384,827486646,1585403244,0,2,0,'10736a793d17e9d99691a69ac0de00bf',1586588639,0,0,0,'73bf903ddb86913f','App注册用户'),(27,3,'13058567905','d47577b1e72355fd72cef8428955b5f4','13058567905','','','13058567905',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1g1p9b4f1vbj20b40b40tj.jpg','','','','','',9,0,1585405521,2028935880,1585406287,2028935880,1585405536,2028935880,2,0,'1d38500ece4e1f53719d5a9e4566e1ac',1585628629,0,0,0,'26fc0039cb77a1b6','App注册用户'),(28,3,'13182828261','92317b5fed05eb6efad58cc8df5ccfa0','13182828261','','','13182828261',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1g1p9qh1aipj20b40b4my1.jpg','','','','','',10,0,1585427432,463259842,1585427448,463259842,0,0,1,0,'ca11b2cba137e4438c7eb3df251de261',1585513831,0,0,0,'831cc4b3cbe2fc21','App注册用户'),(29,3,'15236606204','f573e3596f6de36f65c1d8d3681092b9','15236606204','','','15236606204',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxzbleolj20b40b4q3o.jpg','','','','','',10,0,1585445826,2053123735,1585445828,2053123735,0,0,1,0,'5857ff4af69463af49322a673304f137',1585532225,0,0,0,'65b7aa0b3d78af90','App注册用户'),(30,3,'15613385752','0062d21c1a97acad0fff653df56849b2','15613385752','','','15613385752',1,'https://tva1.sinaimg.cn/large/9bd9b167ly1g1p9adsm87j20b40b4aai.jpg','','','','','',0,0,1585461260,2095876776,1585461276,2095876776,0,0,1,0,'8aae736168fbc30bb8f79a6c13aa6368',1586411660,0,0,0,'56788670c389c7a9','App注册用户'),(31,2,'15511712231','e10adc3949ba59abbe56e057f20f883e','15511712231','','','15511712231',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxzb1nxvj20b40b4aas.jpg','','','','','',10,0,1585498021,0,1585730260,0,1585498030,0,2,0,'fc04084636701ee4912f2ba6dddc61ad',1585584421,0,0,0,'a53bf6dcb7aa5a03','App注册用户'),(32,3,'17630032296','4c4e652110356acb025dbf7f6be6e1ae','17630032296','','','17630032296',1,'https://tva2.sinaimg.cn/large/9bd9b167gy1g1p9q4bx2lj20b40b43z5.jpg','','','','','',9,0,1585629886,0,1585755031,0,1585629904,0,2,0,'0c7fea02d53e1a409341f0a46104c33b',1585838736,0,0,0,'866790037488011','App注册用户'),(34,3,'13478760942','8d49868d770fc836b020f4ceb0ff8a40','13478760942','','','13478760942',1,'https://tva4.sinaimg.cn/large/9bd9b167gy1g1p9q98l0yj20b40b4wf6.jpg','','','','','',10,0,1585668789,1911276920,1585668811,1911276920,0,0,1,0,'b8eded9199ebb4cec91aa899b27f0691',1585755189,0,0,0,'029d2c1308f6241a','App注册用户'),(35,3,'13664211510','6cad143ae2ad7e77e61fe1d21f5cd320','13664211510','','','13664211510',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxy7kc2cj20b40b40sz.jpg','','','','','',10,0,1585726383,663754024,1585726404,663754024,0,0,1,0,'fc340482eac435d29039bf675f021185',1585812782,0,0,0,'15f2aa61aa8255ab','App注册用户'),(36,3,'18763528824','4297f44b13955235245b2497399d7a93','18763528824','','','18763528824',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1fzjxz1wkj2j20b40b4gm8.jpg','','','','','',10,0,1585835831,1894860851,1585835840,1894860851,0,0,1,0,'5152ce9cfc06a07db2307117423e0b01',1585922231,0,0,0,'869720039362218','App注册用户'),(37,3,'18815839980','a38710bee19b01ea7ed08f4344e2f217','18815839980','','','18815839980',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1g1p9al5yzzj20b40b474u.jpg','','','','','',10,0,1585897784,2101948199,1585897802,2101948199,0,0,1,0,'ff2bdabed49e28838e4197a23d13c7c2',1585984184,0,0,0,'3eb68a49c212c3ae','App注册用户'),(38,3,'13219233371','4af98ff496f55e3b7d31e5566b6f0483','13219233371','','','13219233371',1,'https://tva1.sinaimg.cn/large/9bd9b167ly1fzjxzjyyiuj20b40b4wfe.jpg','','','','','',10,0,1585897946,1023363287,1585897958,1023363287,0,0,1,0,'ab5c471df2c19dc7487170396761f0bf',1585984346,0,0,0,'dfdba904600de3f9','App注册用户'),(39,3,'18528190880','09745442a7e3d47f29d7db01920744cc','18528190880','','','18528190880',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1fzjxyzrtpej20b40b4dgf.jpg','','','','','',10,0,1585898655,1999101804,1585898676,1999101804,0,0,1,0,'33f479cebf79050f8b1f23cb15d499b8',1585985055,0,0,0,'4f731bda6ff16e61','App注册用户'),(40,3,'15962219047','40c5cec3b60b739fae30e98818ad930c','15962219047','','','15962219047',1,'https://tva4.sinaimg.cn/large/9bd9b167ly1fzjxylryp3j20b40b4mxn.jpg','','','','','',7,0,1585898746,606660715,1585898757,606660715,0,0,1,0,'18ba5bfdeede7e94b0ae1d933f350a00',1586244346,0,0,0,'320443e2f1eec2c2','App注册用户'),(41,3,'15345866164','e10adc3949ba59abbe56e057f20f883e','15345866164','','','15345866164',1,'https://tva1.sinaimg.cn/large/9bd9b167ly1fzjxzhfyx2j20b40b4my1.jpg','','','','','',10,0,1585908518,605493995,1585908527,605493995,0,0,1,0,'df491e06ab39b47ee384252c1e58547c',1585994918,0,0,0,'2d8d1994ca2f6311','App注册用户'),(42,3,'18665201588','12b6e7cca1ca35aacc1f54a5a89b7d85','18665201588','','','18665201588',1,'https://tva2.sinaimg.cn/large/9bd9b167ly1fzjxyug7cjj20b40b40ta.jpg','','','','','',10,0,1585969738,2028701427,1585969750,2028701427,0,0,1,0,'83e819ed5896dd6894b4e71dbf1b0e7a',1586056138,0,0,0,'c73a96fc0e313e18','App注册用户'),(43,3,'15936992577','e10adc3949ba59abbe56e057f20f883e','15936992577','','','15936992577',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1g1p9pvzab5j20b40b474t.jpg','','','','','',10,0,1586004279,719796878,1586004288,719796878,0,0,1,0,'b67cb2c5177edd1d766421d0a5755ba2',1586090678,0,0,0,'48d2d752b225c9ad','App注册用户'),(44,3,'18305294569','98641e30ace18a76f07bd7e5fbf7cd6c','18305294569','','','18305294569',1,'https://tva3.sinaimg.cn/large/9bd9b167ly1fzjxywfuagj20b40b40ta.jpg','','','','','',10,0,1586060779,0,1586060791,0,0,0,1,0,'2a817ad0da1f2f7b8c6586ea555d159a',1586147179,0,0,0,'869899042462932','App注册用户');
/*!40000 ALTER TABLE `mac_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_visit`
--

DROP TABLE IF EXISTS `mac_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_visit` (
  `visit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `visit_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `visit_ly` varchar(100) NOT NULL DEFAULT '',
  `visit_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`visit_id`),
  KEY `user_id` (`user_id`),
  KEY `visit_time` (`visit_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_visit`
--

LOCK TABLES `mac_visit` WRITE;
/*!40000 ALTER TABLE `mac_visit` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_vod`
--

DROP TABLE IF EXISTS `mac_vod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_vod` (
  `vod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(6) NOT NULL DEFAULT '0',
  `type_id_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_name` varchar(255) NOT NULL DEFAULT '',
  `vod_sub` varchar(255) NOT NULL DEFAULT '',
  `vod_en` varchar(255) NOT NULL DEFAULT '',
  `vod_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_letter` char(1) NOT NULL DEFAULT '',
  `vod_color` varchar(6) NOT NULL DEFAULT '',
  `vod_tag` varchar(100) NOT NULL DEFAULT '',
  `vod_class` varchar(255) NOT NULL DEFAULT '',
  `vod_pic` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `vod_pic_slide` varchar(255) NOT NULL DEFAULT '',
  `vod_actor` varchar(255) NOT NULL DEFAULT '',
  `vod_director` varchar(255) NOT NULL DEFAULT '',
  `vod_writer` varchar(100) NOT NULL DEFAULT '',
  `vod_behind` varchar(100) NOT NULL DEFAULT '',
  `vod_blurb` varchar(255) NOT NULL DEFAULT '',
  `vod_remarks` varchar(100) NOT NULL DEFAULT '',
  `vod_pubdate` varchar(100) NOT NULL DEFAULT '',
  `vod_total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_serial` varchar(20) NOT NULL DEFAULT '0',
  `vod_tv` varchar(30) NOT NULL DEFAULT '',
  `vod_weekday` varchar(30) NOT NULL DEFAULT '',
  `vod_area` varchar(20) NOT NULL DEFAULT '',
  `vod_lang` varchar(10) NOT NULL DEFAULT '',
  `vod_year` varchar(10) NOT NULL DEFAULT '',
  `vod_version` varchar(30) NOT NULL DEFAULT '',
  `vod_state` varchar(30) NOT NULL DEFAULT '',
  `vod_author` varchar(60) NOT NULL DEFAULT '',
  `vod_jumpurl` varchar(150) NOT NULL DEFAULT '',
  `vod_tpl` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_play` varchar(30) NOT NULL DEFAULT '',
  `vod_tpl_down` varchar(30) NOT NULL DEFAULT '',
  `vod_isend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_copyright` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_points` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_points_play` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_points_down` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_duration` varchar(10) NOT NULL DEFAULT '',
  `vod_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vod_time` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_trysee` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vod_douban_id` int(10) unsigned NOT NULL DEFAULT '0',
  `vod_douban_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `vod_reurl` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_vod` varchar(255) NOT NULL DEFAULT '',
  `vod_rel_art` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_play` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_play_url` varchar(255) NOT NULL DEFAULT '',
  `vod_pwd_down` varchar(10) NOT NULL DEFAULT '',
  `vod_pwd_down_url` varchar(255) NOT NULL DEFAULT '',
  `vod_content` text NOT NULL,
  `vod_play_from` varchar(255) NOT NULL DEFAULT '',
  `vod_play_server` varchar(255) NOT NULL DEFAULT '',
  `vod_play_note` varchar(255) NOT NULL DEFAULT '',
  `vod_play_url` mediumtext NOT NULL,
  `vod_down_from` varchar(255) NOT NULL DEFAULT '',
  `vod_down_server` varchar(255) NOT NULL DEFAULT '',
  `vod_down_note` varchar(255) NOT NULL DEFAULT '',
  `vod_down_url` mediumtext NOT NULL,
  `vod_plot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vod_plot_name` mediumtext NOT NULL,
  `vod_plot_detail` mediumtext NOT NULL,
  PRIMARY KEY (`vod_id`),
  KEY `type_id` (`type_id`) USING BTREE,
  KEY `type_id_1` (`type_id_1`) USING BTREE,
  KEY `vod_level` (`vod_level`) USING BTREE,
  KEY `vod_hits` (`vod_hits`) USING BTREE,
  KEY `vod_letter` (`vod_letter`) USING BTREE,
  KEY `vod_name` (`vod_name`) USING BTREE,
  KEY `vod_year` (`vod_year`) USING BTREE,
  KEY `vod_area` (`vod_area`) USING BTREE,
  KEY `vod_lang` (`vod_lang`) USING BTREE,
  KEY `vod_tag` (`vod_tag`) USING BTREE,
  KEY `vod_class` (`vod_class`) USING BTREE,
  KEY `vod_lock` (`vod_lock`) USING BTREE,
  KEY `vod_up` (`vod_up`) USING BTREE,
  KEY `vod_down` (`vod_down`) USING BTREE,
  KEY `vod_en` (`vod_en`) USING BTREE,
  KEY `vod_hits_day` (`vod_hits_day`) USING BTREE,
  KEY `vod_hits_week` (`vod_hits_week`) USING BTREE,
  KEY `vod_hits_month` (`vod_hits_month`) USING BTREE,
  KEY `vod_plot` (`vod_plot`) USING BTREE,
  KEY `vod_points_play` (`vod_points_play`) USING BTREE,
  KEY `vod_points_down` (`vod_points_down`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `vod_time_add` (`vod_time_add`) USING BTREE,
  KEY `vod_time` (`vod_time`) USING BTREE,
  KEY `vod_time_make` (`vod_time_make`) USING BTREE,
  KEY `vod_actor` (`vod_actor`) USING BTREE,
  KEY `vod_director` (`vod_director`) USING BTREE,
  KEY `vod_score_all` (`vod_score_all`) USING BTREE,
  KEY `vod_score_num` (`vod_score_num`) USING BTREE,
  KEY `vod_total` (`vod_total`) USING BTREE,
  KEY `vod_score` (`vod_score`) USING BTREE,
  KEY `vod_version` (`vod_version`),
  KEY `vod_state` (`vod_state`),
  KEY `vod_isend` (`vod_isend`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_vod`
--

LOCK TABLES `mac_vod` WRITE;
/*!40000 ALTER TABLE `mac_vod` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_vod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_website`
--

DROP TABLE IF EXISTS `mac_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_website` (
  `website_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type_id_1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `website_name` varchar(60) NOT NULL DEFAULT '',
  `website_sub` varchar(255) NOT NULL DEFAULT '',
  `website_en` varchar(255) NOT NULL DEFAULT '',
  `website_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `website_letter` char(1) NOT NULL DEFAULT '',
  `website_color` varchar(6) NOT NULL DEFAULT '',
  `website_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `website_sort` int(10) NOT NULL DEFAULT '0',
  `website_jumpurl` varchar(255) NOT NULL DEFAULT '',
  `website_pic` varchar(255) NOT NULL DEFAULT '',
  `website_logo` varchar(255) NOT NULL DEFAULT '',
  `website_area` varchar(20) NOT NULL DEFAULT '',
  `website_lang` varchar(10) NOT NULL DEFAULT '',
  `website_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `website_time` int(10) unsigned NOT NULL DEFAULT '0',
  `website_time_add` int(10) unsigned NOT NULL DEFAULT '0',
  `website_time_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `website_time_make` int(10) unsigned NOT NULL DEFAULT '0',
  `website_hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_hits_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_hits_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_hits_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_score` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `website_score_all` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_score_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_down` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_referer` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_referer_day` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_referer_week` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_referer_month` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `website_tag` varchar(100) NOT NULL DEFAULT '',
  `website_class` varchar(255) NOT NULL DEFAULT '',
  `website_remarks` varchar(100) NOT NULL DEFAULT '',
  `website_tpl` varchar(30) NOT NULL DEFAULT '',
  `website_blurb` varchar(255) NOT NULL DEFAULT '',
  `website_content` mediumtext NOT NULL,
  PRIMARY KEY (`website_id`),
  KEY `type_id` (`type_id`),
  KEY `type_id_1` (`type_id_1`),
  KEY `website_name` (`website_name`),
  KEY `website_en` (`website_en`),
  KEY `website_letter` (`website_letter`),
  KEY `website_sort` (`website_sort`),
  KEY `website_lock` (`website_lock`),
  KEY `website_time` (`website_time`),
  KEY `website_time_add` (`website_time_add`),
  KEY `website_hits` (`website_hits`),
  KEY `website_hits_day` (`website_hits_day`),
  KEY `website_hits_week` (`website_hits_week`),
  KEY `website_hits_month` (`website_hits_month`),
  KEY `website_time_make` (`website_time_make`),
  KEY `website_score` (`website_score`),
  KEY `website_score_all` (`website_score_all`),
  KEY `website_score_num` (`website_score_num`),
  KEY `website_up` (`website_up`),
  KEY `website_down` (`website_down`),
  KEY `website_level` (`website_level`),
  KEY `website_tag` (`website_tag`),
  KEY `website_class` (`website_class`),
  KEY `website_referer` (`website_referer`),
  KEY `website_referer_day` (`website_referer_day`),
  KEY `website_referer_week` (`website_referer_week`),
  KEY `website_referer_month` (`website_referer_month`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_website`
--

LOCK TABLES `mac_website` WRITE;
/*!40000 ALTER TABLE `mac_website` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_website` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-06  0:42:05
