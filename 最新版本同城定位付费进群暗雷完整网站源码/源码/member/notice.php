<? include('../system/inc.php');include('check.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>平台公告</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    
    <link rel="stylesheet" href="layui/css/layui.css">
    <link rel="stylesheet" href="css/pc.css">
    
</head>
<body>

<div class="layui-fluid child-body" style="text-align: center;padding: 30px 0 30px 0;">
 
     
                  <?=$site_notice?>    
</div>
<div class="layui-fluid child-body">
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md3">
            <blockquote class="layui-elem-quote">
                <h3>今日收款数：</h3>
                <br>
                <h1><?=get_tdordernum($member_id)?></h1>
            </blockquote>
        </div>
        <div class="layui-col-md3">
            <blockquote class="layui-elem-quote1">
                <h3>今日收入：</h3>
                <br>
                <h1><?=get_xiaoshu(get_tdorderprice($member_id))?></h1>
            </blockquote>
        </div>
        <div class="layui-col-md3">
            <blockquote class="layui-elem-quote2">
                <h3>昨日收款数：</h3>
                <br>
                <h1><?=get_ztordernum($member_id)?></h1>
            </blockquote>
        </div>
        <div class="layui-col-md3">
            <blockquote class="layui-elem-quote3">
                <h3>昨日收入：</h3>
                <br>
                <h1><?=get_xiaoshu(get_ztorderprice($member_id))?></h1>
            </blockquote>
        </div>
    </div>
    <div class="layui-row">
        <p>详细记录</p>
        <table id="list"></table>
    </div>
</div>
<script src="layui/layui.all.js"></script>
<script src="js/pc.min.js"></script>

<script type="text/html" id="timeTpl">
    {{layui.util.toDateString(parseInt(d.create_time+'000'),'yyyy-MM-dd HH:mm')}}
</script>
<script>
table.render({
    elem: '#list', 
    height: 'full-165',
    cols: [
        [ 
            { field: 'id', title: 'ID', width: 120 },
            { field: 'create_time', title: '收款时间', width: 170},
            { field:'fee', title: '金额',width:100 , },
            { field: 'res_id', title: '资源ID' ,width:120 },
            { field:'trade_no', title: '订单号'},
        ]
    ],
    url: 'ajax.php?act=myorder',
    id: 'list'
})
</script>

<script>;</script>s
<script>
table.render({
    elem: '#video', //指定原始表格元素选择器（推荐id选择器）
    cols: [
        [ //标题栏
            { checkbox: true },
            { field: 'id', title: 'ID', width: 80 },
            { field: 'title', title: '标题' },
            { fixed: 'right', title: '操作', width: 240, align: 'center', toolbar: '#operate' }
        ]
    ],
    url: 'ajax.php?act=shipin&cid=<?=$_GET['cid']?>',
    id: 'video'
})

table.on('tool(list)', function(obj) {
    var data = obj.data
    if (obj.event === 'view') {
        layer.open({
            type: 2,
            // maxmin: true,
            title: false,
            // area: ['100%', '100%'],
            shadeClose: true, //点击遮罩关闭层
            content: '/member/play.php?src=' + data.url,
            success: function(layero, index) {
                var width = layer.getChildFrame('video', index).width()
                var height = layer.getChildFrame('video', index).height()
                var win_width, win_height
                if (self != top) {
                    win_height = $(top.window).height()
                    win_width = $(top.window).width()
                } else {
                    win_height = $(window).height()
                    win_width = $(window).width()
                }
                layer.style(index, {
                    width: width,
                    height: height,
                    top: (win_height - height) / 2,
                    left: (win_width - width) / 2
                })
                layer.iframeAuto(index)
            }
        })
    } else if (obj.event === 'add') {
        addVideo([data.id])
    }
})

function addVideo (id) {
  $.ajax({
      url: "ajax.php?act=addshipin",
      data: { id: id },
      success: function(response) {
          if (response.code == 0) {
              success(response.msg)
          } else if (response.code==1) {
              error(response.msg)
          }
      }
  })
}

$('#add-all-btn').on('click', function() {
    var checkStatus = table.checkStatus('video')
    var data = checkStatus.data
    if (data.length) {
      var id=data.map(function(item) {return parseInt(item.id)})
        addVideo(id)
        $('div.laytable-cell-checkbox').find('div.layui-form-checked').click()
    }
})

</script>

<script>;</script></body>
</html>