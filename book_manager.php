<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书管理</title>
    <?php include_once('html/included_head.php'); ?>
</head>

<body>
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">图书管理</h2>
                    </div>
                </header>
                <!-- Breadcrumb-->
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item active">图书管理</li>
                    </ul>
                </div>

                <section class="dashboard-header">
                    <div class="container-fluid">
                        <!-- TODO:图书分类的数据使用php页面动态生成 -->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类1</strong><br><small>10本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类2</strong><br><small>12本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-blue"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类3</strong><br><small>12本</small></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="statistic d-flex align-items-center bg-white has-shadow">
                                    <div class="icon bg-orange"><i class="fa fa-tasks"></i></div>
                                    <div class="text"><strong>分类4</strong><br><small>12本</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-close">
                            <div class="dropdown">
                                <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                            </div>
                        </div>
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">所有图书</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>排序</th>
                                            <th>id</th>
                                            <th>ISBN</th>
                                            <th>书名</th>
                                            <th>馆藏数量</th>
                                            <th>已借出</th>
                                            <th>其他操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- TODO: 使用php生成图书信息 -->
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>1077942</td>
                                            <td>9787507208740</td>
                                            <td>李白诗歌全集</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td class="row container-fluid">
                                                <div class="ml-2 col-xs-4">
                                                    <button type="button" data-toggle="modal" data-target="#bookDetailModel" class="btn btn-sm btn-primary">详情</button>
                                                    <!-- TODO:该Model使用一个php页面 include 动态显示-->
                                                    <div id="bookDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                                        <div role="document" class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 id="exampleModalLabel" class="modal-title">Signin Modal</h4>
                                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Lorem ipsum dolor sit amet consectetur.</p>
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="email" placeholder="Email Address" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-2 col-xs-4">
                                                    <button type="button" class="btn btn-sm btn-primary">修改</button>
                                                    <!-- TODO:添加修改Model -->
                                                </div>
                                                <div class="ml-2 col-xs-4">
                                                    <button type="button" class="btn btn-sm btn-danger">删除</button>
                                                    <!-- TODO:添加删除警告对话框 -->
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>
