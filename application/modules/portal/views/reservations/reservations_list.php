<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Reservations </title>
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
                            <strong>Reservations List</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <?php if($this->session->userdata('admin_type') == 2) { ?>
                        <a class="btn btn-primary mt-4" href="<?php echo admin_url(); ?>reservations/add"> <i class="fa fa-plus" aria-hidden="true"></i> Add Reservation </a>
                    <?php } ?>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Reservations</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <input type="hidden" value="<?php echo count($reservations); ?>" id="total_count" />
                                    <table id="product_list_tbl" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Product ID</th>
                                                <th>Remaining Time</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($reservations as $reserve) { ?>
                                                <tr class="gradeX" id="tr<?php echo $i; ?>">
                                                    <td>
                                                        <?php echo $reserve['id']; ?>
                                                        <input type="hidden" value="<?php echo $reserve['id']; ?>" id="reservation_id<?php echo $i; ?>" />
                                                    </td>
                                                    <td>
                                                        <?php echo $reserve['first_name']." ".$reserve['last_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $reserve['product_id']; ?>
                                                    </td>
                                                    <td>
                                                        <h3 class="font-weight-bold clock text-danger" id="reserve_time<?php echo $i; ?>"></h3>
                                                        <input type="hidden" value="<?php echo $reserve['created_at']; ?>" id="reserve_time_value<?php echo $i; ?>" />
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($reserve['picture'])) { ?>
                                                            <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $reserve['picture']; ?>" alt="Image" style="width: 50px;" />
                                                        <?php } elseif(!empty($reserve['amz_picture'])) { ?>
                                                            <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $reserve['amz_picture']; ?>" alt="Image" style="width: 50px;" />
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($this->session->userdata('admin_type') == 2) { ?>
                                                            <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>reservations/create_order/<?php echo $reserve['id']; ?>">
                                                                Create Order
                                                            </a>
                                                        <?php } ?>


                                                        <button class="btn btn-danger btn-sm btn_release" data-id="<?php echo $reserve['id'];?>" type="button" data-placement="top" title="Release"> Release </button>


                                                    </td>
                                                </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
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

            $('#product_list_tbl').dataTable({
                "paging": true,
                "searching": true,
                "bInfo": true,
                "responsive": false,
                "lengthMenu": [
                    [50, 100, -1],
                    [50, 100, "All"]
                    ],
                "columnDefs": [{
                    "responsivePriority": 1,
                    "targets": 0
                },
                {
                    "responsivePriority": 2,
                    "targets": -1
                },
                {
                    "responsivePriority": 3,
                    "targets": -2
                },
                ]
            });

            $(document).ready(function() {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });

            function change_active() {
                var total_count=document.getElementById("total_count").value;
                const inst_array = [];
                for (var i = 1; i <= total_count; i += 1) {
                    (function(i) {
                        inst_array[i]=setInterval(function() {
                            var setId="reserve_time"+i;
                            var recordId="reserve_time_value"+i;
                            var reservation_id="reservation_id"+i;
                            var reserve_time=document.getElementById(recordId).value;
                            var final_reserved_date= new Date(reserve_time);
                            final_reserved_date.setHours(final_reserved_date.getHours() + 1);
                            var target_time=0;
                            const nows = new Date();

                            const result = nows.getFullYear() + "-" + pad(nows.getMonth()+1) + "-" + pad(nows.getDate()) + " " + pad(nows.getHours()) + ":" + pad(nows.getMinutes()) + ":" + pad(nows.getSeconds());

                            var now = new Date(result);
                            var distance = final_reserved_date-now;
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            if($('#'+setId).length){
                                $('#'+setId).text(hours + ":" + minutes + ":" + seconds);
                            }

                            // $('#'+setId).text(nows);

                            if (distance < 0) {
                                clearInterval(inst_array[i]);
                                var reservation_value=document.getElementById(reservation_id).value;
                                delt_reservation(reservation_value)
                                var removeRow = "tr"+i;
                                const element = document.getElementById(removeRow);
                                element.remove();
                            }

                        }, 1000)})(i);
                    }
                }

                function pad(n) {
                    return n<10 ? '0'+n : n
                }

                window.onload = change_active;
                function delt_reservation(id){
                    $(document).ready(function(){
                        $.ajax({
                            type: "POST",
                            url: '<?php echo admin_url(); ?>reservations/del_reservation',
                            dataType: 'JSON',
                            data: { id : id },
                            cache:false,
                            success:
                            function(status){
                                if (status.msg == 'success') {
                                    location.reload();
                                } else {
                                    console.log("not");
                                }
                            }
                        });
                        return false;
                    });
                }

                $(document).on("click", ".btn_release", function() {
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: '<?php echo admin_url(); ?>reservations/del_reservation',
                        type: 'post',
                        data: {
                            id: id,
                        },
                        dataType: 'json',
                        success: function(status) {
                            if (status.msg == 'success') {
                                swal({
                                    title: "Success!",
                                    text: status.response,
                                    type: "success"
                                },
                                function(data) {
                                    location.reload();
                                });
                            } else if (status.msg == 'error') {
                                swal("Error", status.response, "error");
                            }
                        }
                    });
                });

            </script>
        </body>
        </html>