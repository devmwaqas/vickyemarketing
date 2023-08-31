<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Reserve An Order </title>
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
                    <h2>Reservations</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>reservations">Reservations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Reserve An Order</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>reservations"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Reservations </a>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Reserve An Order</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="post" id="add_reservation_form">

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Product ID</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="product_id" id="product_id" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-1">
                                            <button class="btn btn-white" id="cancel_btn" data-url="<?php echo admin_url(); ?>reservations">Cancel</button>
                                            <button type="button" class="ladda-button btn btn-primary" id="add_reservation_btn" data-style="expand-right">Reserve Now</button>
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
        $(document).on("click" , "#add_reservation_btn" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');
            var formData =  $("#add_reservation_form").serialize();
            $.ajax({
                url:'<?php echo admin_url(); ?>reservations/reserve_now',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                // contentType: false,
                // processData: false,
                success:function(status){
                    btn.ladda('stop');
                    if(status.msg=='success') {
                        $('#add_reservation_form')[0].reset();
                        toastr.success(status.response,"Success");
                    } else if(status.msg == 'error') {
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });
    </script>
</body>
</html>