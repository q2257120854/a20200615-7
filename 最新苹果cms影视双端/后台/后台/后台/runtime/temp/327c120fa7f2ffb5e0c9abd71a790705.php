<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/www/wwwroot/qy.redlk.com/application/admin/view/app/config.html";i:1585807408;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/foot.html";i:1582533410;}*/ ?>
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
        <input type="hidden" name="__token__" value="<?php echo \think\Request::instance()->token(); ?>" />

        <div class="layui-tab" lay-filter="tb1">
           
            <div class="layui-tab-content">

                <div class="layui-tab-item layui-show">
                <div class="layui-form-item">
                    <label class="layui-form-label">APP名称：</label>
                  <div class="layui-input-inline w150">
                        <input type="text" name="appname" placeholder="" value="<?php echo $config['appname']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">下载地址：</label>
                    <div class="layui-input-inline w500">
                        <input type="text" name="down_url"  value="<?php echo $config['down_url']; ?>" class="layui-input">
                    </div>
                </div>
                    <div class="layui-form-item">
                    <label class="layui-form-label">运营模式：</label>
                    <div class="layui-input-inline w300">
                        <input type="radio" name="pattern" value="0" title="免费" <?php if($config['pattern'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="pattern" value="1" title="收费" <?php if($config['pattern'] == 1): ?>checked <?php endif; ?>>
                    </div>
                    
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">注册限制：</label>
                    <div class="layui-input-inline w150">
                        <input type="number" name="reg_limit"  value="<?php echo $config['reg_limit']; ?>" class="layui-input">
                    </div>
                   <div class="layui-form-mid layui-word-aux">一部手机最多注册几个账号。</div>
                </div>
                  <div class="layui-form-item">
                    <label class="layui-form-label">注册送会员：</label>
                    <div class="layui-input-inline w150">
                        <input type="number" name="reg_givevip"  value="<?php echo $config['reg_givevip']; ?>" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">单位天</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">安全码：</label>
                    <div class="layui-input-inline w200">
                        <input type="text" name="safety_code"  value="<?php echo $config['safety_code']; ?>" class="layui-input">
                    </div>
                  <div class="layui-form-mid layui-word-aux">app与后台的通信验证</div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">提现限制：</label>
                    <div class="layui-input-inline w150">
                        <input type="number" name="tixian_limit"  value="<?php echo $config['tixian_limit']; ?>" class="layui-input">
                    </div>
                  <div class="layui-form-mid layui-word-aux">提现需要会员有效期在多少天以上。</div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">宣传标语：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="app_Invitation_slogans"  value="<?php echo $config['app_Invitation_slogans']; ?>" class="layui-input">
                    </div>
               
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">短域名key：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="suo_key"  value="<?php echo $config['suo_key']; ?>" class="layui-input">
                    </div>
            	<div class="layui-form-mid layui-word-aux">http://suo.im里面的key，自己申请即可</div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">分享海报1：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="poster_img1"  value="<?php echo $config['poster_img1']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">分享海报2：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="poster_img2"  value="<?php echo $config['poster_img2']; ?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">分享海报3：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="poster_img3"  value="<?php echo $config['poster_img3']; ?>" class="layui-input">
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">启动图：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="launchImage_url"  value="<?php echo $config['launchImage_url']; ?>" class="layui-input">
                    </div>
                </div>
                
                <div class="layui-form-item">
                    <label class="layui-form-label">启动图跳转地址：</label>
                    <div class="layui-input-inline w800">
                        <input type="text" name="launchImage_href"  value="<?php echo $config['launchImage_href']; ?>" class="layui-input">
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
<script type="text/javascript" src="/static/js/jquery.cookie.js"></script>
<script type="text/javascript">
    layui.use(['form','upload', 'layer'], function(){
        // 操作对象
        var element = layui.element
            ,form = layui.form
            , layer = layui.layer
            , upload = layui.upload;

        form.on('radio(cache_type)',function(data){
            $('.row_cache_server').hide();
           if(data.value=='memcache' || data.value=='redis' || data.value=='memcached'){
               $('.row_cache_server').show();
           }
        });

        element.on('tab(tb1)', function(){
            $.cookie('config_tab', this.getAttribute('lay-id'));
        });

        if( $.cookie('config_tab') !=null ) {
            element.tabChange('tb1', $.cookie('config_tab'));
        }

        upload.render({
            elem: '.layui-upload'
            ,url: "<?php echo url('upload/upload'); ?>?flag=site"
            ,method: 'post'
            ,before: function(input) {
                layer.msg('文件上传中...', {time:3000000});
            },done: function(res, index, upload) {
                var obj = this.item;
                if (res.code == 0) {
                    layer.msg(res.msg);
                    return false;
                }
                layer.closeAll();
                var input = $(obj).parent().parent().find('.upload-input');
                if ($(obj).attr('lay-type') == 'image') {
                    input.siblings('img').attr('src', res.data.file).show();
                }
                input.val(res.data.file);

                if(res.data.thumb_class !=''){
                    $('.'+ res.data.thumb_class).val(res.data.thumb[0].file);
                }
            }
        });

        $('.upload-input').hover(function (e){
            var e = window.event || e;
            var imgsrc = $(this).val();
            if(imgsrc.trim()==""){ return; }
            var left = e.clientX+document.body.scrollLeft+20;
            var top = e.clientY+document.body.scrollTop+20;
            $(".showpic").css({left:left,top:top,display:""});
            if(imgsrc.indexOf('://')<0){ imgsrc = ROOT_PATH + '/' + imgsrc;	} else{ imgsrc = imgsrc.replace('mac:','http:'); }
            $(".showpic_img").attr("src", imgsrc);
        },function (e){
            $(".showpic").css("display","none");
        });


    });

    function test_cache(){
        var type = $("input[name='app[cache_type]']:checked").val();
        var host = $("input[name='app[cache_host]']").val();
        var port = $("input[name='app[cache_port]']").val();
        var user_name =  $("input[name='app[cache_username]']").val();
        var password = $("input[name='app[cache_password]']").val();
        layer.msg('数据提交中...',{time:500000});
        $.ajax({
            url: "<?php echo url('system/test_cache'); ?>",
            type: "post",
            dataType: "json",
            data: {type:type,host:host,port:port,username:user_name,password:password},
            beforeSend: function () {
            },
            error:function(r){
                layer.msg('发生错误，请检查是否开启扩展库和配置项!',{time:1800});
            },
            success: function (r) {
                layer.msg(r.msg,{time:1800});
            },
            complete: function () {
            }
        });
    }


</script>

</body>
</html>