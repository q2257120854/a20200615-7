<?php require_once 'header.php' ?>
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="am-container">
        <div class="tpl-content-scope">
            <div class="note note-info">
                <?php echo $this->config['tips'] ?>
            </div>
        </div>

        <div class="row">

            <div class="am-u-md-6 am-u-sm-12 row-mb">
                <div class="tpl-portlet">
                    <div class="tpl-portlet-title">
                        <div class="tpl-caption font-green ">
                            <i class="am-icon-shopping-bag"></i>
                            <span>购买商品</span>
                        </div>

                    </div>

                    <div class="tpl-scrollable">
                        <div class="am-g tpl-amazeui-form">


                            <div class="am-u-sm-12 ">
                                <form class="am-form am-form-horizontal" id="sgform">
                                    <div class="am-form-group">
                                        <label for="sc-cid" class="am-u-sm-3 am-form-label">分类</label>
                                        <div class="am-u-sm-9">
                                            <select id="sc-cid" class="am-form-field am-round">
                                                <option value="0">请选择分类</option>
                                                <?php if($class):?>
                                                    <?php foreach($class as $key=>
                                                                  $val):?>
                                                        <option value="<?php echo $val['id']?>">
                                                            <?php echo $val['title']?>
                                                        </option>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <label for="glist" class="am-u-sm-3 am-form-label">列表</label>
                                        <div class="am-u-sm-9">
                                            <select class="am-form-field am-round" id="glist">
                                                <option value="0">请选择商品</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="money" class="am-u-sm-3 am-form-label">单价</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="money" class="am-form-field am-round"
                                                   disabled="disabled" value="">
                                        </div>
                                  </div>

                                    <div class="am-form-group">
                                        <label for="kuc" class="am-u-sm-3 am-form-label">库存</label>
                                        <div class="am-u-sm-9">
                                            <input type="text" id="kuc" class="am-form-field am-round"
                                                   disabled="disabled" value="">
                                        </div>
                                    </div>


                                    <div class="am-form-group">
                                        <label for="number" class="am-u-sm-3 am-form-label">数量</label>
                                        <div class="am-u-sm-9">
                                            <input id="number" class="am-form-field am-round" type="text" value="1">
                                        </div>
                                    </div>


                                    <div class="am-form-group" id="okshop">

                                        <div class="am-u-sm-12 am-u-sm-push-5">
                                            <a onclick="okOrder()" class="am-btn am-btn-primary">确认购买</a>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <div class="am-u-md-6 am-u-sm-12 row-mb">
                <div class="tpl-portlet">
                    <div class="tpl-portlet-title">
                        <div class="tpl-caption font-red ">
                            <i class="am-icon-credit-card-alt"></i>
                            <span>商品详情</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="tpl-scrollable">
                        <div class="am-g tpl-amazeui-form">


                            <div class="am-u-sm-12 " id="gdinfo">

                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="am-u-md-6 am-u-sm-12 row-mb">


                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">

                </div>
            </div>


        </div>		
      
      
      


</div>
</div>


  <?php 
		$id=$_GET["id"];
		$cid=$_GET["cid"];
		$pwd=$_GET["pwd"];
			if ($this->config['indexmode']=='0'){ 
				if($id) {
					echo"<script>";
					echo "$.ajax({
					url: '/index/typegd',
					type: 'POST',
					dataType: 'json',
					data: {cid: ".$cid."},
					beforeSend: function () {
					$('#glist').html();
					},
					success: function (result) {		
					$('#glist').html(result.html);	";
					$optionxz = "$(&quot;#sc-cid option[value='$cid']&quot;).attr(&quot;selected&quot;,&quot;selected&quot;);
						   $(&quot;#glist option[value='$id']&quot;).attr(&quot;selected&quot;,&quot;selected&quot;);";					 
						echo htmlspecialchars_decode($optionxz, ENT_COMPAT);
					echo"}
					});";
					if($pwd){					
						echo"getGoodsInfo(".$id.",".$pwd.")";	
					}else{
						echo"getGoodsInfo(".$id.")";
					}
					echo"</script>";
				}
			}else{
				if($id) {
					echo"<script>";					
					if($pwd){	
						echo"getGoodsInfox(".$id.",".$pwd.")";
					}else{						
						echo"getGoodsInfox(".$id.")";
					}						
					echo"</script>";
				}

}
?>
<?php require_once 'footer.php' ?>				