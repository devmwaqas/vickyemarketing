<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Add User </title>
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
                    <h2>Add User</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>users">Users</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add User</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a href="<?php echo admin_url(); ?>users" class="btn btn-primary mt-4"> Back to Users </a>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Add User</h5>
                            </div>
                            <div class="ibox-content">
                                <form id="add_user_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="first_name" id="first_name" class="form-control" required="required" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="last_name" id="last_name" class="form-control" required="required" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="mobile" id="mobile" class="form-control numeric" required="required" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Confirm Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="c_password" id="c_password" class="form-control" required="required" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Bank Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" required="required" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Account Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="account_title" id="account_title" class="form-control" required="required" placeholder="Account Title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Account Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="account_number" id="account_number" class="form-control numeric" required="required" placeholder="Account Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">CNIC Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="cnic_number" id="cnic_number" class="form-control" required="required" placeholder="CNIC Number">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label control-label">CNIC Front Side</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="cnic_front_side" id="cnic_front_side" class="form-control">
                                        </div>
                                        <label class="col-sm-1 col-form-label control-label">CNIC Back Side</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="cnic_back_side" id="cnic_back_side" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">User Role</label>
                                        <div class="col-sm-10">
                                            <div class="radio radio-info">
                                                <input type="radio" class="iradio_square-green" id="inlineRadio1" value="1" name="user_type" checked="">
                                                <label for="inlineRadio1"> Admin </label>
                                            </div>
                                            <div class="radio radio-info">
                                                <input type="radio" class="iradio_square-green" id="inlineRadio2" value="2" name="user_type">
                                                <label for="inlineRadio2"> Operator </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="button" id="add_user_btn">
                                                Save User
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
    <script type="text/javascript">

        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g,'');
        });


        $("#cnic_number").inputmask("99999-9999999-9");
        $("#mobile").inputmask("99999999999");

        $("#add_user_form").validate();
        $(document).on("click", "#add_user_btn", function(e) {
            if($("#add_user_form").valid()){

                var btn = $(this).ladda();
                btn.ladda('start');

                e.preventDefault();
                var formData =  new FormData( $("#add_user_form")[0] );
                var ajaxurl = '<?php echo admin_url().'users/submit_user'; ?>';
                $.ajax({
                    url: ajaxurl,
                    type : 'post',
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data ) {
                        btn.ladda('stop');
                        if(data.msg =='error') {
                            toastr.error(data.response);
                        }else if(data.msg =='success') {
                            toastr.success(data.response);
                            jQuery('#add_user_form')[0].reset();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>