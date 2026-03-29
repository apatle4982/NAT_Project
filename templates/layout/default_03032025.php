<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head> 
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
 
    <?= $this->Html->css(['/assets/libs/jsvectormap/css/jsvectormap.min']) ?>
     <!--datatable css-->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" /> 
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" /> 
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> 
   
    <!-- Head Css -->   
    <!-- Layout config Js -->
    <?= $this->Html->script(["/assets/js/layout"]) ?>
    <!-- Bootstrap Css -->
    <?= $this->Html->css(['/assets/css/bootstrap.min', '/assets/css/icons.min', '/assets/css/app.min','/assets/css/custom']) ?>
    <!-- Head Css END --> 
    <!-- One of the following themes -->
    <!-----NEW-------->
    <?= $this->Html->css(['/assets/libs/@simonwep/pickr/themes/classic.min', '/assets/libs/@simonwep/pickr/themes/monolith.min', '/assets/libs/@simonwep/pickr/themes/nano.min','/assets/libs/multi.js/multi.min','/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete']) ?>
       
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-----NEW End-------->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    
</head>
<body>
    <div id="layout-wrapper">
        <?= $this->element('header'); ?> 
        <?php if(!empty($LoggedInUsers['user_id']) && $LoggedInUsers['user_id'] !='') {?>
        <?= $this->element('nav'); ?> 
        <?php } ?>
       
        <div class="main-content">
            <div class="page-content">
				
                <div class="container-fluid lrs-frm sml-field">


                    <?php if(!empty($LoggedInUsers['user_id']) && $LoggedInUsers['user_id'] !='') {?>
                        <!-- Page title and quick search -->
                        <div class="row" style="margin-bottom:0px;">
                            <div class="col-12">
                                <div class="title-bar">
                                    <div class="page-title-box-lrs d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0"><?php echo (isset($pageTitle) ? __($pageTitle) : ''); ?></h4>
                                        <!-- (Use This Section to import partner CSV sheet.) -->
                                    </div>
                                    <?= $this->element('quicksearch'); ?> 
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        <?= $this->element('footer'); ?> 
        </div>
    </div>
    
    <!--<script type="text/javascript">
        //var SITE_URL_JS = '<?php //= SITE_URL ?>';
    </script>-->

    <?= $this->Html->script(["/assets/libs/bootstrap/js/bootstrap.bundle.min","/assets/libs/feather-icons/feather.min","/assets/libs/node-waves/waves.min"
    /* "/assets/libs/simplebar/simplebar.min", 
    "/assets/js/pages/plugins/lord-icon-2.1.0",
    "/assets/js/plugins",
    "/assets/libs/apexcharts/apexcharts.min",
    "/assets/libs/jsvectormap/js/jsvectormap.min",
    "/assets/libs/jsvectormap/maps/world-merc", 
    "/assets/js/pages/dashboard-analytics.init"*/
    ]) ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
   
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script> 
   
 
    <?= $this->Html->script(["/assets/js/app"]) ?> <!--"/assets/js/pages/datatables.init",-->

<!-----NEW-------->
    <!--select2 cdn-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <?php //= $this->Html->script(["/assets/js/pages/select2.init"]) ?>
     <!-- multi.js Export setting pg-->   <!-- init js Export setting pg -->
    
    <?= $this->fetch('script') ?>
    <!-----NEW End--------> 
    <?= $this->Html->script(["/assets/libs/multi.js/multi.min","/assets/js/pages/form-advanced.init", "/assets/js/lrscommon"]) ?>
	
</body>
</html>