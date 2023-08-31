<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Products </title>
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
                    <h2>Products</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>Products">Products</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Edit Product</strong>
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
                                <h5 class="float-left">Edit Product</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="post" id="update_product_form" enctype="multipart/form-data">

                                    <input type="hidden" name="product_id" value="<?php echo $product_detail['id']; ?>">

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Keyword</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo $product_detail['keyword']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Brand Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="brand_name" id="brand_name" class="form-control" value="<?php echo $product_detail['brand_name']; ?>">
                                        </div>
                                        <label class="col-sm-1 col-form-label">AMZ Seller</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="amz_seller" id="amz_seller" class="form-control" value="<?php echo $product_detail['amz_seller']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Market</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="market_id" id="market_id">
                                                <option value="">Select market</option>
                                                <?php foreach (get_markets() as $market) { ?>
                                                    <option value="<?php echo $market['id']; ?>" <?php if($market['id'] == $product_detail['market_id']) { ?> selected <?php } ?>><?php echo $market['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 col-form-label">Chinese Seller</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="chinese_seller" id="chinese_seller" class="form-control" value="<?php echo $product_detail['chinese_seller']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Category</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="category_id" id="category_id">
                                                <option value="">Select category</option>
                                                <?php foreach (get_categories() as $category) { ?>
                                                    <option value="<?php echo $category['id']; ?>" <?php if($category['id'] == $product_detail['category_id']) { ?> selected <?php } ?>><?php echo $category['cat_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 col-form-label">Product Type</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="product_type" id="product_type">
                                                <option value="">Select product type</option>
                                                <?php foreach (get_producttypes() as $producttype) { ?>
                                                    <option value="<?php echo $producttype['id']; ?>" <?php if($producttype['id'] == $product_detail['product_type_id']) { ?> selected <?php } ?>><?php echo $producttype['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Amazon Picture</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="amz_picture" id="amz_picture" class="form-control">
                                        </div>
                                        <label class="col-sm-1 col-form-label">Picture</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="picture" id="picture" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Referral Link</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="referral_link" id="referral_link" class="form-control" value="<?php echo $product_detail['referral_link']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">PP Fee Cover</label>
                                        <div class="col-sm-4">


                                            <div><label style="font-size: 18px;"> <input type="radio" <?php if($product_detail['fee_cover']) { ?> checked <?php } ?> value="1" id="fee_cover1" name="fee_cover" style="height:25px; width:25px; vertical-align: middle;"> Yes </label></div>
                                            <div><label style="font-size: 18px;"> <input type="radio" <?php if(!$product_detail['fee_cover']) { ?> checked <?php } ?> value="0" id="fee_cover2" name="fee_cover" style="height:25px; width:25px; vertical-align: middle;"> No </label></div>

                                        </div>
                                        <label class="col-sm-1 col-form-label">Tax Cover</label>
                                        <div class="col-sm-4">

                                            <div><label style="font-size: 18px;"> <input type="radio" <?php if($product_detail['tax_cover']) { ?> checked <?php } ?> value="1" id="tax_cover1" name="tax_cover" style="height:25px; width:25px; vertical-align: middle;"> Yes </label></div>
                                            <div><label style="font-size: 18px;"> <input type="radio" <?php if(!$product_detail['tax_cover']) { ?> checked <?php } ?> value="0" id="tax_cover2" name="tax_cover" style="height:25px; width:25px; vertical-align: middle;"> No </label></div>


                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Instruction</label>
                                        <div class="col-sm-4">
                                            <textarea name="instruction" id="instruction" class="form-control"><?php echo $product_detail['instruction']; ?></textarea>
                                        </div>

                                        <label class="col-sm-1 col-form-label">Refund Conditions</label>
                                        <div class="col-sm-4">
                                            <textarea name="refund_conditions" id="refund_conditions" class="form-control"><?php echo $product_detail['refund_conditions']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">PM Commission</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="pmm_commission" id="pmm_commission" class="form-control price" value="<?php echo $product_detail['pmm_commission']; ?>">
                                        </div>

                                        <label class="col-sm-1 col-form-label">Portal Commission</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="portal_commission" id="portal_commission" class="form-control price" value="<?php echo $product_detail['portal_commission']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Commission Conditions</label>
                                        <div class="col-sm-4">
                                            <textarea cols="10" rows="5" class="form-control " name="commission_conditions"><?php echo $product_detail['commission_conditions']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Sale limit per day</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="sale_limit" id="sale_limit" class="form-control price" value="<?php echo $product_detail['sale_limit']; ?>">
                                        </div>
                                        <label class="col-sm-1 col-form-label">Overall sale limit</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="overall_sale_limit" id="overall_sale_limit" class="form-control price" value="<?php echo $product_detail['overall_sale_limit']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-1">

                                            <a href="<?php echo admin_url(); ?>products" class="btn btn-white" id="cancel_btn">Cancel</a>

                                            <button type="button" class="ladda-button btn btn-primary" id="add_product_btn" data-style="expand-right">Update</button>

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

        $(document).on("click" , "#add_product_btn" , function() {

            var btn = $(this).ladda();
            btn.ladda('start');
            var formData =  new FormData( $("#update_product_form")[0] );
            $.ajax({
                url:'<?php echo admin_url(); ?>products/update_product',
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
                    } else if(status.msg == 'error') {
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });

        $(document).ready(function () {
            $('.price').keypress(function () {
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });
            $('.price').keyup(function () {
                this.value = this.value.replace(/[^0-9\.]/g,'');
            });
        });

    </script>
</body>
</html>