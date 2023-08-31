<!DOCTYPE html>
<html>
<head>
    <title>Vicky Marketing | Dashboard </title>
    <?php $this->load->view('common/admin_header'); ?>
</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('common/admin_nav'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php $this->load->view('common/admin_top_nav'); ?>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <?php
                    $total_orders = get_totals();
                    $ordered = get_totals('0');
                    $reviewed = get_totals('1');
                    $onhold = get_totals('2');
                    $canceled = get_totals('3');
                    $refunded = get_totals('4');
                    $completed = get_totals('5');
                    $review_deleted = get_totals('6');
                    $commission = get_totals('7');
                    $delivered = get_totals('8');
                    if($total_orders == 0) {
                        $total_orders = 1;
                    }
                    ?>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Ordered</h5>
                                <div class="stat-percent font-bold text-navy pull-right"><?php echo number_format((($ordered/$total_orders) * 100),2); ?>% <i class="fa fa-level-up"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $ordered; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Reviewed</h5>
                                <div class="stat-percent font-bold text-navy pull-right"><?php echo number_format((($reviewed/$total_orders) * 100),2); ?>% <i class="fa fa-level-up"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $reviewed; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>On Hold</h5>
                                <div class="stat-percent font-bold text-danger pull-right"><?php echo number_format((($onhold/$total_orders) * 100),2); ?>% <i class="fa fa-level-down"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $onhold; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Canceled</h5>
                                <div class="stat-percent font-bold text-danger pull-right"><?php echo number_format((($canceled/$total_orders) * 100),2); ?>% <i class="fa fa-level-down"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $canceled; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Refunded</h5>
                                <div class="stat-percent font-bold text-danger pull-right"><?php echo number_format((($refunded/$total_orders) * 100),2); ?>% <i class="fa fa-level-down"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $refunded; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Completed</h5>
                                <div class="stat-percent font-bold text-navy pull-right"><?php echo number_format((($completed/$total_orders) * 100),2); ?>% <i class="fa fa-level-up"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $completed; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Review Deleted</h5>
                                <div class="stat-percent font-bold text-danger pull-right"><?php echo number_format((($review_deleted/$total_orders) * 100),2); ?>% <i class="fa fa-level-down"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $review_deleted; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Commissioned</h5>
                                <div class="stat-percent font-bold text-navy pull-right"><?php echo number_format((($commission/$total_orders) * 100),2); ?>% <i class="fa fa-level-up"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $commission; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Delivered</h5>
                                <div class="stat-percent font-bold text-navy pull-right"><?php echo number_format((($delivered/$total_orders) * 100),2); ?>% <i class="fa fa-level-up"></i></div>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $delivered; ?> </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-5">
                        <div class="ibox-content ">
                            <h4>
                                Completed Orders
                            </h4>
                            <hr />
                            <canvas id="lineChart" height="114"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <div class="ibox-content">
                            <h4>
                                Order By Status
                            </h4>
                            <hr />
                            <div>
                                <div class="col-lg-12">
                                    <ul>
                                        <li style="color: #069806; font-size: 20px;">Completed</li>
                                        <li style="color: #FF0000; font-size: 20px;"">Cancelled</li>
                                    </ul>
                                    <canvas id="doughnutChart" width="250" height="315" style="margin: 18px auto 0;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('common/admin_footer'); ?>
            <script src="<?php echo base_url(); ?>admin_assets/js/plugins/chartJs/Chart.min.js"></script>
        </div>
    </div>
    <?php $this->load->view('common/admin_scripts'); ?>
    <script type="text/javascript">

        setTimeout(function() {


            $.ajax({
                url:'<?php echo admin_url(); ?>portal/get_status',
                type:'post',
                data:{},
                dataType:'json',
                success:function(status){
                    if(status.msg=='success'){

                        var lineData = {
                            labels: Array.from(new Array(30), function (_, i) {
                                return i === 0 ? 1 : ++i;
                            }),
                            datasets: [
                            {
                                label: 'Current Month',
                                backgroundColor: "rgba(26,179,148,0.5)",
                                borderColor: "rgba(26,179,148,0.7)",
                                pointBackgroundColor: "rgba(26,179,148,1)",
                                pointBorderColor: "#fff",
                                data: status.current
                            },
                            {
                                label: "Past Month",
                                backgroundColor: "rgba(220,220,220,0.5)",
                                borderColor: "rgba(220,220,220,1)",
                                pointBackgroundColor: "rgba(220,220,220,1)",
                                pointBorderColor: "#fff",
                                data: status.past
                            }
                            ]
                        };

                        var lineOptions = {
                            responsive: true
                        };

                        var ctx = document.getElementById("lineChart").getContext("2d");
                        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
                        var doughnutData = {
                            labels: ["Completed","Cancelled"],
                            datasets: [{
                                data: [status.completed,status.cancelled],
                                backgroundColor: ["#069806","#FF0000"]
                            }]
                        };

                        var doughnutOptions = {
                            responsive: false,
                            legend: {
                                display: false
                            }
                        };

                        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
                        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});
                    }
                }
            });

        }, 2000);
    </script>
</body>
</html>