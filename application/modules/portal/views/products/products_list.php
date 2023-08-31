<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Products </title>
    <?php $this->load->view('common/admin_header'); ?>

    <style type="text/css">

        .download_image {
/*            display: table;*/
vertical-align: middle;
text-align: center;
position: relative;
}

.download_btn {
    display: none;
}

.download_image:hover .download_btn {
    position: absolute;
    left: 0;
    top: 0;
    display: block;
    text-align: center;
    background: rgba(67,81,96,0.7);
}

.download_btn b {
    font-size: 12px;
    font-weight: normal;
    padding: 8px 12px;
    border-radius: 5px;
    background: #6bbe70;
    color: #fff;
    font-family: sans-serif;
}

.download_image:hover .download_btn b:hover {
    background: #000;
}

/*        .product_image {background: #e7e7e7; border: none; vertical-align: bottom;}*/

</style>
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
                    <h2>Products</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>Products">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Products List</strong>
                        </li>
                    </ol>
                </div>
                <?php if($this->session->userdata('admin_type') == 1) { ?>
                    <div class="col-lg-2">
                        <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>products/add"> <i class="fa fa-plus" aria-hidden="true"></i> Add Product </a>
                    </div>
                <?php } ?>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Products</h5>
                            </div>
                            <div class="ibox-content">

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div id="my_table_filter" class="dataTables_filter">

                                            <form action="<?php echo admin_url(); ?>products/search" method="get">
                                                <?php if(!empty($_GET['status'])) { ?>
                                                    <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                                                <?php } ?>

                                                <?php if(!empty($_GET['target'])) { ?>
                                                    <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
                                                <?php } ?>

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="product_code" name="product_code" placeholder="Search By Product Code" aria-label="Search By Product Code" value="<?php echo @$_GET['product_code']; ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div id="my_table_filter" class="dataTables_filter">
                                            <form action="<?php echo admin_url(); ?>products/search" method="get">
                                                <?php if(!empty($_GET['status'])) { ?>
                                                    <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                                                <?php } ?>

                                                <?php if(!empty($_GET['target'])) { ?>
                                                    <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
                                                <?php } ?>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="market" id="market">
                                                        <option value="">Select Market</option>
                                                        <?php foreach (get_markets() as $market) { ?>
                                                            <option value="<?php echo $market['id']; ?>" <?php if($market['id'] == @$_GET['market']) { ?> selected="" <?php } ?>>
                                                                <?php echo $market['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="product_type" id="product_type">
                                                        <option value="">Select Product Type</option>
                                                        <?php foreach (get_producttypes() as $producttype) { ?>
                                                            <option value="<?php echo $producttype['id']; ?>" <?php if($producttype['id'] == @$_GET['product_type']) { ?> selected="" <?php } ?>>
                                                                <?php echo $producttype['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search By Keyword" aria-label="Search By Keyword" value="<?php echo @$_GET['keyword']; ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <?php if($this->session->userdata('admin_type') == 2) { ?>

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div id="my_table_filter" class="dataTables_filter">
                                                <form action="<?php echo admin_url(); ?>products/search" method="get">

                                                    <?php if(!empty($_GET['status'])) { ?>
                                                        <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                                                    <?php } ?>

                                                    <?php if(!empty($_GET['target'])) { ?>
                                                        <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
                                                    <?php } ?>

                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="pmm" id="pmm">
                                                            <option value="">Select PMM</option>
                                                            <?php foreach (get_admins() as $user) { ?>
                                                                <option value="<?php echo $user['id']; ?>" <?php if($user['id'] == @$_GET['pmm']) { ?> selected="" <?php } ?> >
                                                                    <?php echo $user['first_name']." ".$user['last_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">Search</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>
                                <div class="table-responsive">
                                    <table id="product_list_tbl" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr #</th>
                                                <th>Market</th>
                                                <th>Product Type</th>
                                                <th>PM Commission</th>
                                                <th>Sale Limit</th>
                                                <th>Total Remaining</th>
                                                <th>Today Remaining</th>
                                                <th>Product ID</th>
                                                <th class="keyword_cls">Keyword</th>
                                                <th>Image</th>
                                                <?php if($this->session->userdata('admin_type') != 2) { ?>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                <?php } else { ?>
                                                    <th>Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($products as $product) {  ?>
                                                <?php $total_sold = total_sold($product['id']); ?>
                                                <?php $today_remaining = today_remaining($product['id']); ?>

                                                <?php if($total_sold == 0 && $product['status'] != 0) {
                                                    change_to_inactive($product['id']);
                                                    continue;
                                                } ?>

                                                <tr class="gradeX" id="tr<?php echo $product['id'];?>">
                                                    <td>
                                                        <?php echo $i++; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $product['market_name']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $product['product_type']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $product['pmm_commission']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $product['sale_limit']; ?>
                                                    </td>
                                                    <td id="totalsold<?php echo $product['id'];?>"> <?php echo $total_sold; ?> </td>
                                                    <td id="todayremaining<?php echo $product['id'];?>"> <?php echo $today_remaining; ?> </td>
                                                    <td>
                                                        <?php echo $product['id']; ?>
                                                    </td>

                                                    <td class="keyword_cls">
                                                        <a href="<?php echo admin_url(); ?>products/detail/<?php echo $product['id']; ?>">
                                                            <?php echo wordwrap($product['keyword'], 40,"<br>\n",TRUE); ?>
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <?php if(!empty($product['picture'])) { ?>
                                                            <a class="download_image" href="<?php echo base_url(); ?>assets/pictures/<?php echo $product['picture']; ?>" download>
                                                                <img class="product_image" src="<?php echo base_url(); ?>assets/pictures/<?php echo $product['picture']; ?>" alt="Image" style="width: 50px;" />
                                                                <span class="download_btn"><b>Download</b></span>
                                                            </a>
                                                        <?php } elseif(!empty($product['amz_picture'])) { ?>
                                                            <a class="download_image" href="<?php echo base_url(); ?>assets/pictures/<?php echo $product['amz_picture']; ?>" download>
                                                                <img class="product_image" src="<?php echo base_url(); ?>assets/pictures/<?php echo $product['amz_picture']; ?>" alt="Image" style="width: 50px;" />
                                                                <span class="download_btn"><b>Download</b></span>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <?php if($this->session->userdata('admin_type') != 2) { ?>
                                                        <td id="status<?php echo $product['id'];?>">
                                                            <?php if ($product['status'] == 1) { ?>
                                                                <span class="label label-primary">Active</span>
                                                            <?php } else { ?>
                                                                <span class="label label-danger">Inactive</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($product['status'] == 1) { ?>
                                                                <button class="btn btn-danger btn_change_status btn-sm" data-id="<?php echo $product['id'];?>" data-status="0" id="btn<?php echo $product['id'];?>" type="button"> Inactive </button>
                                                            <?php } else { ?>
                                                                <button class="btn btn-primary btn_change_status btn-sm" data-id="<?php echo $product['id'];?>" data-status="1" id="btn<?php echo $product['id'];?>" type="button"> Active </button>
                                                            <?php } ?>
                                                            <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>products/edit/<?php echo $product['id']; ?>">
                                                                Edit
                                                            </a>
                                                            <?php if($this->session->userdata('admin_type') == 0) { ?>
                                                                <button class="btn btn-danger btn-sm btn_delete" data-id="<?php echo $product['id'];?>" type="button" data-placement="top" title="Delete"> Delete </button>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td id="reserve<?php echo $product['id'];?>">
                                                            <?php $reserve = has_reservation($product['id']); ?>
                                                            <?php if(!empty($reserve)) { ?>
                                                                <button class="btn btn-secondary btn-sm" type="button" disabled> Reserved </button>
                                                                <a href="<?php echo admin_url(); ?>reservations/create_order/<?php echo $reserve['id']; ?>" class="btn btn-primary btn-sm" type="button" data-placement="top" title="View Reservation"> Create Order </a>
                                                            <?php } else { ?>
                                                                <?php if($today_remaining != 0) { ?>
                                                                    <button class="btn btn-info btn-sm btn_reserve_now" data-id="<?php echo $product['id'];?>" type="button" data-placement="top" title="Reserve Now"> Reserve Now </button>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('common/admin_footer'); ?>
        </div>
    </div>
    <?php $this->load->view('common/admin_scripts'); ?>
    <script>
        $('#product_list_tbl').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "bInfo": false,
            "responsive": false,
            "lengthMenu": [
                [50, 100, -1],
                [50, 100, "All"]
                ],
            "columnDefs": [
            {
                "responsivePriority": 1,
                "targets": 0
            },
            {
                "responsivePriority": 2,
                "targets": -1
            },
            {
                "responsivePriority": 3,
                "targets": -2
            },
            ]
        });

        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        $(document).on("click", ".btn_delete", function() {
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You want to delete this product!",
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
                        url: '<?php echo admin_url(); ?>products/delete_product',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(status) {
                            $(".confirm").prop("disabled", false);
                            if (status.msg == 'success') {
                                swal({
                                    title: "Success!",
                                    text: status.response,
                                    type: "success"
                                },
                                function(data) {
                                    $("#tr" + id).remove();
                                });
                            } else if (status.msg == 'error') {
                                toastr.error(status.response,"Error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        });
        $(document).on("click", ".btn_change_status", function() {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            swal({
                title: "Are you sure?",
                text: "You want to change the status of this product!",
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
                        url: '<?php echo admin_url(); ?>products/change_status',
                        type: 'post',
                        data: {
                            product_id: id,
                            status: status
                        },
                        dataType: 'json',
                        success: function(status) {
                            $(".confirm").prop("disabled", false);
                            if (status.msg == 'success') {
                                swal({
                                    title: "Success!",
                                    text: status.response,
                                    type: "success"
                                },
                                function(data) {
                                    location.reload();
                                });
                            } else if (status.msg == 'error') {
                                toastr.error(status.response,"Error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
        });
        $(document).on("click", ".btn_reserve_now", function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '<?php echo admin_url(); ?>reservations/reserve_now',
                type: 'post',
                data: {
                    product_id: id,
                },
                dataType: 'json',
                success: function(status) {
                    if (status.msg == 'success') {
                        toastr.success(status.response,"Success");
                        $("#salelimit"+id).text(status.salelimit);
                        $("#todayremaining"+id).text(status.todayremaining);
                        $("#reserve"+id).html('<button class="btn btn-secondary btn-sm" type="button" disabled> Reserved </button>&nbsp;<a href="'+admin_url+'reservations/create_order/'+status.reserve_id+'" class="btn btn-primary btn-sm" type="button" data-placement="top" title="View Reservation"> Create Order </a>');
                    } else if (status.msg == 'error') {
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });
    </script>
</body>
</html>