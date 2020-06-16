<?php
/**
 * 伯乐发卡安装程序
 *
 * 安装完成后建议删除此文件
 * @author Mr zhang
 * @website http://313t.taobao.com
 */
// 定义目录分隔符
define('DS', DIRECTORY_SEPARATOR);

// 定义根目录
define('ROOT_PATH', __DIR__ . DS);

// 定义应用目录
define('APP_PATH', ROOT_PATH . 'app' . DS);

// 安装包目录
define('INSTALL_PATH', ROOT_PATH . 'install' . DS );

// 判断文件或目录是否有写的权限
function is_really_writable($file)
{
    if (DIRECTORY_SEPARATOR == '/' AND @ ini_get("safe_mode") == FALSE)
    {
        return is_writable($file);
    }
    if (!is_file($file) OR ( $fp = @fopen($file, "r+")) === FALSE)
    {
        return FALSE;
    }

    fclose($fp);
    return TRUE;
}

$sitename = "伯乐发卡系统";

$link = array(
    'qqun'  => "//shang.qq.com/wpa/qunwpa?idkey=7c405bba8fd5907a211bf1a84c9ce89e5ce8bb0cc80218c380601694d7f65b83",
);




//错误信息
$errInfo = '';

//数据库配置文件
$dbConfigFile = APP_PATH . 'db.php';
// 锁定的文件
$lockFile = INSTALL_PATH . 'install.lock';
if (is_file($lockFile))
{
    $errInfo = "当前已经安装{$sitename}，如果需要重新安装，请手动移除/install/install.lock文件";
}
else if (version_compare(PHP_VERSION, '5.6.0', '<'))
{
    $errInfo = "当前版本(" . PHP_VERSION . ")过低，请使用PHP5.6或以上版本，官方建议php7.0";
}
else if (!extension_loaded("PDO"))
{
    $errInfo = "当前未开启PDO，无法进行安装";
}
else if (!is_really_writable($dbConfigFile))
{
    $errInfo = "当前权限不足，无法写入配置文件/Config.php";

}
// 当前是POST请求
if (!$errInfo && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $err = '';
    $mysqlHostname = isset($_POST['mysqlHost']) ? $_POST['mysqlHost'] : 'localhost';
    $mysqlHostport = 3306;
    $hostArr = explode(':', $mysqlHostname);
    if (count($hostArr) > 1)
    {
        $mysqlHostname = $hostArr[0];
        $mysqlHostport = $hostArr[1];
    }
    $mysqlUsername = isset($_POST['mysqlUsername']) ? $_POST['mysqlUsername'] : 'root';
    $mysqlPassword = isset($_POST['mysqlPassword']) ? $_POST['mysqlPassword'] : '';
    $mysqlDatabase = isset($_POST['mysqlDatabase']) ? $_POST['mysqlDatabase'] : 'blfk';
    $adminUsername = isset($_POST['adminUsername']) ? $_POST['adminUsername'] : 'admin';
    $adminPassword = isset($_POST['adminPassword']) ? $_POST['adminPassword'] : '123456';
    $adminPasswordConfirmation = isset($_POST['adminPasswordConfirmation']) ? $_POST['adminPasswordConfirmation'] : '123456';
    $adminEmail = isset($_POST['adminEmail']) ? $_POST['adminEmail'] : 'admin@admin.com';

    if ($adminPassword !== $adminPasswordConfirmation)
    {
        echo "两次输入的密码不一致";
        exit;
    }
    else if (!preg_match("/^\w+$/", $adminUsername))
    {
        echo "用户名只能输入字母、数字、下划线";
        exit;
    }
    else if (!preg_match("/^[\S]+$/", $adminPassword))
    {
        echo "密码不能包含空格";
        exit;
    }
    else if (strlen($adminUsername) < 3 || strlen($adminUsername) > 12)
    {
        echo "用户名请输入3~12位字符";
        exit;
    }
    else if (strlen($adminPassword) < 6 || strlen($adminPassword) > 16)
    {

        echo "密码请输入6~16位字符";
        exit;
    }
    try
    {
        //检测能否读取安装文件
        $sql = @file_get_contents(INSTALL_PATH . 'blfk.sql');
        if (!$sql)
        {
            throw new Exception("无法读取/install/blfk.sql文件，请检查是否有读权限");
        }
        $pdo = new PDO("mysql:host={$mysqlHostname};port={$mysqlHostport}", $mysqlUsername, $mysqlPassword, array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));

        $pdo->query("CREATE DATABASE IF NOT EXISTS `{$mysqlDatabase}` CHARACTER SET utf8 COLLATE utf8_general_ci;");

        $pdo->query("USE `{$mysqlDatabase}`");

        $pdo->exec($sql);

        $conphp = "<?php
    return [
    'server'=>'".$mysqlHostname."',
    'port'=>'".$mysqlHostport."',
    'user'=>'".$mysqlUsername."',
    'pass'=>'".$mysqlPassword."',
    'name'=>'".$mysqlDatabase."',
    'prefix'=>'bl_',
    'driver'=>'pdo',
    'debug'=>true,
];";
        //检测能否成功写入数据库配置
        $result = @file_put_contents($dbConfigFile, $conphp);
        if (!$result)
        {
            throw new Exception("无法写入数据库信息到db.php文件，请检查是否有写权限");
        }

        //检测能否成功写入lock文件
        $result = @file_put_contents($lockFile, 1);
        if (!$result)
        {
            throw new Exception("无法写入安装锁定到/install/install.lock文件，请检查是否有写权限");
        }
        date_default_timezone_set ("Asia/Chongqing");
        $newPassword = sha1($adminPassword);      
        $ctime = date('Y-m-d',time());
        $siteurl = 'http://'.$_SERVER['SERVER_NAME'];
        $pdo->query("UPDATE bl_admin SET adminname = '{$adminUsername}',adminpass = '{$newPassword}'WHERE id = 1");      
        $pdo->query("UPDATE bl_config SET ctime = '{$ctime}',siteurl = '{$siteurl}'WHERE id = 1");
        echo "success";
    }
    catch (Exception $e)
    {
        $err = $e->getMessage();
    }
    catch (PDOException $e)
    {
        $err = $e->getMessage();
    }
    echo $err;
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>安装<?php echo $sitename; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <meta name="renderer" content="webkit">

    <style>
        body {
            background: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        body, input, button {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            color: #7E96B3;
        }
        .container {
            max-width: 515px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        a {
            color: #18bc9c;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        h1 {
            margin-top:0;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 28px;
            font-weight: normal;
            color: #3C5675;
            margin-bottom: 0;
        }

        form {
            margin-top: 40px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group .form-field:first-child input {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        .form-group .form-field:last-child input {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .form-field input {
            background: #EDF2F7;
            margin: 0 0 1px;
            border: 2px solid transparent;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
            width: 100%;
            padding: 15px 15px 15px 180px;
            box-sizing: border-box;
        }
        .form-field input:focus {
            border-color: #18bc9c;
            background: #fff;
            color: #444;
            outline: none;
        }
        .form-field label {
            float: left;
            width: 160px;
            text-align: right;
            margin-right: -160px;
            position: relative;
            margin-top: 18px;
            font-size: 14px;
            pointer-events: none;
            opacity: 0.7;
        }
        button,.btn {
            background: #3C5675;
            color: #fff;
            border: 0;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            padding: 15px 30px;
            -webkit-appearance: none;
        }
        button[disabled] {
            opacity: 0.5;
        }

        #error,.error,#success,.success {
            background: #D83E3E;
            color: #fff;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        #success {
            background:#3C5675;
        }

        #error a, .error a {
            color:white;
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>

        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="200px" height="57px" viewBox="0 0 200 57" enable-background="new 0 0 200 57" xml:space="preserve">  <image id="image0" width="200" height="57" x="0" y="0"
                                                                                                                                                                                                                                                        xlink:href="data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABkAAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjdBQjU5OTMzNDZDRjExRTg4NTAyQUY1OTRDNjZEMEExIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjdBQjU5OTM0NDZDRjExRTg4NTAyQUY1OTRDNjZEMEExIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6N0FCNTk5MzE0NkNGMTFFODg1MDJBRjU5NEM2NkQwQTEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6N0FCNTk5MzI0NkNGMTFFODg1MDJBRjU5NEM2NkQwQTEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAABAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAgICAgICAgICAgIDAwMDAwMDAwMDAQEBAQEBAQIBAQICAgECAgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwP/wAARCADIAMgDAREAAhEBAxEB/8QAvAABAAEEAwEBAQAAAAAAAAAAAAkHCAoLAQUGAgQDAQEAAQUAAwEAAAAAAAAAAAAACAEFBgcJAgMEChAAAAYBAwMCBQIEBAYDAQAAAQIDBAUGBwARCCESCTETQSIUFQpRYfBxMiORQhYXgaHB0TMY4VIkJhEAAQMDAgQEAwQHBQQIBwAAAQACAxEEBSEGMUESB1EiEwhhcTKBQlIU8JGxYiMVCaHB0TNDcoKyU5Ki0mM0JRYYwnODJGQ1Jv/aAAwDAQACEQMRAD8Az+NETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNEXAiIbfH/v8A/OlQib/xt++n7VSq+e4f2/b+X8ddPmqrkBHp06fx/wAtE+HNcgO/w20Rc6ImiJoiaImiJoiaImiJoiaImiJoiaImiJoiaImiJoi4EdtUqipRlrOeJMFV5S0Zav8AWqLDgCv06s7JoNnUiqkmKgtIiO7jSEu+OT+hBsmqqf4FHWNbo3jtfZePOT3RfW9laAGhkcA5xGtGM+p7vBrAXHkFmeyu3e9+42UGH2Ri7zJX+nUIYy5sYJp1Sv8AoiYOb3ua0cyolMoebvEUWu4YYbxtaMgnSMAJztlXTpVfdEMbYqrVuqnIWQRIUBESLsmwjuAAPURLD/e/vf2piC632di7nJTNP1zH8tER4t0fKfkWN4cuKm3s7+npvi+jZdb8y1li43CphtwbudtOIcQWQU5VZLJTmOFbT5TzF8lZtwuMFW8ZVtkqqZRBI0TKzD5uiY+6aIvXEs1QWMmUO0x/YL3eoAXUas777O70sj/5Va4i1gLjQGGSVwFdB1GVoNBoT0CvwW7LL2Ido8fE3+Y3eXu5w0Bx9WOJjjTVwaInEVPAdenCpXET5TOVJlROvKUxwUy3u+0etFKQpdwH2QMR6BgS+HXcf31gb/fP35t5C4z41zeqtDa6fLR9afbX4r2Xns07LtbSOG/aemlRca18T5dT+oK5SheWHIpFjBfMc1icbmTAEj1149g3KanTqoV4MkkcB6jt8us127/Ud3vj5j/6vwePvbanG3fJbvB8fMZmu+PBam3L7Jtqvj//AJrK3ltOHf67GzNI8PJ0H9qv6xJz+wZkkjVpMSK+P55cyKIx9k2KxUcrnIQqbaXRAzM4CofoJxJ0DUr+2fvs7J779Oyzdy/A5t5a307sUic9xDaMnbWP6j98s01KjPvj2w9x9ol9xj4W5TFsqfUg+sNFTV0Z83AcBVXts3zSQbIvGLlu8aOCFUQctl010FkzBuU6SyRjpnKYB6CA7amVZ3tpkLZl5YSxzWkjQWvY4OY4Hm1zSQR8io7zwT2sjobljo5mmha4FpB8CDwK/UA/x/Aa+iutF6lzqqJoiaImiJoiaImiJoiaImiJoiaImiJoiaIvkxgKAiYQAAAREREAAAANxERH0AA0qqgEmg1KgJ5/+aql4Zk5jDvF80PkPKLIXUfZL+5AXtFor9JU7ZaPjUkxIFtsbcxDGMJThHtzdm5nBhOkSNHdfv3b7ZbLhtniO5zIBa+d2sMLuFGgf5rxzoRG3Spdq0dL/bL/AE/Nwb+tIN+d4RPitnyBslvZN8t5eMIDg95Nfy0DtAKj1n+ajYgGvdjX3TLeRcy2x3eso3KwXm1SQnBaYsMi4kV0kDHFQrBgkscW0VFIGH+00bkSbpB0IQuudG8MzmtyZCTLZ+6mu8i8mr5HF5Aro1tTRjB91jOlrRoAuse39kbW2DhGbb2dj7XHYWLhFBGGNcaU63keaWV33pZC57uZK7CJX37Q/Tb/AB6fDfYA/wCW2tR5KANBFNKr5byOgJ4H9PmqmRS/Qnzbb9PTp09A/T+WsCvY9SFil5H5i39P8f05KpUUuAdphNtsYAHr/SAdRD16f4axa8i0IpqsWvI6j4qpsIoo6MBWiaro5TAUSNiHcnDfr2iRIDHARD4axuayuZ3dEUb3PPINJP8AYsUyPRA3quCGN5dR6a/Img/YqkxypiH9tUpk1kzCRRMxRIdMwbbkUIYAOQQAQ6CG4f8ALWJX0Lo3Fj2kOBoQdKHgRTxqsYumAtD2mrSKg1FCNCCCNPtCvX4/cpck4Udt20a/NOVIxy/WVKXWVVY9g9gGNGLGE6sUuUgAAGT3T29SD8N59jvdb3P7CX7IcTOchtEuHq4+4c4xEaVMDtXQPoNC3y+LCo/dz+y20e4sDpruL8tnQD0XMTQH11oJBoJGknUHXhRwop1cN5rpebKylYKo87XKJEyTMC6OQspCOzF+ZB0mX/yIiYB9tYm6agemw7gHeHsb372H372sNx7Qn6byINF1aSEC4tZCNWyNH1MJr0St8jwNKGoHNjuB273D25zBxebjrA4kxTt1jmbyLTyP4mHzN+PFVfAd9bsWCLnVUTRE0RNETRE0RNETRE0RNETRE0RNEXAjt/0/fRFioea/y3SFdmp/hpxpsv0kik3Vjc45HhXQkdRqi4gCuO66/QMBkXZ2+/3RwmO5CKAgUQEVNR37udwp4WSbZwT+l/TSeVp1Ff8ATaRzI+vwBou039Pb2PWuUx9r397uWfqWrniTEWEratkArS+nY7i3q/8ADMcNS31CKBqgHxJxuz7lOmuMh41xvP5ErbF6dnLOaioznZmNf9wGVLJ15u7PYkyGA4G+o+mMibuD5+4RDUT7jZu4svZPyGKtJLq1a4gmOj3A/vMB6/jXpprxXTDfXdjtnszPt2ru7LWuKy8kYfGy5D4YpGcjHM5ogPCnR6geKHy01Vfqpxf5NSzlOOZYCy0s/KVA3040qYbmEFzARIRO6boIh3m6bd24fHbWtb3t5va7nMNticg+TTQQv5mg1IpRarzneHtFZxm7n3LhG2uuouoiKjU6NcTp8vkr4sZeLjnFeFgIrh1ajokOQqrjIU3G10vYcDCKiaKB5Jdb2yl6gABuIgHx6fRY+2LvDuGVzWYs2bQdHXMjYx8wKk0+zjyUdt3e8X27bdZ1NzwyD3VIbYxPn4ciXBjRX5nSpUmuKPCNKplSc5fzUkiAggqMVj+EAVCm3KK7R3JThlyHKYAEoKokIIAO4a25t72GOuHibeGaa2MtB9O1jq4HmC+SjTy4NP2qIu8/6hdm7qi2Nt8ud5h6l7MaGvBzY4ekjjXpc4qR7Hnje4k45boiljglvfpGSU+5XV+6n1gWRAB91BJyf6dsQxvm7CF7Q+GpD7c9pXY3bbAXYkX9xUEuunul8zaahpoxtaVIApVRR3V7sO926XurlTY2zgR6doxsI6TyJaOp1BpUmvNXdQ+NMdwTdFCGo9UjEESkIkRpBRqfYUvUpQMVv3D2j6CI63Vj9jbLx0TY8dicfDE3QBsEY4f7q0hfbv3VkpDLf5K9meTUl00h/wDiVjWZOAzbNmVn9+krVHUiHFrGxjSCqcE2Ku9bsjuFXElJuVuxL7m9Fz2CJSiAETL+moYd3/ZHad5e4s28slkLfEYx0cUTILO3HU9sZcXSyuJDfVf1UqGnRorwUj9ge5mXt5sqLbNnZS5G/D5JHTXMzqMc8ABkbRU+m3prQniSvS1zx0YIhBSPIOLXYDETEhivpb6dFQ4h1U9tomn27G6gG4gGmG/py9hrFzZMq/K37g2hD5xG0nxpE1tPgKq1Zf3Ydy8gHC1bY2oJqOiOpA8KuJ/XReGztD454jhR7DiKICFu8jPB76Jph+7JJVpmjvKsJRks5UTUaSAnKUigl3IoXcg7760b7mMR2x9lDdvbv7J2f5HuHcZDztN1PIJ7CJv/ANxDcQvkc10U7nMaHltWuaXRkOBpk3bPIbs77HI4nfk/5nbkNt5SImNMdw80ifG9rQQ5lCS2vmaaO0V9uKskwOV6VD3OBUAEX6PY9ZGMUy8XJJB2vI9yAdQURUHco/5iCBg9ddFuynd7bfe/t5Y7/wBsuAguWdM0NQX21wyglgkp95jvpPBzC1w0KjTvbaGT2NuK427lAfVid5X00kjP0vb8COPgQQqj62wsTTRE0RNETRE0RNETRE0RNETRE0Rcb6IoqPL9zjDhNxRn5msSTVvl/JRlqRjFqr2qOGz5+3MWWshUO4pjJ16OOZYBHYBV7Q331g3cDc3/AKawL5ICP5hMfTiHxPF3+6NVNP2K+3T/ANw3eq2sMzE92xcQBd5Bw0DmMcPSg6uFZ3gN/wBmppRa7QJV/JSjyUlXruSlJJ2u/kJB+4VdPZB86UMs6dvHSxjrruHCpzGOcwiJhMIiO+ofXjHSMJkc5zzWriakk6kk868eS/VK+ytrSyZZ2cUcVnFGGMYxoaxjWijWtaBRrWgAAAUHJXB4lyRecZ2JrbscXO00K0NQTBKwVCdkICUFMgiciDlxHLoi8aEOIj7C4KICI7iXfbWFT3eRxVyLvFzzW10OD43Oa7iDypXgNOBWqt8bT27u/Evwe7MfZ5PCvqXQXMLJo60oS0PB6XcPOzpcBoHBTP4R8uXkVCShK3A5ATypMO/ZjY6IstCQtktKrqiCaQGTh1op++enMPQwCBhH131crTvn3dsrllpY3X524J6GxvgEj3nkPJRxd+1c++4vsf8Aax+UucrkcWcNYMq98sF4baKMDV2sokY1gHEa0WQZx1N5Z8ssGUzmiz4cwJW3YFXI1UxqeayQuguQ/Q1fGz/boYyY77pPToOEh2ESnANtSF2f/wC5PcsLLjcdzi8JYONdbb1bktPIReqGsPwkc1w/CVy/7qN9k2yrmSw2BZ57cuWYadX5/wBKxBBH+t+X9SWv4og9jtRVpUllOoDuuJtlZ27269yqJSHCQsbtmiig5FEybpVlGxLKPbIIuTG39pUXHtgUoAbcNx3riNvy44Nkvr27v7xoHmmc0NBp5i1kbWgB3g7rpQUPNRJzu54cs97MdjrHG2Tz/lwNeSWg1aHySve4ub+JoZWpqOSqOAAAbfD9P2/TWRctViy+CbhuA/5fT9w/x6Drx+9pwXiAAaDkuTHKmHccxSh+pjAUvr+ptg0LmsHmNB8TT58V5gFxo0ErxNvyNT6XDy8rNT8Q2+0xzyQOzWkmaTpx9G1O6+nRROqCh1lilACgACIiOsK3h3E2lsrD3mXzN/ZxflLaWYxumja93psL+hrS6pc6lGilSSsiwW1M7uG+gscfazvE8rGBwjcWjqcG9RIFABWpqsd3JWWrBmG+TN2sK4id65OjGMQOYzaJiUlDFZMGxd9ilTTAO4fUx9xHX5ke+fdXcnejuBfb33HIXSTSFsMQJ6ILdpIihjHINbSp+84lx4rq1s/Y+L2Dtq327i2gNjbWR9PNLIQC57j4k8ByGgV3fCjLy9IvqVPknA/6aux02glMYfbZTYB2sHZNxAqZVjD7Sgj/AJTb/DUkP6fHfq47Y92o9g5eYjZ25JBCQ4+WG84W8wqaAPP8KQ/hcHfdWjfcTsKPce13Z+0YP5zjWl9RxfD99nj5R5m/EU5qaAB+H8fH/pr9Cta+K56LnVUTff00RNETRE0RNETRE0RNETRE0RfI+v8AH7actEWvy88PKp3yG5sWCixrsx6Px8QWx3CoJqKCivPiom7tUkJBH2zKne9iJTAAiBUhDf11FLufnDmNzyWrDW2sgY2+HWaFx8agUAPxOi/UD/TW7KQ9rvb1a7ku4wNxbocL6UkCrYKFttH40DKvIrqXV5KFEh+w5TfoPX09Om+tduHU0gldCJG1bTmpYPHX43c9c7LKi5q0erTMPRb4je25enmK4wTT2lAB1F1luItxtViKQB/sIKFRQEQ99VPcoG+zb3bfNb2ug23b6OLDvPO4HpArqGDTrd8AaDSpHOEfuq92XbT224l0OakbkN+TRl1tjIXgTOqPLJcOFfy8Faed7S5/+kx9HEZwnEXgHxy4ZV5qwxdUUn9yO0KjOZQtCbaVvU2oYglc9kj7CaMGwV7hD6Rgm3REm3uAoYO8ZUbM7cbW2TCP5VAHZEij7h4DpXeNHcGNP4WdI8anVfnV75e5ruv39yj7neV8Y8CJOqHH25dHaRCtW1ZUumeOPqTOe6tenpB6Rett679fj8R/nuI76zyo08VHyi8zbLtT6DEKz93tEBUYVETFPJ2OXYw7MVCJnVFFNd+ugms4MmmYSpkEyhttgAdWzLZrD4CzdkM5dW9pYt4vmkbG3Spp1OIqSBo0ankCrxhNvZ7ct8Mbt6zur6/P+nBE+V1KgVIYDRtSKuNGjmQo0MteXbjTR1nMbQUp/LcogKYFcQyP2GtKCcPmAk1Loi9UOiYNjAVkJDf5TiHXUTd+e9btdtZz7bbsd1m75vOIejAfH+LIC+o50hIPJ1FLbZPsd7tbiYy73MbbCWbq6Sn1rig/7qI9AryrMD4t5Kwe2+WfkPfHItMewVVpSHvL+2WJjF7NNKtDbgkVwrJHcoe8kX/Ok3T6/DUPN4++fvHnZTbbTtbPFxku6eiJ1xMWnhUyFzeofiZG1SWwfsm7V7cgE+6Lm9yEnSKmSQQRBw40EfSaHwdIdFQ+azHyvyEUxrJZcwybZVUVDN27SxsmCZlAKfsSQjmjZFMnaG/aHQS6jPuvuH7it3sd/Ob/AHJPAXE9LBcRxgnWgbE1rQPgFsrG7C7J7YI/lVrgYZgKVLoHvNNNTI9xP+K839tuq5iuZqJtax/6jrS8fNKDsA7bmWfIGMXbYPUdaBzuG3lcOfd5e2yb3Di+aOZxHzc8H9qvrbvb8TfSx89i1nJsUkQr8mscP7AvRRypiGKQ5TJnDfuIoXtOG3puBgAwb/vrWd9bvY4slaWu8CCP2q33LA9vU3zN8Qa6/p4qp8DIqsnLR42UUTXaLouEVCj2GTUROU5BAwDuUQOXp6beu+sdZcXONvoshau6LqCVsjHAkEOY4OBBHgRXxWKZG1bcQSQytDonsLXA0IIIoRzBFCsjHFVqC7Y7p1pAxzKS0EyVcioIicXiSQN3hjCIBuJnSRx36+vqOv1bdjd8juT2i29vWpdNfYyF0hNamZjfTlJrrrIxx+3ieK5L72wjtubtyGGNA2C6eG0/AT1MHho0gafNVC1tdYuuO0N99tEXOiJoiaImiJoiaImiJoiaIvCZOtzag46vd4dqe03qNQsViUP03D7TFOnpdhHYNxOiABv03HXzXlwLW0luHfSyNzv1AlZHs/Bzbn3ZjduQDqmvr6CAD/5srWH+wrVW5Ft8jf8AIF3vEu6VeSdvtlhsb1ysbvVWWl5R0+MYxvjsCwAH7BqD1xNJdXUt1L9csz3frcaf2U1X7S9p4Sz2vtfHbcsWNjs7GyhgY0CgDYo2s4fZVS4eJPxR2PnldD5AyMEpV+NdIk0krBLIpqtJDIMukIKmp9WdnKUpESgAfXvCd306Y9hBBUwCXPth7Hl3TP8Am7zqZhY3eYjQyH8DT4fiKg175PevifbXt4bY2r6N53ayMJMEZIcyyiOn5q4aD9X/ACIjTrd5j5GmufNjzHdIxPS69jvHNZiKfS6rHN4mBr0IzSZR8eybEAhCJpIlKBlT7bqKG3Oc4iYwiIiOpRWlpbWNsyzs2NjtoxRrWigAH6favzLbq3VuHe+4LvdW7Lua/wBwXszpJp5XF73vcakknkOAA0AoAKBfsuN0qOO61L3O9WWGqVUgWqr6XsFgkG0ZFxzVEonOdd26UTTAwgGxShuc5tilATCAa8b6/s8ZayX2QlZBZxtJe97g1rQOZJ0/x5ar5sBt/Obpy8GA23aXF9mbl4ZFDCx0kj3E0o1rRX5ngBqSACVD5avI3nnkxKSNF8c2DJy5RxFzxznkZkOMPB42YmE5kvuNbRlkytZZumskPY4VK6TUKbqgUQ1HXN9296btnfh+zeLfOa9LshcN6IGcR1Ma/wArqFvF/VUEHopqp2Yb2qdt+0dnFuP3U7itrC6LQ9uDspPWvnilei4MR6onEHVjTG5pGkhrRU1Hxd5EyC8SyTzz5gPZF64+nUXiY2VbR0LHACijlWBCdtTn6IjJuKpypCyRbdhB+UA1g0HtO3b3Ev25HuZnb7IZBwaTDbh0nRqSY2l1QGa0HQwUFacldcz74u3HbTGuwXY7aePxeHZ1NFzeOaxz9ABL0s6T1uABcJXyVPFd8k68KHGkHkfMXfE9qsMKuRRZOZm32S58rsghuLMyZZBqUe4RNsQ4FD4ak9sj+nzhGsY7G7Omuw+jhLeAvGmoP8UgN1FaBungoRdx/wCo/uS8kkGZ3rDZ9ILDBYdMQofu9MA83z6l6Vt5ePF9WAFvWU3J/pABBuEDigiCShCiBQBFwqVt3Jbddx9dSYxHsm3hasYLHB4e2Z00FPRBDfDysJUSM776thSPf/Mc5mbp/VU+WZwJ8fM8KpVd8zHAeYVOiNrscEUnZ7akrRnSCKvdsX5PozOhL2AHXcA6B+2r/ce07utasBisLOQHkyVnIacQ0fBYtB70+ylzIWz5C+hp96SCSh8fpLir28Ycm+NGdCN2eOcn0C2O5BHvTgyPWSUusQwB3JjEPioO1TBuG4FIbWp909p927YikG5sLNDZjRz3Qh0VD4uALaGnMrcmzu9PbzessbNpZ60ub5wq2Nk3TN9jHFr6/AAr3VmwhiS5JnTsOPqtIGOXtFcYlqi6KAht8rlBNJco7emw9NR43V2K7P73hdDufbmKuS5tOs27GyAfCRoa8fYVvbD9xd9YBwdispexAGtPVcW1+LXEg/qVlWVuAEIdu7mcQSi8U+SKs4LVZhYzuNd9oAJGrCRUEXTJQR3290VSD0Dp6654d9f6ZuByNncZ3sleSWmUa1zxj7pxkhk5iOGc/wASJx1p6hkbwHl4iROyPdFkGSx2G/IWzWxIBuYh0yN8XSRjyvA/d6T81XLhiaVZ4pdVicbOWMvUrVMw79g7T9tdmruiuKBwENzbHUMICAiUQENh21vb+ni/M47sdcbK3FDNbZ7A528tZoZR0vidVsnQRz1c4hwJBB8pIWt/cK2zn3wzMY17JcffWUUrJGmoeKFocPsA46jmrudTyWiU0RNETRE0RNETRE0RNETRE0RWmc7pN1D8NuTEkySIu7a4cuxkEVTARIxlIhdLc5h2AClBQRH+WrDud7o9vXr2/ULd/wCxbt9tlnBf9/NoWlyS2F+etKkamglB0p8lrs+CPEm2c1+SdAwdXCLN2Es+LK3idTKIpVukxqhF7BLHOACBVQa7poF9TrHKAaiVtXBT7kysOMi4Oo6Q8mMGrj/cF+qb3J98cJ7ee0uT7jZfpdeQR+naQnjcXcg6YYxzp1Uc8/dYCStllh7EVCwRjOnYkxlAs65SqRCtISFjWaRE/wC01TKVZ67MQpRcSMg47lnCxvmUWOYw+upj4+wtcZZx2Nk0MtomhoA+HM+JJ1J8V+Rrfu+dzdyt33++N33L7vcORuHzSyPNdXHRjanyxsFGMaNGtAAXorpZVqhWJefa16etr6OaHVYVmstAezs69ESptY5gkc6SCZnC6hSnWWORBuQTKKmKQpjB53U5t4HTBj5HtGjG6uceQHLXxOg4nQK1bexDM5mIMXNdW1lbyyAPuLh3RDC3Uue8gEnpaCQ1oL3mjWNLiAYGOYt4wJi1SNzr5cMyxb0ibhaTw1wQx6+c2GtxKiQ+9HrWWChVPuOVbgmb2yu5B0VKCYrB/aMdH59evZ3t+3n3rzDbjLQG5sInVbb9RZY245OneaCeWmpGoqKMaQt97q92ewfbntqXaXYMfksnPF0Xe4ZowcxfmlHtsoyD/LbIk0YNJnNcDM5jqhQucjfyQ883Rq4o3DzF1T4zYzbJqsYmUfsYmcv329RNPsUaRscROm1BwguBhIDYHwCU3UQHoHRLYftJ2fgbeJ+5JDezMH+TE30bZlCdAGgPe06Vr0UPJco+4nuY3dnruebGPeyaUnquJnOnuXkgeZz5K0dxGodpTzKHu4585F8iZl3KZPyllHK0pJuxcOkZScm5Zko7XAoCZKDYnCIamOIFACpIEDYNtvhqSmF21tTa0DY8RZ2VlGwUBaxjTQfvnzH7XHiolbl3Funckz5MldXV1I81Ic57hX4N+kfYFdVhnx8czMtjHno3G/Jr2Pki+4znJOtvIGAVIAb+4MzLlaMilAP1Nq35jux25251jK5izZKzixsjXyD4dDKu/sVjsu0ncvc7m/yjEX0kUg0eY3MZ/wBN/S37aqTag+DXloevK2zK1gxbhevRiR3884tdmLIrQ8O2KKr1+4NCEeMSA3blEwgdUu49Na0vfdX2+iuxj8BBf5O8eemNsMXT1vJo1o6y0mp00HxWW2/s87lXFi/Kbgnx2JsIwXyOnm6ixg1c53phzRQa0LvtUet5gKJWrzOV7HNyc5BqMQ8UYRtydRB4Mtg9gwpLyDONVOdZKNVWKIoGPsc6exhAN9SQ25eZa/xMF3nbVtnk5W9T4Q8SenXg1zqAFwFOoDQE05KFm+bLDYzO3Njt27df4mJ/SycsMYkpoXNYSSGk/T1akakBd1XHz6EfNJmFknsLLsFk3DCUjHKrF80cpGKoks2dtjJqpnTMUBDYQD9dX6aztr+2daX8bJrZ4Icx4DmuB4gtdoR81raPKZHGXjL3HSyQ3cTw5j2Oc17SOBDmkEH4ghZenid5T33klhKfjslrrTNqxZNtKya2LF2cWOMcsSu49eQOGxFpRqj/AG1lA/8AIIAYeo65We6Dtpg+3284Z9ugQ4zJQmUQA6RPa7peGjkwnVo5cBou33sr7xbl7rdup7fdjnT5fETMg/MH6p43M6mF55yNHlceLtHHipVB6hqM3yUyl+BpGMWTp+8atUkHMoqkvIKplAoulkEQQTUUANgMoCRQDf1EA66tlnhsXj726yFjAyK8vXtfO5oAMr2MDGudTiQ3SvE01X1T3t1cwxW873OhgaRGCa9IceogfCuvw5LsNXNfKmiJoiaImiJoiaImiJoiaImiK23mJUHN94r8hKg0Iko5m8RXhsimuc6aSiiUE8dAQxyEUOAH9jboA7jsGrPuC3ddYS7gZ9Trd4/6pNFtrsNnYttd6NrZ2cuENvnbNxLQCQDM1tQCQNOpQn/jfcZ4mg8Y7jyJlItoa55jtjyDipFZuQZCOpVPUFoVk2dGJ7ibaWmTqKqkDoJm5N/TbWtuzuDZZYOTKytH5m4kIB5hjNABXkTx+IXQn+rJ3evtzd4bDtVZzPG38DZMmkjDvJJd3Q6utza0Loog1rSeAe6nGqyPC7h3bj17h2237th+H77a3BU8+NFyc+KxtPMf5z4fh8rLcceLLmCuPJE7ZRtcbg6InLVTDIOUjEK1M2IYELBkEpDgoVqYwtY83aLkFT97YJRdkewE29Ws3Pu4SQ7XBrHGPLJckc68WQ8i76n69NBRy0h3L7sRbbc7CYAslzdKPfxbBXl4Ok501a3TqqatGCNkTJOQMvXidyRlK5WK/Xu0PDvZ612mUcS0xIrnMJgIdy5OPsNEAHtSbpARugQAKmQhQANdB8Xi8bhbGPF4mGK2sIgAyONoa1v2DmebjqTqSTqoj5O/vsnO+7yEr5rl5qXOJNT9vhwA5CgGgCyUPx7eClK5NzeR7ryB4tVHJOGK4iklWcqW6bvMS8b3gDFKasV6vxU4yrFyjhZnMq8UdNT/AERykD3BMcCDGX3KdxchtK3tbHbWYntM/KT6kETInAw8nveWmSN1dG0cOsV0oKra/ZXY9lua6uLvP4yK5w8YHTLI6Vp9X8DWteGSClS4ltGmmtSAs1PHnHjAmIy7YuwrinHhzCUTrU2gVauulTFICZTrO4uMbOV1AIG3cc5h21A7Kbq3Nmz/AOc5G9uhwpLPI8ePBziB8gFLTG7Z27h9cTYWlseZjhjYfDUtaCdOdVVOWloqvRUjNTT9pEQ0OxcyEnJP1k2rGPYMkTLuXbldQSJIN0ESCYxhHYADVnggnvJ2W1sx0lzI4Na1oq5znGgAHEkngFdbi4gs7d9zcubHbRsLnOcaNa1oqSTwAABJKw1vKR5VH3KOaf4QwhJPojAcDInbzkymoZo9ynJMVxIVdVNMQWQqSCpBM3QMO7odlFCgHaXXSz2/dh4NiQM3XuhjJN1ysqxp1batcOFeHqkaOcPp4DWpXKb3N+4a67gzSbO2k+SHZsLyJHDyuu3NPE/9y0irW/fPmcKUCiHi3oF2AB2/p+O4h69Pj2/Hpv66lixw15D7f1/H+5QOv7Zzvl+n6fJVUqMdYLjOQ9TqcPJWGyzz1vGQ0JEtlXkjJP3ShUW7ds2RATHMdQwbj0KUNxMIAAiHhfZOyxVjLkcnLHBYQMLnyPIDGNGpLiaDT9Z4AVVmx+2slnsnFisRBLc5K4kDI442lz3vcQAABU/4cTpqs3Xx48WV+KPHeBp1gK2PfrE4VtV6XbgQ4IS0kUp0oYjgof3kYZvsiBvQTAYf31yG769ym9zd9z5azLv5NA0Q24NdWM4yU5GQ+anLRd5fbR2ff2b7Z2+DyIYdxXLvXuyKaSPApH1feEbaNrzNSr69w/X/ALa0xUKQq89WLXAXGOWlq3JIS0c3lpqDVdtREyJZOvybqGl2wGEAAxmckyVSMIbgJijsIh119t9YXeNmFvfMdHO6Njw08emRoew/DqaQaHWh1C+KwyNllIDc2EjZYBI9hc3h1xuLHj/dcCDyqNCV6LXxr7U0RNETRE0RNETRE0RNETRE0RdVORqcxDy8SqQqiMrFyEaqRQTAQ6b5qq2OQ4lEDAUxVdh267a9crPUjdGeDmkfr0X2Y+7fYZCC+jJD4ZmSAjiCxwcKV56aKjfGjB0RxwwlR8NwajdxHU1rJJJLtmoNElTyczIzB+1Lc47pmf8At9wiJj9gCPrr4MPjYsRjo8fF9MYOvjUk/wB6z3u73Fvu7PcPI7+yLXtur98ZIc7qIEcTIuPDXo6qDQVoFH15o+fivA7iFMTlOkEm2actPHGOsWpprkJIwjuRjHy81eUURATinVWCYe2f/I9cN/XW++xfbpncPekdvfNJwVmBPceDw1wDIif33cf3Q74KN3dDeB2jtt01saZO4Jii8W1B6nj/AGRw/eLVrTJeXk56UkZybkHcrMS751JSkm/XVdPpCQerHcO3jtysY6rhw4XVExzmERMYd9dSoIYoIWwwNayBjQ1rRwaAKACmgFByUG3yvmkMsri6V5qSeJJ1JJPElSX+LPxn5E8j+cE60zCSrGEKQ5Zvcw5LRbG9qMYqCCyVUgHCoAg5ts8iQSplKJhapG944AAF1qvu33TxnbHAG6f0S56cEW0JOpP/ADHDiI2HieZ8oKz3YGxrvemTEYqzFxEGWSmgHJo5FzuQPxJFBQ7LDC2F8a8fMY0/D+IqrH02gUaHbQ0BCR6exU0G6ZSqO3q5hFeQlHyoCq5crGOs4WOY5zCYwjrltnc5lNy5abN5qZ0+SneXPe7xPIDgGgaNaNGigCm/isXYYWwixmMjbFZRNDWtH7SeJJ4knUnUqokg/YxLB7Kyj1rGxsc0cyEjIvnCTRiwYs0TuXj167XOmi1aNG6ZjqKHMBCEKIiIAG+rXFE+aRsMTS+Z7gAGgkuJNAABUkk0oBqSvskkjhY6aVwbCwFziTQADUkk6AAAk10osKny5eYVfkVOzPHPjrY1I3BMM8UY264MHRmjrLEg2V7DINVP7SyFNQVJ/aT6GdmDvP8AL2lL0a7AdhYdpRR7t3bE1+53tDoonCrbYEaE8QZSDqfucBrUrnX7hO917u8y7Q2k97NsMcRLKytbkjlyIhB4D7/E6UCiBxlinLeS3sfG48xnfLk6kDCVgEBVJl+3c9he45SvyMyxwCQob/MsAfvqTeS3Nt7Cxvly97a2zWDzepI1tB/sk1p9hUOrbZe5NwStiw1jc3Msho3043PBNPFoNPmdFMhxw8JvL7LCkZJ5IZw+Dam5+mXcr2dYspbDMzrlBwkhXI9TtbvCt9zFFdcpREOofDWiN4e6rt5t5j4sKZcrkhUAR+WGtNKyOGorQeVpNDotzbM9mvcndUkc+dEWIxjqEmXzS0qK9MTToemtOot1oslzh947eP8Aw5YJvqfELWrIzhmihL5LtZUHs+sb2CJukYdMqZW1fj11QMb2m5SiIG2OY22+oQdze929e58xgycv5fBteSy1iJbGNdC/WsjgObq8KgBdAe0Xt57fdoIvzOGg/M7ic0B93MA6XhRwiH0xNJ5M1PBxcr8v8Nh3D0/6ftrT3w8FvY1Che8mPkWZ4uFrxF46SyNl5TZefx1BSUhHBnJ8Wkti6Uam+cqNO7/+vcpORBk1A3uNziVVUoB2lNJXsl2dkzfV3C3jGYdi49jp6PFPzRiBd066+iCKvdwcKtaeJEW++/epuDp232NIJ9/5JzbfqYSfynrEMDiR/rnqoxoNWHzOHAGULj7ixrhPCuMcWNlTOlKVTYSGkpBU3e4lpxFkkefmXao/Mu8lplRdwqcRETHUER1o3d2ek3Pue+zrx0tubmR7W8mx9REbAOQYyjQOAA0W/dl7ei2ntTH7diPUbS1jY9x1L5A0erITzdJIXOcTxJVY9Y6snTRE0RNETRE0RNETRE0RNETRE0RdZKTEVDJtlZaTYxaLx62jWyr50i0TXkHqgIs2SKi5yEO5dLCBUyAPccw7AAjr2RQTTuIga5zg0uIAJoANSachxJ5LwfLHFQyFrQTQVNKk8B8ysBv8n3JdhsfOqj44dPnBKxjrCFacxMKZQ/033W1Tlkeys8VMwAmCsg2aNmwiHwZfy10S9qGKtrbt9cZNjR+bub94c7n0xtjDW/IEudT95RC79XtxPuyKycT+XhtG0b8XucXOHjXQV+CiM4D8E8w+QLPELhnFjJVlFoC3lsj5AdNVFYDHdOBwRF5MyKuwJqyDgRFJi0A3uOVx2AO0phDcncPuBg+3G3n5zLODpD1NhhBo+aSlQxo8Bxc7g1v2LXez9o5HeWWbjrEUi4yPI8sbK6ud8fwt4uNAOZGzW4ocVcRcNcH03A+FoBKGq1VYJEdvzkSNNWmdOkQJO0WR+UhVZKZlXBROoocR7S9pC7EKUA5Wbx3hmd756fcWdkL7uZ2g16Y2fdYwcmtHAfadSp07fwGO23jI8VjGBkLBqaDqe7m93i4n9XAaBXIgA7gP6b7/AL/DWMK9/rVMcw4bx3nmjSONMqwAWqiTaqIztaWfyDBhOII9/bHyhoxyzdOY5Q5wMoj7gEUEpe7coCA3jB57KbbyLcvhZfRyUYPRIA0uYTTVvUCA7TQ0qOStOawmN3DYOxeXj9bHvPnYSQHU5O6SCR4itDzVCMeePjhLiopS0TjHiOE7TCcBPVWcqYDmAgCbeZ+4CA7ED+WslyfdPuJmP/2OYv5B8JC3/g6dFjWP7Zdv8Ya2eIsmmtamMPOvxf1FXUwVZrlYZpR9ar8JX2KACVBlCxTGLapAPQ3toMkEEy93x2DrrC7q+vb2QzXs0s0pOrnuc4n7SSsxtbCysYxFZQxQxDgGMa0D7GgUXegPwH1D118ugK+pUHzhydwFxyr69jzTlKo0SPRIY5EZeVbhKPBKoRH2mESkdSReKiqoUoARMfmHWU7a2VuneF2LPbljPdSk8WtPSNK1c80aBTXUrFdz732ps21N5uS+gtoxwDnDrd8GsFXOPLQLF850efi2X5tMY64gR76g1R2iswkMrWBqRO6yiKwHTWCsRSgnJXEVCDsVwru6AQESgUB1N7tf7VMZh3x5juE9t3ftNW2sZrC0g6GV3GQ/ujyeNVBPur7sctmmSYTt0x9njnt6XXTx/HcCNfTGoiGvE1foR5V1ngd4gzGas0TnMjKLOQmKtjiQckostNOVnbiz5aXUTUeTyqzoyi8h/ptmsZT3u4RK8On+m2vb7pO40G39uRdvMG9kd7eNHrsYA0R2orRlBo31HClKasBXr9qXbC4z245O5G4GvktbN59BzySZLo0PXU1LvSaS6tfrLa6grMO+PXf9v+O/r/LXPOi6NL61VE0RNETRE0RNETRE0RNETRE0RNEVKM3YYovILGFvxJkePXf1W4xK8c6VYO3EZNxDoxRMwnq5NMjpSEFYoV2BXDN43ORZBYhTFH11d8DnMhtvLQ5nFuDbyF4IqA5rhzY9pHS9jhVrmu0IKt+VxlpmLCTHXrS63lbQ0NCDyc1w1a5p1a4agrWseWzA/LPAPKNzS+VNws2V1oeusa9h/M9jao+9kLEcCu5JVDLSLZug3dzMG3dC3fkP3uU3QGFQygHKofqN2b3Bs7cW0hfbQhisw+YvuLZhP8G4eB6nlJJDHEBzKaFtAAKECD3cjFbgxO4DbZ975+lgbDM7/UhbXo15kVo4GpDuZ0KnR8THmG8WfDHAtcwg7qGXsRWVw0YS+V8p2Oks7cS/30zIgSsiVxjpxZLKWvs3SiicW0cMy/RtjdvU5lDnj/3i7Kd2d87hlzzJ7G8tQ5zbe3ZKY/RhB8opMGM6yKF7g7zO14ANG1+3fcnYO2cSzFujuLectDppXR9XqSc9Y+p3SNQwEaD4klT70HzIeMzIjJk+heYOJIhJ8YpU0r3LOccvEO4du98yvbSvOo5Mv+Yy5CFKHUR21HbI9kO6uMe6OfC3j3DnC0Tj7DEXA/Ci2/Z9zNi3zBJFkrZod/zHGM/aHhtPtVfmvPvgu97hacy+LDkAQO7AyOfsVnIdmn2+4+SOW1iRZil3B3rkEUij6mDWOu7c9wWfXg8uCTT/AMHccTwH+Xx+HFXhu8NpOr05PH6f/kRf9tfmlfIJwWh231b3mDxqFIUjLlBlmrHsksoh7B1yrJN42wO11klUkxBMxSiChvlIIm6a84e2/cGd/px4TK9Vaa2szaHwJcwAHxHEDVeE29doW7eqTJ2AFK/58Z+PAOJ+XidFbXc/Nb4zaYk8B1ygq84/atRcJxlVgrhYXDwewpyoNXUdAKxfvqlN073BCgO4CICGsssOwfdjIOb0YiaOMmnVI+JgHxILw79Qr8Fi1/3k7cY5rnSZKN72jgxsjyeehDKf28VHvlX8mfjBBJlSw/h7KGSHQmcJKLWJSIokckJCG9hchjOJ164RVV23D2Uz9u/oPTW0cJ7SN23R/wDPr+ztI9CBH1zOPiODAD9pWrc77pNr2Q6cLY3d1Jrq/pib8Pxk6/AKH/PXn/5t5mbvYmlyFWwXXnrY7Q6NEYne2MxDKGMVctlm/qF2roSiAGMgin0Dpt8ZBbV9sfbbb72T5Jk2Tummv8Z3THy/02EAjiaOJUed2+5HuTnWut8a+LG2rhSkLav41/zHVINNKtDVENb8nXHIM06st7ttguNheruHTmYssw/mX6rh0qKzgSuH7hcyJFVDbiUggUP0DbYJBY6wx2Jt22mKgit7VoADI2BjRTQfSACdedSo55KTJZe6dd5Oea4uHEkukc57jXXUkk8VdHwb4cZX535risWY7aqNIBkqyk8lXpykqENRqkLgAdP3S5E1CqSr5JM6TBsG513Ah0AgGMGF9yu5WE7abdfmsq4Ou3dTYIQfPLJTQAfhHF7uDRXnQHNu2na3L9wtwR4nGsItGkOnlP0xR11cfEng1upc7ThUjYrYJwnQuO2KKThzGkUnEU+jwreJjkikTK4fKkL3PZWRUIUv1MnJuhMssoPUTm2D5QAA5Nbm3HlN25y43DmJDJfXMhefBoP0saOTWjQDhT4rq/tjbmL2lg7fb+GjEePt4w1opqT957jzc46kniVV3ViV+TRE0RNETRE0RNETRE0RNETRE0RNEXG4fqH+OiKzLnLwZwfz4wvK4gzLDFFUpVX9JvEciiW1Y+snt9redgHqhREEzCUCOmpxFB2huQ4b9pi5vsHf+f7d51mawknl4SxOr6czObHj/hcNWnUGlQcY3XtLE7wxbsblGa8WSD643ci0/tHAjT4rXOc/vGVyV8et5dxGUqw7nsYvpA6dKzRXWTl1R7I0UOP0SEg8TKctasJybgoxeCmcTlMKIqkDu1017c91drdyccJsTKIso1v8W1eaSsI4kD77PB7a8uqh0UK94bDzmzrsxX0ZfZE+SVorG8cgfwu4eU6+FQKqO3qHp6b7B+mw/ERLt662VUHXhX9Oawqv7PtXIGMAdBEPlEA2ES/KPUfiA7D8evx1U05/T+1UBqeenxr+n7F9lUOQQ7RHf09R6AHpt1AAANvTVKUOvFeDmdYoePxK7hpIdvqYf0ES7iPT06evXTVWu5s6nkV6ZrLf07GHYAL/AAP8teTdNSKhWKfH68Au8RmAL1FTbb1EREAKH6779ADVag6UoFa340k0A4/2qU7x9eL3kpz7sjJ5W4V5QMKtX6CdozHZY9dKHTanEVF2lRYr/Tq2mXM3D5AR2bEExROoH9I6j7m95tq9t7R7LqRtzn3MPp2sbquJ4AykV9Nvz8xHAeGxtgdmdwb7u2yRM9DDBw9Sd4IaBoT0DTrceAA8o1qRzz7uIXDvC3CjEsbiTC8ADCPTMR7Y7JIAk4tF0nRTAjidskmRNM7x2ptsmTokgnsRMpShtrmnvjfe4O4Wbkzm4ZS950jjFRHEzkxjToB4ni46kkroLszZWC2Lh24fBxdMfF7zTrlfze8ganwGgaNAAFdTrDllyaImiJoiaImiJoiaImiJoiaImiJoiaIvjt3/AKg/4gP6fqA6KhAK47QEe7qAiHbsP+Gq10pyVKa1Xk7nSajkKvSdOvdbhbhU51m4j5euWOLaTERINHKKrZZJyyepLIiBklTFAwB3F36CGvqsb++xt0y9x0skN5Gatexxa5pBBrUU5hei5tba8gda3jGS27hRzXgOaQdKUPNY03L78YrjnlF3OXDitf5nj9ZniajhrQpZE1pxYrJKKnUP7RVRNY68zEggUiLZRRIgh0Lt6Sm2X7rNzYpsdlu63ZkbUaGZv8OcD4/cefEkAnxWkdx9i8JkC+4wUptLh3BjqujrWpofqb4AeYDkFjxZu8BHkzwzJKox+E0MyQ4uTpsZ7Ec6xsQu24AAA6cQbk7SXiyG2/oVKJunxDUlcB7iu1uciDpb/wDJT01ZcMLKHwDtWu+YK0vl+z+9sY4iO2dcx1NDCWu05Eiod+toVjtg4A84as5RaWDibneKcODqEbJr0CYN74pCYVBSMimqUxdiCIDv1ANZ7bdxthXbS+3zFg9g1NJmaV+ZWKz7L3TA4CayuWk6/wCU/wD7K/dV/HdzuugojVuI+eZdNcS9i6FClUUAKZQUu86rkiJEkwUAQEw+mvVd9zO31jX83mMexw5es0nx5E1+xeUGyN13bf4Nhcu/+m/+9oH6zRSL4M/He8kuV3rcbXTqjhCAWaoOvvGQbG3XeJ+6sQp2w1yEFxKldJoiJxA4FANtvjrWue9zHbHCsP5Oea/uA6nTCwhpprXrdRtK6c1l2M7HbuybmuuYmW0RGpkcARwp5R1E/Kg4cdVkccOfxx+JeBHUZbc7yspyTvLBRJ0kxnkAhsdsHSQoKk9utNj+5K+w4TMJFHJ9xAepfUNRm3t7ot6biY+z281mKx7qglh6piNa+c/TUfhHyK3LtjsPtbDvbc5cm+uQa9JHTEDpp01JcNODj9iyE4GAg6vEsICtxEZAwcW1RZxsRDsm8dHMWqCZEkUGrNqmkgikkkQCgBSh0DUari5uLud1zdyPkuHmrnOJcSTxJJ1Oq3dBBDawtgt2NjgaKBrQAAPgAu416V7k0RNETRE0RNETRE0RNETRE0RNETRF5+z2yr0mFeWO42ODqsBHpnWfTVilWMNFtEyEMoYy76QXbtk9iEEeptx20RWc4a8mPAXkNmJ3x+wjyvw5k7MzJhIyjjHtSsxJKd+giRQCTXQKRErV0DEHKYqlSVOchTAYQ266Irk845eqWAMN5RzhfXP0dKxJQrTkO0uu8CezBVKHdzUkcDCU+xvpWZgDoYd/QBHpoisU8Svk7x/5XeKzfkhTaWOL5hhcrFRrrjFe3Eu7upzMGsmdoqFjLW6geUjpyLcpOW6wxrXfuOTtEUxESKT3YPX4/r8f8dEXPpoiaImiLgA/f/t/w1SiL5UUTSTOqqciaSZDKKKKGAiaaZAExznOYQKQhChuIj0ANVRWuYz5u8RszWnKdJxTyHxZkC14SZPZHLEHVrQylXlEj4109ZSD+eBsYyaDJm7jlyKKlMchDJjuPpuRVIwJnTGvJjDtAzzh2dGzYxyfBEslMnxarsvu0Mq5ctEngNXJSLokUVan7QMACIAA/HRFV7RE0RNETRE0RYk+ZPylP9pfJ/NeN7/0X/1B9n5HxfH3/eX/ANm/tX1H3Kxs6/8A6t/27/8AXyS9n2fq/e+g++m7u3t+pDfuAiy2NETRE0RNETRE0RdVOqTKULLq11uxdz6ca9PCNZRZZvGuJUrZQ0ejILtyKOEWSroCFVMQpjlIIiACOiLWE+Szj9+SH5NeW8thPOGBsqxlcczLj/ReKadNMoni9XICLeqrRkwra0JhGhzb9FooC33GTcnlli7B2gYoJlIsjPwQfjUNvG/kKF5bclsjs79yXZwUtHVSl0dV4nj/ABojYmRGb125lXKLF9aLSaLcuWa5RTGPR7xMiZUdj6IvU/l08x1ePXjbSwTXJlxGXXlncUaIIsXXtuf9vq2LKavrZ4gQROaNno9VNgfvD2zgscA+YOhFH9+D+ztSeIufb5+o7GnOb9gdvXElQW+jTmmsHlA9mUamMHs96zdzHAoBR33TAR9Q0RZyEZbarNSL2HhrNX5aXjEUXElFxkzGv5GPQcDsgu9YtXKrloiuPQhlClKb4COiL0GiJoisa53eRriV44MYNsp8qsnM6RFzDpWMqdfZs3s9cLjLkROqWPr1biUHck5IHaALOjEI0bAICqqQNEVIPGH5b+K3ldot8uHHJxbo2UxlNs4i9Uq8QakXPwKUwDw9dlDumhnkC9ZT6Uc4MkVu7VWS9kwLET3L3EX9vIbzWylxTuHFWjVHiDkHkljrkhlwuKsx3Kpi3Ug8Q0aVh5EkrYrGkBj/AETNqkYHjp5JfSw6MW1de45KuKKZyLVxeTHL7Hix5S+eETwPyYGLsL2m0SWNge8fLQ0aVuwY+mavApW+CiparvCxkhFyMuo8932lRTOuY4iO++iqeOi2P/gP8i8Lz74rJNqLxPyVxyxlgWIp2OajYbSqzd0XIRm0Y4QfkocmCwyEqtCqMAUkVDEMkRV4QoKCfuKBUU7miJoiil8kvmC4teL6z8b6Znttdpiz8mLuar1KMpsW0dEgYBi+iYuw36yyEq9jY9vXa7JWBgksiiqq/V+q7kkDkTUMUilRZPGkizaSDByg8Yv2yDxk7bKkWbOmjpIi7Zy3WTEyaqC6JwMQxREDFEBDpoi/QIgACIiAAAbiI9AAA9REfgAaItPx5Cc10HG35EWcs2zMieQoONuf5bNZpGGJ9ackVTshsT2JViVIFPrjMSMVhAEu/wB0U9idwiG5FtyMU5Ux7nDG1Jy9ii1w94xxkWuRtrp1rgXabyMmYSVQKu2cIqpiIprJ7imuicCrNlyHSVKRQhigRVA0RNETRE0RNEUXGSfLpxOw55DKd45cqzUnQMpZBoUPaqTd7QklE48sNnnJF21i8eNZp2ZJItgk2rcp2qgm9pw5UBqGy3aBiKSiy2qs0yBkrTbbBD1qtwzFeSlZ2ckWkZFR7BqkKzh27fPFUm6KCSRRMJhNttois3w75M+APITMBsB4O5bYQytl4sfJSX+h6Nd4uwy5m0McpJUqQMFFW6zmP7u5ZIhzKJkATCAAA6ItbX+WFzTJyf8AJvOYlrkko7ovE6pRGImZWrki8PJ3B8Klzt021KmY5TPUnVlTi1j7+saBQANh3Irfqh40fNFi7xn2zllCTVpwVwxho5zmGaqo5XcYyuc9EKqxsS1uBaZGAwn5phMJSCQsiOHHaskImImG4blXXgpqvwx8T5SyfyQ5P8pLncL3P1DHmOovGLBSWtVgkWL+9WyUj5cE5NF8/XbSH0FYjlzJFUKYyZ1AMUS7CAlRbFLRFAv+SzmaYwx4f+TMhXLBNVWy3E1BplfsFclpWCnoySXvUBP+7GTEK9YSDBVVpX1UzmKp2qJHOmYBKcQ0RR8eMOM4c+Sjgrx08jfK1aqck+YXC3jhkSpS8HdLQ3nUMdGxjYrs5r9juFBe+9DHsc7DwjeQK+lGjpF0g5TUUIf5QKReU/Dsr0e6428zcptfok1bzynsEeZs0Zt0BRZw8e3lWYFWapotjNACynKkkmQiaQAPaAAYAAnJel/KtJ5IZjBR0MA3SBwrwhomN5C78kciHyM3pljvtjcWiIrdZxcyKgVKadkkFpdEyca3UL9yN7nuH9pMyShFgTeP7xI85vJm/tCfFXE4z9eprdc1hyBbJIlQx6xk00E3KFbC1SCCjFeyP0VAMi0T7jiXcxhKXroiyl/x3PJpQfFJcMueODyXvcnceb24yAyJSZLKTkUMVY8XIg8CQhZBNZJAlLY2FYxXX3ZVVVm6EESgJO7cSqthDBT0LaIaMsVclo+dgZpi1k4iYiXaD+Nko96gRy0esnjY6iDhs5bqlOQ5TCBiiA6Ki7bRFAj5zPCTC+Xik4hla3lIuHs9YGlpA+O7fLxjmwU9at2iQhHluhp6BYOWD9V04Ur7RZm4ScF9lVESmKYqg7EUz2MKwbEOF8d0ywTqcwpjDGFRq83ZvpztUpU9LqsfEyU59KZRdRsR8aNO49sTnEgH23EQ30RYZvls/Lfw/SKRecF+OyMstwzHIDP1CTzpa4Rau1DG7lo4Uin7+oQsmiZ9cZowGOdi7N7LJBRLuMRUBKAkWCJxC4t5t8iHLHHfHrG6rmfyhmy5Klk7POKuHqMW2V+pmbdd7M8UUBVVrERiDl4sJlCnXOQEym7zl0RblPxxcDsdeN7idjfitjSx2q3Q1KauXcpZbdImevpmzzbhSUssgxZkKmzgod1NOllGrFAoEbpGApjKKd6pyK+rRE0RNETRE0Ra1H81arr1znZxRvsWdyzVsPGxZI75B4dNdGarmTLQBFWopmIs0MkydtxKYgh85RHcB0RRhZPS8tvM/wAa9Q5Z8ouRN9mOEOIslYe4+0is2i4PyucgupudfQS1rYQjM6qc9I1AiqDR1JypiLKpeyRL3PZOIEWxi4aeHnhB42MYT1v4b4NhbHnllQLS8quXbwshZ8l2qdfV5ZzHRBbY/BuMVX5yXSRD6RAUUEyKbCIgACBFqwYmWe4O8iLrOnkQ465IsURA8grPk3LGJZ+uPIdK9WZC5P7C4p8g5sJGbB1U5ab/ALC50lFk1mIj7QKEMG5FsWfKHz34vcxfx0eUvIfCNziEsf5NxBE0WAgnijSLl6/kFaz1UVsXv4spypNrPCkbqAZsl3FMiiJ0hMTYdEVRvxfeGbjiR4rMUzVlgloTIvJN89zxbPeN87yDtAiOMlfZH524jjz6A5im2MB1R3ANEWRRoiw3vzR8so17gBgrETZyVCUyHyPhrG6TBQxVXFepdKuibpAEwDtOieYnWRzCI9BSANh7h2IsNDwuck5jj1becSRLmhVqzkrx48tKVLNHkq1i28zYXGKLGvQEm53bhEismyt4N1m6aYGVUUACFD5tEWZt+GEuZPx2Z4dHKquYnJazLmIQO9ZYxaPTFDFIBhADKqCGwbiG4joqqB/zz83Odnkn58Y18f8AJ4NyviPCbPK7BjizA7dGOQyJmFUj91FrZQkkXcmwhJCUdVwXZ4Zms6KzaEUMIqiZQxilRXgx3mO5FuLrS/DV4fOOMXwWjsXQs9SrZkzP0TGscqxCdIr0g5yrcp2pxxZOFrE+D5q6mDyib6SdOVFRMmVPchtFXiqpeJzxQY/82fjMzrlHnFerbeeTlj5J5FrGO+Vkm9dWLJ9SXo0TBtTGK/lFUC2ely8nLmO4jllgSWOgGxkzplECorlfEL46vyCPG9yGlcJtsm4YvvBWq2xmDyHy1fbI+rVlp0s5Xdv5nCLWMgJ6x0i5oJuCqPGzlBsxWcpCiJzEH3wIs1LRE0RcCACAgIAICGwgPUBAfUBD4gOiLET/AClMC+OvFHALKmTp/DfHeqcrMkzsXHYruBadAsctT084fN3NidwD2Oakl1AJHtA+scH/APzkL2gcwHMTRFCv+FLg5tY+WfKDPUpBlkG2O8KsqPASrhk7Vbw1luVugJFZZq8FqaORk14GCcJFAViuPYUU7SCQxhAi2SuiJoiaImiJoiaItfz+byyqoPeD8gEkxG7C1yEyUh/pUvuRaqVVFdGSF72e+LE8udRIEu7sBQom23HfRF5CNrJbL+HMLs0U8llaVktpemZmoOjDEOq1kBi4Ql1/pzABWrIyw9wqbpAJw7g9NEWcRwTyAnlfhbxTyakuLlK/8fcTW5NwZZNwK5J+kw0kVUV0t0lhUBxv3F6G9Q0RYJH5nnNOn2/MWDuE9IRg3U1i+JWydmGfZs2gzSFgtCYtKlR5N8Zv9aCUXXmqcoUhVPbEJIncAiUO0i/V4ePxicm8hcPcZ+QvJjlK6HhzlNjVeQjviZUnN2ansM77a415O5MZB0hTGzv6APbcO0Gyr76ZwZJNRP5gMRbEaDhImtQsRXYCOZxEFAxjCGhYmPQTasIyKjGqTKPj2TZIpUm7Rm0QImmQoAUhCgABsGiLtNEWtt/Naz22tPKzizx6jngAbE2KLRc7IxTXEwqP8lS8L9icOW++xPYjqyuCRtgEfdP6htsVVCp4UOC09yiyByPzRZIKNNgPjDxizxd77YbPGNnddc3Nxiu0tMb1WPNKN1Yp7Y3NpXauQR+ZZFumKpQAew2iosif8U3yj8NOKnF3lthjkHklriy00mz2/kmK82gcsTYsdsoSCiJhnVfp0jKSdqiXUcn2RiQHdOyOS+yQew2irxCu68ZtAU8yXmty95mvsloiuJXHVBljbi05tLCTilL3c4erK05OWj4iSAiCUfEQsnIvJEqYGFvLOG5TdqhR2Kig08tXMzEWFvPtznzBBSyUonFcfsjYdipOtMweNHmZrBxraU6IZOXUcUQVQY2p6mzfOhMPsHRUAxg9sQAqjRTvfj2eXrxacWPHngDjJkjlDW8fZiVd2e15CjLpEzlegoW226fWcPEF7XItQrx0fZIioZYFyph3D0DtERKizKKnbatfa1CXOkWODt9Rssc2l67Z61KMpuAnYp4QFGklES0cs4YyDFymPcmqkc5Dh1AR0Reh0RQC+aHyJco/F1kXiRykgaWTJfA1xL27FvLupRzCPWtkLNW1aBkMb5Cr8gVuMwwWrrGCl0djrBGODuioLJmXVbKJEV2vK7yycaeNvjyfeRyuu5PN2GZCtQ8pQT42bGmQss5Z1U42uwUxINQXaVHtn1isZJV8Kf21yRRJYAUIJdEWqT5NciudXm+5nPLcpVLxmPKVrXWYY6w/juKmbBD43pQPEwRh69DtE3IRUHHAqmaQkVwKKpgBVwrsUvaTUqZSqeM38izwkY0T5D8cVZ6MhLOmxnsuY/wtI1rMp6++jEnSLM15xsVpZGNhQZw7hf3pJk1cJMkhOUyyfymEikc4B/maSxbHFY68jWFI2OhjumEOtmvDTCVJIwhyqLElZm+UB68kVJIETlKAJwiaChR6ewOwjoqrPGxhk2hZox3TMsYttMRdsd5Cr0Za6bbIF2m+iJ6Bl25HTCQYukhMRRJVI/UPUpgEogAgIaKi93oiaImiL5OciZDKKGKQhCmOc5zAUhCFARMYxhEAKUoBuIj0ANEWoN/JS58tedfkwySNRmQmMScdUTYJxsun2gguasO1TX2RSEgimsk+vykgCKoCYFG6aYgIl22IsknjRA/evw4M/JLHXafQ4uyvPImFI4e/9ptcG8IQAMBO9Bx7Ik7w3KA9eu22iKXTxhc+cXcdvx4sBcssoTrBGpcfOOLWpLJuZTc01ZaABKLWKY0V+kSVTkJuwpNI1NJNNUUPc33OUgm0VVrAMv3jkV5IeWOY8wpVi2ZSzJmCwXHJ8rXq40c2OaZV6JaqvhZMm7VAjl1FUmpR6LYglSAQatCj26Ki2FXhd/JT4DWfB+HuJPIVQ/D/ACjialwuOo5W8OQXxbZ/9MkYQDMjG3A2YuIKyTDo5jjGPGRE0RKYoOTiG2iLK2d52wmxrKlzeZdxo3qaUeMqpY1LxWiw4R5UfqBdg/8AuX05khR+YNjCI79OuiLq6TyQwDkjH7vKtDzLja2Y5j2TqRkrlC3CEeQMYxZncJuXMm9I87I1NI7VQP7/ALYj27huG2iLUNeT3kG+8s/mHvtlxgV7d63lHMVXwrhgYNuqd9N42g5dGrVWQaoAiodIzqIMd4cRIYEimExtwAREi2E/PHws1GX8Ld64D8K6nFYruder1QyHCR9TcKMVcpZSx+kwmJxrZ5cRQdzspkdVi5agq4ORErl2Q/YQhAIBV+Cxm/H7+HvmfMFExbk/mPkad48yTjIdjQyrgkkK0f2x5jGPRglID7TbI6cVZRM3ZHZn6bgFW7gjZIiRy95jCBSos6hZ/wALeCvGyOwfE5QxbxexPRKK4olVAlwr9fkKk2JDOGSUyzB25O9dWFoIC7O5VTVUUcl71NxHRFrxqhxC/HgwvkbJeUebXk2t3NuTsF/mrNXK3x1hZdqLlq/lVZgzzIljkWrlW3S0mLgxXhWZ2KRlu4SnEg7CVdFeVmnjZ+O9zc8cPNrM3BnE2WsL3HhTj2KuSOTp6DnKcla5uYcycVX2Ci0xKWCJvbCQfslW7pqiLJyksdA4bAJRMRXBfhUZk5G2yG5V4nstunLBxsx3GVeRpMDLrrvmVQyLPSffJNIBdcTfb2UrBkMqs2IbsFRMpwKXruVFkg+cfygPfFRwomM6VGsRVyy1bLHHY/xTBT51y15GwyhTKurFPJNRI4fRddYkFc7QiiBnRxKn7qe4mAi1uPMP8jXyd838D3jjhmTIOO2OLskLohdI2iY7Z11/ORCDxGQTrS0g6kZc6ECD5qkr7aRSLdyRf7uwCAkXqfCH5l1PH1bLHx65KQJszcAc+qnhcx4rm2idhb1A8y3CJe3mqREgKjY4lZKB9xYF9sr1JMBIZJcAU0RbLDxySPiddY8dXTxvk4zRVRsq31s04xOnBRE0D0ExRcNpxq7FKxR6zUxTJKoqFImVQpg2EQHRFIfI5ExyyIqlLXmktExAUl05GzQTcglUASmSVI5ekLscoiAlEOoaIoNecvhN8NfPe4McjZOjaHj3IpZ1nMWS7YSyTTcfTN7btwboqxFwSIWTipFouzRMQFUm6Dopj9/uiIBoilYwBCcTeMGH6JgfB9mxdR8W43hUoGpVllfYNyhHMSHUWUEV3kyu4VXdullFlTCbYyihhAAAdgIrom7hu8boO2i6Lpq6RScNnLdUi7dw3XIVVFdBZIxk1kVkzAYpiiJTFEBAdtEX9tETRFTHNtTmL7hnLlFrzxeOn7pjG/VODkGq/wBK5YzFjqstDxjxs670/pl2r14Q5FO4vYYoDuG2+iLR1tOKfIG28qZHiLXaHZbfyFNleaxWpTmDB67mHtxjJ93DyjhzumdRCNSXbqOnD5YQboswM4UUBIBPoi2zs146bviPwM2jxy43YoZOyhHcR7FjKMZuDRsUjbsg2FJ3MP0TrP10Y1uiack1U0zqqgUE0ibm0RYinkA8VXl4xj4wvHL4/wCg4ssuWKXBDlLNec4vGiv3JaEyveLOMlVMf2xdw8Q95jQIGbdoJg3FSNXddywD3JpDoimA/GY8BmXuBtqsnM7mVX42r51m607p+JsZIyrGZlMc12cQAljsVhkYV28iAnbJHLfRlaJrLC1b9/udqhu0pFXTy3/iw8a+dU5Yc4cXJmD4u8ipn3HcwxTjFSYWv0qqqU6sjY4CEZuHlZll+5Q6z2MbnM5VP3LJnEN9EWGHnP8AHB8zuEnDioKcdLBkqjJSntRExjS91WzViVVWdkSI/SgCWJKajPdXOU4i7YoGKX5jbAAiBFlmeGb8YOGwTx1yy457265Tdx5VYvc4/v8Ax4o13l6/Q6PVZMpHDc9ieQD5Jra8nRS6hzNnYgu2hzdWpzKKKiBFfL44PxlOGfjk5WPOVtWvmQcwWWHZSLfEtbyNGwARuJ30qf2nU9EyEcUHszOpRR1WaDlwBDooLKepjCYSLJH0RdBaoELTWbBWhk5SGCfhpKHGXhHajCYjAkWirQX8W+RMVZpINQV70lCiBiHABAdw0RYzlu/FE8dtuqF6fWyezxlnP1gYvzV/NeY8xXa2SEXK+4DqL+6Qx5M0ZMsSrFFJwLlJwoKKpzEAFNhEigJ5B8AORXibZKWW9eEbhzznxZXlAV/3ix5N5ZvTddVwQCoL2bHyqI3GKJHIJ97oTRR4gggc/u9u46Io1+UXk35neXWv4g8aXEThdR+K2IZa4sXinHfjvVXETE225pm+jLNW1+nAwLaAq0ALtQ7lIyaLQRKms5MZRNPtItg94TfFlXfFDw2hMLKSrS0ZgvEgnf8AO1xjwXJGTN6eNvZSi4dJbYxYSpRhiRzVQSkO4KiKxwAxxACK5vyD+PHjj5LsCPOPvJODlpCsllULJW5yuS7qDslTtTJBdGPmop+1MUVSJCt/faLAdu6IUCqFHYBAihhxp+Il4gajWG0RfKRl7LNhTMYXNtmcxXmqOHID/SQsNS5iHiW4Bv12IYR/UPiRWh8xvwyeHuQ4Z/K8MMsXjj3cW7BcIerX+Tk8l48k5I/YKJpqXklHt0i2yQlHYWxnA9phASGHYwEWFLzT8ZXkd8SF5dusqU2/Y/r71R5DwOd8Vy8o4x5Z4tV0i1RINzrC5fsIzCxygjHS4snqolHZEe0R0RWZxWPeXXIlr97gaFyJzgykZAW/3aDqWR8jtH0q3ExBQB9Gx0wi5foCAgJO4VC9emiK4rG/iI8mmV1WyNP4RcixM729kbLjSx0hMe52oyAVFbkygk0Q99MepxL8mx/6BARIpK8I/imeYTLD+PLbML1LB8BIpIrp2LJGS6Q5IiksJdjOYGlzlosjUxCG3MRVoRQNv6fTRFsf/Elw25B8DuGGPeN/I/kQHI26Uk71vF2Js1fhDVSsCsb7LSK7KzjdrZJiBgWgFSamfJpmQSAEUyESIUoEUmeiJoiaIqeMMRYoirevkKLxjj2Nvzozozm8R9LrbK4ODPkTNnplrM2jUptUzxuYU1RFcRUIIgbcNEVQSkAu4gJh3/8Asc5/8AMYQDRF9aImiJoiaIuNuoD13Df4jt1/UN9h0Rc6ImiJoiaIv5qpJLpKILpprIrJnSWRVIVRJVJQokUTUTOAkOmcgiAgICAgOw6IvDwOLMY1aWGerGOaHXJwU10hmYGoV+IlhSdbfUpjIx8e3eCm42/uB37H+O+iL3miJoiaImiLztqp9SvUM4rl2q9duNednTO6gbVCRlhhnJ0Td6J3EXLtnbFY6R+pRMQRKPUNEX5anQaLQ45KIo1LqdMiUTnVRi6nXIeuxySigCB1EmUOzZtkznAwgIgUBEB0Res0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRE0RNETRF//Z" />
</svg>

    </h1>
    <h2><?php echo $sitename; ?></h2>
    <div>

        <p>若你在安装中遇到麻烦可点击    <a href="<?php echo $link['qqun']; ?>">QQ交流群</a></p>

        <form method="post">
            <?php if ($errInfo): ?>
                <div class="error">
                    <?php echo $errInfo; ?>
                </div>
            <?php endif; ?>
            <div id="error" style="display:none"></div>
            <div id="success" style="display:none"></div>

            <div class="form-group">
                <div class="form-field">
                    <label>MySQL 数据库地址</label>
                    <input name="mysqlHost" value="127.0.0.1" required="">
                </div>

                <div class="form-field">
                    <label>MySQL 数据库名</label>
                    <input name="mysqlDatabase" value="bolefaka" required="">
                </div>

                <div class="form-field">
                    <label>MySQL 用户名</label>
                    <input name="mysqlUsername" value="root" required="">
                </div>

                <div class="form-field">
                    <label>MySQL 密码</label>
                    <input type="password" name="mysqlPassword">
                </div>
            </div>

            <div class="form-group">
                <div class="form-field">
                    <label>管理者用户名</label>
                    <input name="adminUsername" value="admin" required="" />
                </div>


                <div class="form-field">
                    <label>管理者密码</label>
                    <input type="password" name="adminPassword" required="">
                </div>

                <div class="form-field">
                    <label>重复密码</label>
                    <input type="password" name="adminPasswordConfirmation" required="">
                </div>
            </div>

            <div class="form-buttons">
                <button type="submit" <?php echo $errInfo ? 'disabled' : '' ?>>点击安装</button>
            </div>
        </form>

        <script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
        <script>
            $(function () {
                $('form :input:first').select();

                $('form').on('submit', function (e) {
                    e.preventDefault();

                    var $button = $(this).find('button')
                        .text('安装中...')
                        .prop('disabled', true);

                    $.post('', $(this).serialize())
                        .done(function (ret) {
                            if (ret === 'success') {
                                $('#error').hide();
                                $("#success").text("安装成功！开始你的<?php echo $sitename; ?>之旅吧！").show();
                                $('<a class="btn" href="/">访问首页</a> <a class="btn" href="/admin" style="background:#18bc9c">访问后台</a>').insertAfter($button);
                                $button.remove();
                            } else {
                                $('#error').show().text(ret);
                                $button.prop('disabled', false).text('点击安装');
                                $("html,body").animate({
                                    scrollTop: 0
                                }, 500);
                            }
                        })
                        .fail(function (data) {
                            $('#error').show().text('发生错误:\n\n' + data.responseText);
                            $button.prop('disabled', false).text('点击安装');
                            $("html,body").animate({
                                scrollTop: 0
                            }, 500);
                        });

                    return false;
                });
            });
        </script>
    </div>
</div>
<script type="text/javascript" src="//js.users.51.la/20001233.js"></script>
</body>
</html>