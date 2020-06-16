<?php require_once 'header.php' ?>
    <h3>
        <span class="current">
            友情链接列表
        </span>
        &nbsp;/&nbsp;
        <span>
            添加友情链接
        </span>
    </h3>
    <br>
    <div class="set set0  table-responsive">
      <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-inline" action="" method="get">
                <div class="form-group"><select name="is_state" class="form-control">
                        <option value="-1" selected>
                            全部状态
                        </option>
                        <option value="1">启用
                        </option>
                        <option value="0">禁用
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="filter" placeholder="标题或者链接"
                           value="">
                </div>
                <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-search">

                                </span>
                    &nbsp;立即查询
                </button>
            </form>

        </div>
        <div class="panel-body">
            <button onclick="checkOrder('/admin/link/checkLink',9)" type="button"
                    class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash">
                    </span>
                &nbsp;删除
            </button>
            <button onclick="checkOrder('/admin/link/checkLink',0)" type="button"
                    class="btn btn-info">
                    <span class="glyphicon glyphicon-pencil">
                    </span>
                &nbsp;禁用
            </button>
            <button onclick="checkOrder('/admin/link/checkLink',1)" type="button"
                    class="btn btn-success">
                    <span class="glyphicon glyphicon-ok">
                    </span>
                &nbsp;启用
            </button>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr class="info">
            <th>
                <input type="checkbox" id="checkAll" class="checkbox">
            </th>
            <th>
                id
            </th>
            <th>
                链接名字
            </th>
            <th>
                链接地址
            </th>
            <th>
                状态
            </th>
            <th>
                操作
            </th>
        </tr>
        </thead>
        <tbody>

                <?php if ($lists): ?>
                <?php foreach ($lists as $key => $val): ?>
            		<tr data-id="<?php echo $val['id']?>">
                    <td class="text-center">
                        <input type="checkbox" name="checkname" value="<?php echo $val['id']?>" class="checkbox">
                    </td>
                    <td> <?php echo $val['id']?> </td>
                    <td><?php echo $val['title']?></td>
                    <td> <?php echo $val['url']?></td>
                    <td>
                      <?php echo $val['is_state']=='1' ?
                                '<span class="label label-success">启用</span>' :
                                '<span class="label label-danger">禁用</span>' ?>
                       </td>

                    <td>
                        <a href="<?php echo $this->dir?>/link/edit/<?php echo $val['id']?>" data-toggle="tooltip"
                           title="编辑">
                                    <span class="glyphicon glyphicon-edit">
                                    </span>
                        </a>
                        &nbsp;
						   <a href="javascript:;" onclick="del(<?php echo $val['id']?>,'<?php echo $this->dir?>link/del')"
                                data-toggle="tooltip" title="删除">
                                    <span class="glyphicon glyphicon-trash">
                                    </span>
                                </a>
                    </td>
                </tr>
          
                        <?php endforeach;?>
                            <?php else:?>
                                <tr>
                                    <td colspan="4">
                                        no data.
                                    </td>
                                </tr>
                                <?php endif;?>
            </tbody>
        </table>
    </div>
<div class="set set1 hide">
    <form class="form-ajax form-horizontal" action="<?php echo $this->dir?>/link/save"
          method="post" autocomplete="off">
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                链接名字：
            </label>
            <div class="col-md-3">
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label for="url" class="col-md-2 control-label">
                链接地址：
            </label>
            <div class="col-md-3">
                <input type="text" name="url" id="url" class="form-control" required value="">
            </div>
        </div>

        <div class="form-group">
            <label for="is_state" class="col-md-2 control-label">
                是否启用：
            </label>
            <div class="col-md-3">
                <select name="is_state" class="form-control">
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
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


    <script>
        $(function() {
            $('.selectAll').click(function() {
                $('.panel-body [type="checkbox"]').prop('checked', true);
            });
            $('.cancelAll').click(function() {
                $('.panel-body [type="checkbox"]').prop('checked', false);
            });
            $('.unSelectAll').click(function() {
                $('.panel-body [type="checkbox"]').each(function() {
                    if ($(this).prop('checked')) {
                        $(this).prop('checked', false);
                    } else {
                        $(this).prop('checked', true);
                    }
                });
            });
        });
    </script>
    <?php require_once 'footer.php' ?>