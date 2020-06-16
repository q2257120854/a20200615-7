<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"template/default_pc/html/actor/index.html";i:1582533410;s:70:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/include.html";i:1582533410;s:67:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/head.html";i:1582533410;s:67:"/www/wwwroot/qy.redlk.com/template/default_pc/html/public/foot.html";i:1582533410;}*/ ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $maccms['site_name']; ?>-明星库</title>
<meta name="keywords" content="<?php echo $maccms['site_keywords']; ?>" />
<meta name="description" content="<?php echo $maccms['site_description']; ?>" />
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

<link href="<?php echo $maccms['path_tpl']; ?>css/actor.css" rel="stylesheet" type="text/css" />
</head><body>
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
            <?php $_5e84095dee23f=explode(',',$maccms['search_hot']); if(is_array($_5e84095dee23f) || $_5e84095dee23f instanceof \think\Collection || $_5e84095dee23f instanceof \think\Paginator): if( count($_5e84095dee23f)==0 ) : echo "" ;else: foreach($_5e84095dee23f as $key2=>$vo2): ?>
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
<div class="main" id="latest-focus">
  <div class="datll_com mt10 clearfix">
    <ul class="globalPicTxt picList">
      <?php $__TAG__ = '{"num":"9","order":"desc","by":"time","id":"vo","key":"key"}';$__LIST__ = model("Actor")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
      <li class="liA">
        <div class="pic"> <img src="<?php echo mac_url_img($vo['actor_pic']); ?>" alt="" title="<?php echo $vo['actor_name']; ?>" width="334" height="310">
          <div class="txt"> <span class="sTit"><?php echo $vo['actor_name']; ?></span>
            <p class="pTxt"><span class="sDes"><?php echo $vo['actor_remarks']; ?></span></p>
          </div>
          <a class="aPlayBtn" href="<?php echo mac_url_actor_detail($vo); ?>" title="<?php echo $vo['actor_name']; ?>" target="_blank" ></a> </div>
      </li>
      <?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>
  </div>

  <!--内地明星-->
  <div class="channel-item btop">
    <div class="ui-title fn-clear"><span><a href="<?php echo mac_url('actor/show',['area'=>'大陆']); ?>">查看更多&gt;</a></span>
      <h2>内地明星</h2>
    </div>
    <div class="box_con">
      <ul>
        <?php $__TAG__ = '{"num":"12","area":"\u5927\u9646,\u5185\u5730","order":"desc","by":"time","id":"vo","key":"key"}';$__LIST__ = model("Actor")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <li> <a href="<?php echo mac_url_actor_detail($vo); ?>"><span><img src="<?php echo mac_url_img($vo['actor_pic']); ?>" alt="<?php echo $vo['actor_name']; ?>"></span></a> <a href="<?php echo mac_url_actor_detail($vo); ?>">
          <h3><?php echo $vo['actor_name']; ?></h3></a>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
  <!--港台明星-->
  <div class="channel-item btop">
    <div class="ui-title fn-clear"><span><a href="<?php echo mac_url('actor/show',['area'=>'香港']); ?>">查看更多&gt;</a></span>
      <h2>港台明星</h2>
    </div>
    <div class="box_con">
      <ul>
        <?php $__TAG__ = '{"num":"12","area":"\u9999\u6e2f,\u53f0\u6e7e,\u6fb3\u95e8","order":"desc","by":"time","id":"vo","key":"key"}';$__LIST__ = model("Actor")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <li> <a href="<?php echo mac_url_actor_detail($vo); ?>"><span><img src="<?php echo mac_url_img($vo['actor_pic']); ?>" alt="<?php echo $vo['actor_name']; ?>"></span></a> <a href="<?php echo mac_url_actor_detail($vo); ?>">
          <h3><?php echo $vo['actor_name']; ?></h3></a>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
  <!--韩日明星-->
  <div class="channel-item btop">
    <div class="ui-title fn-clear"><span><a href="<?php echo mac_url('actor/show',['area'=>'日本']); ?>">查看更多&gt;</a></span>
      <h2>韩日明星</h2>
    </div>
    <div class="box_con">
      <ul>
        <?php $__TAG__ = '{"num":"12","area":"\u97e9\u56fd,\u65e5\u672c,\u4e9a\u6d32","order":"desc","by":"time","id":"vo","key":"key"}';$__LIST__ = model("Actor")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <li> <a href="<?php echo mac_url_actor_detail($vo); ?>"><span><img src="<?php echo mac_url_img($vo['actor_pic']); ?>" alt="<?php echo $vo['actor_name']; ?>"></span></a> <a href="<?php echo mac_url_actor_detail($vo); ?>">
          <h3><?php echo $vo['actor_name']; ?></h3></a>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
  <!--欧美明星-->
  <div class="channel-item btop">
    <div class="ui-title fn-clear"><span><a href="<?php echo mac_url('actor/show',['area'=>'美国']); ?>">查看更多&gt;</a></span>
      <h2>欧美明星</h2>
    </div>
    <div class="box_con">
      <ul>
        <?php $__TAG__ = '{"num":"12","area":"\u7f8e\u56fd,\u6b27\u7f8e,\u6b27\u6d32","order":"desc","by":"time","id":"vo","key":"key"}';$__LIST__ = model("Actor")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
        <li> <a href="<?php echo mac_url_actor_detail($vo); ?>"><span><img src="<?php echo mac_url_img($vo['actor_pic']); ?>" alt="<?php echo $vo['actor_name']; ?>"></span></a> <a href="<?php echo mac_url_actor_detail($vo); ?>">
          <h3><?php echo $vo['actor_name']; ?></h3></a>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
</div>
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