<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"template/conch/html/comment/ajax.html";i:1569497528;}*/ ?>
<!--评论开始-->
<div class="part_rows_fa">
<form class="comment_form cmt_form clearfix"  >
   <input type="hidden" name="comment_pid" value="0">
   <!--评论框-->
   <div class="input_wrap clearfix">
       <textarea class="comment_content" name="comment_content" placeholder="文明发言，共建和谐社会"></textarea>
       <div class="smt fr clearfix">
            <div class="comm_tips fl">还可以输入<span class="comment_remaining">200</span>字</div>
            <?php if($comment['verify'] == 1): ?>
            <input class="comment_submit cmt_post fr" type="button" value="发布">
            <img class="comm-code fr" src="<?php echo mac_url('verify/index'); ?>" data-role="<?php echo mac_url('verify/index'); ?>" title="看不清楚? 换一张！" onClick="this.src=this.src+'?v=<?php echo time(); ?>'"/>
            <input type="text" name="verify" placeholder="验证码" class="verify fr">
            <?php endif; ?>  
       </div>
    </div>
</form>
</div>
    <?php $__TAG__ = '{"num":"5","paging":"yes","order":"desc","by":"id","id":"vo","key":"key"}';$__LIST__ = model("Comment")->listCacheData($__TAG__);$__PAGING__ = mac_page_param($__LIST__['total'],$__LIST__['limit'],$__LIST__['page'],$__LIST__['pageurl'],$__LIST__['half']); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;endforeach; endif; else: echo "" ;endif; ?>
<ul class="part_rows">
	<?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ?>
	<li class="comm_each line_top margin">
		<img class="comm_avat part_roun" src="<?php echo mac_get_user_portrait($vo['user_id']); ?>" />
		<div class="comm_head">
			<strong class="text_line"><?php echo $vo['comment_name']; ?></strong>
			<span class="part_tips"><?php echo date('Y-m-d H:i:s',$vo['comment_time']); ?></span>
		</div>
		<div class="comm_cont">
			<div class="comm_content"><?php echo mac_em_replace($vo['comment_content']); ?></div>
			<div class="gw_action">
				<a class="digg_link" data-id="<?php echo $vo['comment_id']; ?>" data-mid="4" data-type="up" href="javascript:;"><i class="iconfont">&#xe64e;</i><em class="digg_num icon-num"><?php echo $vo['comment_up']; ?></em></a>
				<a class="digg_link" data-id="<?php echo $vo['comment_id']; ?>" data-mid="4" data-type="down" href="javascript:;"><i class="iconfont">&#xe64f;</i><em class="digg_num icon-num"><?php echo $vo['comment_down']; ?></em></a>
				<a class="comment_reply" data-id="<?php echo $vo['comment_id']; ?>" href="javascript:;">回复</a>
				<a class="comment_report" data-id="<?php echo $vo['comment_id']; ?>" href="javascript:;">举报</a>	
			</div>
			<?php if(is_array($vo['sub']) || $vo['sub'] instanceof \think\Collection || $vo['sub'] instanceof \think\Paginator): if( count($vo['sub'])==0 ) : echo "" ;else: foreach($vo['sub'] as $key=>$child): ?>
			<div class="comm_reply comm_reply_child back_ashen comm_tops">
				<div class="comm_rp_head">
					<span class="text_line"><?php echo $child['comment_name']; ?> ／ <?php echo date('H:i',$child['comment_time']); ?></span>
					<div class="comm_content"><?php echo mac_em_replace($child['comment_content']); ?></div>
						<div class="gw_action">
						<a class="digg_link" data-id="<?php echo $child['comment_id']; ?>" data-mid="4" data-type="up" href="javascript:;"><i class="iconfont">&#xe64e;</i><em class="digg_num icon-num"><?php echo $child['comment_up']; ?></em></a>
						<a class="digg_link" data-id="<?php echo $child['comment_id']; ?>" data-mid="4" data-type="down" href="javascript:;"><i class="iconfont">&#xe64f;</i><em class="digg_num icon-num"><?php echo $child['comment_down']; ?></em></a>
						<a class="comment_report_child" data-id="<?php echo $child['comment_id']; ?>" href="javascript:;">举报</a	
					</div>
				</div>
			</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
	</li>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<!--评论结束-->
<?php if($__PAGING__['page_total']>1): ?>
<ul class="page text_center cleafix">
	<li><a href="javascript:void(0);" onclick="MAC.Comment.Show(1)" title="首页"<?php if($__PAGING__['page_current']==1): ?> class="btns_disad"<?php endif; ?>>首页</a></li>
	<li><a href="javascript:void(0);" onclick="MAC.Comment.Show('<?php echo $__PAGING__['page_prev']; ?>')" title="上一页"<?php if($__PAGING__['page_current']==1): ?> class="btns_disad"<?php endif; ?>>上一页</a></li>
	<?php if(is_array($__PAGING__['page_num']) || $__PAGING__['page_num'] instanceof \think\Collection || $__PAGING__['page_num'] instanceof \think\Paginator): if( count($__PAGING__['page_num'])==0 ) : echo "" ;else: foreach($__PAGING__['page_num'] as $key=>$num): ?>
	<li class="hidden_xs <?php if($__PAGING__['page_current'] == $num): ?>active<?php endif; ?>">
	    <?php if($__PAGING__['page_current'] == $num): ?>
            <a class="page_link page_current" href="javascript:;" title="第<?php echo $num; ?>页"><?php echo $num; ?></a>
            <?php else: ?>
            <a class="page_link" href="javascript:void(0)" onclick="MAC.Comment.Show('<?php echo $num; ?>')" title="第<?php echo $num; ?>页" ><?php echo $num; ?></a>
         <?php endif; ?>
    </li>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	<li class="hidden_xs active"><span class="num btns_disad"><?php echo $__PAGING__['page_current']; ?>/<?php echo $__PAGING__['page_total']; ?></span></li>
	<li><a href="javascript:void(0)" onclick="MAC.Comment.Show('<?php echo $__PAGING__['page_next']; ?>')" title="下一页"<?php if($__PAGING__['page_current']==$__PAGING__['page_total']): ?> class="btns_disad"<?php endif; ?>>下一页</a></li>
	<li><a href="javascript:void(0)" onclick="MAC.Comment.Show('<?php echo $__PAGING__['page_total']; ?>')" title="尾页"<?php if($__PAGING__['page_current']==$__PAGING__['page_total']): ?> class="btns_disad"<?php endif; ?>>尾页</a></li>		
</ul>
<div class="page_tips hidden_mb">共<span><?php echo $__PAGING__['record_total']; ?></span>条数据&nbsp;/&nbsp;当前<?php echo $__PAGING__['page_current']; ?>/<?php echo $__PAGING__['page_total']; ?>页</div>
<?php endif; ?>
<script type="text/javascript">
	$(".part_rows_fa .comment_content").click(function(){
		$(".part_rows_fa .smt").addClass("smt_hidn");	
	});
</script>
<script type="text/javascript">
    $('.mac_total').html('<?php echo $__PAGING__['record_total']; ?>');
</script>