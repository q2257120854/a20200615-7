<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"template/default_pc/html/topic/detail.html";i:1582533410;s:70:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/include.html";i:1582533410;s:67:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/head.html";i:1582533410;s:67:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/foot.html";i:1582533410;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $obj['topic_name']; ?>专题详情- <?php echo $maccms['site_name']; ?></title>
    <meta name="keywords" content="<?php echo $obj['topic_name']; ?>电影专题,<?php echo $obj['topic_name']; ?>电视剧专题,<?php echo $obj['topic_name']; ?>综艺专题,<?php echo $obj['topic_name']; ?>动漫专题,<?php echo $obj['topic_name']; ?>推荐专题" />
    <meta name="description" content="本站提供<?php echo $obj['topic_name']; ?>,最新最全精品专题数据" />
    <link href="<?php echo $maccms['path']; ?>static/css/home.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $maccms['path_tpl']; ?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $maccms['path']; ?>static/js/jquery.js"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.lazyload.js"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.autocomplete.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.superslide.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.lazyload.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.base.js"></script>
<script>var maccms={"path":"","mid":"<?php echo $maccms['mid']; ?>","aid":"<?php echo $maccms['aid']; ?>","url":"<?php echo $maccms['site_url']; ?>","wapurl":"<?php echo $maccms['site_wapurl']; ?>","mob_status":"<?php echo $maccms['mob_status']; ?>"};</script>
<script src="<?php echo $maccms['path']; ?>static/js/home.js"></script>
<script></script>

</head>
<body>
<!-- 页头 -->
<div class="header">
    <div id="logo"><a href="<?php echo $maccms['path']; ?>" title="<?php echo $maccms['site_name']; ?>"><img src="<?php echo mac_url_img($maccms['site_logo']); ?>" alt="<?php echo $maccms['site_name']; ?>" /></a></div>
    <div id="searchbar">
        <div class="ui-search">
            <form id="search" name="search" method="get" action="<?php echo mac_url('vod/search'); ?>" onSubmit="return qrsearch();">
                <input type="text" name="wd" class="search-input mac_wd" value="<?php echo $param['wd']; ?>" placeholder="请在此处输入影片名或演员名称" />
                <input type="submit" id="searchbutton"  class="search-button mac_search" value="搜索影片" />
            </form>
        </div>
        <div class="hotkeys">热搜：
            <?php $_5e83887abbb61=explode(',',$maccms['search_hot']); if(is_array($_5e83887abbb61) || $_5e83887abbb61 instanceof \think\Collection || $_5e83887abbb61 instanceof \think\Paginator): if( count($_5e83887abbb61)==0 ) : echo "" ;else: foreach($_5e83887abbb61 as $key2=>$vo2): ?>
            <a href="<?php echo mac_url('vod/search',['wd'=>$vo2]); ?>"><?php echo $vo2; ?></a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <ul id="qire-plus">
        <li><a href="<?php echo mac_url('label/rank'); ?>" class=""><i class="ui-icon top-icon"></i>排行</a></li>
        <li><a href="<?php echo mac_url('gbook/index'); ?>"><i class="ui-icon gb-icon"></i>留言</a></li>
        <li><a href="javascript:void(0);" style="cursor:hand; background:none;" onclick="MAC.Fav(location.href,document.title);"><i class="ui-icon fav-icon"></i>收藏</a></li>
    </ul>
</div>
<!-- 导航菜单 -->
<div id="navbar">
    <div class="layout fn-clear">
        <ul id="nav" class="ui-nav">
            <li class="nav-item <?php if($maccms['aid'] == 1): ?> current<?php endif; ?>"><a class="nav-link" href="<?php echo $maccms['path']; ?>">网站首页</a></li>
            <?php $__TAG__ = '{"ids":"parent","order":"asc","by":"sort","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
            <li class="nav-item <?php echo $vo['type_id']; ?>=<?php echo $vo['type_pid']; if(($vo['type_id'] == $GLOBALS['type_id'] || $vo['type_id'] == $GLOBALS['type_pid'])): ?> current<?php endif; ?>"><a class="nav-link" href="<?php echo mac_url_type($vo); ?>"><?php echo $vo['type_name']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <li class="nav-item <?php if($maccms['aid'] == 30): ?> current<?php endif; ?>"><a class="nav-link" href="<?php echo mac_url_topic_index(); ?>">专题</a></li>
            <li class="nav-item mac_user"><a class="nav-link" href="javascript:;">会员</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo mac_url('map/index'); ?>" style=" margin-left:102px; padding:0 0 0 30px; background:url(<?php echo $maccms['path_tpl']; ?>images/ico.png) no-repeat left center;">最近更新</a></li>
        </ul>
    </div>
</div>
<!--当前位置-->
<div class="bread-crumb-nav fn-clear">
    <ul class="bread-crumbs">
        <li class="home"><a href="<?php echo $maccms['path']; ?>">首页</a></li>
        <li>专题详细介绍</li>
        <li class="back"><a href="javascript:MAC.GoBack()">返回上一页</a></li>
    </ul>
</div>
<!--专题-->
<div class="ui-box ui-qire fn-clear" id="list-focus">
    <ul class="zhuanti-con">
        <li><div class="play-img"><img src="<?php echo mac_url_img($obj['topic_pic']); ?>" alt="<?php echo $obj['topic_name']; ?>" /></div>
            <div class="play-txt">
                <h2><?php echo $obj['topic_name']; ?></h2>
                <p class="juqing">专题介绍：<?php echo $obj['topic_content']; ?>.</a></p>
            </div>
        </li>
    </ul>
</div>
<!--专题视频-->
<div class="fn-clear" id="channel-box">
    <!-- 左侧影视 -->
    <div class="qire-box ztl">
        <div class="channel-item">
            <div class="ui-title fn-clear"><span>本专题共“<?php echo count($obj['vod_list']); ?>”部视频</span><h2>专题相关视频</h2></div>
            <div class="box_con">
                <ul class="zt-list">
                    <?php if(is_array($obj['vod_list']) || $obj['vod_list'] instanceof \think\Collection || $obj['vod_list'] instanceof \think\Paginator): if( count($obj['vod_list'])==0 ) : echo "" ;else: foreach($obj['vod_list'] as $key=>$vo): ?>
                    <li><a href="<?php echo mac_url_vod_detail($vo); ?>" title="<?php echo $vo['vod_name']; ?>"><img src="<?php echo mac_url_img($vo['vod_pic']); ?>" alt="<?php echo $vo['vod_name']; ?>"/><h2><?php echo $vo['vod_name']; ?></h2><p><?php echo $vo['vod_actor']; ?></p><i><?php echo $vo['vod_remarks']; ?></i><em></em></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- 右侧文章 -->
    <div class="qire-l ztr">
        <div class="ui-ranking">
            <h3>本专题最新文章</h3>
            <ul class="ranking-list">
                <?php if(is_array($obj['art_list']) || $obj['art_list'] instanceof \think\Collection || $obj['art_list'] instanceof \think\Paginator): if( count($obj['art_list'])==0 ) : echo "" ;else: foreach($obj['art_list'] as $key=>$vo): ?>
                <li><i <?php if($key < 3): ?>class="stress" <?php endif; ?>><?php echo $key+1; ?></i><a href="<?php echo mac_url_art_detail($vo); ?>" title="<?php echo $vo['art_name']; ?>"><?php echo $vo['art_name']; ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
<span style="display:none" class="mac_ulog_set" alt="设置内容页浏览记录" data-type="1" data-mid="<?php echo $maccms['mid']; ?>" data-id="<?php echo $obj['topic_id']; ?>" data-sid="" data-nid=""></span>
<span style="display:none" class="mac_history_set" alt="设置History历史记录" data-name="<?php echo $obj['topic_name']; ?>" data-pic="<?php echo mac_url_img($obj['topic_pic']); ?>"></span>

<!-- 页脚 -->
<div class="footer">
    <div class="foot-nav">
        <?php $__TAG__ = '{"ids":"parent","order":"asc","by":"sort","id":"vo","key":"key"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <a class="color" href="<?php echo mac_url_type($vo); ?>" title="<?php echo $vo['type_name']; ?>"><?php echo $vo['type_name']; ?></a>-
        <?php endforeach; endif; else: echo "" ;endif; ?>

        <a href="<?php echo mac_url('map/index'); ?>" title="最近更新">最近更新</a>-
        <a href="<?php echo mac_url('gbook/index'); ?>" title="反馈留言">反馈留言</a>-
        <a href="<?php echo mac_url('rss/index'); ?>" title="rss">RSS</a>-
        <a href="<?php echo mac_url('rss/baidu'); ?>" target="_blank" title="网站地图">Sitemap</a>
    </div>
    <div class="copyright">
        <p>免责声明：若本站收录的资源侵犯了您的权益，请发邮件至：<?php echo $maccms['site_email']; ?>，我们会及时删除侵权内容，谢谢合作！</p>
        <p>Copyright &#169; 2012-2018 <?php echo $maccms['site_url']; ?>. All Rights Reserved. <?php echo $maccms['site_tj']; ?> </p>
    </div>
</div>
</body>
</html>

