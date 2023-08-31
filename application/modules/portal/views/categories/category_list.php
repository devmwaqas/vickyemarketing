<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Categories </title>
    <?php $this->load->view('common/admin_header'); ?>

</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('common/admin_nav'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php $this->load->view('common/admin_top_nav'); ?>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Categories</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>Categories">Categories</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Categories List</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary mt-4" data-toggle="modal" data-target="#add_category_modal" data-placement="top" title="Add Category"> <i class="fa fa-plus" aria-hidden="true"></i> Add Category </button>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Categories</h5>
                            </div>
                            <div class="ibox-content">

                                <form id="update_category_order_form">
                                    <div class="table-responsive">
                                        <table id="category_list_tbl" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sr #</th>
                                                    <th>Category Name</th>
                                                    <th>Parent Category</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($category as $ctgry) { ?>
                                                    <tr class="gradeX" id="tr<?php echo $ctgry['id'];?>">
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $ctgry['cat_name']; ?></td>
                                                        <td>

                                                            <?php if(!empty($ctgry['parent_id'])) { ?>
                                                                <?php echo get_single_value('categories', $ctgry['parent_id'], 'name'); ?>
                                                            <?php } ?>

                                                        </td>
                                                        <td>
                                                            <?php if ($ctgry['status'] == 1) { ?>
                                                                <span class="label label-primary">Active</span>
                                                            <?php } else { ?>
                                                                <span class="label label-danger">Inactive</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-id="<?php echo $ctgry['id']; ?>" id="btn_edit_category" data-placement="top" title="Edit"> Edit </button>
                                                            <button class="btn btn-danger btn-sm" data-id="<?php echo $ctgry['id'];?>" type="button" id="btn_delete" data-placement="top" title="Delete"> Delete </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal show fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content animated flipInY">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">Add Category</h5>
                        </div>
                        <div class="modal-body">
                            <form id="add_form" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Parent Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control input-sm" name="parent_id">
                                            <option value="0">Select Category</option>
                                            <?php foreach (get_categories() as $cat) { ?>
                                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['cat_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Title </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="category_name" class="form-control input-sm" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3"> Is Active </label>
                                    <div class="col-sm-9">
                                        <div class="i-checks">
                                            <label> <input type="checkbox" name="status" checked> <i></i> Yes </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submit_button"> Submit </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal inmodal show fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content animated flipInY" id="edit_category_modal_body">

                    </div>
                </div>
            </div>

            <?php $this->load->view('common/admin_footer'); ?>
        </div>
    </div>
    <?php $this->load->view('common/admin_scripts'); ?>

    <script>
        $('#category_list_tbl').dataTable({
            "paging": true,
            "searching": true,
            "bInfo":true,
            "responsive": true,
            "lengthMenu": [ [50, 100, -1], [50, 100, "All"] ],
            "columnDefs": [
                { "responsivePriority": 1, "targets": 0 },
                { "responsivePriority": 2, "targets": -1 },
                { "responsivePriority": 3, "targets": -2 },
                ]
        });

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        $(document).on("click" , "#submit_button" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');

            var formData =  new FormData($("#add_form")[0]);
            $.ajax({
                url:'<?php echo admin_url(); ?>categories/add_category',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,

                success:function(status){
                    if(status.msg=='success') {
                        toastr.success(status.response,"Success");
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else if(status.msg == 'error') {
                        btn.ladda('stop');
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });

        $(document).on("click" , "#btn_edit_category" , function()
        {
            var id = $(this).attr('data-id');
            $.ajax({
                url:'<?php echo admin_url(); ?>categories/edit',
                type: 'POST',
                dataType:'json',
                data: {id: id},
                success:function(status){
                    $("#edit_category_modal_body").html(status.response);
                    $("#edit_category_modal").modal('show');
                }
            });
        });

        $(document).on("click" , "#update_button" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');

            var formData =  new FormData($("#edit_form")[0]);
            $.ajax({
                url:'<?php echo admin_url(); ?>categories/update_category',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(status){
                    if(status.msg=='success') {
                        toastr.success(status.response,"Success");
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else if(status.msg == 'error') {
                        btn.ladda('stop');
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });

        $(document).on("click" , "#btn_delete" , function(){
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You want to delete this category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, please!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $(".confirm").prop("disabled", true);
                    $.ajax({
                        url:'<?php echo admin_url(); ?>categories/delete_category',
                        type:'post',
                        data:{id: id},
                        dataType:'json',
                        success:function(status){
                            $(".confirm").prop("disabled", false);
                            if(status.msg == 'success'){
                                swal({title: "Success!", text: status.response, type: "success"},
                                    function(data){
                                        $("#tr"+id).remove();
                                    });
                            } else if(status.msg=='error'){
                                swal("Error", status.response, "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        });
    </script>
</body>
</html>