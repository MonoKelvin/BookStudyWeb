<?php


?>
<tr>
    <th scope="row">1</th>
    <td>5</td>
    <td>Tony Stack</td>
    <td>15007083506</td>
    <td>pas******123</td>
    <td>
        <!-- <i class="fa fa-check" style="color: #54e69d !important;"></i> -->
        <i class="fa fa-close" style="color: #ff7676 !important;"></i>
    </td>
    <td class="row container-fluid">
        <div class="ml-2 col-xs-4">
            <button type="button" data-toggle="modal" data-target="#userDetailModel" class="btn btn-sm btn-primary">详情</button>
            <!-- TODO:该Model使用一个php页面 include 动态显示-->
            <div id="userDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">用户详情</h4>
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