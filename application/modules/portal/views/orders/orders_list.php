<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Orders </title>
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
                    <h2>Orders</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>orders">Orders</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Orders List</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Orders</h5>
                            </div>
                            <div class="ibox-content">

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div id="my_table_filter" class="dataTables_filter">
                                            <form action="<?php echo admin_url(); ?>orders/search" method="get">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="cust_email_id" name="cust_email_id" placeholder="Search by customer email..." aria-label="Search by customer email..." value="<?php echo @$_GET['cust_email_id']; ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div id="my_table_filter" class="dataTables_filter">
                                            <form action="<?php echo admin_url(); ?>orders/search" method="get">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="product_id" name="product_id" placeholder="Search by product ID..." aria-label="Search by product ID..." value="<?php echo @$_GET['product_id']; ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div id="my_table_filter" class="dataTables_filter">
                                            <form action="<?php echo admin_url(); ?>orders/search" method="get">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="order_number" name="order_number" placeholder="Search by order #" aria-label="Search by order #" value="<?php echo @$_GET['order_number']; ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="product_list_tbl" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Order Number</th>
                                                <th>Product</th>
                                                <th>Customer Email</th>
                                                <th>Market</th>
                                                <th>Type</th>
                                                <th>Report</th>
                                                <th>Create Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($orders as $order) { ?>
                                                <tr class="gradeX" id="tr<?php echo $i; ?>">
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $order['first_name']." ".$order['last_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $order['order_number']; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo admin_url(); ?>products/detail/<?php echo $order['product_id']; ?>" target="_blank">
                                                            <?php if(!empty($order['picture'])) { ?>
                                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order['picture']; ?>" alt="Image" style="width: 50px;" />
                                                            <?php } elseif(!empty($order['amz_picture'])) { ?>
                                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order['amz_picture']; ?>" alt="Image" style="width: 50px;" />
                                                            <?php } ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $order['customer_email']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $order['market_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $order['product_type']; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($order['order_status'] !== 2) { ?>
                                                            <button type="button" data-id="<?php echo $order['order_id']; ?>" class="btn btn-primary report_order">
                                                                Report
                                                            </button>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('Y-m-d H:i:s', strtotime($order['created_at'])); ?>
                                                    </td>
                                                    <td>

                                                        <?php

                                                        if($order['order_status'] == 0) {
                                                            echo "Ordered";
                                                        } elseif($order['order_status'] == 1) {
                                                            echo "Reviewed";
                                                        } elseif($order['order_status'] == 2) {
                                                            echo "On Hold";
                                                        } elseif($order['order_status'] == 3) {
                                                            echo "Canceled";
                                                        } elseif($order['order_status'] == 4) {
                                                            echo "Refunded";
                                                        } elseif($order['order_status'] == 5) {
                                                            echo "Completed";
                                                        } elseif($order['order_status'] == 6) {
                                                            echo "Review Deleted";
                                                        } elseif($order['order_status'] == 7) {
                                                            echo "Commission";
                                                        } elseif($order['order_status'] == 8) {
                                                            echo "Delivered";
                                                        }

                                                        ?>
                                                    </td>

                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>orders/detail/<?php echo $order['order_id']; ?>">
                                                            View
                                                        </a>
                                                    </td>

                                                </tr>
                                                <?php $i++; } ?>
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

            <div class="modal inmodal" id="reportModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Select An Issue</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="report_form">
                                <input type="hidden" id="report_form_order_id" name="order_id">
                                <div class="modal-body">
                                    <select name="issue_type" class="form-control">
                                        <?php foreach (get_issue_types() as $issue_type) { ?>
                                            <option value="<?php echo $issue_type['id']; ?>"> <?php echo $issue_type['name']; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" id="submit_report" class="btn btn-primary">Report</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('common/admin_scripts'); ?>
        <script>
            $('#product_list_tbl').dataTable({
                "paging": true,
                "searching": false,
                "bInfo": true,
                "responsive": false,
                "lengthChange": false,
                "lengthMenu": [
                    [50, 100, -1],
                    [50, 100, "All"]
                    ],
                "columnDefs": [{
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

            $(document).on("click", ".report_order", function() {
                var id = $(this).attr('data-id');
                $('#report_form_order_id').val(id);
                $("#reportModal").modal('show');
            });

            $(document).on("click" , "#submit_report" , function() {
                var btn = $(this).ladda();
                btn.ladda('start');
                var formData = $("#report_form").serialize();
                $.ajax({
                    url:'<?php echo admin_url(); ?>orders/submit_report',
                    type: 'POST',
                    data: formData,
                    dataType:'json',
                    cache: false,
                    success:function(status){
                        btn.ladda('stop');
                        if(status.msg=='success') {
                            $('#report_form')[0].reset();
                            toastr.success(status.response,"Success");
                            window.location.href = '<?php echo admin_url() ?>support';
                        } else if(status.msg == 'error') {
                            toastr.error(status.response,"Error");
                        }
                    }
                });
            });

        </script>
    </body>
    </html>