<?php require_once 'header.php' ?>
<div class="am-container" style="padding:2px">    
        <div class="am-panel am-panel-default" style="margin:5px 0 5px 0;border-radius: 0px">
      <div class="am-panel-bd "><?php echo $this->config['tips'] ?></div>
    </div>
   <div class="goods">
					 <div class="am-show-landscape">
                              <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-thumbnails">
                                
                               <?php foreach ($lists as $key => $val): ?>
                                <li ><a onclick="getnewGoods('<?php echo $val['id'] ?>')">
                                    <div style="background-color: #fff;" class="index_good_body">                      
                                    <img src="<?php echo $val['image'] ?>" style="width:100%;height:280px"/>
                                    <div class="pr-info" style="padding:5px">
                                      <span class="price">¥<?php echo $val['price'] ?></span>
                                                                            <span class="pr-xl am-badge am-badge-danger" style="color:#fff">库存<?php echo $val['kuc'] ?>张</span>
                                               
                      					<input id="cp<?php echo $val['id']?>" data-pwd<?php echo $val['pwd']?> type="hidden">                             
                                      <div class="index-goodname-xq" style="height:45px;color:#333"><p title="<?php echo $val['gname'] ?>"><?php echo $val['gname'] ?></p></div>
                                      </div>
                                    </div>
                                </a>
                                </li>
               				 <?php endforeach; ?>                                 
                       		</ul>
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