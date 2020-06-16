<?php

	header("content-type:text/html; charset=utf-8"); 
	require_once("config.php");
	require_once("Mysql.php");
	$db = MySql::getInstance();

	function pagination($count, $perlogs, $page, $url) {
		$pnums = @ceil($count / $perlogs);
		$re = '';
		$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|", "", $url);
		for ($i = $page - 5; $i <= $page + 5 && $i <= $pnums; $i++) {
			if ($i > 0) {
				if ($i == $page) {
					$re .= " <span>$i</span> ";
				} elseif ($i == 1) {
					$re .= " <a href=\"$urlHome\">$i</a> ";
				} else {
					$re .= " <a href=\"$url$i\">$i</a> ";
				}
			}
		}
		if ($page > 6)
			$re = "<a href=\"{$urlHome}\" title=\"首页\">首页</a><em>...</em>$re";
		if ($page + 5 < $pnums)
			$re .= "<em>...</em> <a href=\"$url$pnums\" title=\"尾页\">尾页</a>";
		if ($pnums <= 1)
			$re = '';
		return $re;
	}
?>