<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portal | Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicon.png">

    <link href="<?php echo base_url(); ?>admin_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>admin_assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>admin_assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>admin_assets/css/style.css" rel="stylesheet">

    <script>
        var base_url = "<?php echo base_url(); ?>";
        var admin_url = "<?php echo admin_url(); ?>";
    </script>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div style="margin-top: 150px;">
            <div>
                <img src="<?php echo base_url(); ?>assets/logo.png" class="logo" style="width: 100%;">
            </div>


            <h2 class="font-bold">Forgot password</h2>

            <p>
                Enter your email address and your password will be reset and emailed to you.
            </p>

            <div class="alert alert-danger" id="error_msg" style="display: none;">

            </div>

            <div class="alert alert-success" id="success_msg" style="display: none;">

            </div>

            <form class="m-t" role="form" id="forgot_form">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required="">
                </div>
                <button type="button" class="btn btn-primary block full-width m-b" id="forgot-btn">Send new password</button>
            </form>

            <p class="text-inverse b-b-default text-right">Back to <a href="<?php echo admin_url(); ?>login">Login.</a></p>




            <p class="m-t"> <small>All rights reserved Vicky Marketing &copy; <?php echo date("Y"); ?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>admin_assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/datatable/jquery.dataTables.min.js"></script>

    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>admin_assets/js/plugins/iCheck/icheck.min.js"></script>

    <script src="<?php echo base_url(); ?>admin_assets/js/select2.min.js"></script>

    <script src="<?php echo base_url(); ?>admin_assets/js/functions.js"></script>

</body>

</html>