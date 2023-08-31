<!DOCTYPE html>
<html>

<head>

    <title>Vicky Marketing | Change Password </title>
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
                <h2>Change Password</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo admin_url(); ?>users">Users</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Change Password</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="float-left">Change Password</h5>

                        </div>
                        <div class="ibox-content">


                            <form role="form" id="change_password_form">
                                <div class="row" id="pwd-container3">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="c_password">Confirm Password</label>
                                            <input type="password" class="form-control" name="c_password" id="c_password" placeholder="">
                                        </div>
                                        <button type="button" id="submit" class="btn btn-primary block full-width m-b">Change</button>
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

    $('#change_password_form').validate({
        errorElement: 'span',
        errorClass: 'text-danger',
        focusInvalid: true,
        ignore: "",
        rules: {
            old_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength: 6
            },
            c_password: {
                required: true,
                equalTo:"#new_password"
            },
        },
        messages: {
            old_password: "Please enter old password.",
            new_password: {
                required : "Please enter new password",
                minlength : "Password must be greater than 6 digits.",
            },
            c_password:{
                required : "Please enter confirm password.",
                equalTo : "Confirm password does not match.",
            },
        },
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element);
        },
        submitHandler: function (form) {

        },
        invalidHandler: function (form) {

        }
    });

    $('#submit').click(function(e){

       if($("#change_password_form").valid()){

          // var btn = $(this).ladda();
          // btn.ladda('start');

          var value = $("#change_password_form").serialize();
          $.ajax({
            url:'<?php echo admin_url(); ?>update_password',
            type:'post',
            data:value,
            dataType:'json',
            success:function(status){
                // btn.ladda('stop');
                if(status.msg=='success'){
                    $('#change_password_form')[0].reset();
                    toastr.success(status.response,"Success");
                }
                else if(status.msg == 'error'){
                    toastr.error(status.response,"Error");
                }
            }
        });
      }
  });

</script>

</body>
</html>