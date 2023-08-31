<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Profile </title>
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
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>profile">Profile</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Profile</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Profile</h5>
                            </div>
                            <div class="ibox-content">
                                <form id="update_profile_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="first_name" id="first_name" class="form-control" required="required" value="<?php echo $profile_detail['first_name']; ?>" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="last_name" id="last_name" class="form-control" required="required" value="<?php echo $profile_detail['last_name']; ?>" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="mobile" id="mobile" class="form-control numeric" required="required" value="<?php echo $profile_detail['mobile']; ?>" placeholder="Mobile">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" required="required" value="<?php echo $profile_detail['email']; ?>" placeholder="Email" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Bank Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="<?php echo $profile_detail['bank_name']; ?>" required="required" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Account Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="account_title" id="account_title" class="form-control" value="<?php echo $profile_detail['account_title']; ?>" required="required" placeholder="Account Title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Account Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="account_number" id="account_number" class="form-control numeric" value="<?php echo $profile_detail['account_number']; ?>" required="required" placeholder="Account Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">CNIC Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="cnic_number" id="cnic_number" class="form-control" value="<?php echo $profile_detail['cnic_number']; ?>" required="required" placeholder="CNIC Number">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">CNIC Front Side</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="cnic_front_side" id="cnic_front_side" class="form-control">
                                            OLD CNIC Front Side: <a href="<?php echo base_url(); ?>assets/pictures/cards/<?php echo $profile_detail['cnic_front_side']; ?>" title="Image from Unsplash" data-gallery=""> View </a>
                                        </div>
                                        <label class="col-sm-1 col-form-label">CNIC Back Side</label>
                                        <div class="col-sm-4">
                                            <input type="file" accept="image/*" name="cnic_back_side" id="cnic_back_side" class="form-control">
                                            OLD CNIC Back Side: <a href="<?php echo base_url(); ?>assets/pictures/cards/<?php echo $profile_detail['cnic_back_side']; ?>" title="Image from Unsplash" data-gallery=""> View </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="button" id="submit">
                                                <span class="glyphicon glyphicon-check"></span>
                                                Update
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
        $('#update_profile_form').validate();
        $('#submit').click(function(e){
            if($("#update_profile_form").valid()){
                var btn = $(this).ladda();
                btn.ladda('start');
                var formData =  new FormData( $("#update_profile_form")[0] );
                $.ajax({
                    url:'<?php echo admin_url(); ?>profile/update_profile',
                    type:'post',
                    data: formData,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    success:function(status){
                        btn.ladda('stop');
                        if(status.msg=='success'){
                            toastr.success(status.response,"Success");
                            setTimeout(function() { location.reload(); }, 2000);
                        } else if(status.msg == 'error'){
                            toastr.error(status.response,"Error");
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>