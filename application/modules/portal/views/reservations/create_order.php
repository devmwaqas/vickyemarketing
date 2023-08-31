<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Create Order </title>
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
                            <strong>Create Order</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>orders"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Orders </a>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Create Order</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="post" id="add_order_form" enctype="multipart/form-data">

                                    <input type="hidden" name="id" value="<?php echo $reservation_details['id']; ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $reservation_details['product_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $reservation_details['user_id']; ?>">

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Order Number</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_number" id="order_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Customer Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" name="cust_email_id" id="cust_email_id" class="form-control">
                                        </div>
                                        <label class="col-sm-1 col-form-label">AMZ Review Link</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="amz_review_link" id="amz_review_link" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Order Picture</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="order_pic" id="order_pic" class="form-control">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-1">
                                            <button class="btn btn-white" id="cancel_btn" data-url="<?php echo admin_url(); ?>orders">Cancel</button>
                                            <button type="button" class="ladda-button btn btn-primary" id="add_order_btn" data-style="expand-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
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

        $("#order_number").inputmask("999-9999999-9999999");

        $(document).on("click" , "#add_order_btn" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');
            var formData =  new FormData( $("#add_order_form")[0] );
            $.ajax({
                url:'<?php echo admin_url(); ?>reservations/submit_order',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(status){
                    btn.ladda('stop');
                    if(status.msg=='success') {
                        $('#add_order_form')[0].reset();
                        toastr.success(status.response,"Success");
                        setTimeout(function(){ location.reload(); }, 2000);
                        window.location.href = '<?php echo admin_url() ?>orders';
                    } else if(status.msg == 'error') {
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });
    </script>
</body>
</html>