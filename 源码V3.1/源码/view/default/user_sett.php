<?php require_once 'header.php' ?>

<style type="text/css">


</style>

<div class="tpl-page-container tpl-page-header-fixed">


<?php require_once 'left.php' ?>

<div class="tpl-content-wrapper">
       
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 个人设置
                </div>
            </div>
            <div class="tpl-block ">

                <div class="am-g tpl-amazeui-form">

     									<?php if($lists):?>
                                                 
                    <div class="am-u-sm-12 am-u-md-9">
                        <form class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
                                <div class="am-u-sm-9">
                                    <input type="text" id="user-name" value="<?php echo $lists['uname']?>" disabled >
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">当前等级</label>
                                <div class="am-u-sm-9">
                                    <input type="text" id="user-name" value="<?php echo $gtitle; ?>" disabled >
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-email" class="am-u-sm-3 am-form-label">累计消费</label>
                                <div class="am-u-sm-9">
                                    <input type="email" id="user-email" value="<?php echo $lists['allmoney']?>" disabled>
                                    <small>累计到一定数额可以升级等级</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">邮箱</label>
                                <div class="am-u-sm-9">
                                    <input type="tel" id="user-phone" value="<?php echo $lists['email']?>" disabled>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">上次登录时间</label>
                                <div class="am-u-sm-9">
                                    <input type="tel" id="user-phone" value="<?php echo date("Y-m-d H:i:s", $lists['ctime']);?>" disabled>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">上次登录ip</label>
                                <div class="am-u-sm-9">
                                    <input type="tel" id="user-phone" value="<?php echo $lists['last_ip']?>" disabled>
                                </div>
                            </div>

                          <?php endif;?>
                  
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>


</div>

<?php require_once 'footer.php' ?>