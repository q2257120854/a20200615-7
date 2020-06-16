<?php require_once 'header.php' ?> 
<style type="text/css">    
        /* 色调设置 */
		.am-thumbnails {
			margin-right: -.1rem;
		}
		.item-shop {
			width: 100%;
			height: 188px;
			border-radius: 10px;
			background: white;
			text-align: center;
			float: left;
			margin-right: 8px;
			margin-left: 8px;
			margin-bottom: 20px;
			overflow: hidden;
		}
		.goods{			
			background-color: rgba(193, 193, 193, 0.88);
		}
	.item-title {
			font-size: 18px;
			margin-bottom: 10px;
			border-radius: 5px;
			height: 40px;
			line-height: 40px;
			color: white;
			background: #274D81;
		}
		.alert-info {
			color: #F86539;
			background-color: #FAFBF9;
			border-color: #bce8f1;
		}
		.red {
			color: blue;
		}
		.but2 {
			border-radius: 10px;
			width: 100%;
			padding: 10px 10px !important;
			background: rgb(61, 121, 210);
			color: white;
		}
		.item-title:hover{
			background: #0B0EF2;
			}
		.but2:hover {
			background: #0652c1;
		}
       .liebiaocatname{         
      	 width:100%;
		 margin: 0 auto;
		background: rgb(234, 113, 26);
		color: #ffffff;
		line-height: 35px;
		text-align: center;
		font-size: 20px;
		border-radius: 60px;
		margin-bottom: 15px;
		float: left;
		cursor: pointer;
      }
       .liebiaocatname a{         
      	 color:#fff;text-align:center
      }
    </style>
<div class="am-container" style="padding:2px">    
        <div class="am-panel am-panel-default" style="margin:5px 0 5px 0;border-radius: 0px">
      <div class="am-panel-bd "><?php echo $this->config['tips'] ?></div>
    </div>
   <div class="goods">
   <?php foreach($class as $vals):?>
    <div class="liebiaocatname am-show-landscape"><a href="?cid=<?php echo $vals['id'];?>"><b><?php echo $vals['title'];?></b></a></div>
					 <div class="am-show-landscape">
                              <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-thumbnails">
							  <?php foreach ($lists as $val): ?>
						   <?php if ($vals['id']==$val['cid']){ ?>
                                <li ><a onclick="getnewGoods('<?php echo $val['id'] ?>')">
                                    <div style="background-color: #fff;" class="index_good_body">     
										<div class="item-shop" id="231" name="14">	
											<div class="item-title"><?php echo $val['gname'] ?></div>
											
											<div class="item-bz">
												<p><label id="tip" style="padding:5px; margin-bottom: 0px;" class="alert alert-info">1个=<?php echo $val['price'] ?>元</label></p>
																		<p>实时库存：<span class="red"><?php echo $val['kuc'] ?></span></p>											
											</div>
											<div>						
												<input type="submit" class="but2" value="在线购买">
											</div>
											</div>
										</div>
                                </a>
                                </li>
						   <?php }?>
						   <?php endforeach;?>                                
                       		</ul>
						</div>     
				   <?php endforeach;?>
				   
				   
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
                                        <img class="am-radius" alt="140*140" src="<?php echo $val['image']?>" width="70" height="70" style="float: left" />
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