<?php require_once 'header.php' ?>

    <style type="text/css">    
        /* 色调设置 */
       .liebiaocatname{         
      	 background-color:#393D49;color:#fff;text-align:center
      }
       .wapcatname{         
      	 background-color:#393D49;color:#fff;text-align:center
      }
      .am-table {
        background-color:#fff;font-size:15px;border:#ccc solid 1px
      }
      .index_good_body:hover{
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
			z-index: 2;
        }
    </style>



<div class="am-container" style="padding:2px">    
        <div class="am-panel am-panel-default" style="margin:5px 0 5px 0;border-radius: 0px">
      <div class="am-panel-bd "><?php echo $this->config['tips'] ?></div>
    </div>
   <div class="goods">
	  <div class="am-show-landscape">
		   <table class="am-table">
			  <thead>
				  <tr class="thhead">
					  <th style="text-align: left">商品标题</th>
					  <th style="text-align: center;width: 10%">单价</th>
					  <th style="text-align: center;width: 10%">库存</th>
					  <th style="text-align:center">操作</th>
				  </tr>
			  </thead>
			  <tbody>
				
						<?php foreach($class as $vals):?>
						  <tr><th colspan="4" class="liebiaocatname"><a href="?cid=<?php echo $vals['id'];?>"><b><?php echo $vals['title'];?></b></a></th></tr>
						   <?php foreach ($lists as $val): ?>
						   <?php if ($vals['id']==$val['cid']){ ?>
						   <tr>
							 <td><b><?php echo $val['gname']?></b></td>
							 <td style="text-align: center"><span style="font-size:13px;color:red"><?php echo $val['price']?>元</span></td>
							 <td style="text-align: center"><?php echo $val['kuc'] ?>件</td>
							 <input id="cp<?php echo $val['id']?>" data-pwd<?php echo $val['pwd']?> type="hidden">
							 <td style="text-align:center">
							   <button onclick="getnewGoods('<?php echo $val['id'] ?>')" class="am-btn am-btn-default am-btn-xs am-text-secondary">
								 <span class="am-icon-shopping-cart"></span>购买
							   </button>
							 </td>
						   </tr>
						   <?php }?>
						   <?php endforeach;?>
						   <?php endforeach;?>
										
				</tbody>
		  </table>
		  </div>
					  
	<div class="am-show-portrait">
				<div class="am-container">
				  <div class="am-g">
					  <?php foreach($class as $vals):?>
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12" style="padding:2px">
                                  <a href="?cid=<?php echo $vals['id'];?>"><div style="background-color: #393D49;color: #fff;padding: 10px;text-align: center"><?php echo $vals['title'];?></div></a>
                                </div>
                                <?php foreach ($lists as $val): ?>
                  				 <?php if ($vals['id']==$val['cid']){ ?>
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12" style="margin-bottom: 5px;padding:2px">
                                  <div style="background-color: #fff;height: 80px">
                                    <div style="padding:5px">
                                      <a onclick="getnewGoods('<?php echo $val['id'] ?>')" style="color: #000;">
                                        <img class="am-radius" alt="<?php echo $val['gname']?>" src="<?php echo $val['image']?>" width="70" height="70" style="float: left" />
                                        <div class="am-text-truncate" style="margin-left: 15px;">
                                          <span style="margin-left: 5px"><?php echo $val['gname']?></span>
                                          <br>
                                          <div style="margin-top: 18px">
                                            <span class="am-badge am-badge-danger am-radius" style="margin-left: 5px">库存(<?php echo $val['kuc']?>)</span>
                                            <span style="color: #ff0000">
                                              <b>¥<?php echo $val['price']?></b>
                                            </span>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                
                   <?php }?>
                   <?php endforeach;?>
                   <?php endforeach;?>  
				</div>
			  </div>						  
			</div>
						  <?php echo $lists ? $pagelist : '' ?>
    </div>
    </div>

<?php require_once 'footer.php' ?>