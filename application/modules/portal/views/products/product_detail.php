<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Products </title>
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
                    <h2>Products</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>Products">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Product Detail</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>products"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Products </a>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Product Detail</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php if(!empty($product_detail['picture'])) { ?>
                                            <div class="col-md-12 mb-5">
                                                <h4>Picture:</h4>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $product_detail['picture']; ?>" alt="Image" style="width: 100%;" />
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($product_detail['amz_picture'])) { ?>
                                            <div class="col-md-12">
                                                <h4>AMZ Picture:</h4>
                                                <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $product_detail['amz_picture']; ?>" alt="Image" style="width: 100%;" />
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-9">

                                        <div class="row">

                                            <div class="col-md-12">

                                                <h2>
                                                    Keyword: <?php echo $product_detail['keyword']; ?>
                                                </h2>

                                            </div>

                                            <div class="col-md-6">



                                                <h4>Brand Name</h4>
                                                <div class="text-muted"><?php echo $product_detail['brand_name']; ?></div>
                                                <h4>Market</h4>
                                                <div class="text-muted"><?php echo $product_detail['market_name']; ?></div>
                                                <h4>AMZ Seller</h4>
                                                <div class="text-muted"><?php echo $product_detail['amz_seller']; ?></div>
                                                <?php if($this->session->userdata('admin_type') != 2) { ?>
                                                    <h4>Chinese Seller</h4>
                                                    <div class="text-muted"><?php echo $product_detail['chinese_seller']; ?></div>
                                                <?php } ?>
                                                <h4>Category</h4>
                                                <div class="text-muted"><?php echo $product_detail['cat_name']; ?></div>
                                                <h4>Product Type</h4>
                                                <div class="text-muted"><?php echo $product_detail['product_type']; ?></div>
                                                <h4>Referral Link</h4>
                                                <div class="text-muted"><?php echo $product_detail['referral_link']; ?></div>

                                                <h4>PP Fee Cover</h4>
                                                <?php if($product_detail['fee_cover']) { ?>
                                                    <div class="text-muted">Yes</div>
                                                <?php } else { ?>
                                                    <div class="text-muted">No</div>
                                                <?php } ?>
                                                <h4>Tax Cover</h4>
                                                <?php if($product_detail['tax_cover']) { ?>
                                                    <div class="text-muted">Yes</div>
                                                <?php } else { ?>
                                                    <div class="text-muted">No</div>
                                                <?php } ?>
                                                <dl class="m-t-md">
                                                    <dt>Instruction</dt>
                                                    <dd><?php echo nl2br($product_detail['instruction']); ?></dd>
                                                </dl>


                                            </div>
                                            <div class="col-md-6">

                                                <div id='copied'>
                                                    <div class="bd-clipboard"><button onclick="copy_vcode()" id="clipboard" class="btn-clipboard" title="Copy this Detail => Keyword : <?php echo $product_detail['keyword']; ?> Sold By : <?php echo $product_detail['amz_seller']; ?> Brand : <?php echo $product_detail['brand_name']; ?> Product Code : <?php echo $product_detail['id']; ?> Referral Link: <?php echo $product_detail['referral_link']; ?>" data-original-title="Copy to clipboard"><i style='font-size:24px' class="fa fa-copy"></i></button></div>
                                                    <input id="refu" type="text" value="Keyword : <?php echo $product_detail['keyword']; ?> Sold By : <?php echo $product_detail['amz_seller']; ?> Brand : <?php echo $product_detail['brand_name']; ?> Product Code : <?php echo $product_detail['id']; ?> Referral Link: <?php echo $product_detail['referral_link']; ?>" style="display: none;" />
                                                </div>

                                                <dl class="m-t-md">
                                                    <dt>Refund Conditions</dt>
                                                    <dd><?php echo nl2br($product_detail['refund_conditions']); ?></dd>
                                                </dl>

                                                <dl class="m-t-md">
                                                    <dt>PM Commission</dt>
                                                    <dd><?php echo $product_detail['pmm_commission']; ?></dd>
                                                </dl>
                                                <?php if($this->session->userdata('admin_type') != 2) { ?>
                                                    <dl class="m-t-md">
                                                        <dt>Portal Commission</dt>
                                                        <dd><?php echo $product_detail['portal_commission']; ?></dd>
                                                    </dl>
                                                <?php } ?>
                                                <dl class="m-t-md">
                                                    <dt>Commission Conditions</dt>
                                                    <dd><?php echo nl2br($product_detail['commission_conditions']); ?></dd>
                                                </dl>
                                                <dl class="m-t-md">
                                                    <dt>Sale limit per day</dt>
                                                    <dd><?php echo $product_detail['sale_limit']; ?></dd>
                                                </dl>
                                                <dl class="m-t-md">
                                                    <dt>Overall sale limit</dt>
                                                    <dd><?php echo $product_detail['overall_sale_limit']; ?></dd>
                                                </dl>
                                                <?php if($this->session->userdata('admin_type') == 2) { ?>
                                                    <dl class="m-t-md">
                                                        <dt>PMM Name</dt>
                                                        <dd><?php echo $product_detail['created_first_name']." ".$product_detail['created_last_name']; ?></dd>
                                                    </dl>
                                                <?php } ?>


                                            </div>

                                            <?php if($this->session->userdata('admin_type') != 2) { ?>
                                                <div class="col-md-12">
                                                    <hr>
                                                    <div>
                                                        <div class="btn-group">
                                                            <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>products/edit/<?php echo $product_detail['id']; ?>"><i class="fa fa-edit" aria-hidden="true"></i>
                                                                Edit Product
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

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