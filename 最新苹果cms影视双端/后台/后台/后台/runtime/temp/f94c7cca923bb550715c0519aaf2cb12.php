<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"/www/wwwroot/qy.redlk.com/application/admin/view/index/quickmenu.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/foot.html";i:1582533410;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS内容管理系统</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css?v=1020">
    <link rel="stylesheet" href="/static/css/admin_style.css?v=1020">
    <script type="text/javascript" src="/static/js/jquery.js?v=1020"></script>
    <script type="text/javascript" src="/static/layui/layui.js?v=1020"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>

<div class="page-container">
    <fieldset class="layui-elem-field layui-field-title" class="mt10">
        <legend>自定义快捷菜单</legend>
    </fieldset>

    <blockquote class="layui-elem-quote layui-quote-nm">
        格式要求：1.菜单名称,菜单链接地址；2.每个快捷菜单各占一行；<br>
        1，支持远程地址，例如： 更新日志,//www.maccms.com/doc/v10/log.html<br>
        2，支持插件文件，例如： 插件文件菜单,/application/xxxx.html<br>
        3，支持系统模块，例如： 文章管理,art/data<br>
        4，支持行分隔符，例如： 分隔符,###
    </blockquote>

    <form class="layui-form" action="">
        <div class="layui-form-item layui-form-text">
            <textarea name="quickmenu" placeholder="请输入内容" class="layui-textarea" style="height:600px; resize:none"><?php echo $quickmenu; ?></textarea>
        </div>
        <div class="layui-form-item center">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">保 存</button>
                <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>

</body>
</html>