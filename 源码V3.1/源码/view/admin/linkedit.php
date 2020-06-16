<?php require_once 'header.php' ?>
    <h3>
        <span class="current">
            编辑账号信息
        </span>
    </h3>
    <br>
    <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>link/editsave/<?php echo $data['id']?>"
    method="post" autocomplete="off">      
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                链接名称：
            </label>
            <div class="col-md-3">
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $data['title'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="url" class="col-md-2 control-label">
                链接地址：
            </label>
            <div class="col-md-3">
                <input type="text" name="url" id="url" class="form-control" value="<?php echo $data['url'] ?>">
            </div>
        </div>
        

        <div class="form-group">
            <label for="is_state" class="col-md-2 control-label">
                是否启用：
            </label>
            <div class="col-md-3">
                <select name="is_state" class="form-control">
                    <option value="1"<?php echo $data[ 'is_state']=='1' ? ' selected' : '' ?>>启用</option>
                    <option value="0"<?php echo $data[ 'is_state']=='0' ? ' selected' : '' ?>>禁用</option>
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
        </div>
    </form>
    <?php require_once 'footer.php' ?>