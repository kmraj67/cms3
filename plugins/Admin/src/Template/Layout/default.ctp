<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= $base_url ?>admin/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= $base_url ?>admin/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= $base_url ?>admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom CSS -->
    <link href="<?= $base_url ?>admin/css/custom.css" rel="stylesheet">
    
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

    <div id="wrapper">
        
        <?= $this->element('Layout/nav') ?>
        
        <div id="page-wrapper">
            <div class="container-fluid">
                <?= $this->fetch('content') ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?= $this->element('Layout/ajax_loader') ?>
    <?= $this->element('Layout/alert') ?>
    <?= $this->element('medium_modal') ?>

    <!-- jQuery -->
    <script src="<?= $base_url ?>admin/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $base_url ?>admin/js/bootstrap.min.js"></script>

    <!-- Jquery validations -->
    <script src="<?= $base_url ?>admin/js/jquery.validate.min.js"></script>
    <script src="<?= $base_url ?>admin/js/additional-methods.min.js"></script>
    
    <!-- Custom js -->
    <script src="<?= $base_url ?>admin/js/custom.js"></script>
    
    <?php if($this->request->params['controller'] == 'EmailTemplates'): ?>
    <script src="<?= $base_url ?>admin/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'editor1' );
    </script>
    <?php endif; ?>
    
    <?php if($this->request->params['controller'] == 'Analytics'): ?><!-- Morris Charts JavaScript -->
    <!--<script src="<?= $base_url ?>admin/js/plugins/morris/raphael.min.js"></script>
    <script src="<?= $base_url ?>admin/js/plugins/morris/morris.min.js"></script>
    <script src="<?= $base_url ?>admin/js/plugins/morris/morris-data.js"></script>-->
    <?php endif; ?>
</body>

</html>