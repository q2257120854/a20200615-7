/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : 01

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 17/01/2020 09:13:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin' COMMENT '账号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin' COMMENT '密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', 'admin');

-- ----------------------------
-- Table structure for bbscomment
-- ----------------------------
DROP TABLE IF EXISTS `bbscomment`;
CREATE TABLE `bbscomment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bbsid` int(11) NOT NULL,
  `userid` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `del` int(11) NULL DEFAULT NULL COMMENT '0=删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bbscomment
-- ----------------------------
INSERT INTO `bbscomment` VALUES (1, 38, '999999', '1560704662', '66666666666', NULL);
INSERT INTO `bbscomment` VALUES (2, 34, '999999', '1560704679', '可以可以', NULL);
INSERT INTO `bbscomment` VALUES (3, 38, '999999', '1560704968', '777777777', NULL);
INSERT INTO `bbscomment` VALUES (4, 38, '999999', '1560704980', '？？？？？', NULL);
INSERT INTO `bbscomment` VALUES (5, 38, '999999', '1560705048', '？？？？？', NULL);
INSERT INTO `bbscomment` VALUES (6, 39, '999999', '1560705208', '????', NULL);
INSERT INTO `bbscomment` VALUES (7, 39, '999999', '1560705944', '什么', NULL);
INSERT INTO `bbscomment` VALUES (8, 38, '999999', '1560705983', '？？？？', NULL);
INSERT INTO `bbscomment` VALUES (9, 40, '16176791', '1560707960', '666666', NULL);
INSERT INTO `bbscomment` VALUES (10, 41, '977847728', '1560708766', '笑出声', NULL);
INSERT INTO `bbscomment` VALUES (11, 44, '977847728', '1560728815', '1', NULL);
INSERT INTO `bbscomment` VALUES (12, 44, '977847728', '1560728818', '12', NULL);
INSERT INTO `bbscomment` VALUES (13, 44, '977847728', '1560728825', '2', NULL);
INSERT INTO `bbscomment` VALUES (14, 44, '977847728', '1560728830', '2', NULL);
INSERT INTO `bbscomment` VALUES (15, 43, '977847728', '1560728835', '2', NULL);
INSERT INTO `bbscomment` VALUES (16, 43, '977847728', '1560728838', '23', NULL);
INSERT INTO `bbscomment` VALUES (17, 43, '977847728', '1560728840', '23', NULL);
INSERT INTO `bbscomment` VALUES (18, 43, '977847728', '1560728842', '23', NULL);
INSERT INTO `bbscomment` VALUES (19, 44, '977847728', '1560729493', '.', NULL);
INSERT INTO `bbscomment` VALUES (20, 44, '977847728', '1560746973', '测试回复下', NULL);
INSERT INTO `bbscomment` VALUES (21, 46, '977847728', '1560761776', '666666', NULL);
INSERT INTO `bbscomment` VALUES (22, 46, '977847728', '1560761782', '好不好看', NULL);
INSERT INTO `bbscomment` VALUES (23, 44, '888888', '1560772245', '我来了', NULL);
INSERT INTO `bbscomment` VALUES (24, 49, '999999', '1560788859', '666666666', NULL);
INSERT INTO `bbscomment` VALUES (25, 50, '999999', '1560790591', '666666666', NULL);
INSERT INTO `bbscomment` VALUES (26, 50, '999999', '1560790601', '666666666', NULL);
INSERT INTO `bbscomment` VALUES (27, 50, '999999', '1560790601', '666666666', NULL);
INSERT INTO `bbscomment` VALUES (28, 51, '999999', '1560793250', '666666666', NULL);
INSERT INTO `bbscomment` VALUES (29, 51, '977847728', '1560793930', '好看吗？这个。', NULL);
INSERT INTO `bbscomment` VALUES (30, 54, '977847728', '1560794517', '666666', NULL);
INSERT INTO `bbscomment` VALUES (31, 58, '977847728', '1560817692', '6666', NULL);
INSERT INTO `bbscomment` VALUES (32, 56, '123456666', '1560817770', '。。。', NULL);
INSERT INTO `bbscomment` VALUES (33, 62, '999999', '1560870024', '不好看', NULL);
INSERT INTO `bbscomment` VALUES (34, 64, '977847728', '1560878837', '666', NULL);
INSERT INTO `bbscomment` VALUES (35, 56, '99752683', '1560993226', '111', NULL);
INSERT INTO `bbscomment` VALUES (36, 56, '877842255', '1561175346', '666', NULL);
INSERT INTO `bbscomment` VALUES (37, 71, '999999', '1561210261', '6666', NULL);
INSERT INTO `bbscomment` VALUES (38, 75, '999999', '1561222731', '1', NULL);
INSERT INTO `bbscomment` VALUES (39, 75, '999999', '1561222733', '2', NULL);
INSERT INTO `bbscomment` VALUES (40, 75, '999999', '1561222738', '4', NULL);
INSERT INTO `bbscomment` VALUES (41, 75, '999999', '1561222740', '5', NULL);
INSERT INTO `bbscomment` VALUES (42, 69, '147852', '1561229968', '是吧唧吧唧唧歪歪', NULL);
INSERT INTO `bbscomment` VALUES (43, 64, '147147147', '1561235073', '。。。', NULL);
INSERT INTO `bbscomment` VALUES (44, 75, '19981116', '1561236871', '好', NULL);
INSERT INTO `bbscomment` VALUES (45, 44, '147147147', '1561260881', '.', NULL);

-- ----------------------------
-- Table structure for bbspost
-- ----------------------------
DROP TABLE IF EXISTS `bbspost`;
CREATE TABLE `bbspost`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `time` bigint(20) NULL DEFAULT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `img` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `del` int(11) NULL DEFAULT NULL COMMENT '0=删除',
  `comnum` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 76 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bbspost
-- ----------------------------
INSERT INTO `bbspost` VALUES (44, '977847728', 1560709194, '【签到】十二生肖镇楼！', '睡觉', '@upload/img16968ae3271157409161d9bf826ab3eec1560709194.png|', NULL, 1);
INSERT INTO `bbspost` VALUES (46, '977847728', 1560752968, '最新的哥斯拉2已经发布！', '随着《哥斯拉》和《金刚：骷髅岛》在全球范围内取得成功，传奇影业和华纳兄弟影业联手开启了怪兽宇宙系列电影的新篇章—一部史诗级动作冒险巨制。在这部电影中，哥斯拉将和众多大家在流行文化中所熟知的怪兽展开较量。全新故事中，研究神秘动物学的机构“帝王组织”将勇敢直面巨型怪兽，其中强大的哥斯拉也将和魔斯拉、拉顿和它的死对头——三头王者基多拉展开激烈对抗。当这些只存在于传说里的超级生物再度崛起时，它们将展开王者争霸，人类的命运岌岌可危……', '@upload/img16968ae3271157409161d9bf826ab3eec1560752968.png|', NULL, 0);
INSERT INTO `bbspost` VALUES (64, '977847728', 1560878815, '影视推荐：恶种[原声版]', '影视简介：《恶种》是由乌维·鲍尔执导，威尔·桑德森、拉尔夫·默勒、 迈克尔·帕尔领衔主演的惊悚片，于2006年上映。电影讲述了连环杀人犯被活埋尸体从墓地中消失后而引发的故事。...\n#剧名=恶种[原声版]#id=30796#', '@upload/img16968ae3271157409161d9bf826ab3eec1560878815.png|', NULL, 1);
INSERT INTO `bbspost` VALUES (70, '999999', 1561209659, '影视推荐：动物管理局', '影视简介：兽医郝运（陈赫 饰）因为一场猫咪配种事故，意外发现这个世界上有转化者存在。动物管理局带走郝运，但用各种办法都无法洗掉他的记忆，只好迫使他加入动物管理局。从此郝运和战斗力超强的吴爱爱（王子文 饰）组成搭档，开始处理一桩桩动物案件......开启了一个巨大而神秘的都市精灵世界的故事。\n#剧名=动物管理局#id=29239#', '@upload/img152c69e3a57331081823331c4e69d3f2e1561209659.png|', NULL, 0);
INSERT INTO `bbspost` VALUES (71, '999999', 1561209806, '影视推荐：听雪楼', '影视简介：拜月教荼毒众生、为祸江湖，武林三大高手白帝、雪谷、血魔携手听雪楼楼主萧逝水对战拜月。拜月教主华莲与大祭司联手，用圣物护花铃，侵入血魔心神，令其杀妻自刎。血魔女儿舒靖容被白帝收入门下，与师兄青岚青羽、雪谷爱徒萧逝水之子萧忆情一起长大。师兄青岚和师父白帝的相继离世，令舒靖容发现自己是不详之身的预言，自责不已。舒靖容拿走父亲血魔留下的血薇剑加入听雪楼，与少楼主萧忆情携手剿灭霹雳堂，对抗不断作恶的拜月楼，维护百姓平安。 拜月教护法孤光被策反，帮助萧忆情解开萧逝水留下的无字之书，获知当年父母死因的萧忆情，立誓要为父母报仇。萧忆情和舒靖容联手，铲除了拜月教，还世人以太平江湖。萧舒二人终不离不弃，生死相许。\n#剧名=听雪楼#id=8854#', '@upload/img152c69e3a57331081823331c4e69d3f2e1561209806.png|', NULL, 1);
INSERT INTO `bbspost` VALUES (69, '999999', 1561209453, '影视推荐：白发', '影视简介：西启长公主容乐从昏迷中醒来，记忆全失，种种迹象令她对自己的身份产生怀疑。为结盟北临，容乐奉命嫁给北临王子无忧，却被无忧拒婚。容乐化名茶楼掌柜漫夭，秘密寻找秦家遗落的治世奇书，和无忧不打不相识。不知其真实身份的无忧对漫夭心生爱慕。当找到奇书之时，王兄容齐却要容乐嫁给北临大将军傅筹。容乐与傅筹达成假结婚协议，无忧此时发现漫夭就是容乐。痛苦中决心掌握自己命运的漫夭，却发现傅筹原来是无忧的亲兄弟，而她自己则是秦家遗于世的女儿秦漫。m.ysgou.cc容乐他们意识到，身处乱世，他们连自己和亲人的幸福也护佑不了。最终容乐、无忧和傅筹跳出小我，放下恩怨，在容齐的舍身相助下，粉碎奸佞的阴谋，安定了朝局，他们也各自走向新的人生。\n#剧名=白发#id=8318#', '@upload/img152c69e3a57331081823331c4e69d3f2e1561209453.png|', NULL, 1);

-- ----------------------------
-- Table structure for bbstop
-- ----------------------------
DROP TABLE IF EXISTS `bbstop`;
CREATE TABLE `bbstop`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` bigint(20) NOT NULL DEFAULT 0,
  `objid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bbstop
-- ----------------------------
INSERT INTO `bbstop` VALUES (2, 1560959698, 46);
INSERT INTO `bbstop` VALUES (3, 1560960274, 64);
INSERT INTO `bbstop` VALUES (4, 1561218805, 70);
INSERT INTO `bbstop` VALUES (5, 1561218809, 71);

-- ----------------------------
-- Table structure for cl_message
-- ----------------------------
DROP TABLE IF EXISTS `cl_message`;
CREATE TABLE `cl_message`  (
  `uid` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `txt` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int(40) NULL DEFAULT NULL,
  `hftxt` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hftime` int(40) NULL DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eruyi_kami
-- ----------------------------
DROP TABLE IF EXISTS `eruyi_kami`;
CREATE TABLE `eruyi_kami`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `generate` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '管理员' COMMENT '卡密生成账号',
  `kami` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` enum('TK','ZK','YK','BNK','NK','YJKK','CJVIP','HJVIP','YJK') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `new` enum('y','n') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'y' COMMENT '卡密可用状态',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eruyi_peizhi
-- ----------------------------
DROP TABLE IF EXISTS `eruyi_peizhi`;
CREATE TABLE `eruyi_peizhi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'QQ',
  `banben` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '版本',
  `dizhi` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新地址',
  `qunkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'QQ群号',
  `gxneirong` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新内容',
  `gonggao` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公告',
  `fldizhi` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '福利加密地址',
  `mrjiekou` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '默认解析接口',
  `jiekou` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '解析接口',
  `qita` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '解析规则',
  `codetime` int(10) NULL DEFAULT NULL COMMENT '限制注册码注册间隔小时',
  `iptime` int(10) NULL DEFAULT NULL COMMENT '限制IP注册注册间隔小时',
  `regvip` int(10) NULL DEFAULT NULL COMMENT '注册送体验VIP时间小时',
  `invvip` int(10) NULL DEFAULT NULL COMMENT '邀请成功赠送体验VIP时间小时',
  `dqrenshu` int(10) NULL DEFAULT NULL COMMENT '当邀请人为多少人1',
  `zstime` int(10) NULL DEFAULT NULL COMMENT '送体验VIP时间小时1',
  `dqrenshu2` int(10) NULL DEFAULT NULL COMMENT '当邀请人为多少人2',
  `zstime2` int(10) NULL DEFAULT NULL COMMENT '送体验VIP时间小时2',
  `yzfid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '易支付商户ID',
  `yzfkey` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '易支付商户KEY',
  `yzfurl` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '易支付API地址',
  `zfbhb` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝红包搜索码',
  `rjjg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '软件价格',
  `charge` int(2) NULL DEFAULT NULL COMMENT '运营模式',
  `dailirj` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '软件包名',
  `guanggao` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '轮播广告',
  `ggms` int(2) NULL DEFAULT NULL COMMENT '轮播广告模式',
  `xianshi` int(2) NOT NULL DEFAULT 1 COMMENT '1显示后台视频0不显示后台视频',
  `weixinid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信分享ID',
  `guanggao2` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '广告2',
  `guanggao3` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '广告3',
  `guanggao4` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '广告4',
  `guanggao5` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '广告5',
  `guanggao6` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '广告6',
  `addyue` int(11) NOT NULL DEFAULT 0 COMMENT '一次任务增加余额',
  `tcgonggao` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '弹窗公告',
  `tcgonggaoid` int(10) NOT NULL COMMENT '弹窗公告id',
  `mzfid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '码支付id',
  `mzfkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '码支付key',
  `pay_type` int(11) NOT NULL DEFAULT 0 COMMENT '支付方式',
  `kmgmdz` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '卡密购买地址',
  `mzftoken` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '码支付token',
  `tcgonggaots` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '弹窗公告提示',
  `apkurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'apk地址',
  `updatetype` int(2) NOT NULL COMMENT '更新方式',
  `updateis` int(2) NOT NULL COMMENT '是否强制更新',
  `banben_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '版本号',
  `code_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '增量更新地址',
  `is_code_up` int(2) NOT NULL COMMENT '是否增量更新',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eruyi_peizhi
-- ----------------------------
INSERT INTO `eruyi_peizhi` VALUES (1, '3203113460', '2.0.1', 'http://admin.lekan.ml/app/index.html', '565482581', '优化注册登录业务，提升用户体验', '欢迎使用乐看影视，如需帮助请留言               ', '                                                                                               ', 'https://api.52jiexi.top/?url=', '免费观看各种视频，无广告，极速播放                                                ', 'https://ae01.alicdn.com/kf/Hbc92f27bae5d4f9f9dab5724e1291071U.png', 1, 0, 42, 24, 5, 720, 12, 8760, '', '', '', '           .mp4|.m3u8|m3u8.|video/m|m3u8Md5|&m3u8=|.flv                                                                                                  ', ' {\"天卡价\":\"1.00\",\"周卡价\":\"1.00\",\"月卡价\":\"7.00\",\"季卡价\":\"15.00\",\"年卡价\":\"66.00\",\"永久价\":\"99.00\",\"代理价\":\"199.00\"}  ', 0, NULL, '{1.<a>img=\"https://ae01.alicdn.com/kf/H7af01db95a7f41fbb5d4894665047b14x.jpg\"title=\"大明风华\"href=\"61379\"</a>\r\n2.<a>img=\"https://ae01.alicdn.com/kf/H8b7100a10ff14029a658053b7718599fc.jpg\"title=\"爱情公寓5\"href=\"91775\"</a>\r\n3.<a>img=\"https://ae01.alicdn.com/kf/H9c7d3ff147e449f8a9a76bc30695d58fV.jpg\"title=\"利刃出鞘\"href=\"62357\"</a>\r\n4.<a>img=\"https://ae01.alicdn.com/kf/Hf5a67040eb114abdbedea12fb474a0b56.jpg\"title=\"梦回\"href=\"60863\"</a>\r\n5.<a>img=\"https://ae01.alicdn.com/kf/Hbe9761596af64a7b8e03a7a787e0078dW.jpg\"title=\"猎魔人：第一季\"href=\"61645\"</a>\r\n6.<a>img=\"https://ae01.alicdn.com/kf/H54ce1ab94fa8409fbac816f47ae8e40eo.jpg\"title=\"丑 Joker\"href=\"87656\"</a>}                                                ', 1, 1, '', '{1.<a>img=\"https://ae01.alicdn.com/kf/H8b7100a10ff14029a658053b7718599fc.jpg\"title=\"爱情公寓5\"href=\"91775\"</a>\r\n2.<a>img=\"https://ae01.alicdn.com/kf/H7af01db95a7f41fbb5d4894665047b14x.jpg\"title=\"大明风华\"href=\"61379\"</a>\r\n3.<a>img=\"https://ae01.alicdn.com/kf/Hf5a67040eb114abdbedea12fb474a0b56.jpg\"title=\"梦回\"href=\"60863\"</a>\r\n1.<a>img=\"https://ae01.alicdn.com/kf/H8b7100a10ff14029a658053b7718599fc.jpg\"title=\"爱情公寓5\"href=\"91775\"</a>\r\n2.<a>img=\"https://ae01.alicdn.com/kf/H7af01db95a7f41fbb5d4894665047b14x.jpg\"title=\"大明风华\"href=\"61379\"</a>\r\n3.<a>img=\"https://ae01.alicdn.com/kf/Hf5a67040eb114abdbedea12fb474a0b56.jpg\"title=\"梦回\"href=\"60863\"</a>\r\n}                    ', '{1.<a>img=\"https://ae01.alicdn.com/kf/H39ada958bf0a4839b76e0880f79bef23z.jpg\"title=\"\"href=\"\"</a>\r\n2.<a>img=\"https://ae01.alicdn.com/kf/H44e363d962fd4754a74a078cb9f1f8b4B.png\"title=\"大额淘宝优惠券\"href=\"http://www.baidu.com\"</a>}                                   ', '{1.<a>img=\"https://ae01.alicdn.com/kf/H8b7100a10ff14029a658053b7718599fc.jpg\"title=\"爱情公寓5\"href=\"91775\"</a>\r\n}                    ', '{1.<a>img=\"https://ae01.alicdn.com/kf/H39ada958bf0a4839b76e0880f79bef23z.jpg\"title=\"\"href=\"\"</a>\r\n2.<a>img=\"https://ae01.alicdn.com/kf/H44e363d962fd4754a74a078cb9f1f8b4B.png\"title=\"大额淘宝优惠券\"href=\"http://www.baidu.com\"</a>}                                   ', '{1.<a>img=\"https://cmsp111.com/ad/502-2.gif\"title=\"图片标题1\"href=\"http://4005502.com/?member=102932\"</a>\r\n2.<a>img=\"https://cmsp111.com/ad/502-2.gif\"title=\"图片标题1\"href=\"http://4005502.com/?member=102932\"</a>\r\n3.<a>img=\"https://cmsp111.com/ad/502-2.gif\"title=\"图片标题1\"href=\"http://4005502.com/?member=102932\"</a>\r\n4.<a>img=\"https://cmsp111.com/ad/502-2.gif\"title=\"图片标题1\"href=\"http://4005502.com/?member=102932\"</a>}                                                ', 1, '<pstyle=\'color:#007AFF;\'>欢迎使用乐看影视</p><p>成人内容可在设置-隐私设置中关闭</p> 好东西记得分享给朋友哦                ', 4, '106611', 'RUxzMLbieKq5XGxtjwY5WB369DSsgbaX', 2, 'http://www.baidu.com', 'DiAspuhpZrtmPhJkxMJq5Y3tmtbemQ2b', '温馨提示', 'http://lekan.test.upcdn.net/lekan2.0.1.apk', 0, 1, '3', 'http://admin.lekan.ml/codeupdate/H5EF3C469.wgt', 0);

-- ----------------------------
-- Table structure for eruyi_user
-- ----------------------------
DROP TABLE IF EXISTS `eruyi_user`;
CREATE TABLE `eruyi_user`  (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `QQ` int(12) NOT NULL DEFAULT 123456,
  `qiandao` int(11) NOT NULL DEFAULT 0,
  `GGCS` int(11) NOT NULL DEFAULT 0 COMMENT '广告点击次数',
  `FXCS` int(11) NOT NULL DEFAULT 0 COMMENT '分享点击次数',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名称',
  `pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'pic/tx.png' COMMENT '用户头像',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户账号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户密码',
  `inv` int(11) NULL DEFAULT NULL COMMENT '推荐人id',
  `number` int(11) NULL DEFAULT NULL COMMENT '邀请人数',
  `vip` int(11) NULL DEFAULT NULL COMMENT 'vip时间',
  `money` int(11) NULL DEFAULT NULL COMMENT '金币',
  `superpass` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号找回密码的',
  `regdate` int(11) NULL DEFAULT NULL COMMENT '注册时间戳',
  `regip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册IP',
  `regcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '机器码',
  `codetime` int(11) NULL DEFAULT NULL COMMENT '机器码修改记录时间',
  `lock` enum('y','n') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'y' COMMENT '账号状态',
  `online` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token',
  `fenzu` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'PT' COMMENT '用户组',
  `addyuetime` int(11) NOT NULL DEFAULT 0 COMMENT '余额最后添加时间',
  `is_admin` int(1) NOT NULL DEFAULT 0 COMMENT '是否管理员',
  `uuid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '设备标识',
  `aqcode` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '安全码',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 168 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for shipin_data
-- ----------------------------
DROP TABLE IF EXISTS `shipin_data`;
CREATE TABLE `shipin_data`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频标题',
  `src` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频图片',
  `href` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '视频地址',
  `txt` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '视频简介',
  `time` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频上传时间',
  `shipfl` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频分类',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipin_data
-- ----------------------------
INSERT INTO `shipin_data` VALUES (2, '匪医诺克', 'http://img1.doubanio.com/view/photo/s_ratio_poster/public/p2499521127.jpg', 'https://new.jsyunbf.com/20180828/xesh2uE1/index.m3u8', '当医生来敲门，健康的人都成病人，不管小病还是重症，能够赚钱都是好病人。柯诺克曾是一名骗徒，改邪归正成了医生，搬到阿尔卑斯山旁的富有山庄，接手退休医师的诊所，他下定决心在这裡赚大钱，不料当地居民个个身强体壮，一点赚头都没有，他只好用诚恳笑容和三寸不烂之舌，强力渲染各种疾病无所不在，没病没痛的村民都被柯诺克诊断出大病大症，还被再三嘱咐要定期回诊，很快地诊所挤满了各式症状的病患，不论病情是真是假。于是，他成为山庄最炙手可热的新好医生，每週二的免费义诊谘询吸引更多居民看病，让他赚进大把钞票，同时也邂逅了一位美丽的农场女子，事业爱情两得意，引起了村庄神父的忌妒，神父愤怒看著他的教徒都挤在诊所外，而不进他的教堂，正好一个知道医生黑历史的不速之客出现在村庄，与神父联手来扰乱医生的大好计画…', '2018年08月28日', '电影');
INSERT INTO `shipin_data` VALUES (3, '他是一只狗', 'http://img1.doubanio.com/view/photo/s_ratio_poster/public/p2524690349.jpg', 'https://new.jsyunbf.com/20180824/g6m5JDvr/index.m3u8', '一只流浪狗出现在问题少女阿慧的世界。就在流浪狗即将被宰杀的时候，阿慧救回了流浪狗，取名Lucky。Lucky似乎非同寻常，除了聪明可爱、忠心耿耿，竟然对少女主人产生了特殊的情感。一次次危机时刻，Lucky舍身救主。直到有一天，阿慧惊讶的发现，Lucky竟然变成了一个大男孩！这段感情该如何延续……', '2018年08月28日', '电影');
INSERT INTO `shipin_data` VALUES (4, '鱼缸加州', 'http://img3.doubanio.com/view/photo/s_ratio_poster/public/p2521418022.jpg', 'https://new.jsyunbf.com/20180823/w7cc3Xib/index.m3u8', '一个努力寻找生活目标的人被一个醉酒的病人寡妇所启发', '2018年08月28日', '推荐');
INSERT INTO `shipin_data` VALUES (5, '栋笃特工', 'http://img1.doubanio.com/view/photo/s_ratio_poster/public/p2509642867.jpg', 'https://new.jsyunbf.com/20180821/s2YqEpTs/index.m3u8', '有一个后生仔，发明左一只「真性情药」，食完后真性情表露无遗，顾家好男人会兽性尽现搞人老婆……子华身为一个以前系特工嘅私家侦探居然同身为黑社会大佬嘅女人阿佘联手调查这单案，想找那个人出来研究解药。正当他们以为成功打到大佬之际，才发现背地裡原来有更大阴谋——他们发现，原来好多行为疯狂的人，根本都没食这隻「真性情药」……', '2018年08月29日', '推荐');
INSERT INTO `shipin_data` VALUES (6, '媚者无疆 ', 'http://img1.doubanio.com/view/photo/s_ratio_poster/public/p2527086138.jpg', '第01集$https://videos.jsyunbf.com/20180725/GymNU0I7/index.m3u8|第02集$https://videos.jsyunbf.com/20180725/ppRiEbMX/index.m3u8|第03集$https://videos.jsyunbf.com/20180725/KYwQwLrR/index.m3u8|第04集$https://videos.jsyunbf.com/20180725/oVcIrkjd/index.m3u8|第05集$https://videos.jsyunbf.com/20180725/PYw3yefy/index.m3u8|第06集$https://videos.jsyunbf.com/20180725/rfdl6KXm/index.m3u8|第07集$https://videos.jsyunbf.com/20180725/WXjeHK8c/index.m3u8|第08集$https://new.jsyunbf.com/20180728/lLWOy2Ux/index.m3u8|第09集$https://new.jsyunbf.com/20180728/x4rycE3h/index.m3u8|第10集$https://new.jsyunbf.com/20180731/xX5apBIW/index.m3u8|第11集$https://new.jsyunbf.com/20180731/ZKud7zud/index.m3u8|第12集$https://new.jsyunbf.com/20180731/OrtpDggu/index.m3u8|第13集$https://new.jsyunbf.com/20180804/NqVIDVBl/index.m3u8|第14集$https://new.jsyunbf.com/20180811/Qf1cvShp/index.m3u8|第15集$https://new.jsyunbf.com/20180808/LWpnoEsa/index.m3u8|第16集$https://new.jsyunbf.com/20180808/0mRr8KcL/index.m3u8|第17集$https://new.jsyunbf.com/20180808/gwFywkIu/index.m3u8|第18集$https://new.jsyunbf.com/20180808/LQEYFVJv/index.m3u8|第19集$https://new.jsyunbf.com/20180810/16UVlFxy/index.m3u8|第20集$https://new.jsyunbf.com/20180810/B07rbC6s/index.m3u8|第21集$https://new.jsyunbf.com/20180810/IqgttgWK/index.m3u8|第22集$https://new.jsyunbf.com/20180811/NC6SsVsT/index.m3u8|第23集$https://new.jsyunbf.com/20180814/8HZTYQiB/index.m3u8|第24集$https://new.jsyunbf.com/20180814/8MvPWw52/index.m3u8|第25集$https://new.jsyunbf.com/20180817/8KXjediw/index.m3u8|第26集$https://new.jsyunbf.com/20180817/gShddkpT/index.m3u8|第27集$https://new.jsyunbf.com/20180817/atCtaCiu/index.m3u8|第28集$https://new.jsyunbf.com/20180817/pzAXC3uH/index.m3u8|第29集$https://new.jsyunbf.com/20180821/k2pAaawO/index.m3u8|第30集$https://new.jsyunbf.com/20180821/Ydpv1thb/index.m3u8|第31集$https://new.jsyunbf.com/20180824/AUMsPm0e/index.m3u8|第32集$https://new.jsyunbf.com/20180824/X5ZiD6fQ/index.m3u8|第33集$https://new.jsyunbf.com/20180824/flsXUKi1/index.m3u8|第34集$https://new.jsyunbf.com/20180828/xcBSfDCa/index.m3u8|第35集$https://new.jsyunbf.com/20180828/EYk7WfSF/index.m3u8|第36集$https://new.jsyunbf.com/20180828/2tAtXj4u/index.m3u8 ', '后唐乱世，少女七雪被父抛弃卖到青楼，在一次阴差阳错之下误入神秘的姽婳城，被赐名晚媚。她在一次次任务中艰难挣扎，幸得身世成谜的影子长安多方卫护，两人斡旋于朝野纷争，又因姽婳城的禁忌，受困于内心对于对方的感情。晚媚涅槃重生，成为姽婳城新任城主，而这一切都在姽婳城幕后的主人，公子的算计之中。', '2018年08月29日', '电视剧');

-- ----------------------------
-- Table structure for shipin_fl
-- ----------------------------
DROP TABLE IF EXISTS `shipin_fl`;
CREATE TABLE `shipin_fl`  (
  `uid` int(20) NOT NULL AUTO_INCREMENT,
  `fenlei` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频分类',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shipin_fl
-- ----------------------------
INSERT INTO `shipin_fl` VALUES (1, '推荐');
INSERT INTO `shipin_fl` VALUES (2, '动漫');
INSERT INTO `shipin_fl` VALUES (3, '电视剧');
INSERT INTO `shipin_fl` VALUES (4, '综艺');

SET FOREIGN_KEY_CHECKS = 1;
