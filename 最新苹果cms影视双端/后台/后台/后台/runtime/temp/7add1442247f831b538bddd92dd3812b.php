<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/www/wwwroot/qy.redlk.com/application/admin/view/app/notice.html";i:1582866622;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/foot.html";i:1582533410;}*/ ?>
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

    <div class="showpic" style="display:none;"><img class="showpic_img" width="120" height="160"></div>

    <form class="layui-form layui-form-pane" action="">
        <div class="layui-tab">
            
            <div class="layui-tab-content">

                <div class="layui-tab-item layui-show">

                <div class="layui-form-item">
                        <label class="layui-form-label">首页公告：</label>
                        <div class="layui-input-block">
                            <textarea name="home_gg" class="layui-textarea"><?php echo $config['home_gg']; ?></textarea>
                        </div>
                    </div>
                  <div class="layui-form-item">
                        <label class="layui-form-label">大厅公告：</label>
                        <div class="layui-input-block">
                            <textarea name="hall_gg" class="layui-textarea" ><?php echo $config['hall_gg']; ?></textarea>
                        </div>
                    </div>
                  <div class="layui-form-item">
                        <label class="layui-form-label">代理专区公告：</label>
                        <div class="layui-input-block">
                            <textarea name="agentzq_gg" class="layui-textarea" ><?php echo $config['agentzq_gg']; ?></textarea>
                        </div>
                    </div>
                  <div class="layui-form-item">
                        <label class="layui-form-label">代理公告：</label>
                        <div class="layui-input-block">
                            <textarea name="agent_gg" class="layui-textarea"><?php echo $config['agent_gg']; ?></textarea>
                        </div>
                    </div>
                  
            </div>


                <div class="layui-form-item center">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">保 存</button>
                        <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="/static/js/admin_common.js"></script>
<script type="text/javascript">
    layui.use(['form', 'layer'], function(){
        // 操作对象
        var form = layui.form
                , layer = layui.layer;


    });



</script>

</body>
</html>