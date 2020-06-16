-- ----------------------------
-- Table structure for #__admin
-- ----------------------------
DROP TABLE IF EXISTS `#__admin`;
CREATE TABLE `#__admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员自增ID',
  `admin_name` varchar(20) NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员密码',
  `admin_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `admin_login_time` int(11) NOT NULL COMMENT '登录时间',
  `admin_login_num` int(11) NOT NULL COMMENT '登录次数',
  `admin_is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级管理员',
  `admin_group_id` smallint(6) DEFAULT '0' COMMENT '权限组ID',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Table structure for #__admingroup
-- ----------------------------
DROP TABLE IF EXISTS `#__admingroup`;
CREATE TABLE `#__admingroup` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限自增id',
  `group_name` varchar(50) DEFAULT NULL COMMENT '权限组名',
  `group_limits` text COMMENT '权限组序列',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限组表';

-- ----------------------------
-- Table structure for #__adminlog
-- ----------------------------
DROP TABLE IF EXISTS `#__adminlog`;
CREATE TABLE `#__adminlog` (
  `adminlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员记录自增ID',
  `admin_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `admin_name` char(20) NOT NULL COMMENT '管理员名称',
  `content` varchar(255) NOT NULL COMMENT '操作内容',
  `createtime` int(11) DEFAULT NULL COMMENT '发生时间',
  `ip` char(15) NOT NULL COMMENT '管理员操作IP',
  `url` varchar(50) NOT NULL DEFAULT '' COMMENT 'controller/action',
  PRIMARY KEY (`adminlog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Table structure for #__adv
-- ----------------------------
DROP TABLE IF EXISTS `#__adv`;
CREATE TABLE `#__adv` (
  `adv_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告自增ID',
  `ap_id` int(11) unsigned NOT NULL COMMENT '广告位ID',
  `adv_title` varchar(255) NOT NULL COMMENT '广告内容描述',
  `adv_link` varchar(255) NOT NULL COMMENT '广告链接地址',
  `adv_code` varchar(1000) DEFAULT NULL COMMENT '广告图片地址',
  `adv_starttime` int(10) DEFAULT NULL COMMENT '广告开始时间',
  `adv_endtime` int(10) DEFAULT NULL COMMENT '广告结束时间',
  `adv_order` int(10) DEFAULT '0' COMMENT '广告图片排序',
  `adv_enabled` tinyint(1) unsigned DEFAULT '1' COMMENT '广告是否有效',
  `adv_clicknum` int(10) DEFAULT '0' COMMENT '广告点击次数',
  `lang_mark` varchar(50) NOT NULL COMMENT '语言包',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Table structure for #__advposition
-- ----------------------------
DROP TABLE IF EXISTS `#__advposition`;
CREATE TABLE `#__advposition` (
  `ap_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位置自增ID',
  `ap_name` varchar(100) NOT NULL COMMENT '广告位名称',
  `ap_intro` varchar(255) NOT NULL COMMENT '广告位简介',
  `ap_isuse` smallint(1) unsigned NOT NULL COMMENT '广告位是否启用：0不启用 1启用',
  `ap_width` int(10) DEFAULT '0' COMMENT '广告位宽度',
  `ap_height` int(10) DEFAULT NULL COMMENT '广告位高度',
  `lang_mark` varchar(50) NOT NULL COMMENT '语言包',
  PRIMARY KEY (`ap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告位表';

-- ----------------------------
-- Table structure for #__cases
-- ----------------------------
DROP TABLE IF EXISTS `#__cases`;
CREATE TABLE `#__cases` (
  `cases_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息ID，自增',
  `cases_title` varchar(200) NOT NULL COMMENT '信息名称',
  `cases_content` longtext NOT NULL COMMENT '信息内容',
  `column_id` int(11) DEFAULT '0' COMMENT '所属一级栏目ID，column表ID值',
  `cases_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `cases_wap_ok` int(1) NOT NULL DEFAULT '0' COMMENT '手机版页面是否显示',
  `cases_new_ok` int(1) NOT NULL DEFAULT '0' COMMENT '最新信息，1为最新，0不是最新',
  `cases_imgurl` varchar(255) NOT NULL COMMENT '缩略图路径',
  `cases_imgurls` varchar(255) NOT NULL COMMENT '原图路径',
  `cases_com_ok` int(1) NOT NULL DEFAULT '0' COMMENT '推荐信息，1为推荐，0为不推荐',
  `cases_hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `cases_updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `cases_addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `cases_issue` varchar(100) NOT NULL COMMENT '发布者',
  `cases_access` int(11) NOT NULL DEFAULT '0' COMMENT '访问权限，会员组ID值，表ID',
  `cases_top_ok` int(1) NOT NULL DEFAULT '0' COMMENT '是否置顶，1置顶，0为不置顶',
  `cases_recycle` int(11) DEFAULT '0' COMMENT '是否被删除到回收站中，0表示没有，3表示已删除到回收站中。值为-1时候表示，在批量上传中，只上传内容，未上传图片的信息',
  `cases_displaytype` int(11) DEFAULT '1' COMMENT '是否在前台显示，1显示，0不显示',
  `cases_links` varchar(200) NOT NULL COMMENT '外部链接',
  `seo_title` varchar(200) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(200) NOT NULL COMMENT 'SEO关键词',
  `seo_description` text NOT NULL COMMENT 'SEO描述',
  `lang_mark` varchar(50) NOT NULL COMMENT '所属语言',
  PRIMARY KEY (`cases_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='案例表';

-- ----------------------------
-- Table structure for #__column
-- ----------------------------
DROP TABLE IF EXISTS `#__column`;
CREATE TABLE `#__column` (
  `column_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目的ID，自增',
  `column_name` varchar(100) NOT NULL COMMENT '栏目名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上机栏目ID',
  `column_module` int(11) NOT NULL COMMENT '所属导航栏目 ',
  `column_order` int(11) NOT NULL COMMENT '排序，越小越靠前',
  `column_wap_ok` int(1) NOT NULL DEFAULT '0' COMMENT '是否在手机版显示',
  `column_keywords` varchar(200) NULL COMMENT '栏目关键词',
  `column_list_order` int(11) NOT NULL DEFAULT '0' COMMENT '列表页排序方式，1更新时间，2发布时间，3点击次数，4ID倒序5ID顺序',
  `column_new_windows` varchar(50) NOT NULL DEFAULT '0' COMMENT '是否新窗口打开，为空或为0不在新窗口中打开，target=''_blank''为在新窗口中打开',
  `column_access` int(11) NOT NULL DEFAULT '0' COMMENT '栏目访问权限，存放为会员组的ID',
  `column_display` int(11) NOT NULL DEFAULT '0' COMMENT '是否在前台显示，1显示，0不显示',
  `seo_title` varchar(200) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(200) NOT NULL COMMENT 'SEO关键词',
  `seo_description` text NOT NULL COMMENT 'SEO描述',
  `lang_mark` varchar(50) NOT NULL COMMENT '栏目所属语言',
  PRIMARY KEY (`column_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';

-- ----------------------------
-- Table structure for #__config
-- ----------------------------
DROP TABLE IF EXISTS `#__config`;
CREATE TABLE `#__config` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `value` text,
  `remark` varchar(100) DEFAULT NULL,
  `lang_mark` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置表';

-- ----------------------------
-- Table structure for #__exppointslog
-- ----------------------------
DROP TABLE IF EXISTS `#__exppointslog`;
CREATE TABLE `#__exppointslog` (
  `explog_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '经验值日志自增ID',
  `explog_memberid` int(11) NOT NULL COMMENT '会员ID',
  `explog_membername` varchar(100) NOT NULL COMMENT '会员名称',
  `explog_points` int(11) NOT NULL DEFAULT '0' COMMENT '经验值负数表示扣除',
  `explog_addtime` int(11) NOT NULL COMMENT '经验值添加时间',
  `explog_desc` varchar(100) NOT NULL COMMENT '经验值操作描述',
  `explog_stage` varchar(50) NOT NULL COMMENT '经验值操作状态',
  PRIMARY KEY (`explog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='经验值日志表';

-- ----------------------------
-- Table structure for #__job
-- ----------------------------
DROP TABLE IF EXISTS `#__job`;
CREATE TABLE `#__job` (
  `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '职位ID，自增',
  `job_position` varchar(200) NOT NULL COMMENT '职位名称',
  `job_count` int(11) NOT NULL DEFAULT '0' COMMENT '招聘人数',
  `job_place` varchar(200) NOT NULL COMMENT '工作地点',
  `job_deal` varchar(200) NOT NULL DEFAULT '' COMMENT '薪资水平',
  `job_addtime` int(11) NOT NULL COMMENT '发布时间',
  `job_endtime` int(11) NOT NULL COMMENT '结束时间',
  `job_content` text NOT NULL COMMENT '详细内容',
  `job_access` int(11) NOT NULL DEFAULT '0' COMMENT '访问权限，会员组ID值，admingroup表ID',
  `job_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `job_top_ok` int(1) NOT NULL DEFAULT '0' COMMENT '最新信息，1为最新信息，0不为最新信息',
  `job_email` varchar(255) NOT NULL COMMENT '邮箱地址',
  `job_displaytype` int(11) DEFAULT '1' COMMENT '是否在前台显示，1显示，0不显示',
  `lang_mark` varchar(50) NOT NULL DEFAULT '' COMMENT '所属语言',
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='职位表';

-- ----------------------------
-- Table structure for #__jobcv
-- ----------------------------
DROP TABLE IF EXISTS `#__jobcv`;
CREATE TABLE `#__jobcv` (
  `jobcv_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '简历信息的ID，自增',
  `jobcv_addtime` int(11) NOT NULL COMMENT '投递时间',
  `jobcv_readok` int(11) NOT NULL DEFAULT '0' COMMENT '管理员是否阅读，1为已阅读，0为未阅读',
  `jobcv_customer` varchar(50) NOT NULL DEFAULT '0' COMMENT '投递者身份',
  `jobcv_ip` varchar(255) DEFAULT NULL COMMENT '投递者IP',
  `job_id` int(11) DEFAULT NULL COMMENT '职位ID',
  `resume_name` varchar(32) NOT NULL COMMENT '投递人姓名',
  `resume_sex` tinyint(1) DEFAULT '1' COMMENT '性别 1-男 2-女',
  `resume_birthday` int(11) DEFAULT NULL COMMENT '出生年月',
  `resume_resume_place` varchar(32) DEFAULT NULL COMMENT '籍贯',
  `resume_telephone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `resume_zip_code` int(6) DEFAULT NULL COMMENT '邮编',
  `resume_email` varchar(64) DEFAULT NULL COMMENT '邮箱',
  `resume_education` varchar(64) DEFAULT NULL COMMENT '学历',
  `resume_professional` varchar(64) DEFAULT NULL COMMENT '专业',
  `resume_school` varchar(64) DEFAULT NULL COMMENT '学校',
  `resume_address` varchar(128) DEFAULT NULL COMMENT '通讯地址',
  `resume_awards` text COMMENT '所获奖项',
  `resume_hobby` varchar(255) DEFAULT NULL COMMENT '业余爱好',
  `resume_experience` text COMMENT '工作经历',
  PRIMARY KEY (`jobcv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='投递信息表';

-- ----------------------------
-- Table structure for #__lang
-- ----------------------------
DROP TABLE IF EXISTS `#__lang`;
CREATE TABLE `#__lang` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息ID，自增',
  `lang_name` varchar(100) NOT NULL COMMENT '语言名称',
  `lang_useok` int(1) NOT NULL DEFAULT '0' COMMENT '语言是否开启，1开启，0不开启',
  `lang_mark` varchar(50) NOT NULL COMMENT '语言标识（唯一）',
  `lang_flag` varchar(100) NOT NULL COMMENT '国旗图标路径',
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='语言表';

-- ----------------------------
-- Table structure for #__link
-- ----------------------------
DROP TABLE IF EXISTS `#__link`;
CREATE TABLE `#__link` (
  `link_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情链接自增ID',
  `link_webname` varchar(255) NOT NULL COMMENT '友情网站名称',
  `link_weburl` varchar(255) NOT NULL COMMENT '友情网站链接',
  `link_weblogo` varchar(255) NOT NULL COMMENT '友情链接Logo路径',
  `link_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '友情链接类型（文字或Logo）',
  `link_info` varchar(255) NOT NULL COMMENT '描述文字',
  `link_contact` varchar(255) NOT NULL COMMENT '联系方式',
  `link_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `link_com_ok` int(11) NOT NULL DEFAULT '0' COMMENT '是否推荐，1为推荐，0为不推荐',
  `link_show_ok` int(11) NOT NULL DEFAULT '0' COMMENT '审核，1为审核，0为未审核',
  `link_addtime` int(11) NOT NULL COMMENT '添加时间',
  `lang_mark` varchar(50) NOT NULL COMMENT '所属语言',
  `link_ip` varchar(255) NOT NULL COMMENT '申请人IP',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Table structure for #__member
-- ----------------------------
DROP TABLE IF EXISTS `#__member`;
CREATE TABLE `#__member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员自增ID',
  `member_name` varchar(50) NOT NULL COMMENT '会员用户名',
  `member_truename` varchar(20) DEFAULT NULL COMMENT '会员真实姓名',
  `member_avatar` varchar(50) DEFAULT NULL COMMENT '会员头像',
  `member_sex` tinyint(1) DEFAULT '0' COMMENT '会员性别',
  `member_birthday` int(11) DEFAULT NULL COMMENT '会员生日',
  `member_password` varchar(32) NOT NULL COMMENT '会员密码',
  `member_email` varchar(50) DEFAULT NULL COMMENT '会员邮箱',
  `member_email_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否绑定邮箱',
  `member_mobile` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `member_mobile_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否绑定手机',
  `member_qq` varchar(20) DEFAULT NULL COMMENT '会员QQ',
  `member_loginnum` int(11) NOT NULL DEFAULT '0' COMMENT '会员登录次数',
  `member_add_time` int(11) NOT NULL COMMENT '会员添加时间',
  `member_login_time` int(11) DEFAULT '0' COMMENT '会员当前登录时间',
  `member_old_login_time` int(11) DEFAULT '0' COMMENT '会员上次登录时间',
  `member_login_ip` varchar(20) DEFAULT NULL COMMENT '会员当前登录IP',
  `member_old_login_ip` varchar(20) DEFAULT NULL COMMENT '会员上次登录IP',
  `member_qqopenid` varchar(100) DEFAULT NULL COMMENT 'qq互联id',
  `member_qqinfo` text COMMENT 'qq账号相关信息',
  `member_sinaopenid` varchar(100) DEFAULT NULL COMMENT '新浪微博登录id',
  `member_sinainfo` text COMMENT '新浪账号相关信息序列化值',
  `member_wxopenid` varchar(100) DEFAULT NULL COMMENT '微信互联openid',
  `member_wxunionid` varchar(100) DEFAULT NULL COMMENT '微信用户统一标识',
  `member_wxinfo` text COMMENT '微信用户相关信息',
  `inform_allow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许举报(1可以/2不可以)',
  `is_allowtalk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员是否有咨询和发送站内信的权限 1为开启 0为关闭',
  `member_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员的开启状态 1为开启 0为关闭',
  `member_snsvisitnum` int(11) NOT NULL DEFAULT '0' COMMENT 'sns空间访问次数',
  `member_areaid` int(11) DEFAULT NULL COMMENT '地区ID',
  `member_cityid` int(11) DEFAULT NULL COMMENT '城市ID',
  `member_provinceid` int(11) DEFAULT NULL COMMENT '省份ID',
  `member_areainfo` varchar(255) DEFAULT NULL COMMENT '地区内容',
  `member_privacy` text COMMENT '隐私设定',
  `member_exppoints` int(11) NOT NULL DEFAULT '0' COMMENT '会员经验值',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Table structure for #__message
-- ----------------------------
DROP TABLE IF EXISTS `#__message`;
CREATE TABLE `#__message` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息ID，自增',
  `message_ip` varchar(255) NOT NULL COMMENT 'IP地址',
  `message_replytime` int(11) DEFAULT NULL COMMENT '回复时间',
  `message_addtime` int(11) NOT NULL COMMENT '提交时间',
  `message_readok` int(11) NOT NULL DEFAULT '0' COMMENT '管理员是否阅读，1为已阅读，0为未阅读',
  `message_useinfo` text NOT NULL COMMENT '管理员回复信息',
  `message_customer` varchar(30) NOT NULL DEFAULT '0' COMMENT '留言者身份，会员',
  `message_title` varchar(50) NOT NULL COMMENT '留言标题',
  `message_ctitle` varchar(50) NOT NULL COMMENT '留言短标题',
  `message_content` varchar(255) NOT NULL COMMENT '留言内容',
  `admin_id` int(11) NOT NULL COMMENT '回复留言的管理员ID',
  `lang_mark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Table structure for #__nav
-- ----------------------------
DROP TABLE IF EXISTS `#__nav`;
CREATE TABLE `#__nav` (
  `nav_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '页面导航自增ID',
  `nav_title` varchar(100) DEFAULT NULL COMMENT '页面导航标题',
  `nav_url` varchar(255) DEFAULT NULL COMMENT '页面导航链接',
  `nav_location` varchar(10) NOT NULL COMMENT '页面导航位置，header头部，middle中部，footer底部',
  `nav_new_open` varchar(50) DEFAULT 'target="_blank"' COMMENT '是否以新窗口打开',
  `nav_order` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '页面导航排序',
  `nav_is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否前台显示，0为否，1为是，默认为1',
  `nav_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示方式 1-PC端  2-手机端',
  `lang_mark` varchar(50) NOT NULL COMMENT '所属语言',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

-- ----------------------------
-- Table structure for #__news
-- ----------------------------
DROP TABLE IF EXISTS `#__news`;
CREATE TABLE `#__news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '信息ID，自增',
  `news_title` varchar(200) DEFAULT NULL COMMENT '信息名称',
  `news_content` longtext NOT NULL COMMENT '信息内容',
  `column_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属一级栏目ID，column表ID值',
  `news_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `news_wap_ok` int(1) NOT NULL DEFAULT '0' COMMENT '手机版页面是否显示，1为显示，0为不显示',
  `news_img_ok` int(1) NOT NULL DEFAULT '0' COMMENT '最新信息，1为最新信息，0为不是最新信息',
  `news_imgurl` varchar(255) NOT NULL COMMENT '缩略图路径',
  `news_imgurls` varchar(255) NOT NULL COMMENT '原图路径',
  `news_com_ok` int(1) NOT NULL DEFAULT '0' COMMENT '推荐信息，1为推荐，0为不推荐',
  `news_issue` varchar(100) NOT NULL COMMENT '发布者',
  `news_hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `news_updatetime` int(11) NOT NULL COMMENT '更新时间',
  `news_addtime` int(11) NOT NULL COMMENT '添加时间',
  `news_access` int(11) NOT NULL DEFAULT '0' COMMENT '访问权限，会员组ID值，表ID',
  `news_top_ok` int(1) NOT NULL DEFAULT '0' COMMENT '是否置顶，1为置顶，0为不置顶',
  `news_recycle` int(11) DEFAULT '0' COMMENT '是否被删除到回收站中，0表示没有，2表示已删除到回收站中。值为-1时候表示，在批量上传中，只上传内容，未上传图片的信息',
  `news_displaytype` int(11) DEFAULT '1' COMMENT '是否在前台显示，1显示，0不显示',
  `news_links` varchar(200) NOT NULL COMMENT '外部链接地址',
  `seo_title` varchar(200) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(200) NOT NULL COMMENT 'SEO关键词',
  `seo_description` text NOT NULL COMMENT 'SEO描述',
  `lang_mark` varchar(50) NOT NULL COMMENT '所属语言',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='新闻表';

-- ----------------------------
-- Table structure for #__pic
-- ----------------------------
DROP TABLE IF EXISTS `#__pic`;
CREATE TABLE `#__pic` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `pic_type` varchar(10) NOT NULL COMMENT '类型，例如案例，新闻',
  `pic_type_id` int(11) NOT NULL COMMENT '图片关联的ID',
  `pic_name` varchar(50) NOT NULL COMMENT '图片名',
  `pic_cover` varchar(255) NOT NULL COMMENT '图片路径',
  `pic_size` int(100) NOT NULL COMMENT '图片大小',
  `pic_time` int(10) NOT NULL COMMENT '图片上传时间',
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图片表';

-- ----------------------------
-- Table structure for #__product
-- ----------------------------
DROP TABLE IF EXISTS `#__product`;
CREATE TABLE `#__product` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '信息ID，自增',
  `product_title` varchar(200) NOT NULL COMMENT '信息名称',
  `product_content` longtext NOT NULL COMMENT '信息内容',
  `column_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属栏目ID，column表ID值',
  `product_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `product_wap_ok` int(1) NOT NULL DEFAULT '0' COMMENT '手机版页面是否显示',
  `product_new_ok` int(1) NOT NULL DEFAULT '0' COMMENT '最新信息，1为最新，0不是最新',
  `product_imgurl` varchar(255) NOT NULL COMMENT '缩略图路径',
  `product_imgurls` varchar(255) NOT NULL COMMENT '原图路径',
  `product_com_ok` int(1) NOT NULL DEFAULT '0' COMMENT '推荐信息，1为推荐，0为不推荐',
  `product_hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `product_updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `product_addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `product_issue` varchar(100) NOT NULL COMMENT '发布者',
  `product_access` int(11) NOT NULL DEFAULT '0' COMMENT '访问权限，会员组ID值，会员表ID',
  `product_top_ok` int(1) NOT NULL DEFAULT '0' COMMENT '是否置顶，1置顶，0为不置顶',
  `product_recycle` int(11) DEFAULT '0' COMMENT '是否被删除到回收站中，0表示没有，3表示已删除到回收站中。值为-1时候表示，在批量上传中，只上传内容，未上传图片的信息',
  `product_displaytype` int(11) DEFAULT '1' COMMENT '是否在前台显示，1显示，0不显示',
  `seo_title` varchar(200) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(200) NOT NULL COMMENT 'SEO关键词',
  `seo_description` text NOT NULL COMMENT 'SEO描述',
  `lang_mark` varchar(50) NOT NULL COMMENT '所属语言',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品表';


-- ----------------------------
-- Table structure for #__smslog
-- ----------------------------
DROP TABLE IF EXISTS `#__smslog`;
CREATE TABLE `#__smslog` (
  `smslog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '短信记录自增ID',
  `smslog_phone` char(11) NOT NULL COMMENT '短信手机号',
  `smslog_captcha` char(6) NOT NULL COMMENT '短信动态码',
  `smslog_ip` varchar(15) NOT NULL COMMENT '短信请求IP',
  `smslog_msg` varchar(300) NOT NULL COMMENT '短信内容',
  `smslog_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '短信类型:1为注册,2为登录,3为找回密码,默认为1',
  `smslog_smstime` int(10) unsigned NOT NULL COMMENT '短信添加时间',
  `member_id` int(10) unsigned DEFAULT '0' COMMENT '短信会员ID,注册为0',
  `member_name` varchar(50) DEFAULT '' COMMENT '短信会员名',
  PRIMARY KEY (`smslog_id`),
  KEY `smslog_phone` (`smslog_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='手机短信记录表';


-- config表数据
INSERT INTO `#__config` VALUES ('1', 'site_name', '德尚CMS', '官网名称', 'zh-cn');
INSERT INTO `#__config` VALUES ('2', 'site_phone', '3', '官网客服服务电话', 'zh-cn');
INSERT INTO `#__config` VALUES ('3', 'site_state', '1', '官网状态', 'zh-cn');
INSERT INTO `#__config` VALUES ('4', 'site_logo', 'site_logo.png', '官网logo图', 'zh-cn');
INSERT INTO `#__config` VALUES ('5', 'member_logo', 'member_logo.png', '默认会员图', 'zh-cn');
INSERT INTO `#__config` VALUES ('7', 'site_mobile_logo', 'site_mobile_logo.jpg', '默认官网手机端logo', 'zh-cn');
INSERT INTO `#__config` VALUES ('8', 'site_logowx', 'site_logowx.jpg', '微信二维码', 'zh-cn');
INSERT INTO `#__config` VALUES ('9', 'icp_number', '22222', 'ICP备案号', 'zh-cn');
INSERT INTO `#__config` VALUES ('10', 'site_tel400', '40002541852', '解释,备注', 'zh-cn');
INSERT INTO `#__config` VALUES ('11', 'site_email', '858761000@qq.com', '电子邮件', 'zh-cn');
INSERT INTO `#__config` VALUES ('12', 'flow_static_code', '德尚网络科技', '底部版权信息', 'zh-cn');
INSERT INTO `#__config` VALUES ('13', 'closed_reason', '5555', '官网关闭原因', 'zh-cn');
INSERT INTO `#__config` VALUES ('14', 'guest_comment', '1', '是否允许游客咨询', 'zh-cn');
INSERT INTO `#__config` VALUES ('15', 'captcha_status_login', '0', '会员登录是否需要验证码', 'zh-cn');
INSERT INTO `#__config` VALUES ('16', 'captcha_status_register', '1', '会员注册是否验证码', 'zh-cn');
INSERT INTO `#__config` VALUES ('17', 'captcha_status_feedback', '', '是否开启验证码', 'zh-cn');
INSERT INTO `#__config` VALUES ('40', 'smscf_wj_username', '123', '短信平台账号', 'zh-cn');
INSERT INTO `#__config` VALUES ('41', 'smscf_wj_key', '321', '短信平台密钥', 'zh-cn');
INSERT INTO `#__config` VALUES ('51', 'email_host', 'smtp.126.com', '邮箱地址', 'zh-cn');
INSERT INTO `#__config` VALUES ('52', 'email_port', '25', '邮箱端口', 'zh-cn');
INSERT INTO `#__config` VALUES ('53', 'email_addr', '', '邮箱发件人地址', 'zh-cn');
INSERT INTO `#__config` VALUES ('54', 'email_id', '', '身份验证用户名', 'zh-cn');
INSERT INTO `#__config` VALUES ('55', 'email_pass', '', '用户名密码', 'zh-cn');
INSERT INTO `#__config` VALUES ('56', 'email_secure', '', '邮箱发送协议', 'zh-cn');
INSERT INTO `#__config` VALUES ('60', 'cache_open', '1', '是否开启缓存', 'zh-cn');
INSERT INTO `#__config` VALUES ('100', 'template_name', 'default', '当前主题', 'zh-cn');
INSERT INTO `#__config` VALUES ('101', 'style_name', 'default', '当前样式', 'zh-cn');
INSERT INTO `#__config` VALUES ('121', 'sms_register', '1', '是否手机注册', 'zh-cn');
INSERT INTO `#__config` VALUES ('122', 'sms_login', '1', '是否手机号登录', 'zh-cn');
INSERT INTO `#__config` VALUES ('123', 'sms_password', '1', '是否手机找回密码', 'zh-cn');
INSERT INTO `#__config` VALUES ('130', 'seo_home_title', '', 'SEO标题后台设置', 'zh-cn');
INSERT INTO `#__config` VALUES ('131', 'seo_home_title_type', '', 'SEO展示方式', 'zh-cn');
INSERT INTO `#__config` VALUES ('132', 'seo_home_keywords', '', 'SEO关键词后台设置', 'zh-cn');
INSERT INTO `#__config` VALUES ('133', 'seo_home_description', '', 'SEO描述后台设置', 'zh-cn');


-- 广告位
INSERT INTO `#__advposition` VALUES ('1', 'PC-首页-轮播图', 'PC-首页-轮播图', '1', '1920', '400', 'zh-cn');
INSERT INTO `#__advposition` VALUES ('2', 'PC-客户案例-banner', 'PC-客户案例-banner', '1', '1200', '600', 'zh-cn');
INSERT INTO `#__advposition` VALUES ('3', 'PC-公司产品-banner', 'PC-公司产品-banner', '1', '1200', '600', 'zh-cn');
INSERT INTO `#__advposition` VALUES ('4', 'PC-新闻资讯-banner', 'PC-新闻资讯-banner', '1', '1200', '600', 'zh-cn');
INSERT INTO `#__advposition` VALUES ('5', 'PC-招贤纳士-banner', 'PC-招贤纳士-banner', '1', '1200', '600', 'zh-cn');

-- 广告
INSERT INTO `#__adv` VALUES (1, 1, 'PC-首页-轮播图1', 'http://www.csdeshang.com', '5b97c9e1e5701.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (2, 1, 'PC-首页-轮播图1', 'http://www.csdeshang.com', '5b97c9e1e5702.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (3, 1, 'PC-首页-轮播图1', 'http://www.csdeshang.com', '5b97c9e1e5703.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (4, 1, 'PC-首页-轮播图1', 'http://www.csdeshang.com', '5b97c9e1e5704.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (5, 2, 'PC-客户案例-banner1', 'http://www.csdeshang.com', '5b97c9e1e5711.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (6, 3, 'PC-公司产品-banner1', 'http://www.csdeshang.com', '5b97c9e1e5712.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (7, 4, 'PC-新闻资讯-banner1', 'http://www.csdeshang.com', '5b97c9e1e5713.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');
INSERT INTO `#__adv` VALUES (8, 5, 'PC-招贤纳士-banner1', 'http://www.csdeshang.com', '5b97c9e1e5714.jpg', 1536595200, 1568131200, 255, 1, 0, 'zh-cn');



-- 友链
INSERT INTO `#__link` VALUES ('1', '百度', 'https://www.baidu.com', '20180824\\ac825bafb3565ee1ee6a822d06c6618f.jpg', '1', '1231234', '', '255', '1', '1', '1534348800', 'zh-cn', '127.0.0.1');
INSERT INTO `#__link` VALUES ('2', '腾讯', 'https://www.qq.com', '20180824\\ca3305c6b9b2bc7182fd1dd9c6e557d4.jpg', '1', '123123', '', '255', '1', '1', '1534348800', 'zh-cn', '127.0.0.1');
INSERT INTO `#__link` VALUES ('3', '网易', 'https://www.163.com', '20180824\\e9ef678d084023005b977f5c1ccfafb3.jpg', '1', '123', '', '1', '0', '1', '1535040000', 'zh-cn', '127.0.0.1');
INSERT INTO `#__link` VALUES ('4', '阿里', 'https://www.1688.com', '20180824\\391db3af2c4bb68162961d6937414c7f.jpg', '1', '444', '', '255', '1', '1', '1535040000', 'zh-cn', '127.0.0.1');

-- 语言
INSERT INTO `#__lang` VALUES ('1', '简体中文', '1', 'zh-cn', '');
INSERT INTO `#__lang` VALUES ('2', '美式英文', '1', 'en-us', '');

-- 导航
INSERT INTO `#__nav` VALUES ('1', '官方网站', 'http://www.csdeshang.com/home/dscms/index.html', 'header', 'target=\"_blank\"', '1', '1', '1', 'zh-cn');
INSERT INTO `#__nav` VALUES ('2', 'DSCMS使用手册', 'http://www.csdeshang.com/home/help/article/id/202.html', 'header', 'target=\"_blank\"', '1', '1', '1', 'zh-cn');
INSERT INTO `#__nav` VALUES ('8', '案例中心', 'http://dscms.csdeshang.com/home/cases/search', 'header', 'target=\"_blank\"', '255', '1', '2', 'zh-cn');
INSERT INTO `#__nav` VALUES ('9', '产品中心', 'http://dscms.csdeshang.com/home/product/search', 'header', 'target=\"_blank\"', '255', '1', '2', 'zh-cn');
INSERT INTO `#__nav` VALUES ('10', '新闻资讯', 'http://dscms.csdeshang.com/home/news/search', 'header', 'target=\"_blank\"', '255', '1', '2', 'zh-cn');
INSERT INTO `#__nav` VALUES ('11', '招贤纳士', 'http://dscms.csdeshang.com/home/job/index', 'header', 'target=\"_blank\"', '255', '1', '2', 'zh-cn');


-- 栏目
INSERT INTO `#__column` VALUES ('1', '德尚快讯', '0', '1', '255', '0', '', '0', '', '0','1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('2', '咨询德尚', '0', '1', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('3', 'DSCMS', '0', '1', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('4', '商城建设', '0', '1', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('5', '行业动态', '0', '1', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('6', 'DSSHOP', '0', '2', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('7', 'DSMALL', '0', '2', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('8', '案例展示', '0', '3', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('9', '客户案例', '0', '3', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('10', '招贤纳士', '0', '4', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('11', '在线应聘', '0', '4', '0', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('12', '关于德尚', '0', '6', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('13', '我的信息', '0', '6', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');
INSERT INTO `#__column` VALUES ('14', '用户中心', '0', '6', '255', '0', '', '0', '', '0', '1', '','','','zh-cn');

