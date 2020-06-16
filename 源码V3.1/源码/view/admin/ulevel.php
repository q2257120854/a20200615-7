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

                <div class="panel-body">
                    <form class="form-ajax form-inline" action="<?php echo $this->dir?>ulevel/editsave/<?php echo $val['id']?>"
                          method="post">
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        名称
                                    </span>
                                <input type="text" name="title" class="form-control" placeholder="<?php echo $val['title']?>"
                                       value="<?php echo $val['title']?>">
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-success">
                                &nbsp;
                                <span class="glyphicon glyphicon-save">
                                    </span>
                                &nbsp;保存设置&nbsp;
                            </button>

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