<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="<?= $base_url ?>admin/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>admin/css/login.css" rel="stylesheet">
    
    <!--<link href="{{ URL::asset('font-awesome-4.1.0/css/font-awesome.min.css') }}" rel="stylesheet">-->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript">
        var BASE_URL = '<?= $base_url ?>';
    </script>
</head>

<body>
    <div id="wraper">
        <!-- Navigation section start --
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <!-- Nav header start --
            <div class="navbar-header">
                <a class="navbar-brand">App Admin</a>
            </div>
            <!-- Nav header end --
        </nav>
        <!-- Navigation section end -->
        
        <!-- Page container start -->
        <div class="container login-container">
            
            <div class="row" style="margin-top: 100px;">
                <div class="col-md-4 col-md-offset-4">        
                    <!-- Panel start -->
                    
                    <?= $this->Flash->render() ?>
                    
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
        <!-- Page container end -->
    </div>
</body>
<script src="<?= $base_url ?>admin/js/jquery-1.11.0.js"></script>
<script src="<?= $base_url ?>admin/bootstrap-3.3.5/js/bootstrap.min.js"></script>

<!-- Jquery validations -->
<script src="<?= $base_url ?>admin/js/jquery.validate.min.js"></script>
<script src="<?= $base_url ?>admin/js/additional-methods.min.js"></script>
<!-- Custom js -->
<script src="<?= $base_url ?>admin/js/custom.js"></script>
<script type="text/javascript"></script>
</html>