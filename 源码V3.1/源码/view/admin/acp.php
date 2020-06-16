<?php require_once 'header.php' ?>
    <h3>
        <span class="current">
            接入商信息
        </span>
    </h3>
    <br>
    <div class="set set0">
        <?php if($lists):?>
            <?php foreach($lists as $key=>$val):?>
                <div class="panel panel-info" data-id="<?php echo $val['id']?>">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-th-list">
                        </span>
                        &nbsp;
                        <?php echo $val['name']?>
                    </div>
                    <div class="panel-body">
                        <form class="form-ajax form-inline" action="<?php echo $this->dir?>acp/editsave/<?php echo $val['id']?>"
                        method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        账号
                                    </span>
                                    <input type="text" name="email" class="form-control" placeholder="账号"
                                    value="<?php echo $val['email']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        编号
                                    </span>
                                    <input type="text" name="userid" class="form-control" placeholder="ID"
                                    value="<?php echo $val['userid']?>" size="15">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        密钥
                                    </span>
                                    <input type="text" name="userkey" class="form-control" placeholder="密钥"
                                    value="<?php echo $val['userkey']?>">
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        状态
                                    </span>
                                    <select name="is_ste" class="form-control">
                                        <option value="1"<?php echo $val['is_ste'] == '1' ? ' selected' : '' ?>>
                                            启用
                                        </option>
                                        <option value="0"<?php echo $val['is_ste'] == '0' ? ' selected' : '' ?>>停用
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="input-group">
                                <button type="submit" class="btn btn-success">
                                    &nbsp;
                                    <span class="glyphicon glyphicon-save">
                                    </span>
                                    &nbsp;保存设置&nbsp;
                                </button>
                                &nbsp;
                                <a href="javascript:;" onclick="del(<?php echo $val['id']?>,'<?php echo $this->dir?>acp/del')"
                                data-toggle="tooltip" data-placement="top" title="删除">
                                    <span class="glyphicon glyphicon-trash">
                                    </span>
                                </a>
								<?php if($val['code']=="mazf"){									
									echo '<a target="_blank" href="https://codepay.fateqq.com/i/138123" data-toggle="tooltip" title="" data-original-title="'.$val['name'].'开通" se_prerender_url="complete">
                                    <span class="glyphicon glyphicon-link">申请地址
                                    </span>
                            </a>';
								}?>
				
									<?php if($val['code']=="zfbf2f"){									
									echo '<br/><code>建议开通当面付，不抽查网站内容，金额自动无需用户手工输入，杜绝丢单，减少网站投诉。
                                    </code>';
								}?>				
                            </div>
                        </form>

                    </div>
                </div>

                <?php endforeach;?>
                    <?php endif?>
    </div>
    <script>
        $(function() {
            $('.panel').mouseover(function() {
                $(this).removeClass('panel-info').addClass('panel-primary');
            }).mouseleave(function() {
                $(this).removeClass('panel-primary').addClass('panel-info');
            });
        });
    </script>
    
    <?php require_once 'footer.php' ?>	