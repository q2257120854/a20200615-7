/*
Navicat MySQL Data Transfer

Source Server         : 9cqj2f5j.2377.dnstoo.com_5504
Source Server Version : 50535
Source Host           : 9cqj2f5j.2377.dnstoo.com:5504
Source Database       : newblfaka

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2019-04-22 12:49:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bl_acp`
-- ----------------------------
DROP TABLE IF EXISTS `bl_acp`;
CREATE TABLE `bl_acp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(300) NOT NULL DEFAULT '',
  `userid` text NOT NULL,
  `userkey` text NOT NULL,
  `is_ste` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用 1是 0否',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_acp
-- ----------------------------
INSERT INTO `bl_acp` VALUES ('1', 'zfbf2f', '支付宝当面付', '应用appid', '支付宝公钥', '开发者私钥', '0');
-- ----------------------------
-- Table structure for `bl_admin`
-- ----------------------------
DROP TABLE IF EXISTS `bl_admin`;
CREATE TABLE `bl_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminname` varchar(20) NOT NULL,
  `adminpass` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `is_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `limits` text,
  `limit_ip` varchar(300) NOT NULL DEFAULT '',
  `is_limit_ip` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_admin
-- ----------------------------
INSERT INTO `bl_admin` VALUES ('1', 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', '4718737b9f2f6e2c225fe605d6c7234330e7e7e4', '0', '{\"limit_ip\":\"\",\"is_limit_ip\":\"0\",\"set\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"mailtpl\":\"\\u90ae\\u4ef6\\u6a21\\u7248\",\"admins\":\"\\u7ba1\\u7406\\u5458\\u5217\\u8868\",\"pwd\":\"\\u4fee\\u6539\\u5bc6\\u7801\",\"logs\":\"\\u767b\\u5f55\\u65e5\\u5fd7\",\"cog\":\"\\u5bfc\\u822a\\u8bbe\\u7f6e\",\"link\":\"\\u53cb\\u60c5\\u94fe\\u63a5\",\"user\":\"\\u7528\\u6237\\u5217\\u8868\",\"ulevel\":\"\\u7528\\u6237\\u7ea7\\u522b\",\"orders\":\"\\u8ba2\\u5355\\u5217\\u8868\",\"gdclass\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"goods\":\"\\u5546\\u54c1\\u5217\\u8868\",\"kami\":\"\\u5361\\u5bc6\\u7ba1\\u7406\",\"acp\":\"\\u63a5\\u5165\\u4fe1\\u606f\"}', '', '0');

-- ----------------------------
-- Table structure for `bl_adminlogs`
-- ----------------------------
DROP TABLE IF EXISTS `bl_adminlogs`;
CREATE TABLE `bl_adminlogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminid` int(10) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adminid` (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `bl_config`
-- ----------------------------
DROP TABLE IF EXISTS `bl_config`;
CREATE TABLE `bl_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(50) NOT NULL,
  `siteurl` varchar(50) NOT NULL,
  `siteinfo` varchar(50) NOT NULL DEFAULT '',
  `keyword` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(300) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `tel` varchar(12) NOT NULL DEFAULT '',
  `qq` varchar(12) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `icpcode` varchar(20) NOT NULL DEFAULT '',
  `copyright` varchar(500) NOT NULL DEFAULT '',
  `stacode` varchar(500) NOT NULL DEFAULT '',
  `smtp_server` varchar(20) NOT NULL DEFAULT '',
  `smtp_email` varchar(50) NOT NULL DEFAULT '',
  `smtp_pwd` varchar(20) NOT NULL DEFAULT '',
  `tips` text,
  `ctime` varchar(100) DEFAULT NULL,
  `email_state` tinyint(1) NOT NULL DEFAULT '0',
  `ismail_kuc` tinyint(1) NOT NULL DEFAULT '0',
  `ismail_num` int(20) DEFAULT '0',
  `serive_token` varchar(255) DEFAULT NULL,
  `indexmode` int(1) DEFAULT '0' COMMENT '首页显示模式 0为分类模式 1列表模式 2详情模式',
  `xieyi` text,
  `mp3list` text NOT NULL,
  `mp3_state` tinyint(1) NOT NULL DEFAULT '0',
  `bodyimage` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_config
-- ----------------------------
INSERT INTO `bl_config` VALUES ('1', '伯乐发卡系统', 'https://www.kxdao.net/', '伯乐发卡系统 安全稳定', '伯乐发卡系统 安全稳定', '伯乐发卡系统 安全稳定', 'admin@zysxtd.com', '400-000-0000', '41122836', '伯乐建站', 'ICP备13009591号', 'CopyRight©2019 Bolekami Inc.', '', 'smtp.163.com', 'zysxtd@163.com', 'z123457574123', '<h2>\r\n	<ul class=\"tpl-task-list tpl-task-remind\" style=\"box-sizing:border-box;margin:0px;padding:0px;list-style:none;color:#333333;font-family:\" font-size:18px;white-space:normal;background-color:#ffffff;\"=\"\">\r\n	<li style=\"box-sizing:border-box;margin:0px 0px 7px;padding:10px !important;list-style:none;position:relative;border-bottom:1px solid #F4F6F9;height:auto !important;font-size:14px !important;line-height:22px !important;color:#82949A;\">\r\n		<div class=\"cosA\" style=\"box-sizing:border-box;margin-right:80px;\">\r\n			<span class=\"cosIco\" style=\"box-sizing:border-box;display:inline-block;width:24px;height:24px;vertical-align:middle;color:#FFFFFF;text-align:center;border-radius:3px;background-color:#36C6D3;\"><span class=\"am-icon-bell-o\" style=\"box-sizing:border-box;display:inline-block;\"></span></span> <span style=\"box-sizing:border-box;\">注意：本站为伯乐发卡系统演示站，商品数据只做测试使用！</span> \r\n		</div>\r\n	</li>\r\n	<li style=\"box-sizing:border-box;margin:0px 0px 7px;padding:10px !important;list-style:none;position:relative;border-bottom:1px solid #F4F6F9;height:auto !important;font-size:14px !important;line-height:22px !important;color:#82949A;\">\r\n		<div class=\"cosA\" style=\"box-sizing:border-box;margin-right:80px;\">\r\n			<span class=\"cosIco label-danger\" style=\"box-sizing:border-box;background-color:#36C6D3;display:inline-block;width:24px;height:24px;vertical-align:middle;color:#FFFFFF;text-align:center;border-radius:3px;\"><span class=\"am-icon-bolt\" style=\"box-sizing:border-box;display:inline-block;\"></span></span> 伯乐发卡系统全开源、可二开！\r\n		</div>\r\n	</li>\r\n	<li style=\"box-sizing:border-box;margin:0px 0px 7px;padding:10px !important;list-style:none;position:relative;border-bottom:1px solid #F4F6F9;height:auto !important;font-size:14px !important;line-height:22px !important;color:#82949A;\">\r\n		<div class=\"cosA\" style=\"box-sizing:border-box;margin-right:80px;\">\r\n			<span class=\"cosIco label-info\" style=\"box-sizing:border-box;background-color:#36C6D3;display:inline-block;width:24px;height:24px;vertical-align:middle;color:#FFFFFF;text-align:center;border-radius:3px;\"><span class=\"am-icon-bullhorn\" style=\"box-sizing:border-box;display:inline-block;\"></span></span>下单之前请一定要看完该商品的注意事项再进行下单！\r\n		</div>\r\n	</li>\r\n	<li style=\"box-sizing:border-box;margin:0px 0px 7px;padding:10px !important;list-style:none;position:relative;border-bottom:1px solid #F4F6F9;height:auto !important;font-size:14px !important;line-height:22px !important;color:#82949A;background:#F4F6F9;\">\r\n		<div class=\"cosA\" style=\"box-sizing:border-box;margin-right:80px;\">\r\n			<span class=\"cosIco label-warning\" style=\"box-sizing:border-box;background-color:#36C6D3;display:inline-block;width:24px;height:24px;vertical-align:middle;color:#FFFFFF;text-align:center;border-radius:3px;\"><span class=\"am-icon-plus\" style=\"box-sizing:border-box;display:inline-block;\"></span></span> 软件官网：<a href=\"https://www.kxdao.net/" target=\"_blank\">https://www.zysxtd.com</a> 交流QQ群 ：<a target=\"_blank\" href=\"https://jq.qq.com/?_wv=1027&k=1ve10gvx"><img border=\"0\" src=\"//pub.idqqimg.com/wpa/images/group.png\" alt=\"伯乐建站交流群\" title=\"伯乐建站交流群\" /></a> \r\n		</div>\r\n	</li>\r\n		</ul>\r\n			</h2>', '2019-03-31', '1', '1', '10', 'bolefk2018', '2', '<p><span style=\"font-size:14px;\">            欢迎您使用伯乐商业版全自动发卡平台（专业虚拟数字产品交易平台服务产品）。以下所述条款和条件即构成您与伯乐商业版虚拟数字产品交易平台所达成的协议（以下简称“本协议”）。以下协议根据《中华人民共和国合同法》、《中华人民共和国计算机信息网络国际互联网管理暂行规定》、邮电部《中国公用计算机互联网国际网管理办法》等有关规定制定。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     一、承诺 　　</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">            1. 您确认，在您成为我们的用户之前已充分阅读、理解并接受本协议的全部内容，一旦您使用本服务，即表示您同意遵循本协议之所有约定。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　    2. 您同意，本公司有权随时对本协议内容进行单方面的变更，并以在本网站公告的方式予以公布，无需另行单独通知您；若您在本协议内容公告变更后继续使用本服务的，表示您已充分阅读、理解并接受修改后的协议内容，也将遵循修改后的协议内容使用本服务；若您不同意修改后的协议内容，您应停止使用本服务。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     二、伯乐商业版--专业虚拟数字产品交易平台服务使用的责任和义务　　</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">           1. 您在使用本服务时应遵守中华人民共和国相关法律法规、您所在国家或地区之法令及相关国际惯例，不将本服务用于任何非法目的，也不以任何非法方式使用本服务。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　    2. 您不得利用本服务从事侵害他人合法权益之行为，否则本公司有权拒绝提供本服务，且您应承担所有相关法律责任，因此导致本公司或本公司用户受损的，您应承担赔偿责任。上述行为包括但不限于：</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (1)侵害他人名誉权、隐私权、商业秘密、商标权、著作权、专利权等合法权益。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (2)违反依法定或约定之保密义务。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (3)冒用他人名义使用本服务。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (4)从事不法行为，如制作色情、赌博、病毒、挂马、反动、外挂、私服、钓鱼以及为私服提供任何服务(比如支付)的类似网站。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (5)提供赌博资讯或以任何方式引诱他人参与赌博。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (6)从事任何可能含有电脑病毒或是可能侵害本服务系统、资料之行为。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (7)其他本公司有正当理由认为不适当之行为。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     3. 您理解并同意，本公司不对因下述任一情况导致的任何损害赔偿承担责任，包括但不限于流量、访问、数据等方面的损失或其他无形损失的损害赔偿 (无论本公司是否已被告知该等损害赔偿的可能性)：</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (1)本公司有权基于单方判断，包含但不限于本公司认为您已经违反本协议的明文规定及精神，暂停、中断或终止向您提供本服务或其任何部分，并移除您的资料。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (2) 本公司在发现非法网站或有疑义或有违反法律规定或本协议约定之虞时，有权不经通知先行暂停或终止该域名的解析，并拒绝您使用本服务之部分或全部功能。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (3) 在必要时，本公司无需事先通知即可终止提供本服务，并暂停、关闭或删除该账户及您账号中所有相关资料及档案，如遇到非法域名被关闭，所涉及到的款项将不会退款给您。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     三、 隐私与保护　　</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">             一旦您同意本协议或使用本服务，您即同意本公司按照以下条款来使用和披露您的个人信息。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　      (1) 用户名和密码 　　在您注册为伯乐商业版--专业虚拟数字产品交易平台用户时，我们会要求您设置用户名和密码，以便在您丢失密码时用以确认您的身份。请确保您的账号安全防止泄露密码，如果您发现发现账号和密码有泄露的嫌疑，请及时联系我司处理，在我司采取行动之前，本司对此不负任何责任。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　      (2)注册信息 　　我们有义务保证您在注册我们系统时填写的真实姓名、电话号码、电子邮件地址、身份证号码的其隐私性，并且您同意我们通过电子邮件或者电话号码通知您有关我司有关优惠活动和您在我们系统上面设置的告警通知。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     (3)为了更好的向您提供服务，您同意，本公司有权将您在注册及在使用我们服务的过程中所产生的信息，提供给本司的关联公司。除本协议另有规定外，本公司不对外公开或向第三方提供您的信息，但以下情况除外：</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　      A、事先获得您的明确授权；</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　     　 B、按照本协议的要求进行的披露；</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　      C、根据法律法规的规定；</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　      D、由国家相关部门开具证明，需要调阅您的信息</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　     　 E、您使用伯乐商业版--专业虚拟数字产品交易平台账户成功登录过的其他网站。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　     　 F、为维护本公司及其关联公司的合法权益；</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     四、安全 　　</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">             本司仅以现有技术提供相应的安全措施来保证您的信息不丢失、泄露。尽管有这些安全措施，但本司不保证这些信息的100%安全。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     五、免责条款</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     因下列状况无法正常运作，使您无法使用各项服务时，本公司不承担损害赔偿责任，该状况包括但不限于：</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     1. 由于系统升级或调整期间需要停机维护且停机维护之前做过广告的</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     2. 用户违反本协议条款的约定，导致第三方主张的任何损失或索赔。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     3. 因台风、地震、海啸、洪水、停电、战争、恐怖袭击等不可抗力之因素，造成本公司系统障碍不能执行业务的。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     4. 由于黑客攻击、电信部门技术调整或故障、网站升级、银行方面的问题等原因而造成的服务中断或者延迟。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     六、责任范围及责任限制</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     1. 本公司仅对本协议中列明的责任承担范围负责。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　     　2. 由于服务服务器故障给您造成大范围无法正常销售超过72小时的，除VIP外您无权要求本公司给予经济赔偿。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">     七、法律及争议解决</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     1.本协议适用中华人民共和国法律。如遇本协议有关的某一特定事项缺乏明确法律规定，则应参照通用国际商业惯例和（或）行业惯例。</span></p>\r\n\r\n    <p><span style=\"font-size:14px;\">　　     2.因双方就本协议的签订、履行或解释发生争议，双方应努力友好协商解决。如协商不成，任何一方均有权将争议递交当地人民法院。</span></p>', '{title:\"让我做你的眼睛\",artist:\"伯乐发卡\",mp3:\"http://fdfs.xmcdn.com/group47/M08/D4/1D/wKgKk1tcL_vBL202AAz8jjodJhU873.mp3\",cover:\"http://p4.music.126.net/7VJn16zrictuj5kdfW1qHA==/3264450024433083.jpg?param=106x106\",},\r\n{title:\"往后余生\",artist:\"伯乐发卡\",mp3:\"http://music.163.com/song/media/outer/url?id=571338279.mp3\",cover:\"http://p4.music.126.net/7VJn16zrictuj5kdfW1qHA==/3264450024433083.jpg?param=106x106\",},\r\n{title:\"讲真的\",artist:\"伯乐发卡\",mp3:\"http://music.163.com/song/media/outer/url?id=30987293.mp3\",cover:\"http://p4.music.126.net/7VJn16zrictuj5kdfW1qHA==/3264450024433083.jpg?param=106x106\",},', '1', '/upload/image/20190331/20190331180421_27673.png');

-- ----------------------------
-- Table structure for `bl_gdclass`
-- ----------------------------
DROP TABLE IF EXISTS `bl_gdclass`;
CREATE TABLE `bl_gdclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '分类名称',
  `ord` int(100) DEFAULT '0' COMMENT '商品排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_gdclass
-- ----------------------------
INSERT INTO `bl_gdclass` VALUES ('10', '分类一', '0');

-- ----------------------------
-- Table structure for `bl_goods`
-- ----------------------------
DROP TABLE IF EXISTS `bl_goods`;
CREATE TABLE `bl_goods` (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cid` int(100) NOT NULL COMMENT '分类id',
  `image` varchar(255) NOT NULL COMMENT '主图',
  `gname` varchar(255) NOT NULL COMMENT '商品名称',
  `gmoney` decimal(20,2) NOT NULL DEFAULT '400.00' COMMENT '商品售价',
  `money1` decimal(20,2) NOT NULL DEFAULT '100.00',
  `money2` decimal(20,2) NOT NULL DEFAULT '200.00',
  `money3` decimal(20,2) NOT NULL DEFAULT '100.00',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 自动发卡  1 手工订单',
  `checks` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许重复下单 1是  0否',
  `cont` text COMMENT '商品介绍',
  `onetle` varchar(255) DEFAULT NULL COMMENT '第一个输入框标题',
  `gdipt` varchar(255) DEFAULT NULL COMMENT '更多input qq密码 ,大区名称',
  `ord` int(100) DEFAULT '0' COMMENT '排序',
  `is_ste` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0下架 1上架',
  `kuc` int(100) NOT NULL DEFAULT '0' COMMENT '库存',
  `pwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_goods
-- ----------------------------
INSERT INTO `bl_goods` (`id`, `cid`, `image`, `gname`, `gmoney`, `money1`, `money2`, `money3`, `type`, `checks`, `cont`, `onetle`, `gdipt`, `ord`, `is_ste`, `kuc`, `pwd`) VALUES
(2, 10, '/upload/image/20190516/20190516130749_70184.jpg', '新版发卡系统带分销分站和免签', '50.00', '0.01', '200.00', '300.00', 0, 1, '<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\">演示地址：fenxiao.313t.com\r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><br />\r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><span style=\"color: rgb(229, 51, 51); font-size: 18px;\" font-size:16px;white-space:normal;background-color:#ffffff;\"=\"\"><strong>平台自带免签支持微信和云闪付 &nbsp;不用对接第三方</strong></span><span style=\"color:#E53333;font-size:18px;\"><strong>，交易数据更加私密安全</strong></span> \r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><span style=\"color:#E53333;font-size:18px;\"><strong><br />\r\n</strong></span>\r\n</p>\r\n<p style=\"padding: 0px; margin-top: 0px; margin-bottom: 0px;\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><span style=\"color:#e53333;\"><span style=\"font-size:18px;\"><b>三级分销和分站模式让你的交易额成倍增长</b></span></span>\r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><br />\r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><br />\r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><br />\r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130806_69762.jpg\" alt=\"\" /> \r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130820_64161.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130830_24513.png\" alt=\"\" /> \r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130839_33447.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130847_93779.jpg\" alt=\"\" /> \r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130855_13472.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\">平台自带免签 &nbsp;不用对接第三方\r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;line-height:18px;widows:1;background-color:#ffffff;font-stretch:normal;\"=\"\"><img src=\"/upload/image/20190516/20190516130928_63578.jpg\" alt=\"\" /> \r\n</p>', 'QQ号', '', 0, 1, 23, ''),
(3, 12, '/upload/image/20180608/20180608152210_32815.jpg', '银河奇异果VIP会员12个月充值 赠爱奇艺vip黄金会员一年支持TV端', '0.01', '0.01', '0.01', '0.01', 0, 1, '<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;background-color:#ffffff;\"=\"\"> <span style=\"font-size:20px;\"> <span style=\"font-size:24px;\"> 导购提示</span></span> \r\n	</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" text-align:center;white-space:normal;background-color:#ffffff;\"=\"\"> <span style=\"font-size:20px;\"><span style=\"font-size:24px;\"></span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;color:#666666;font-family:\" white-space:normal;background-color:#ffffff;\"=\"\"><br />\r\n	</p>\r\n<span style=\"color:#666666;font-family:\" text-align:center;white-space:normal;background-color:#ffffff;\"=\"\">1、本商品为奇异果一年会员支持手机、平板、电脑、电视！<br />\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		2、订单成功后自动发货，<span style=\"color:#FF0000;font-size:20px;\">请登陆到商城找到对应订单即可看到提取卡密入口！<br />\r\n</span> \r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		3、如未收到卡密可以联系在线客服获取QQ或微信 949562415 或电话15186676637\r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		4、<span style=\"color:#FF0000;font-size:20px;\">收到激活码请直接在电视APP激活使用<br />\r\n</span> \r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		5、充值账号：登陆奇异果时用手机号或邮箱登陆（请勿使用第三方账号登陆充值）\r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		6、<span style=\"color:#00B050;font-size:20px;\">奇异果会员权益高清画质、高速通道、专属片库、赠点播券！</span> \r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		<span style=\"color:#00B050;font-size:20px;\"></span> \r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;text-align:left;\">\r\n		<span style=\"color:#00B050;font-size:20px;\"></span> \r\n	</p>\r\n	<p style=\"padding:0px;margin-top:0px;margin-bottom:0px;\">\r\n		<img title=\"TB2EH4ywdRopuFjSZFtXXcanpXa_!!2949669952.jpg\" src=\"http://www.vipdaka.com/bdimages/upload1/20170728/1501228580843078.jpg\" style=\"max-width:820px;\" /> \r\n	</p>\r\n</span>', 'QQ号', '电话号', 0, 1, 0, '0'),
(10, 10, '/upload/image/20190429/20190429110710_92720.png', '1111111', '100.00', '100.00', '100.00', '100.00', 0, 1, '22222222222222222222222', 'QQ号', '', 0, 1, 0, ''),
(4, 12, '/upload/image/20180608/20180608152601_10747.jpg', '搜狐视频VIP会员1个月 搜狐黄金影视VIP会员一个月 搜狐会员充值', '100.00', '100.00', '100.00', '100.00', 0, 1, '<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;text-align:center;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;font-weight:700;\"><span style=\"padding:0px;margin:0px;color:#FF0000;\"><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;font-size:x-large;\">账号即为激活码</span><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;color:#CC0000;font-size:24px;\">,</span><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;font-size:x-large;\">拍1件为1个月,可累加！</span></span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;text-align:center;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;color:#444444;\"><span style=\"padding:0px;margin:0px;font-weight:700;\"><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;\"><span style=\"padding:0px;margin:0px;font-size:18px;\">非搜狐会员账号，是给您自己的账号激活会员的激活码</span></span></span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"text-align:center;padding:0px;line-height:1.4;margin:0px;\"></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"text-align:center;padding:0px;line-height:1.4;margin:0px;\"> 运营公司：搜狐影视</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"text-align:center;padding:0px;line-height:1.4;margin:0px;\"></span><span style=\"text-align:center;padding:0px;line-height:1.4;margin:0px;\"></span> <span style=\"padding:0px;line-height:19px;margin:0px;\">适用途径：搜狐影视会员<span style=\"font-weight:700;padding:0px;line-height:19px;margin:0px;\"><span style=\"padding:0px;margin:0px;font-size:24px;\"><span style=\"padding:0px;line-height:19px;margin:0px;\"><span style=\"padding:0px;line-height:19px;margin:0px;color:#FF0000;\">（</span></span></span></span></span><span style=\"font-weight:700;padding:0px;margin:0px;\"><span style=\"padding:0px;margin:0px;font-size:24px;\"><span style=\"padding:0px;line-height:19px;margin:0px;\"><span style=\"padding:0px;line-height:19px;margin:0px;color:#FF0000;\">不支持电视机观看！）</span></span></span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	计费方式：拍一件/1个月\r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;font-family:kaiti_gb2312;\"><span style=\"padding:0px;line-height:25px;margin:0px;font-size:18px;\"><span style=\"padding:0px;margin:0px;color:#000000;\"><span style=\"padding:0px;margin:0px;font-weight:700;\"><span style=\"padding:0px;background-color:#E69138;margin:0px;\">提取卡密：</span></span></span><span style=\"padding:0px;margin:0px;font-size:14px;\"><span style=\"padding:0px;line-height:1.4;margin:0px;color:#444444;\">到已买宝贝</span></span></span><span style=\"padding:0px;margin:0px;\"><span style=\"padding:0px;line-height:19px;margin:0px;\">→</span>找到此订单<span style=\"padding:0px;line-height:19px;margin:0px;\">→</span>点击订单下的【查看卡密】<span style=\"padding:0px;line-height:19px;margin:0px;\">→</span>复制【密码】（卡号就是激活码）</span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"font-weight:700;padding:0px;margin:0px;\"><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;\"> 【</span><span style=\"padding:0px;margin:0px;font-family:kaiti_gb2312;font-size:18px;\">充值地址</span><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;\">】</span></span><a href=\"http://zhifu.le.com/exchange.html\" target=\"_blank\" style=\"color:#23527C;outline:none medium;box-sizing:border-box;padding:0px;list-style-type:none;margin:0px;line-height:20px;font-family:\" font-stretch:normal;outline-offset:-2px;\"=\"\"></a><a href=\"http://film.sohu.com/index.html\" target=\"_blank\" style=\"color:#23527C;outline:none medium;box-sizing:border-box;padding:0px;list-style-type:none;margin:0px;font-stretch:normal;line-height:20px;font-family:\" outline-offset:-2px;\"=\"\">http://film.sohu.com/index.html</a><a href=\"http://film.qq.com/duihuan.html\" style=\"color:#666666;outline:none medium;text-decoration:none;\"></a><span style=\"padding:0px;line-height:1.4;margin:0px;font-family:kaiti_gb2312;color:#0000FF;\"></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	充值账号：在搜狐视频登陆自己的账号激活！<span style=\"padding:0px;margin:0px;color:#FF0000;\"><span style=\"padding:0px;margin:0px;font-weight:700;\"><span style=\"padding:0px;margin:0px;\"><br style=\"padding:0px;margin:0px;\" />\r\n</span></span></span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;color:#FF0000;\"><span style=\"padding:0px;margin:0px;font-weight:700;\"> </span></span> 注意事项：<span style=\"padding:0px;margin:0px;color:#FF0000;\">1.该商品为搜狐黄金会员激活码一个月。</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;color:#FF0000;\"> 2.付款后请找到对应订单提取激活码自助激活</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;color:#FF0000;\"></span><span style=\"padding:0px;margin:0px;color:#FF0000;\"> 3.不会使用的用户请联系客服协助激活！</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;margin:0px;color:#FF0000;\"></span><span style=\"padding:0px;margin:0px;color:#FF0000;\"> 4.充值成功，请登录乐视视频会员官网（<a class=\"c-showurl\" href=\"https://www.baidu.com/link?url=QP1HsLIwUqwo7snmr6SZntNQfbHcSuj46yq8T8o6h8a&amp;wd=&amp;eqid=c6f397d000139044000000025948c0c7\" target=\"_blank\" style=\"color:green;outline:none medium;text-decoration:none;font-stretch:normal;font-size:13px;line-height:20px;font-family:arial;\">tv.sohu.com</a>）查询您的会员状态和时间。</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;line-height:1.5;widows:2;margin:0px;font-family:kaiti_gb2312;font-stretch:normal;\"> 每个激活码只能使用一</span><span style=\"padding:0px;line-height:1.5;widows:2;margin:0px;font-family:kaiti_gb2312;color:#000000;font-stretch:normal;\">次，</span><span style=\"padding:0px;line-height:1.5;margin:0px;font-family:kaiti_gb2312;color:#222222;\">禁止库存，禁止扫货，购买后</span><span style=\"padding:0px;line-height:1.5;margin:0px;font-family:kaiti_gb2312;color:#FF00FF;\"><span style=\"padding:0px;margin:0px;color:#000000;\">请</span><span style=\"padding:0px;margin:0px;font-weight:700;\"><span style=\"padding:0px;margin:0px;font-size:18px;\"><span style=\"padding:0px;margin:0px;color:#9900FF;\">当天使用</span></span></span></span><span style=\"padding:0px;line-height:1.5;margin:0px;font-family:kaiti_gb2312;color:#222222;\">，过期出现问题，无法退款；</span> \r\n</p>\r\n<p style=\"padding:0px;margin-top:1.12em;margin-bottom:1.12em;white-space:normal;widows:1;background-color:#FFFFFF;font-size:14px;line-height:1.4;font-family:tahoma, arial, 宋体, sans-serif;color:#404040;font-stretch:normal;\">\r\n	<span style=\"padding:0px;line-height:1.5;margin:0px;font-family:kaiti_gb2312;color:#222222;\"><img title=\"TB2OtMlcVXXXXbXXXXXXXXXXXXX-2508682495.jpg\" src=\"http://www.vipdaka.com/bdimages/upload1/20170620/1497940273327945.jpg\" style=\"max-width:820px;\" /></span> \r\n</p>', 'QQ号', '', 0, 1, 7, ''),
(5, 10, 'http://kami.313t.com/upload/image/20180605/20180605145608_14217.jpg', '手工测试', '0.01', '0.01', '0.01', '0.01', 1, 1, '', '联系方式', '密码,大区', 0, 1, 10, ''),
(7, 10, 'https://img.alicdn.com/bao/uploaded/i2/TB1OCNYNpXXXXbJaXXXXXXXXXXX_!!0-item_pic.jpg', '爱奇艺会员一个月【不是真的爱奇艺会员！测试支付流程】', '480.00', '100.00', '100.00', '100.00', 1, 1, '', 'QQ号', '', 0, 1, 423, ''),
(8, 10, 'http://www.xiaoyukf.cc/static/images/1545720354.png', '鸡腿周卡', '80.00', '100.00', '100.00', '100.00', 1, 1, '', 'QQ号', '', 0, 1, 53, ''),
(1, 10, '/upload/image/20190422/20190422101255_25088.jpg', '收银系统开通支持信用卡花呗微信', '20.00', '20.00', '20.00', '20.00', 2, 1, '<p>\r\n	<span style=\"box-sizing:border-box;font-weight:700;color:#64451D;font-family:\" font-size:18px;white-space:normal;background-color:#ffffff;\"=\"\">步骤：注册-下载APP-登陆-实名认证-绑定结算卡-目前支付宝收款每日限量报备，最好半夜十二点左右开始，报备信息随便选。</span> \r\n</p>\r\n<p>\r\n	<span style=\"box-sizing:border-box;font-weight:700;color:#64451D;font-family:\" font-size:18px;white-space:normal;background-color:#ffffff;\"=\"\"><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span style=\"box-sizing:border-box;font-weight:700;color:#64451D;font-family:\" font-size:18px;white-space:normal;background-color:#ffffff;\"=\"\"><a href=\"https://www.xjklmy.cc/cjzf.html\" target=\"_blank\">点击开通</a><br />\r\n</span> \r\n</p>', 'QQ号', '', 1, 1, 970, ''),
(11, 12, '/upload/image/20190430/20190430212631_88237.jpg', '呵呵哒', '100.00', '100.00', '100.00', '50.00', 1, 1, '测试是个测试<img src=\"/upload/image/20190430/20190430212713_41619.gif\" alt=\"\" />', 'QQ号', '收货地址；手机号；名字', 0, 1, 66, '');


-- ----------------------------
-- Table structure for `bl_kami`
-- ----------------------------
DROP TABLE IF EXISTS `bl_kami`;
CREATE TABLE `bl_kami` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `gid` int(100) NOT NULL COMMENT '商品id',
  `kano` text NOT NULL COMMENT '卡号',
  `is_ste` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常 1:已售',
  `ctime` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_kami
-- ----------------------------
INSERT INTO `bl_kami` VALUES ('1', '2', '卡号1----卡密', '0', '1527990893');
INSERT INTO `bl_kami` VALUES ('2', '2', '卡号2----卡密', '0', '1527990893');
INSERT INTO `bl_kami` VALUES ('3', '2', '卡号3----卡密', '0', '1527990893');
INSERT INTO `bl_kami` VALUES ('4', '2', '卡号4----卡密', '0', '1527990893');
INSERT INTO `bl_kami` VALUES ('5', '2', '卡号5----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('6', '2', '卡号6----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('7', '2', '卡号7----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('8', '2', '卡号8----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('9', '2', '卡号9----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('10', '2', '卡号10----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('11', '2', '卡号11----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('12', '2', '卡号12----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('13', '2', '卡号13----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('14', '2', '卡号14----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('15', '2', '卡号15----卡密', '0', '1528375073');
INSERT INTO `bl_kami` VALUES ('16', '2', '卡号16----卡密', '0', '1528375976');
INSERT INTO `bl_kami` VALUES ('17', '3', '奇异卡号1----卡密', '1', '1528378834');
INSERT INTO `bl_kami` VALUES ('18', '3', '奇异卡号2----卡密', '1', '1528378834');
INSERT INTO `bl_kami` VALUES ('26', '4', '搜狐卡号8----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('27', '4', '搜狐卡号9----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('28', '4', '搜狐卡号10----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('29', '4', '搜狐卡号11----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('30', '4', '搜狐卡号12----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('31', '4', '搜狐卡号13----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('32', '4', '搜狐卡号14----卡密', '0', '1528443016');
INSERT INTO `bl_kami` VALUES ('46', '2', 'dfghjgvgghgg', '0', '1554343935');
INSERT INTO `bl_kami` VALUES ('47', '2', 'fdghgddffffff', '0', '1554343935');
INSERT INTO `bl_kami` VALUES ('48', '2', 'tfugdryuuhu', '0', '1554343935');
INSERT INTO `bl_kami` VALUES ('49', '2', 'ggihfdcuyffggggggghgff', '0', '1554343980');
INSERT INTO `bl_kami` VALUES ('50', '2', 'gfddrtrrdghygggvbhhbbnh', '0', '1554343980');
INSERT INTO `bl_kami` VALUES ('51', '2', 'ffrrryuiihgvbhbvbjbnjihhh', '0', '1554343980');
INSERT INTO `bl_kami` VALUES ('52', '2', 'gghggghhhuijjjiiiijhb', '0', '1554343980');
INSERT INTO `bl_kami` VALUES ('53', '3', '卡号----卡密', '1', '1554796388');
INSERT INTO `bl_kami` VALUES ('54', '3', '卡号----卡密2', '0', '1554796388');
INSERT INTO `bl_kami` VALUES ('55', '3', '卡号----卡密3', '0', '1554796388');

-- ----------------------------
-- Table structure for `bl_links`
-- ----------------------------
DROP TABLE IF EXISTS `bl_links`;
CREATE TABLE `bl_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_links
-- ----------------------------
INSERT INTO `bl_links` VALUES ('1', '官方淘宝店', 'http://313t.taobao.com/', '1');

-- ----------------------------
-- Table structure for `bl_mailtpl`
-- ----------------------------
DROP TABLE IF EXISTS `bl_mailtpl`;
CREATE TABLE `bl_mailtpl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text,
  `is_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cname` (`cname`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_mailtpl
-- ----------------------------
INSERT INTO `bl_mailtpl` VALUES ('1', '卡密发送', '您在{sitename}购买的商品已发货', '<p class=\"p1\">\r\n<span class=\"s1\">尊敬的用户您好：</span> \r\n</p>\r\n<p class=\"p1\">\r\n<span class=\"s1\">您在：【{sitename}】 购买的商品：{gname} 已发货。</span> \r\n</p>\r\n<p class=\"p1\">订单号：{orid}</p>\r\n<p class=\"p1\">数量：{ornum}</p>\r\n<p class=\"p1\">金额：{cmoney}</p>\r\n<p class=\"p1\">时间：{ctime}</p>\r\n---------------------------------------------------------------------------------------------------------------------------<br/>\r\n<p class=\"p1\"> \r\n<span class=\"s1\">{orderinfo}</span>\r\n</p> \r\n---------------------------------------------------------------------------------------------------------------------------<br/>\r\n\r\n感谢您的惠顾，祝您生活愉快！<br/>\r\n<p class=\"p1\">\r\n	<span class=\"s1\">来自 <span style=\"white-space:normal;\">{sitename} -{siteurl}</span></span> \r\n</p>', '0', '0');
INSERT INTO `bl_mailtpl` VALUES ('2', '管理员通知', '【{sitename}】新订单等待处理', '<p class=\"p1\">尊敬的管理员：</p>\r\n\r\n<p class=\"p1\">客户购买的商品：【{gname}】 已支付成功，请及时处理。</p>\r\n------------------------------------------<br/>\r\n<p class=\"p1\">订单号：{orid}</p>\r\n<p class=\"p1\">数量：{ornum}</p>\r\n<p class=\"p1\">金额：{cmoney}</p>\r\n<p class=\"p1\">时间：{ctime}</p>\r\n---------------------------------------------<br/>\r\n\r\n<p class=\"p1\">\r\n	<span class=\"s1\">来自 <span style=\"white-space:normal;\">{sitename} -{siteurl}</span></span> \r\n</p>', '0', '0');
INSERT INTO `bl_mailtpl` VALUES ('3', '库存告警', '【{sitename}】库存告警', '<p class=\"p1\">尊敬的管理员：</p>\r\n\r\n<p class=\"p1\">平台商品：【{gname}】库存低于{ornum}，请及时补货。</p>\r\n\r\n<p class=\"p1\">\r\n	<span class=\"s1\">来自 <span style=\"white-space:normal;\">{sitename} -{siteurl}</span></span> \r\n</p>', '0', '0');
INSERT INTO `bl_mailtpl` VALUES ('4', '找回密码', '【{sitename}】找回密码', '<p class=\"p1\">\r\n<span class=\"s1\">尊敬的用户您好：</span> \r\n</p>\r\n<p class=\"p1\">\r\n<span class=\"s1\">以下是您找回密码的验证链接，请勿告知他人！链接有效期为2小时！</span> \r\n</p>\r\n---------------------------------------------------------------------------------------------------------------------------<br/>\r\n\r\n<a href=\"{siteurl}/reg/repwd?token={token}\">{siteurl}/reg/repwd?token={token}</a><br/>\r\n\r\n---------------------------------------------------------------------------------------------------------------------------<br/>\r\n\r\n感谢您的惠顾，祝您生活愉快！<br/>\r\n<p class=\"p1\">\r\n	<span class=\"s1\">来自 <span style=\"white-space:normal;\">{sitename} -{siteurl}</span></span> \r\n</p>', '0', '0');

-- ----------------------------
-- Table structure for `bl_navcog`
-- ----------------------------
DROP TABLE IF EXISTS `bl_navcog`;
CREATE TABLE `bl_navcog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_navcog
-- ----------------------------
INSERT INTO `bl_navcog` VALUES ('2', '{\"set\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"admins\":\"\\u7ba1\\u7406\\u5458\\u5217\\u8868\",\"user\":\"\\u7528\\u6237\\u5217\\u8868\",\"orders\":\"\\u8ba2\\u5355\\u5217\\u8868\",\"gdclass\":\"\\u5546\\u54c1\\u5206\\u7c7b\",\"goods\":\"\\u5546\\u54c1\\u5217\\u8868\",\"kami\":\"\\u5361\\u5bc6\\u7ba1\\u7406\"}');

-- ----------------------------
-- Table structure for `bl_orders`
-- ----------------------------
DROP TABLE IF EXISTS `bl_orders`;
CREATE TABLE `bl_orders` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(200) NOT NULL COMMENT '订单id',
  `oname` varchar(255) NOT NULL COMMENT '订单名称',
  `gid` int(100) NOT NULL COMMENT '商品id',
  `omoney` decimal(60,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `cmoney` decimal(60,2) NOT NULL COMMENT '订单总价',
  `onum` int(100) NOT NULL COMMENT '订单数量',
  `chapwd` varchar(255) DEFAULT NULL COMMENT '查询密码',
  `account` varchar(255) NOT NULL COMMENT '充值账号',
  `otype` tinyint(1) NOT NULL COMMENT '订单类型 0自动发卡 1手工充值',
  `info` text COMMENT '充值详情',
  `payid` varchar(200) DEFAULT NULL COMMENT '第三方支付平台id',
  `paytype` varchar(255) DEFAULT NULL COMMENT '支付方式',
  `ctime` int(100) NOT NULL COMMENT '下单日期',
  `status` tinyint(1) NOT NULL COMMENT '0待付款 1待处理 2已处理 3已完成  4处理失败 5发卡失败',
  `uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 CHECKSUM=1;

-- ----------------------------
-- Table structure for `bl_ulevel`
-- ----------------------------
DROP TABLE IF EXISTS `bl_ulevel`;
CREATE TABLE `bl_ulevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_ulevel
-- ----------------------------
INSERT INTO `bl_ulevel` VALUES ('1', '铜牌');
INSERT INTO `bl_ulevel` VALUES ('2', '银牌');
INSERT INTO `bl_ulevel` VALUES ('3', '金牌');

-- ----------------------------
-- Table structure for `bl_users`
-- ----------------------------
DROP TABLE IF EXISTS `bl_users`;
CREATE TABLE `bl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `upasswd` varchar(40) NOT NULL,
  `lid` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `is_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `allmoney` decimal(10,2) DEFAULT '0.00',
  `pwtime` varchar(300) DEFAULT '1465164366',
  `ctime` varchar(300) NOT NULL DEFAULT '1514736000',
  `last_ip` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `ckmail` tinyint(1) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_users
-- ----------------------------
INSERT INTO `bl_users` VALUES ('1', 'daili', '7c4a8d09ca3762af61e59520943dc26494f8941b', '3', '551962171@qq.com', '1', '0.00', '1465164366', '1554384861', '114.139.49.69', '1', '');
INSERT INTO `bl_users` VALUES ('2', 'cesi', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1', '949562415@qq.com', '1', '0.00', '1465164366', '1553948766', '1.205.121.100', '1', null);