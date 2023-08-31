<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Support </title>
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
                    <h2>Support</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>support">Support</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Report Detail</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>support"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Support </a>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Report Detail</h5>
                            </div>
                            <div class="ibox-content">

                                <button class="btn btn-primary mb-2" id="issue_resolved" data-id="<?php echo $report_detail['id']; ?>"> <i class="fa fa-check" aria-hidden="true"></i> Issue Resolved  </button>

                                <div>
                                    <div class="chat-activity-list">
                                        <div class="chat-element">
                                            <a href="javascript:void(0);" class="float-left">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <div class="media-body ">
                                                <strong><?php echo ucwords($report_detail['username']); ?></strong>
                                                <p class="m-b-xs">
                                                    <?php echo $report_detail['issue_type']." of order #".$report_detail['order_number']; ?>
                                                </p>
                                                <small class="text-muted"><?php echo date('Y-m-d H:i:s', strtotime($report_detail['created_at'])); ?></small>
                                            </div>
                                        </div>

                                        <?php foreach ($messages as $message) { ?>
                                            <div class="chat-element">
                                                <a href="javascript:void(0);" class="float-left">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                                <div class="media-body ">
                                                    <strong><?php echo ucwords($message['username']); ?></strong>
                                                    <p class="m-b-xs">
                                                        <?php echo $message['message']; ?>
                                                    </p>
                                                    <?php if(!empty($message['attachment'])) { ?>
                                                        <p class="m-b-xs">
                                                            <a href="<?php echo base_url(); ?>assets/pictures/<?php echo $message['attachment']; ?>" target="_blank"> View Attachment </a>
                                                        </p>
                                                    <?php } ?>
                                                    <small class="text-muted"><?php echo date('Y-m-d H:i:s', strtotime($message['created_at'])); ?></small>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>



                                </div>
                                <div class="chat-form">
                                    <form role="form" id="submit_message_form">
                                        <input type="hidden" name="order_number" value="<?php echo $report_detail['order_number']; ?>">
                                        <input type="hidden" name="report_id" value="<?php echo $report_detail['id']; ?>">
                                        <div class="form-group">
                                            <textarea name="message" id="message" class="form-control" placeholder="Message"></textarea>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label">Attachment</label>
                                            <div class="col-sm-4">
                                                <input type="file" accept="image/*" name="attachment" id="attachment" class="form-control">
                                            </div>
                                        </div>
                                        <div class="">
                                            <button type="button" class="btn btn-sm btn-primary m-t-n-xs" id="submit_message_btn"><strong>Send Message</strong></button>
                                        </div>
                                    </form>
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
    <script>


        $(document).on("click", "#issue_resolved", function() {

            var id = $(this).attr('data-id');

            swal({
                title: "Are you sure?",
                text: "You want to change the status of this report as resolved!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, please!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {

                    $(".confirm").prop("disabled", true);

                    $.ajax({
                        url: '<?php echo admin_url(); ?>support/mark_resolved',
                        type: 'post',
                        data: { report_id: id },
                        dataType: 'json',
                        success: function(status) {

                            $(".confirm").prop("disabled", false);
                            if (status.msg == 'success') {
                                swal({
                                    title: "Success!",
                                    text: status.response,
                                    type: "success"
                                },
                                function(data) {
                                    window.location = admin_url +"support";
                                });
                            } else if (status.msg == 'error') {
                                toastr.error(status.response,"Error");
                            }
                        }
                    });

                }  else {
                    swal("Cancelled", "", "error");
                }

            });
        });

        $(document).on("click" , "#submit_message_btn" , function() {
            var btn = $(this).ladda();
            btn.ladda('start');
            var formData =  new FormData( $("#submit_message_form")[0] );
            $.ajax({
                url:'<?php echo admin_url(); ?>support/submit_message',
                type: 'POST',
                data: formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(status){
                    btn.ladda('stop');
                    if(status.msg=='success') {
                        $('#submit_message_form')[0].reset();
                        toastr.success(status.response,"Success");
                        setTimeout(function(){ location.reload(); }, 2000);
                    } else if(status.msg == 'error') {
                        toastr.error(status.response,"Error");
                    }
                }
            });
        });
    </script>
</body>
</html>