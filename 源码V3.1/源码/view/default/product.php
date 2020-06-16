<?php require_once 'header.php' ?>

  <script src="/static/common/layer/layer.js"></script>
  <script src="/static/default/assets/js/app.js"></script>
  <script src="/static/default/js/app.js"></script>
  <?php
  if($data['pwd']&&$data['pwd']!=$_GET['pwd']){
  echo "<script>    
         layer.prompt({title: '请输入商品密码', formType: 1}, function (pass, index) {
            layer.close(index);
            if (pass == '') {
                layer.alert('请输入商品密码', {icon: 2});
                return;
            }
            gpwd = pass
	  $.ajax({
        url: '/index/getGoodsInfoajax',
        type: 'POST',
        dataType: 'json',
        data: {id: ".$data['id'].",pass:gpwd},
        beforeSend: function () {
            layer.load(1);
        },
        success: function (result) {
            layer.closeAll();
            if (result.status == 0) {
                layer.alert('查询失败', {icon: 2})
            } else {              
          		window.location.href='product?id=".$data['id']."&pwd='+gpwd           
              			}
              }
          });
          
        });        
    </script>";
    exit;
  }
  ?>
  

      <div class="am-container" style="padding:2px">
         <div class="am-panel am-panel-default" style="margin:5px 0 5px 0;border-radius: 0px">
         	 <div class="am-panel-bd "><?php echo $this->config['tips'] ?></div>
        </div>

<div class="good-trade">
        <div class="am-container" style="">
                        <div class="am-g ">
                            
                          <div class="am-u-sm-12 am-u-md-5 am-u-lg-5 trade-goodimg am-u-end" style="padding: 0px;text-align: center">
                                       
                                                        <img src="<?php echo $data['image'];?>" >
                                                 
                          </div>
                          <div class="am-u-sm-12 am-u-md-7 am-u-lg-7  am-u-end" style="">
                                  <!-- 网格开始 -->
                                 
                                                
                                                <h2 style="margin-top: 0px;color: #333;font-family: 微软雅黑;" class="am-text-truncate"><?php echo $data['gname'];?></h2>
                                                <p class="trade-goodinfo" style="background-color:#f5f3ef;margin-top: 20px">
                                                        <span style="color:#6c6c6c">促销：</span>
                                                        <span class="trade-price"><?php echo $data['price'];?></span>
                                                  		<span style="color:#6C6C6C">库存：<?php echo $data['kuc'];?>件</span>
                                                                                                           
                                                </p>                    
                                  <div class="am-form-group ajaxdiv">
                                      <label for="number" class="am-u-sm-4 am-form-label">购买数量</label>
                                        <div class="am-u-sm-8">
                                          <input type="hidden" value="<?php echo $data['id'];?>"  id="glist" name="gid">
                                            <input type="number" id="number" name="number" min="1" max="10000" value="1" class="othbox am-form-field"  pattern="^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$" required="required">
                                        </div>
                                    
                                    
                     </div>
                            
                          <?php  
                            
                                    //判断是否是自动发卡
        if ($data['type'] != 1) {
            $html = "<div class=\"am-form-group ajaxdiv\">
                                      <label for=\"account\" class=\"am-u-sm-4 am-form-label\">联系方式</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-active\"
                                                 placeholder=\"QQ号码或者电话\"   value=\"\">
                                        </div>
                     </div>
                     <div class=\"am-form-group ajaxdiv\">
                                        <label for=\"chapwd\" class=\"am-u-sm-4 am-form-label\">查询密码</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"chapwd\" class=\"am-form-field am-active\"
                                                placeholder=\"请仔细查询密码，作为查询重要依据\"    value=\"\">
                                        </div>
                                    </div>";

        }else{
            //手工订单
            $html = "<div class=\"am-form-group ajaxdiv\"><label for=\"account\" class=\"am-u-sm-4 am-form-label\">".$data['onetle']."</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-active\"
                                                    value=\"\">
                                        </div>
                     </div>";
            $ripu = explode(',',$data['gdipt']);
            if($ripu[0]){
                $ipu = 1;
                foreach ($ripu as $v){
                    $html.="<div class=\"am-form-group ajaxdiv\"><label for=\"ipu".$ipu."\" class=\"am-u-sm-4 am-form-label\">".$v."</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"ipu".$ipu."\" class=\"am-form-field am-active\"
                                                    value=\"\">
                                        </div>
                     </div>";
                    $ipu = $ipu+1;
                }

            }
        }
                            
                            echo $html;
                            ?>
                                              
                            
                                               
                                               <br>
                                                <button type="submit" class="am-btn am-btn-danger am-btn-xl am-square" onclick="okOrder()" id="paysubmit" style="margin-top:20px"><span class="am-icon-shopping-cart"></span>立即购买</button>
                                                
                                               
                                <!-- 网格结束 -->
                          </div>
                        </div>
                      </div>


<div class="am-panel am-panel-default" style="border-radius:0px;margin-top: 10px">
                <div class="am-panel-hd">商品描述</div>
                <div class="am-panel-bd"><?php echo $data['cont'];?>
                                                </div>
              </div>
</div>



    </div>
  
    <footer data-am-widget="footer"
          class="am-footer am-footer-default"
           data-am-footer="{  }">
    <div class="am-footer-miscs ">
        <p><?php echo $this->config['copyright']?></p>
        <p><?php echo $this->config['icpcode']?></p>
        <p><?php echo $this->config['tel']?></p>
    </div>
  </footer>

  <div id="am-footer-modal"
       class="am-modal am-modal-no-btn am-switch-mode-m am-switch-mode-m-default">
    <div class="am-modal-dialog">
      <div class="am-modal-hd am-modal-footer-hd">
        <a href="javascript:void(0)" data-dismiss="modal" class="am-close am-close-spin " data-am-modal-close>&times;</a>
      </div>
      <div class="am-modal-bd">
		<?php echo $this->config['copyright']?>
		<?php echo $this->config['icpcode']?>
		<?php echo $this->config['tel']?>
	
      </div>
    </div>
  </div>


<script>
function countoper(oper){
        count=$("#count").val();
        if(oper=='jia'){
           count=parseInt(count)+1;
        }else{
           count=parseInt(count)-1;
        }
        if(parseInt(count)<0){
           count=0;
        }
         $("#count").val(count);
}

        
</script>
<?php echo $this->config['stacode'];?>
</body>
</html>