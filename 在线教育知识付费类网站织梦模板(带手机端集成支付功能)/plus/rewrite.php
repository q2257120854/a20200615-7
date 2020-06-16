<?php
/**
 * 织梦伪静态助手
 * @link           https://www.yunziyuan.com.cn
 */
require_once (dirname(__FILE__) . "/../member/config.php");
helper('caches');
$s = $_GET['s'];
$s = ltrim($s,'/');
$mobile = $_GET['mobile'];
if(!$mobile && $dedemao_jump=='on' && isRewriteMobile() && $dedemao_domain){
    //header('HTTP/1.1 301 Moved Permanently');
    header('Location: '.rtrim($dedemao_domain,'/').'/'.$s);
    exit;
}
//首页
if(empty($s) || in_array($s,array('index.php','index.html'))){
    showIndex();
    exit();
}

//标签封面页
$count = preg_match('/^\/?tags\.html$/',$s,$matches);
if($count>0){
    $_SERVER['QUERY_STRING'] = '';
    showTagList();
    exit();
}
//标签列表页
$count = preg_match('/^\/?tags\/(.*)\.html$/',$s,$matches);
if($count>0){
    $_SERVER['QUERY_STRING'] = '/'.$matches[1];
    showTagList();
    exit();
}

//搜索页
$count = preg_match('/^\/?search\/(.*)\.html$/',$s,$matches);
if($count>0){
    $matchInfo = explode('/',$matches[1]);
    $q = $matchInfo[0];
    $PageNo = $matchInfo[1]?intval($matchInfo[1]):1;
    showSearch();
    exit();
}

//列表栏目(分页)
$count = preg_match('/^(.*)\/list_([0-9]+)\.html$/',$s,$matches);
if($count>0){
    $tid = $matches[1];
    $PageNo = $matches[2];
    showList();
    exit();
}

//列表栏目(分页)
$count = preg_match('/^(.*)\/list_([0-9]+)_([0-9]+)\.html$/',$s,$matches);
if($count>0){
    $tid = $matches[2];
    $PageNo = $matches[3];
    showList();
    exit();
}

//文章页（分页）
$count = preg_match('/^(.*)\/([0-9]+)_([0-9]+)\.html$/',$s,$matches);
if($count>0){
    $aid = $matches[2];
    $pageno = $matches[3];
    showArticle();
    exit();
}

//文章页
$count = preg_match('/^(.*)\/(.*)\.html$/',$s,$matches);
if($count>0 && $matches[2]!='index'){
    $aid = $matches[2];
    showArticle();
    exit();
}

//列表栏目（首页）
$count = preg_match('/^(.*)$/',$s,$matches);
if($count>0){
    $tid = str_replace('index.html','',$matches[1]);
    showList();
    exit();
}


function showIndex()
{
    global $dsql,$mobile,$dedemao_path,$dedemao_visit,$cfg_basedir,$cfg_templets_dir,$rewrite_index;
    require_once DEDEINC."/arc.partview.class.php";
    $indexFilePath =  $mobile==1 ? DEDEROOT.'/m/index.html' : DEDEROOT.'/index.html';
    if($rewrite_index=='off' && file_exists($indexFilePath)){
        echo file_get_contents($indexFilePath);
        exit();
    }
    $cacheType = $mobile ? 'index_m' : 'index';
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_index']=='on'){
        $content = getCaches($cacheType,'','');
        if($content){
            echo $content;exit();
        }
    }
    $GLOBALS['_arclistEnv'] = 'index';
    $row = $dsql->GetOne("Select * From `#@__homepageset`");
    $row['templet'] = MfTemplet($row['templet']);
    $pv = new PartView();
    if($mobile==1){
        define('DEDEMOB', 'Y');
        if(!$dedemao_path) $dedemao_path='/m';
        if($dedemao_visit=='top') $dedemao_path='/';
        $GLOBALS['cfg_cmspath'] = $GLOBALS['cfg_cmsurl'] = rtrim($dedemao_path,'/');
        $GLOBALS['cfg_indexurl'] = rtrim($dedemao_path,'/').'/index.html';
        $row['templet'] =str_replace('.htm','_m.htm',$row['templet']);
    }
    if ( !file_exists($cfg_basedir . $cfg_templets_dir . "/" . $row['templet']) )
    {
        echo "模板文件不存在，无法解析文档！";
        exit();
    }
    $pv->SetTemplet($cfg_basedir . $cfg_templets_dir . "/" . $row['templet']);
    $pv->Display();
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_index']=='on'){
        setCaches($cacheType,'','',$pv->dtp->GetResult());
    }
    exit();
}

function showTagList()
{
    global $mobile,$dedemao_path,$dedemao_visit,$PageNo,$dsql;
    require_once (DEDEINC . "/arc.taglist.class.php");
    $PageNo = 1;
    $tagTemplate = 'tag.htm';
    $tagListTemplate = 'taglist.htm';
    if($mobile==1){
        define('DEDEMOB', 'Y');
        if(!$dedemao_path) $dedemao_path='/m';
        if($dedemao_visit=='top') $dedemao_path='/';
        $GLOBALS['cfg_cmspath'] = $GLOBALS['cfg_cmsurl'] = rtrim($dedemao_path,'/');
        $GLOBALS['cfg_indexurl'] = rtrim($dedemao_path,'/').'/index.html';
        $tagTemplate =str_replace('.htm','_m.htm',$tagTemplate);
        $tagListTemplate =str_replace('.htm','_m.htm',$tagListTemplate);
    }
    if(isset($_SERVER['QUERY_STRING'])){
        $tag = trim($_SERVER['QUERY_STRING']);
        $tags = explode('/', $tag);
        if(isset($tags[1])) $tag = $tags[1];
        if(isset($tags[2])) $PageNo = intval($tags[2]);
    }
    else $tag = '';
    $tag = FilterSearch(urldecode($tag));
    if($tag != addslashes($tag)) $tag = '';
    if($mobile==1){
        $tag = str_replace('&mobile=1','',$tag);
        $tag = str_replace('mobile=1','',$tag);
    }
    $cacheType = $mobile ? 'tag_m' : 'tag';
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_tag']=='on'){
        $content = getCaches($cacheType,base64_encode($tag),$PageNo);
        if($content){
            echo $content;exit();
        }
    }
    if(is_numeric($tag)){
        $row = $dsql->GetOne("Select tag From `#@__tagindex` where id = '{$tag}' ");
        if($row['tag']) $tag = $row['tag'];
    }
    if($tag == '') $dlist = new TagList($tag, $tagTemplate);
    else $dlist = new TagList($tag, $tagListTemplate);
    $dlist->Display();
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_tag']=='on'){
        setCaches($cacheType,base64_encode($tag),$PageNo,$dlist->dtp->GetResult());
    }
    exit();
}

function showSearch()
{
    global $mobile,$dedemao_path,$dedemao_visit,$cfg_notallowstr,$cfg_search_time,$dsql,$q,$PageNo;
    require_once(DEDEINC."/arc.searchview.class.php");
    if($mobile==1){
        define('DEDEMOB', 'Y');
        if(!$dedemao_path) $dedemao_path='/m';
        if($dedemao_visit=='top') $dedemao_path='/';
        $GLOBALS['cfg_cmspath'] = $GLOBALS['cfg_cmsurl'] = rtrim($dedemao_path,'/');
        $GLOBALS['cfg_indexurl'] = rtrim($dedemao_path,'/').'/index.html';
    }
    $pagesize = (isset($pagesize) && is_numeric($pagesize)) ? $pagesize : 10;
    $typeid = (isset($typeid) && is_numeric($typeid)) ? $typeid : 0;
    $channeltype = (isset($channeltype) && is_numeric($channeltype)) ? $channeltype : 0;
    $kwtype = (isset($kwtype) && is_numeric($kwtype)) ? $kwtype : 0;
    $mid = (isset($mid) && is_numeric($mid)) ? $mid : 0;
    if(!isset($orderby)) $orderby='';
    else $orderby = preg_replace("#[^a-z]#i", '', $orderby);
    if(!isset($searchtype)) $searchtype = 'titlekeyword';
    else $searchtype = preg_replace("#[^a-z]#i", '', $searchtype);
    if(!isset($keyword)){
        if(!isset($q)) $q = '';
        $keyword=$q;
    }
    $oldkeyword = $keyword = FilterSearch(stripslashes($keyword));
    //查找栏目信息
    if(empty($typeid)){
        $typenameCacheFile = DEDEDATA.'/cache/typename.inc';
        if(!file_exists($typenameCacheFile) || filemtime($typenameCacheFile) < time()-(3600*24) ){
            $fp = fopen(DEDEDATA.'/cache/typename.inc', 'w');
            fwrite($fp, "<"."?php\r\n");
            $dsql->SetQuery("Select id,typename,channeltype From `#@__arctype`");
            $dsql->Execute();
            while($row = $dsql->GetArray()){
                fwrite($fp, "\$typeArr[{$row['id']}] = '{$row['typename']}';\r\n");
            }
            fwrite($fp, '?'.'>');
            fclose($fp);
        }
        //引入栏目缓存并看关键字是否有相关栏目内容
        require_once($typenameCacheFile);
        if(isset($typeArr) && is_array($typeArr))
        {
            foreach($typeArr as $id=>$typename)
            {
                //$keywordn = str_replace($typename, ' ', $keyword);
                $keywordn = $keyword;
                if($keyword != $keywordn)
                {
                    $keyword = HtmlReplace($keywordn);
                    $typeid = intval($id);
                    break;
                }
            }
        }
    }
    $keyword = addslashes(cn_substr($keyword,30));
    $typeid = intval($typeid);
    if($cfg_notallowstr !='' && preg_match("#".$cfg_notallowstr."#i", $keyword)){
        ShowMsg("你的搜索关键字中存在非法内容，被系统禁止！","-1");
        exit();
    }
    if(($keyword=='' || strlen($keyword)<2) && empty($typeid)){
        ShowMsg('关键字不能小于2个字节！','-1');
        exit();
    }
    $cacheType = $mobile ? 'search_m' : 'search';
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_so']=='on'){
        $content = getCaches($cacheType,base64_encode($keyword),$PageNo);
        if($content){
            echo $content;exit();
        }
    }
    //检查搜索间隔时间
    $lockfile = DEDEDATA.'/time.lock.inc';
    $lasttime = file_get_contents($lockfile);
    if(!empty($lasttime) && ($lasttime + $cfg_search_time) > time()){
        ShowMsg('管理员设定搜索时间间隔为'.$cfg_search_time.'秒，请稍后再试！','-1');
        exit();
    }
    //开始时间
    if(empty($starttime)) $starttime = -1;
    else{
        $starttime = (is_numeric($starttime) ? $starttime : -1);
        if($starttime>0)
        {
            $dayst = GetMkTime("2008-1-2 0:0:0") - GetMkTime("2008-1-1 0:0:0");
            $starttime = time() - ($starttime * $dayst);
        }
    }
    $t1 = ExecTime();
    $sp = new SearchView($typeid,$keyword,$orderby,$channeltype,$searchtype,$starttime,$pagesize,$kwtype,$mid);
    $keyword = $oldkeyword;
    $sp->Display();
    PutFile($lockfile, time());
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_so']=='on'){
        setCaches($cacheType,base64_encode($keyword),$PageNo,$sp->dtp->GetResult());
    }
}

function showList()
{
    global $mobile,$dedemao_path,$dedemao_visit,$tid,$dsql,$PageNo;
    helper(array('rewrite','cache'));
    if($mobile==1){
        define('DEDEMOB', 'Y');
        if(!$dedemao_path) $dedemao_path='/m';
        if($dedemao_visit=='top') $dedemao_path='/';
        $GLOBALS['cfg_cmspath'] = $GLOBALS['cfg_cmsurl'] = rtrim($dedemao_path,'/');
        $GLOBALS['cfg_indexurl'] = rtrim($dedemao_path,'/').'/index.html';
    }
    if(!is_numeric($tid))
    {
        $typedir = parse_url($tid, PHP_URL_PATH);
        $typedir = ltrim($typedir,'/');
        $typedir = rtrim($typedir,'/');
        $PageNo = stripos(GetCurUrl(), '.html') ? intval(str_replace('.html', '', end(explode("_", GetCurUrl())))) : 1;
        if($PageNo<1) $PageNo=1;
        $code = GetShortStr($typedir.$PageNo);
        $tid = GetCache('tid',$code);
        if(!$tid){
            $tinfos = $dsql->GetOne("SELECT * FROM `#@__arctype` WHERE typedir='/$typedir' or typedir='{cmspath}/$typedir'");
            if(is_array($tinfos)){
                $tid = $tinfos['id'];
                $typeid = GetSonIds($tid);
                $row = $dsql->GetOne("Select count(id) as total From `#@__archives` where typeid in({$typeid})");
                $TotalResult = is_array($row) ? $row['total'] : 0;
            }else{
                $tid = 0;
            }
            SetCache('tid',$code,$tid);
        }
    }
    $tid = (isset($tid) && is_numeric($tid) ? $tid : 0);
    $channelid = (isset($channelid) && is_numeric($channelid) ? $channelid : 0);

    if($tid==0 && $channelid==0){
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        include(DEDEROOT."/404.html");
        exit();
    }
    $cacheType = $mobile ? 'list_m' : 'list';
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_list']=='on'){
        $content = getCaches($cacheType,$tid,$PageNo);
        if($content){
            echo $content;exit();
        }
    }
    if(isset($TotalResult)) $TotalResult = intval(preg_replace("/[^\d]/", '', $TotalResult));

//如果指定了内容模型ID但没有指定栏目ID，那么自动获得为这个内容模型的第一个顶级栏目作为频道默认栏目
    if(!empty($channelid) && empty($tid))
    {
        $tinfos = $dsql->GetOne("SELECT tp.id,ch.issystem FROM `#@__arctype` tp LEFT JOIN `#@__channeltype` ch ON ch.id=tp.channeltype WHERE tp.channeltype='$channelid' And tp.reid=0 order by sortrank asc");
        if(!is_array($tinfos)) die(" No catalogs in the channel! ");
        $tid = $tinfos['id'];
    }
    else
    {
        $tinfos = $dsql->GetOne("SELECT ch.issystem FROM `#@__arctype` tp LEFT JOIN `#@__channeltype` ch ON ch.id=tp.channeltype WHERE tp.id='$tid' ");
    }
    if(empty($tinfos)){
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        include(DEDEROOT."/404.html");
        exit();
    }
    if($tinfos['issystem']==-1)
    {
        $nativeplace = ( (empty($nativeplace) || !is_numeric($nativeplace)) ? 0 : $nativeplace );
        $infotype = ( (empty($infotype) || !is_numeric($infotype)) ? 0 : $infotype );
        if(!empty($keyword)) $keyword = FilterSearch($keyword);
        $cArr = array();
        if(!empty($nativeplace)) $cArr['nativeplace'] = $nativeplace;
        if(!empty($infotype)) $cArr['infotype'] = $infotype;
        if(!empty($keyword)) $cArr['keyword'] = $keyword;
        include(DEDEINC."/arc.sglistview.class.php");
        $lv = new SgListView($tid,$cArr);
    } else {
        include(DEDEINC."/arc.listview.class.php");
        $lv = new ListView($tid);
        //对设置了会员级别的栏目进行处理
        if(isset($lv->Fields['corank']) && $lv->Fields['corank'] > 0)
        {
            require_once(DEDEINC.'/memberlogin.class.php');
            $cfg_ml = new MemberLogin();
            if( $cfg_ml->M_Rank < $lv->Fields['corank'] )
            {
                $dsql->Execute('me' , "SELECT * FROM `#@__arcrank` ");
                while($row = $dsql->GetObject('me'))
                {
                    $memberTypes[$row->rank] = $row->membername;
                }
                $memberTypes[0] = "游客或没权限会员";
                $msgtitle = "你没有权限浏览栏目：{$lv->Fields['typename']} ！";
                $moremsg = "这个栏目需要 <font color='red'>".$memberTypes[$lv->Fields['corank']]."</font> 才能访问，你目前是：<font color='red'>".$memberTypes[$cfg_ml->M_Rank]."</font> ！";
                include_once(DEDETEMPLATE.'/plus/view_msg_catalog.htm');
                exit();
            }
        }
    }
    if($lv->IsError) ParamError();
    $lv->Display(1);
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_list']=='on'){
        $result = $lv->Fields['ispart']==1 ? $lv->PartView->dtp->GetResult() : $lv->dtp->GetResult();
        setCaches($cacheType,$tid,$PageNo,$result);
    }
}

function showArticle()
{
	
    global $mobile,$dedemao_path,$dedemao_visit,$aid,$dsql;
    require_once(DEDEINC.'/arc.archives.class.php');
    helper(array('rewrite','cache'));
    if($mobile==1){
        define('DEDEMOB', 'Y');
        if(!$dedemao_path) $dedemao_path='/m';
        if($dedemao_visit=='top') $dedemao_path='/';
        $GLOBALS['cfg_cmspath'] = $GLOBALS['cfg_cmsurl'] = rtrim($dedemao_path,'/');
        $GLOBALS['cfg_indexurl'] = rtrim($dedemao_path,'/').'/index.html';
    }
    if(!is_numeric($aid)){
        $curUrl = GetCurUrl();
        $position = stripos($curUrl, '.html');
        $curUrl = substr($curUrl,0,$position+5);
        $curUrlArr = explode("/", $curUrl);
        $aid = $position ? str_replace('.html', '', end($curUrlArr)) : 0;
        $aidpage = explode("_",$aid);
        $aid = $aidpage[0];
        $pageno = intval($aidpage[1]);
        if(!is_numeric($aid)){
            //自定义文件名
            $arcRow = $dsql->GetOne("SELECT * FROM `#@__archives` WHERE filename='{$aid}'");
            if($arcRow['id']) $aid = intval($arcRow['id']);
            else $aid=0;
        }else{
            $aid = intval($aid);
        }
    }
    $pageno = isset($pageno) ? intval($pageno) : 1;
    $cacheType = $mobile ? 'article_m' : 'article';
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_arc']=='on'){
        $content = getCaches($cacheType,$aid,$pageno);
        if($content){
            echo $content;exit();
        }
    }

    $arc = new Archives($aid);
	//九戒织梦 课程权限 
	if($arc->Fields['channel'] == 17 ){
		if(empty($cfg_ml->M_ID)){
		
			ShowMsg('请先登录！', '/member/',  0, 0);
			exit;
		}
	}
	
    if($arc->IsError){
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        include(DEDEROOT."/404.html");
        exit();
    }
    $arc->NameFirst = $aid;
    if($arc->IsError) ParamError();
    $arc->display(1);
    if($GLOBALS['rewrite_cache']=='on' && $GLOBALS['cache_arc']=='on'){
        setCaches($cacheType,$aid,$pageno,$arc->dtp->GetResult());
    }
    exit();
}

function isRewriteMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if(isRewriteWeixin()){
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

function isRewriteWeixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } else {
        return false;
    }
}
