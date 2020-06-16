<?php require_once 'header.php' ?>
    <style>
        .form-ajax>.form-group>.col-md-6{color:#6B6D6E;font-size:0.9em;line-height:
        30px}.form-ajax>.form-group>.col-md-2{color:#6B6D6E;}
    </style>
    <script charset="utf-8" src="/view/editor/kindeditor-min.js">
    </script>
    <script charset="utf-8" src="/view/editor/lang/zh_CN.js">
    </script>
    <script>
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name="tips"]', {
                allowFileManager: false,
            });
        });
    </script>
    <h3>
        <span class="current">
            系统设置
        </span>
        &nbsp;/&nbsp;
        <span>
            邮件服务器
        </span>
        &nbsp;/&nbsp;
        <span>
            公告设置
        </span>
        &nbsp;/&nbsp;
        <span>
            库存告警策略
        </span>
        &nbsp;/&nbsp;
        <span>
            音乐设置
        </span>

    </h3>
    <br>
    <div class="set set0">
        <script charset="utf-8" src="/view/editor/kindeditor-min.js">
    </script>
    <script charset="utf-8" src="/view/editor/lang/zh_CN.js">
    </script>
    <script>
        var editor;
        KindEditor.ready(function(K) {          
		var editor = K.editor({
         allowFileManager : true
        });
        K('#upload').click(function() {
         editor.loadPlugin('image', function() {
          editor.plugin.imageDialog({
           imageUrl : K('#image').val(),
           clickFn : function(url, title, width, height, border, align) {
            K('#image').val(url);
            editor.hideDialog();
           }
          });
         });
        });
        K('#upload2').click(function() {
         editor.loadPlugin('image', function() {
          editor.plugin.imageDialog({
           imageUrl : K('#upload2').val(),
           clickFn : function(url, title, width, height, border, align) {
            K('#upload2').val(url);
            editor.hideDialog();
           }
          });
         });
        }); 
          
          
        });
    </script>
      
        <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>set/save"
        method="post" autocomplete="off">
            <div class="form-group">
                <label for="sitename" class="col-md-2 control-label">
                    站点名称：
                </label>
                <div class="col-md-6">
                    <input type="text" name="sitename" id="sitename" class="form-control"
                    value="<?php echo $this->config['sitename']?>">
                </div>
                <span class="col-md-4">
                    网站title
                </span>
            </div>
            <div class="form-group">
                <label for="siteinfo" class="col-md-2 control-label">
                    站点简介：
                </label>
                <div class="col-md-6">
                    <input type="text" name="siteinfo" id="siteinfo" class="form-control"
                    value="<?php echo $this->config['siteinfo']?>">
                </div>
                <span class="col-md-4">
                    显示在网站title后面
                </span>
            </div>
          <div class="form-group">
            <label for="bodyimage" class="col-md-2 control-label">
                背景图：
            </label>
            <div class="col-md-6">
             <input type="text" name="bodyimage" id="upload2" value="<?php echo $this->config['bodyimage']?>" >
              <img src="<?php if (strpos($this->config['bodyimage'], "//") != false) { echo $this->config['bodyimage']; }else{
				echo  "../../../".$this->config['bodyimage'];
			  }?>" style="height:50px;width:auto;" class="img-rounded">
            </div>            
                <span class="col-md-4">
                    点击输入框修改
                </span>
        </div>
          
            <div class="form-group">
                <label for="siteurl" class="col-md-2 control-label">
                    站点网址：
                </label>
                <div class="col-md-6">
                    <input type="text" name="siteurl" id="siteurl" class="form-control" value="<?php echo $this->config['siteurl']?>">
                </div>
            </div>

            <div class="form-group">
                <label for="keyword" class="col-md-2 control-label">
                    网站关键字：
                </label>
                <div class="col-md-6">
                    <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo $this->config['keyword']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-md-2 control-label">
                    网站介绍：
                </label>
                <div class="col-md-6">
                    <textarea name="description" id="description" class="form-control" rows="5"><?php echo $this->config['description']?></textarea>
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="ctime" class="col-md-2 control-label">
                    建站时间：
                </label>
                <div class="col-md-6">
                    <input type="date" name="ctime" id="ctime" class="form-control" value="<?php echo $this->config['ctime']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-2 control-label">
                    客服邮箱：
                </label>
                <div class="col-md-6">
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo $this->config['email']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="tel" class="col-md-2 control-label">
                    客服电话：
                </label>
                <div class="col-md-6">
                    <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $this->config['tel']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="qq" class="col-md-2 control-label">
                    客服QQ：
                </label>
                <div class="col-md-6">
                    <input type="text" name="qq" id="qq" class="form-control" value="<?php echo $this->config['qq']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-2 control-label">
                    公司地址：
                </label>
                <div class="col-md-6">
                    <input type="text" name="address" id="address" class="form-control" value="<?php echo $this->config['address']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="icpcode" class="col-md-2 control-label">
                    ICP备案号：
                </label>
                <div class="col-md-6">
                    <input type="text" name="icpcode" id="icpcode" class="form-control" value="<?php echo $this->config['icpcode']?>">
                </div>
                <span class="col-md-4">
                </span>
            </div>
			
            <div class="form-group">
                <label for="copyright" class="col-md-2 control-label">
                    底部版权：
                </label>
                <div class="col-md-6">
                    <textarea name="copyright" id="copyright" class="form-control" rows="5">
                        <?php echo $this->config['copyright']?>
                    </textarea>
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                    统计代码：
                </label>
                <div class="col-md-6">
                    <textarea name="stacode" id="stacode" class="form-control" rows="5">
                        <?php echo $this->config['stacode']?>
                    </textarea>
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
                <label for="xieyi" class="col-md-2 control-label">
                    注册协议：
                </label>
                <div class="col-md-6">
                    <textarea name="xieyi" id="stacode" class="form-control" rows="5">
                        <?php echo $this->config['xieyi']?>
                    </textarea>
                </div>
                <span class="col-md-4">
                </span>
            </div>
            <div class="form-group">
               <label for="indexmode" class="col-md-2 control-label">
                    首页模式：
              </label><div class="col-md-4">
                    <select name="indexmode" class="form-control">
                       <option value="0" <?php echo $this->config['indexmode']=='0' ? ' selected' : ''?>>分类模式
                      </option>
                        <option value="1" <?php echo $this->config['indexmode']=='1' ? ' selected' : ''?>>列表模式
                      </option>
                        <option value="2" <?php echo $this->config['indexmode']=='2' ? ' selected' : ''?>>格子模式
                      </option>
                      </option>
                        <option value="3" <?php echo $this->config['indexmode']=='3' ? ' selected' : ''?>>图片模式
                      </option>
              </select>
              </div>
      </div>
            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                </label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">
                        &nbsp;
                        <span class="glyphicon glyphicon-save">
                        </span>
                        &nbsp;保存设置&nbsp;
                    </button>
                </div>
                <span class="col-md-4">
                </span>
            </div>
        </form>
    </div>

    <div class="set set1 hide">
        <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>set/save"
        method="post" autocomplete="off">
            <div class="form-group">
                <label for="smtp_server" class="col-md-2 control-label">
                    邮件服务器：
                </label>
                <div class="col-md-4">
                    <input type="text" name="smtp_server" id="smtp_server" class="form-control"
                    value="<?php echo $this->config['smtp_server']?>">
                </div>
                <span class="col-md-6">
                    以smtp开头
                </span>
            </div>
            <div class="form-group">
                <label for="smtp_email" class="col-md-2 control-label">
                    邮箱账号：
                </label>
                <div class="col-md-4">
                    <input type="text" name="smtp_email" id="smtp_email" class="form-control"
                    value="<?php echo $this->config['smtp_email']?>">
                </div>
                <span class="col-md-6">
                </span>
            </div>
            <div class="form-group">
                <label for="smtp_pwd" class="col-md-2 control-label">
                    邮箱密码：
                </label>
                <div class="col-md-4">
                    <input type="password" name="smtp_pwd" id="smtp_pwd" class="form-control"
                    value="<?php echo $this->config['smtp_pwd']?>">
                </div>
                <span class="col-md-6">
                </span>
            </div>
            <div class="form-group">
                <label for="email_state" class="col-md-2 control-label">
                    邮件开关：
                </label>
                <div class="col-md-4">
                    <select name="email_state" class="form-control">
                        <option value="1" <?php echo $this->config['email_state']=='1' ? ' selected' : ''?>>已开启
                        </option>
                        <option value="0" <?php echo $this->config['email_state']=='0' ? ' selected' : ''?>>已关闭
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                </label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        &nbsp;
                        <span class="glyphicon glyphicon-save">
                        </span>
                        &nbsp;保存设置&nbsp;
                    </button>
                </div>
                <span class="col-md-6">
                </span>
            </div>
        </form>
    </div>

    <div class="set set2 hide">
        <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>set/save"
              method="post" autocomplete="off">

            <div class="form-group">
                <label for="tips" class="col-md-2 control-label">
                    公告内容：
                </label>
                <div class="col-md-4">
                    <textarea name="tips" style="width:100%;height:300px;visibility:hidden;">
                    <?php echo $this->config['tips']?>
                </textarea>
                </div>
                <span class="col-md-6">
                </span>
            </div>

            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                </label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        &nbsp;
                        <span class="glyphicon glyphicon-save">
                        </span>
                        &nbsp;保存设置&nbsp;
                    </button>
                </div>
                <span class="col-md-6">
                </span>
            </div>
        </form>
    </div>

    <div class="set set3 hide">
        <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>set/save"
              method="post" autocomplete="off">

            <div class="form-group">
                <label for="ismail_num" class="col-md-2 control-label">
                    告警阈值：
                </label>
                <div class="col-md-4">
                    <input type="text" name="ismail_num" id="ismail_num" class="form-control"
                           value="<?php echo $this->config['ismail_num']?>">
                </div>
                <span class="col-md-6">
                    库存低于多少告警
                </span>
            </div>

            <div class="form-group">
                <label for="serive_token" class="col-md-2 control-label">
                    Token：
                </label>
                <div class="col-md-4">
                    <input type="text" name="serive_token" id="ismail_num" class="form-control"
                           value="<?php echo $this->config['serive_token']?>">
                </div>
                <span class="col-md-6">
                    用于订单清理或库存告警定时任务通讯密钥
                </span>
            </div>

            <div class="form-group">
                <label for="ismail_kuc" class="col-md-2 control-label">
                    库存告警开关：
                </label>
                <div class="col-md-4">
                    <select name="ismail_kuc" class="form-control">
                        <option value="1" <?php echo $this->config['ismail_kuc']=='1' ? ' selected' : ''?>>已开启
                        </option>
                        <option value="0" <?php echo $this->config['ismail_kuc']=='0' ? ' selected' : ''?>>已关闭
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                </label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        &nbsp;
                        <span class="glyphicon glyphicon-save">
                        </span>
                        &nbsp;保存设置&nbsp;
                    </button>
                </div>
                <span class="col-md-6">
                </span>
            </div>
        </form>
    </div>

    <div class="set set4 hide">
        <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>set/save"
              method="post" autocomplete="off">

            <div class="form-group">
                <label for="mp3list" class="col-md-2 control-label">
                    音乐列表：
                </label>
                <div class="col-md-6">
				  <textarea name="mp3list" id="mp3list" class="form-control" rows="5">
                        <?php echo $this->config['mp3list']?>
                    </textarea>
                </div>
                <span class="col-md-4">
                    示例{title:"标题",artist:"作者",mp3:"http://xx.com/173.mp3",cover:"http://xx.com/2.jpg",},
					{title:"标题",artist:"作者",mp3:"http:/xx.com/song/2.mp3",cover:"http://xxx.com/3.jpg",},
                </span>
            </div>

            <div class="form-group">
                <label for="mp3_state" class="col-md-2 control-label">
                    音乐开关：
                </label>
                <div class="col-md-4">
                    <select name="mp3_state" class="form-control">
                        <option value="1" <?php echo $this->config['mp3_state']=='1' ? ' selected' : ''?>>已开启
                        </option>
                        <option value="0" <?php echo $this->config['mp3_state']=='0' ? ' selected' : ''?>>已关闭
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="stacode" class="col-md-2 control-label">
                </label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        &nbsp;
                        <span class="glyphicon glyphicon-save">
                        </span>
                        &nbsp;保存设置&nbsp;
                    </button>
                </div>
                <span class="col-md-6">
                </span>
            </div>
        </form>
    </div>
	

    <?php require_once 'footer.php' ?>