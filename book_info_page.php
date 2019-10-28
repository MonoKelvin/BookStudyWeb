<?php
require_once('api/book_api.php');
isLogedIn();

global $book;
if (isset($_GET['id'])) {
    $book = getBookInfoById($_GET['id']);
} else {
    isEntry404(true);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>图书<?php echo $book['id']; ?></title>
    <?php include_once('html/included_head.php'); ?>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap-datetimepicker.min.css">
</head>

<body onload="createUserLentItemsForBook(<?php echo $book['id']; ?>);">
    <div class="page">
        <?php include_once('html/header_navbar.php'); ?>
        <div class="page-content d-flex align-items-stretch">
            <?php include_once('html/side_navbar.php'); ?>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">用户管理</h2>
                    </div>
                </header>
                <!-- Breadcrumb-->
                <div class="breadcrumb-holder container-fluid">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">主页</a></li>
                        <li class="breadcrumb-item"><a href="book_manager.php">图书管理</a></li>
                        <li class="breadcrumb-item active">图书<?php echo $book['id']; ?></li>
                    </ul>
                </div>

                <section class="forms">
                    <form id="book-form" action="api/book_update.php" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="container-fluid d-flex flex-row">
                            <div class="card col-lg-12 no-padding">
                                <div class="card-header">
                                    <h3>基本信息</h3>
                                </div>
                                <div class="card-body d-flex align-items-center row">
                                    <div class="col-lg-4 d-flex justify-content-center pb-3 flex-column">
                                        <img id="book-image" src=<?php echo "{$book['image']}"; ?> alt="void" class="img-fluid">
                                        <input id="tmp-file-input" name="image" onchange="changeBookImage(this)" type="file" class="hidden-form-control">
                                        <button type="button" class="btn btn-primary mt-3" onclick="$('#tmp-file-input').click();">更换封面</button>
                                        <small class="help-block-none mt-2">请选择不大于1M的png、jpg或jpeg格式的图片文件</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="container-fluid">
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">ID</label>
                                                <div class="col-lg-9">
                                                    <input name="id" type="text" readonly value=<?php echo "'{$book['id']}'"; ?> class="form-control">
                                                    <small class="help-block-none">书籍的ID编号不可更改.</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">ISBN13</label>
                                                <div class="col-lg-9">
                                                    <input name="isbn13" type="text" value=<?php echo "'{$book['isbn13']}'"; ?> class="form-control" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                    <small class="help-block-none">书籍的ISBN13分类号尽量不要更改！</small>
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">书名</label>
                                                <div class="col-lg-9">
                                                    <input name="title" type="text" class="form-control" value=<?php echo "'{$book['title']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">副标题</label>
                                                <div class="col-lg-9">
                                                    <input name="subtitle" type="text" class="form-control" value=<?php echo "'{$book['subtitle']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 form-control-label">原标题</label>
                                                <div class="col-lg-9">
                                                    <input name="origin_title" type="text" class="form-control" value=<?php echo "'{$book['origin_title']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="line"></div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">作者</label>
                                                <div class="col-sm-9">
                                                    <input name="author" type="text" class="form-control" value=<?php echo "'{$book['author']}'"; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>详细信息</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">摘要</label>
                                                <div class="col-sm-9">
                                                    <textarea name="summary" class="form-control" rows="6"><?php echo $book['summary']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">作者简介</label>
                                                <div class="col-sm-9">
                                                    <textarea name="author_intro" class="form-control" rows="6"><?php echo $book['author_intro']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">翻译</label>
                                                <div class="col-sm-9">
                                                    <input name="translator" type="text" class="form-control" value=<?php echo "'{$book['translator']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版社</label>
                                                <div class="col-sm-9">
                                                    <input name="publisher" type="text" class="form-control" value=<?php echo "'{$book['publisher']}'"; ?>>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">出版时间</label>
                                                <div class="col-sm-9">
                                                    <input name="pubdate" class="form-control" id="datetimepicker" type="text" value=<?php echo "'{$book['pubdate']}'"; ?>>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">页数</label>
                                                <div class="col-sm-9">
                                                    <input name="pages" type="text" class="form-control" value=<?php echo "'{$book['pages']}'"; ?> onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">评分</label>
                                                <div class="col-sm-9">
                                                    <input type="text" disabled="" placeholder=<?php echo "'{$book['rating']}'"; ?> class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">装帧形式</label>
                                                <div class="col-sm-9">
                                                    <select name="binding" class="form-control mb-3">
                                                        <option><?php echo $book['binding']; ?></option>
                                                        <option>平装</option>
                                                        <option>精装</option>
                                                        <option>线装</option>
                                                        <option>单行本</option>
                                                        <option>合订本</option>
                                                        <option>普及本</option>
                                                        <option>缩印本</option>
                                                        <option>袖珍本</option>
                                                        <option>特藏本</option>
                                                        <option>豪华本</option>
                                                        <option>简册装</option>
                                                        <option>卷轴装</option>
                                                        <option>经折装</option>
                                                        <option>旋风装</option>
                                                        <option>蝴蝶装</option>
                                                        <option>包背装</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">标签</label>
                                                <div class="col-sm-9">
                                                    <div id="add-tag-container" class="bootstrap-label">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend pb-2">
                                                                <button onclick="addTag();" type="button" class="btn btn-primary"> <i class="fa fa-plus"></i> </button>
                                                            </div>
                                                            <input id="input-add-tag" class="form-control">
                                                        </div>
                                                        <?php
                                                        $tags = explode(',', $book['tags']);
                                                        if ($book['tags']) {
                                                            foreach ($tags as $tag) {
                                                                echo "<span class='label label-info m-1'>$tag";
                                                                echo '<a onclick="deleteTag(this);" class="text-white pl-2" style="cursor:pointer">';
                                                                echo '<i class="fa fa-trash"></i></a></span>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="line"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 form-control-label">目录章节</label>
                                                <div class="col-sm-9">
                                                    <?php
                                                    $nl_count = substr_count($book['catalog'], "\n") * 26;
                                                    $nl_count = $nl_count < 200 ? 200 : ($nl_count > 1000 ? 1000 : $nl_count);
                                                    echo '<textarea name="catalog" style="height:' . $nl_count . 'px;" class="form-control" rows="6">';
                                                    echo $book['catalog'];
                                                    echo '</textarea>';
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="line pt-5"></div>

                                            <div class="form-group row justify-content-end">
                                                <div class="col-sm-2 pb-2">
                                                    <button type="button" data-toggle="modal" data-target="#alterAlert" class="form-control btn btn-primary">保存修改</button>
                                                    <div id="alterAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                                        <div role="document" class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 id="exampleModalLabel" class="modal-title">数据改动提示</h4>
                                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>你确定要保存当前数据的修改吗？</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">取消</button>
                                                                    <form action="book_update.php" method="post">
                                                                        <button id="btn-submit" type="submit" name="submit" value="submit" class="btn btn-primary">确定</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 pb-2">
                                                    <button type="button" onclick="window.location.reload();" class="form-control btn btn-secondary">取消修改</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>



                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">正借此书的用户</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">用户id</th>
                                            <th class="text-center">用户名</th>
                                            <th class="text-center">借书时间</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-lent-the-book-table">
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
    <script src="vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="js/charts-custom.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <!-- Ajax Request File -->
    <script src="js/ajax/user_lent_books.js"></script>
    <!-- DataTimePicker Plugin -->
    <script>
        var today = new Date();
        $('#datetimepicker').datetimepicker({
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            autoclose: true,
            endDate: today,
            startView: 3,
            minView: 2,
            todayBtn: true,
            todayHighlight: true,
        });

        // 防止input回车键自动提交表单
        document.onkeydown = function(event) {
            var target, code, tag;
            if (!event) {
                event = window.event; //针对ie浏览器
                target = event.srcElement;
                code = event.keyCode;
                if (code == 13) {
                    tag = target.tagName;
                    if (tag == "TEXTAREA") {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                target = event.target; //针对遵循w3c标准的浏览器，如Firefox
                code = event.keyCode;
                if (code == 13) {
                    tag = target.tagName;
                    if (tag == "INPUT") {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        };

        <?php
        if ($book['tags'] != '') {
            $tmp = explode(',', $book['tags']);
            foreach ($tmp as $key => $val) {
                $tmp[$key] = '"' . $val . '"';
            }
            $tmp = implode(',', $tmp);
            echo "var tags = [$tmp];";
        } else {
            echo "var tags = [];";
        }
        ?>

        Array.prototype.remove = function(val) {
            var index = this.indexOf(val);
            if (index > -1) {
                this.splice(index, 1);
            }
        };

        document.getElementById('btn-submit').addEventListener('click', () => {
            let bookForm = $('#book-form');
            let tmpTagsInput = $("<input type='text' name='tags' style='display:none'/>");
            tmpTagsInput.val(tags.join(','));
            bookForm.append(tmpTagsInput);
            bookForm.submit();
        });
    </script>

    <!-- Utility Js File -->
    <script src="js/utility.js"> </script>
</body>

</html>
