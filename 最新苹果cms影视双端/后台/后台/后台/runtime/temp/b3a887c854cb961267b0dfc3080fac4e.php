<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"/www/wwwroot/qy.redlk.com/application/admin/view/app/apixx.html";i:1582873624;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/foot.html";i:1582533410;}*/ ?>
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
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-tab" lay-filter="tb1">
               
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <blockquote class="layui-elem-quote layui-quote-nm">
                           天行数据接口官网：https://www.tianapi.com<br>
                          需要申请：ONE一个，晚安心语，早安心语，网络取名    接口都是免费的
                        </blockquote>
                <div class="layui-form-item">
                    <label class="layui-form-label">
                        APIKEY ：</label>
                    <div class="layui-input-block">
                        <input type="text" name="tianxing_apikey"  value="<?php echo $config['tianxing_apikey']; ?>" class="layui-input">
                    </div>
                </div>
                

                </div>
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
<script type="text/javascript" src="/static/js/jquery.cookie.js"></script>
<script type="text/javascript">
    layui.use(['element', 'form', 'layer'], function() {
        var element = layui.element
            ,form = layui.form
            , layer = layui.layer;


        element.on('tab(tb1)', function(){
            $.cookie('configapi_tab', this.getAttribute('lay-id'));
        });

        if( $.cookie('configapi_tab') !=null ) {
            element.tabChange('tb1', $.cookie('configapi_tab'));
        }

    });
</script>

</body>
</html>