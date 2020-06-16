<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 缓存助手
 *
 * @link           http://www.yunziyuan.com.cn
 */


function getCaches($type,$id=0,$page=1)
{
    global $cache_type;
    switch ($cache_type){
        case 'redis':
            return getRedisCache($type,$id,$page);
            break;
        case 'file':
            return getFileCache($type,$id,$page);
            break;
    }
}

function setCaches($type,$id=0,$page=1,$content='')
{
    global $cache_type;
    switch ($cache_type){
        case 'redis':
            setRedisCache($type,$id,$page,$content);
            break;
        case 'file':
            setFileCache($type,$id,$page,$content);
            break;
    }
}

function getRedisInfo()
{
    global $redis,$cache_expire;
    if(!$redis){
        require_once(DEDEINC."/redis.class.php");
        if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
        $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
        $redisConfig = array(
            'host'=>'127.0.0.1',
            'port'=>6379,
            'password'=>'',
            'select'=>0,
            'expire'=>$expire,
            'prefix'=>'dede_',
        );
        $redis = $GLOBALS['redis'] = new RedisHelper($redisConfig);
    }
    return $redis->info();
}
function getRedisCache($type,$id=0,$page=1)
{
    global $redis,$cache_expire;
    if(!$redis){
        require_once(DEDEINC."/redis.class.php");
        if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
        $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
        $redisConfig = array(
            'host'=>'127.0.0.1',
            'port'=>6379,
            'password'=>'',
            'select'=>0,
            'expire'=>$expire,
            'prefix'=>'dede_',
        );
        $redis = $GLOBALS['redis'] = new RedisHelper($redisConfig);
    }
    return $redis->get($type.'_'.$id.'_'.$page);
}
function getFileCache($type,$id=0,$page=1)
{
    helper('cache');
    return GetCache('rewrite',$type.'_'.$id.'_'.$page);
}

function setRedisCache($type,$id=0,$page=1,$content='')
{
    global $redis,$cache_expire;
    if(!$redis){
        require_once(DEDEINC."/redis.class.php");
        if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
        $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
        $redisConfig = array(
            'host'=>'127.0.0.1',
            'port'=>6379,
            'password'=>'',
            'select'=>0,
            'expire'=>$expire,
            'prefix'=>'dede_',
        );
        $redis = $GLOBALS['redis'] = new RedisHelper($redisConfig);
    }
    if($content)
        $redis->set($type.'_'.$id.'_'.$page,$content);
}

function setFileCache($type,$id=0,$page=1,$content='')
{
    helper('cache');
    global $cache_expire;
    if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
    $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
    if($content)
        SetCache('rewrite',$type.'_'.$id.'_'.$page,$content,$expire*60);
}

function delRedisCache($type,$id,$page=1)
{
    global $redis,$cache_expire;
    if(!$redis){
        require_once(DEDEINC."/redis.class.php");
        if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
        $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
        $redisConfig = array(
            'host'=>'127.0.0.1',
            'port'=>6379,
            'password'=>'',
            'select'=>0,
            'expire'=>$expire,
            'prefix'=>'dede_',
        );
        $redis = $GLOBALS['redis'] = new RedisHelper($redisConfig);
    }
    $redis->rm($type.'_'.$id.'_'.$page);
}

function delFileCache($type,$id,$page=1)
{
    helper('cache');
    DelCache('rewrite',$type.'_'.$id.'_'.$page);
}

function delWriteCache($type,$id,$page=1)
{
    global $cache_type;
    switch ($cache_type){
        case 'redis':
            delRedisCache($type,$id,$page);
            break;
        case 'file':
            delFileCache($type,$id,$page);
            break;
    }
}

function delAllCache()
{
    global $cache_type;
    switch ($cache_type){
        case 'redis':
            return delAllRedisCache();
            break;
        case 'file':
            return delAllFileCache();
            break;
    }
}
function delAllRedisCache()
{
    global $redis,$cache_expire;
    if(!$redis){
        require_once(DEDEINC."/redis.class.php");
        if(!isset($cache_expire)) $cache_expire = 60;       //默认缓存60分钟
        $expire = $cache_expire ? $cache_expire*60 : 0;  //缓存过期时间
        $redisConfig = array(
            'host'=>'127.0.0.1',
            'port'=>6379,
            'password'=>'',
            'select'=>0,
            'expire'=>$expire,
            'prefix'=>'dede_',
        );
        $redis = $GLOBALS['redis'] = new RedisHelper($redisConfig);
    }
    return $redis->clear();
}

function delAllFileCache($dir='')
{
    $dir = empty($dir) ? DEDEDATA."/cache/rewrite" : $dir;
    if(!is_dir($dir)) {
        return NULL;
    }
    $dh = opendir($dir);
    while(($row = readdir($dh)) !== false) {
        if($row == '.' || $row == '..')  continue;

        if(!is_dir($dir . '/' . $row)) {
            unlink($dir . '/' . $row);
        } else {
            delAllFileCache($dir . '/' . $row); //递归把子目录/子文件删了
        }
    }
    closedir($dh);
    rmdir($dir);
    return true;
}