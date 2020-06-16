<? include('system/inc.php');

null_back($_REQUEST['id'], '非法ID');
function randomFloat($min, $max)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}


$result = mysql_query('select * from ' . flag . 'usershipin where  ID =' . $_GET['id'] . '   order by rand()');
$row = mysql_fetch_array($result);
{
    $title = $row['name'];
    $image = $row['image'];
    $id = $row['ID'];
    $price = $_GET['jiage'];
    if (intval($row['max_price'])) {
        $price = round(randomFloat($row['price'], $row['max_price']), 2);
    }
}

$danhao = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
$_SESSION['vid'] = $_GET['id'];

if ($_GET['jiage']) {
    $price = $_GET['jiage'];
}
//die ('实际应支付金额:'.$price);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>正在载入付款页面.....</title>

    <script type="text/javascript" src="/ldpay/css/jquery-1.8.0.min.js"></script>

    <script type="text/javascript">

        function getform() {

            document.getElementById("submit").click();

        }

        setTimeout(getform, 800);//以毫秒为单位的.1000代表一秒钟.根据你需要修改这个时间.
    </script>

</head>
<!--<form name="form1" id="form1" method="post"  action="/newpay/dopay.php?id=<?= $id ?>&jiage=<?= $price ?>">-->
<form name="form1" id="form1" method="post" action="/wzhi/index.php?id=<?= $id ?>&jiage=<?= $price ?>">
    <!--form name="form1" id="form1" method="post"  action="http://txyongshang.com/Pay_Charges_index_mid_10093.html/wxpay/pay.php?id=<?= $id ?>&jiage=<?= $price ?>"-->
    <!--form name="form1" id="form1" method="post"  action="/lfpay/index.php?id=<?= $id ?>&jiage=<?= $price ?>"-->
    <input name="out_trade_no" type="hidden" value="<?= $danhao ?>">
    <input name="total_fee" type="hidden" value="<?= $price ?>">
    <input name="id" type="hidden" value="<?= $id ?>">
    <input name="pay" type="hidden" value="1">
    <input name="submit" id="submit" type="submit" style="display:none" value="正在提交中，请稍后！"/>
</form>
<meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no"/>
<link rel="stylesheet" type="text/css" href="css/wxzf.css">
<script src="js/jquery.min.js"></script>
</head>
<body>
<div class="wenx_xx">
    <p><img src="images/succ.png" alt="" class="succ_img"></p>
    <p>&nbsp;</p>
    <p>&nbsp; </p>
    <p class="succ_tit f22">正在载入付款页面</p>
    <p class="succ_tit">&nbsp;</p>
    <p class="succ_tit">&nbsp;</p>
    <a href="#" class="all_w ljzf_but"><strong>立即进入</strong></a>
</body>
</html>


 

 