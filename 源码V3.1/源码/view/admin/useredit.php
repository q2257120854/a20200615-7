<?php require_once 'header.php' ?>
    <h3>
        <span class="current">
            编辑账号信息
        </span>
    </h3>
    <br>
    <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>user/editsave/<?php echo $data['id']?>"
    method="post" autocomplete="off">      
        <div class="form-group">
            <label for="uname" class="col-md-2 control-label">
                用户名：
            </label>
            <div class="col-md-3">
                <input type="text" name="uname" id="uname" class="form-control" value="<?php echo $data['uname'] ?>" disabled required>
            </div>
        </div>
        <div class="form-group">
            <label for="upasswd" class="col-md-2 control-label">
                登录密码：
            </label>
            <div class="col-md-3">
                <input type="password" name="upasswd" id="upasswd" class="form-control"  value="">
            </div>
        </div>
        <div class="form-group">
            <label for="cirpwd" class="col-md-2 control-label">
                确认登录密码：
            </label>
            <div class="col-md-3">
                <input type="password" name="cirpwd" id="cirpwd" class="form-control"
                maxlength="20">
            </div>
        </div>
        <div class="form-group">
            <label for="lid" class="col-md-2 control-label">
                用户等级：
            </label>
            <div class="col-md-3">
                <select name="lid" class="form-control">
                  <?php foreach ($ulevel as $key => $val): ?>
                  <option value="<?php echo $val['id'] ?>"<?php echo $val['id'] == $data['lid'] ? ' selected' : '' ?>><?php echo $val['title'] ?>
                  </option>
                  <?php endforeach; ?>
              </select>
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
            <label for="email" class="col-md-2 control-label">
                邮箱：
            </label>
            <div class="col-md-3">
                <input type="email" name="email" id="email" class="form-control" required value="<?php echo $data[ 'email']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="ckmail" class="col-md-2 control-label">
                邮箱是否启用：
            </label>
            <div class="col-md-3">
                <select name="ckmail" class="form-control">
                    <option value="1"<?php echo $data[ 'ckmail']=='1' ? ' selected' : '' ?>>启用</option>
                    <option value="0"<?php echo $data[ 'ckmail']=='0' ? ' selected' : '' ?>>禁用</option>
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