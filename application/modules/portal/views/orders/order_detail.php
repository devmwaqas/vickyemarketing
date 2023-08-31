<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Orders </title>
    <?php $this->load->view('common/admin_header'); ?>

    <style type="text/css">

        .btn-clipboard {
            position: absolute;
            top: .5rem;
            right: .5rem;
            z-index: 10;
            display: block;
            padding: .25rem .5rem;
            font-size: 75%;
            color: #818a91;
            cursor: pointer;
            background-color: transparent;
            border: 0;
            border-radius: .25rem;
        }

        #clipboard:hover + #copied {
            background: #ccc
        }

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
                    <h2>Orders</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>orders">Orders</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Order Detail</strong>
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
                                <h5 class="float-left">Order Detail</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="col-md-12 mb-5">
                                            <h4>Order Picture:</h4>
                                            <?php if(!empty($order_detail['order_pic'])) { ?>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['order_pic']; ?>" alt="Image" style="width: 100%;" />
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-12 mb-5">
                                            <hr />
                                            <h4>Review Picture:</h4>
                                            <?php if(!empty($order_detail['review_pic'])) { ?>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['review_pic']; ?>" alt="Image" style="width: 100%;" />
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-12 mb-5">
                                            <hr />
                                            <h4>Refund Picture:</h4>
                                            <?php if(!empty($order_detail['refund_pic'])) { ?>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $order_detail['refund_pic']; ?>" alt="Image" style="width: 100%;" />
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div class="col-md-9">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <h2 class="font-bold m-b-xs">
                                                    Order Number: <?php echo $order_detail['order_number']; ?>
                                                </h2>
                                                <hr>
                                            </div>

                                            <div class="col-md-6">
                                                <h4>Customer Email:</h4>
                                                <div class="text-muted"><?php echo $order_detail['customer_email']; ?></div>
                                                <h4>Product ID:</h4>
                                                <div class="text-muted"><?php echo $order_detail['product_id']; ?></div>
                                                <h4>AMZ Review Link:</h4>
                                                <div class="text-muted"><?php echo $order_detail['amz_review_link']; ?></div>
                                                <h4>Market:</h4>
                                                <div class="text-muted"><?php echo $order_detail['market_name']; ?></div>
                                            </div>

                                            <div class="col-md-6">

                                                <div id='copied'>
                                                    <div class="bd-clipboard"><button onclick="copy_vcode()" id="clipboard" class="btn-clipboard" title="Copy this Detail => Order Number: <?php echo $order_detail['order_number']; ?> Customer Email: <?php echo $order_detail['customer_email']; ?>" data-original-title="Copy to clipboard"><i style='font-size:24px' class="fa fa-copy"></i></button></div>
                                                    <input id="refu" type="text" value="Order Number: <?php echo $order_detail['order_number']; ?> Customer Email: <?php echo $order_detail['customer_email']; ?>" style="display: none;" />
                                                </div>

                                                <h4>Order Status:</h4>
                                                <div>
                                                    <?php
                                                    if($order_detail['order_status'] == 0) {
                                                        echo "Ordered";
                                                    } elseif($order_detail['order_status'] == 1) {
                                                        echo "Reviewed";
                                                    } elseif($order_detail['order_status'] == 2) {
                                                        echo "On Hold";
                                                    } elseif($order_detail['order_status'] == 3) {
                                                        echo "Canceled";
                                                    } elseif($order_detail['order_status'] == 4) {
                                                        echo "Refunded";
                                                    } elseif($order_detail['order_status'] == 5) {
                                                        echo "Completed";
                                                    } elseif($order_detail['order_status'] == 6) {
                                                        echo "Review Deleted";
                                                    } elseif($order_detail['order_status'] == 7) {
                                                        echo "Commission";
                                                    } elseif($order_detail['order_status'] == 8) {
                                                        echo "Delivered";
                                                    }
                                                    ?>
                                                </div>
                                                <h4>Order Date:</h4>
                                                <div class="text-muted"><?php echo $order_detail['order_date']; ?></div>
                                                <h4>Refund Date:</h4>
                                                <?php if(!empty($order_detail['refund_date'])) { ?>
                                                    <div class="text-muted"><?php echo $order_detail['refund_date']; ?></div>
                                                <?php } ?>
                                                <h4>Last Update Date:</h4>
                                                <div class="text-muted"><?php echo $order_detail['updated_at']; ?></div>
                                                <dl class="m-t-md">
                                                    <dt>Remarks:</dt>
                                                    <dd><?php echo $order_detail['remarks']; ?></dd>
                                                </dl>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>orders/edit/<?php echo $order_detail['order_id']; ?>">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                            Edit Order
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
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

    <script type="text/javascript">



        function copy_vcode() {
            // Get the text field
          var copyText = document.getElementById("refu");

            // Select the text field
          copyText.select();
          copyText.setSelectionRange(0, 99999); // For mobile devices

          // Copy the text inside the text field
          navigator.clipboard.writeText(copyText.value);

          // Alert the copied text
          toastr.success("Copied the text: " + copyText.value, "Success");
      }



  </script>

</body>
</html>