<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Update Order </title>
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
                            <strong>Update Order</strong>
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
                                <h5 class="float-left">Update Order</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="post" id="update_order_form" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $order_detail['order_id']; ?>">
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Order Number</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="order_number" id="order_number" class="form-control" value="<?php echo $order_detail['order_number']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Customer Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" value="<?php echo $order_detail['customer_email']; ?>" readonly="">
                                        </div>
                                        <label class="col-sm-1 col-form-label">AMZ Review Link</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="amz_review_link" id="amz_review_link" class="form-control" value="<?php echo $order_detail['amz_review_link']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <?php if($this->session->userdata('admin_type') == 2) { ?>
                                            <label class="col-sm-1 col-form-label">Order Picture</label>
                                            <div class="col-sm-4">
                                                <input type="file" accept="image/*" name="order_pic" id="order_pic" class="form-control">
                                                <p class="text-danger">Note: If you want to change picture please attach new one</p>
                                                <?php if(!empty($order_detail['order_pic'])) { ?>
                                                    <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['order_pic']; ?>" alt="Image" style="width: 100%;" />
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <label class="col-sm-1 col-form-label">Refund Picture </label>
                                            <div class="col-sm-4">
                                                <input type="file" accept="image/*" name="refund_pic" id="refund_pic" class="form-control">
                                                <p class="text-danger">Note: If you want to change picture please attach new one</p>
                                                <?php if(!empty($order_detail['refund_pic'])) { ?>
                                                    <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['refund_pic']; ?>" alt="Image" style="width: 100%;" />
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <label class="col-sm-1 col-form-label">Review Picture </label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="review_pic" id="review_pic" class="form-control">
                                            <p class="text-danger">Note: If you want to change picture please attach new one</p>
                                            <?php if(!empty($order_detail['review_pic'])) { ?>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['review_pic']; ?>" alt="Image" style="width: 100%;" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Status</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="status" id="status">
                                                <?php if($this->session->userdata('admin_type') == 2) { ?>

                                                    <option value="0" <?php if($order_detail['order_status'] == 0) { ?> selected <?php } ?>>
                                                        Ordered
                                                    </option>
                                                    <option value="1" <?php if($order_detail['order_status'] == 1) { ?> selected <?php } ?>>
                                                        Reviewed
                                                    </option>
                                                    <option value="3" <?php if($order_detail['order_status'] == 3) { ?> selected <?php } ?>>
                                                        Canceled
                                                    </option>

                                                <?php } elseif($this->session->userdata('admin_type') == 1) { ?>

                                                    <option value="0" <?php if($order_detail['order_status'] == 0) { ?> selected <?php } ?>>
                                                        Ordered
                                                    </option>

                                                    <option value="1" <?php if($order_detail['order_status'] == 1) { ?> selected <?php } ?>>
                                                        Reviewed
                                                    </option>

                                                    <option value="8" <?php if($order_detail['order_status'] == 8) { ?> selected <?php } ?>>
                                                        Delivered
                                                    </option>

                                                    <option value="2" <?php if($order_detail['order_status'] == 2) { ?> selected <?php } ?>>
                                                        On Hold
                                                    </option>

                                                    <option value="4" <?php if($order_detail['order_status'] == 4) { ?> selected <?php } ?>>
                                                        Refunded
                                                    </option>

                                                    <option value="6" <?php if($order_detail['order_status'] == 6) { ?> selected <?php } ?>>
                                                        Review Deleted
                                                    </option>

                                                    <option value="3" <?php if($order_detail['order_status'] == 3) { ?> selected <?php } ?>>
                                                        Canceled
                                                    </option>

                                                <?php } else { ?>

                                                    <option value="0" <?php if($order_detail['order_status'] == 0) { ?> selected <?php } ?>>
                                                        Ordered
                                                    </option>
                                                    <option value="1" <?php if($order_detail['order_status'] == 1) { ?> selected <?php } ?>>
                                                        Reviewed
                                                    </option>
                                                    <option value="2" <?php if($order_detail['order_status'] == 2) { ?> selected <?php } ?>>
                                                        On Hold
                                                    </option>
                                                    <option value="3" <?php if($order_detail['order_status'] == 3) { ?> selected <?php } ?>>
                                                        Canceled
                                                    </option>
                                                    <option value="4" <?php if($order_detail['order_status'] == 4) { ?> selected <?php } ?>>
                                                        Refunded
                                                    </option>
                                                    <option value="5" <?php if($order_detail['order_status'] == 5) { ?> selected <?php } ?>>
                                                        Completed
                                                    </option>
                                                    <option value="6" <?php if($order_detail['order_status'] == 6) { ?> selected <?php } ?>>
                                                        Review Deleted
                                                    </option>
                                                    <option value="7" <?php if($order_detail['order_status'] == 7) { ?> selected <?php } ?>>
                                                        Commissioned
                                                    </option>
                                                    <option value="8" <?php if($order_detail['order_status'] == 8) { ?> selected <?php } ?>>
                                                        Delivered
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Remarks</label>
                                        <div class="col-sm-4">
                                            <textarea name="remarks" id="remarks" class="form-control"><?php echo $order_detail['remarks']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-1">
                                            <a class="btn btn-white" href="<?php echo admin_url(); ?>orders">Cancel</a>
                                            <button type="button" class="ladda-button btn btn-primary" id="update_order_btn" data-style="expand-right">
                                                Update Now
                                            </button>
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
        $("#order_number").inputmask({"mask": "999-9999999-9999999"});
        $(document).on("click" , "#update_order_btn" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');
            var formData =  new FormData( $("#update_order_form")[0] );
            $.ajax({
                url:'<?php echo admin_url(); ?>orders/update_order',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(status){
                    btn.ladda('stop');
                    if(status.msg=='success') {
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