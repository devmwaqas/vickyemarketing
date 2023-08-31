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
                            <strong>Reports List</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Reports List</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id="product_list_tbl" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subject</th>
                                                <th>Message</th>

                                                <th>Create Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($reports as $report) { ?>
                                                <tr class="gradeX" id="tr<?php echo $i; ?>">
                                                    <td>
                                                        <?php echo $i; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $report['subject']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $report['issue_type']." of order #".$report['order_number']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo date('Y-m-d H:i:s', strtotime($report['created_at'])); ?>
                                                    </td>

                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="<?php echo admin_url(); ?>support/detail/<?php echo $report['id']; ?>">
                                                            View
                                                        </a>
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
                "responsive": true,
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

        </script>
    </body>
    </html>