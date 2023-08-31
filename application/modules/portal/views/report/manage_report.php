<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Report </title>
    <?php $this->load->view('common/admin_header'); ?>

    <link href="<?php echo base_url(); ?>admin_assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>admin_assets/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

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
                    <h2>Report</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>report">Report</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Export Report</strong>
                        </li>
                    </ol>
                </div>

            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Report</h5>
                            </div>
                            <div class="ibox-content">

                                <form method="get" action="<?php echo admin_url(); ?>report/export_excel_report">


                                    <div class="form-group row" id="data_5">
                                        <label class="font-normal col-sm-1">Date Range</label>
                                        <div class="input-daterange input-group col-sm-4" id="datepicker">
                                            <input type="text" class="form-control-sm form-control" name="start_date" value="<?php echo date('m/d/Y'); ?>"/>
                                            <input type="text" class="form-control-sm form-control" name="end_date" value="<?php echo date('m/d/Y'); ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Status</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="status" id="status">
                                                <option value=""> All </option>
                                                <option value="0"> Ordered </option>
                                                <option value="1"> Reviewed </option>
                                                <option value="2"> On Hold </option>
                                                <option value="3"> Canceled </option>
                                                <option value="4"> Refunded </option>
                                                <option value="5"> Completed </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-1">
                                            <button type="submit" class="ladda-button btn btn-primary" data-style="expand-right">
                                                Export Report
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

    <script src="<?php echo base_url(); ?>admin_assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo base_url(); ?>admin_assets/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="<?php echo base_url(); ?>admin_assets/js/plugins/daterangepicker/daterangepicker.js"></script>



    <script type="text/javascript">

        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

    </script>
</body>
</html>