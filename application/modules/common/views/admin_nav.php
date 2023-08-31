<?php $class = $this->router->fetch_class(); ?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="<?php echo base_url(); ?>admin_assets/img/user.png" style="width: 30px;background: white;"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"> <?php echo $this->session->userdata('admin_username'); ?> </span>
                        <span class="text-muted text-xs block">
                            <?php
                            if($this->session->userdata('admin_type') == 0) {
                                echo "Super Admin";
                            } elseif($this->session->userdata('admin_type') == 1) {
                                echo "Admin";
                            } else {
                                echo "Operator";
                            }
                            ?>
                            <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="<?php echo admin_url(); ?>profile">Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo admin_url(); ?>change_password">Change Password</a></li>
                            <li><a class="dropdown-item" href="<?php echo admin_url(); ?>logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        VEM
                    </div>
                </li>
                <li <?php if($class == "portal" ) { ?> class="active" <?php } ?>>
                    <a href="<?php echo admin_url(); ?>dashboard">
                        <i class="fa fa-th-large"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <?php if($this->session->userdata('admin_type') == 0) { ?>
                    <li <?php if($class == "users" ) { ?> class="active" <?php } ?>>
                        <a href="<?php echo admin_url(); ?>users">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">Users</span>
                        </a>
                    </li>
                    <li <?php if($class == "categories" ) { ?> class="active" <?php } ?>>
                        <a href="<?php echo admin_url(); ?>categories">
                            <i class="fa fa-list"></i>
                            <span class="nav-label">Categories</span>
                        </a>
                    </li>
                <?php } ?>
                <li <?php if($class == "products" ) { ?> class="active" <?php } ?>>
                    <a href="javascript:void(0);" aria-expanded="false">
                        <i class="fa fa-product-hunt"></i>
                        <span class="nav-label">Products</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?php if($class == "products" && empty($_GET)) { ?> class="active" <?php } ?>><a href="<?php echo admin_url(); ?>products">All</a></li>
                        <?php if($this->session->userdata('admin_type') != 2) { ?>
                            <li <?php if($class == "products" && @$_GET['status'] == 1) { ?> class="active" <?php } ?>><a href="<?php echo admin_url(); ?>products?status=1">Active</a></li>
                            <li <?php if($class == "products" && @$_GET['status'] == 2) { ?> class="active" <?php } ?>><a href="<?php echo admin_url(); ?>products?status=2">Inactive</a></li>
                        <?php } ?>
                        <?php foreach(get_categories() as $category) { ?>
                            <li <?php if($class == "products" && @$_GET['target'] == $category['id']) { ?> class="active" <?php } ?>>
                                <a href="<?php echo admin_url(); ?>products?target=<?php echo $category['id']; ?>">
                                    <?php echo $category['cat_name']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li <?php if($class == "reservations" ) { ?> class="active" <?php } ?>>
                    <a href="<?php echo admin_url(); ?>reservations">
                        <i class="fa fa-ticket"></i>
                        <span class="nav-label">Reservations</span>
                    </a>
                </li>
                <li <?php if($class == "orders" ) { ?> class="active" <?php } ?>>
                    <a href="javascript:void(0);" aria-expanded="false">
                        <i class="fa fa-list"></i>
                        <span class="nav-label">Orders</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?php if($class == "orders" && @$_GET['target'] == '') { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders">
                                All
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 10) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=10">
                                Ordered
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 1) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=1">
                                Reviewed
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 2) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=2">
                                On Hold
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 3) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=3">
                                Canceled
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 4) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=4">
                                Refunded
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 5) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=5">
                                Completed
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 6) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=6">
                                Review Deleted
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 7) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=7">
                                Commission
                            </a>
                        </li>
                        <li <?php if($class == "orders" && @$_GET['target'] == 8) { ?> class="active" <?php } ?>>
                            <a href="<?php echo admin_url(); ?>orders?target=8">
                                Delivered
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if($this->session->userdata('admin_type') != 2) { ?>
                    <li <?php if($class == "report" ) { ?> class="active" <?php } ?>>
                        <a href="<?php echo admin_url(); ?>report">
                            <i class="fa fa-file-excel-o"></i>
                            <span class="nav-label">Report</span>
                        </a>
                    </li>
                <?php } ?>
                <li <?php if($class == "support" ) { ?> class="active" <?php } ?>>
                    <a href="<?php echo admin_url(); ?>support">
                        <i class="fa fa-ticket"></i>
                        <span class="nav-label">Support</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>