<!DOCTYPE html>
<html>

<head>

    <title>Vicky Marketing | Users </title>
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
                <h2>Users</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo admin_url(); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Users</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
                <a href="<?php echo admin_url(); ?>users/add" class="btn btn-primary mt-4"> Add User </a>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="float-left">Users list</h5>

                        </div>
                        <div class="ibox-content">

                            <div class="table-responsive">

                                <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>

                                            <th>Status</th>

                                            <th>Mobile</th>
                                            <td>Created By </td>
                                            <td>Created At </td>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($users as $user) { ?>
                                            <tr class="gradeX">

                                                <td>
                                                    <?php echo $i; $i++; ?>
                                                </td>

                                                <td>
                                                    <?php echo $user['first_name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $user['last_name']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $user['email']; ?>
                                                </td>
                                                <td>
                                                    <?php if($user['user_type'] == 1) {
                                                        $label_class = 'primary';
                                                        $label = 'Admin';
                                                    } elseif($user['user_type'] == 2) {
                                                        $label_class = 'danger';
                                                        $label = 'Operator';
                                                    } ?>
                                                    <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span>
                                                </td>

                                                <td>
                                                    <?php if($user['status'] == 1){
                                                        $label_class = 'primary';
                                                        $label = 'Active';
                                                    }else{
                                                        $label_class = 'danger';
                                                        $label = 'Inactive';
                                                    } ?>
                                                    <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span>

                                                </td>

                                                <td>
                                                    <?php echo $user['mobile']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $user['create_by']; ?>
                                                </td>

                                                <td>
                                                    <?php echo date('m-d-Y', strtotime($user['created_at'])); ?>
                                                </td>

                                                <td>
                                                    <a href="<?php echo admin_url(); ?>users/edit/<?php echo $user['id']; ?>" class="btn btn-primary btn-sm"> Edit </a>

                                                    <a href="javascript:void(0);" data-id="<?php echo $user['id']; ?>" data-model="users" class="btn btn-danger btn-sm delete-btn"> Delete </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
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

</body>
</html>