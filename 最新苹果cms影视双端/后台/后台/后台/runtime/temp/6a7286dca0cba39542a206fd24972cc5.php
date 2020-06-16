<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/www/wwwroot/qy.redlk.com/application/admin/view/app/popupmessage.html";i:1585288650;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/application/admin/view/public/foot.html";i:1582533410;}*/ ?>
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
                    <label class="layui-form-label">标题/片名：</label>
                    <div class="layui-input-block">
                        <input type="text" name="vod_name"  value="<?php echo $config['vod_name']; ?>" class="layui-input">
                    </div>
                </div>
                
                  <div class="layui-form-item">
                        <label class="layui-form-label">图片：</label>
                        <div class="layui-input-inline w600">
                            <input type="text" name="img" value="<?php echo $config['img']; ?>" class="layui-input upload-input">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:0,thumb_class:'site[site_logo]'}}" id="upload1">上传图片</button>
                        </div>
                    </div>
                   
                    <div class="layui-form-item">
                    <label class="layui-form-label">类型：</label>
                    <div class="layui-input-inline w300">
                        <input type="radio" name="patternn" value="0" title="跳转链接" <?php if($info['patternn'] != 1): ?>checked <?php endif; ?>>
                        <input type="radio" name="patternn" value="1" title="影片播放" <?php if($info['patternn'] == 1): ?>checked <?php endif; ?>>
                    </div>
                    <div class="layui-form-mid layui-word-aux" style="color:red;"><span style="color:red;">如果为播放影片，以下影片相关的4项必填，否则无法播放。</span></div>
                </div>
                   
                  <div class="layui-form-item">
                   <label class="layui-form-label">跳转地址：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="url"  value="<?php echo $config['url']; ?>" class="layui-input w400" >
                    </div>
                </div>
                  <div class="layui-form-item">
                   <label class="layui-form-label">影片id：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="vod_id"  value="<?php echo $config['vod_id']; ?>" class="layui-input w150" >
                    </div>
                </div>
                
                 <div class="layui-form-item">
                   <label class="layui-form-label">影片分类id：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="type_id"  value="<?php echo $config['type_id']; ?>" class="layui-input w150" >
                    </div>
                </div>
                
                 <div class="layui-form-item">
                   <label class="layui-form-label">影片地区：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="vod_area"  value="<?php echo $config['vod_area']; ?>" class="layui-input w150" >
                    </div>
                </div>
                
                <div class="layui-form-item">
                   <label class="layui-form-label">弹窗id：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="number"  value="<?php echo $config['number']; ?>" class="layui-input w150" >
                    </div>
                    <div class="layui-form-mid layui-word-aux" style="color:red;"><span style="color:red;">修改弹窗，数值要大于原来的。</span></div>
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