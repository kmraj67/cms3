<?php
    $controller = $this->request->params['controller'];
    $action = $this->request->params['action'];
    //pr($controller); pr($action); die;
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= $base_url ?>admin/dashboard"><?= SITE_TITLE ?></a>
    </div>
    
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= isset($loggedInUser->full_name)?$loggedInUser->full_name:'Admin' ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?= $base_url ?>admin/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?= $base_url ?>admin/settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?= $base_url ?>admin/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php if($controller=='Analytics' && $action=='dashboard'){echo 'active';} ?>">
                <a href="<?= $base_url ?>admin/dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="<?php if($controller=='Users'){echo 'active';} ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#user-list">
                    <i class="fa fa-fw fa-users"></i> Users Management <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="user-list" class="sub-menue <?php if($controller!='Users'){echo 'collapse';} ?>">
                    <li class="<?php if($controller=='Users' && $action=='add'){echo 'active';} ?>">
                        <a href="<?= $base_url ?>admin/users/add"><i class="fa fa-fw fa-plus"></i> Add User</a>
                    </li>
                    <li class="<?php if($controller=='Users' && $action=='index'){echo 'active';} ?>">
                        <a href="<?= $base_url ?>admin/users"><i class="fa fa-fw fa-list"></i> List User</a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($controller=='EmailTemplates'){echo 'active';} ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#email-templates-list">
                    <i class="fa fa-fw fa-envelope"></i> Email Templates <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="email-templates-list" class="sub-menue <?php if($controller!='EmailTemplates'){echo 'collapse';} ?>">
                    <li class="<?php if($controller=='EmailTemplates' && $action=='add'){echo 'active';} ?>">
                        <a href="<?= $base_url ?>admin/email-templates/add"><i class="fa fa-fw fa-plus"></i> Add Template</a>
                    </li>
                    <li class="<?php if($controller=='EmailTemplates' && $action=='index'){echo 'active';} ?>">
                        <a href="<?= $base_url ?>admin/email-templates"><i class="fa fa-fw fa-list"></i> List Templates</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>