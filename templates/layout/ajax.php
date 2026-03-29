<!doctype html>
<html lang="en" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- Layout config Js -->
    <?= $this->Html->script(["/assets/js/layout"]) ?>
    <!-- Bootstrap Css -->
    <?= $this->Html->css(['/assets/css/bootstrap.min', '/assets/css/icons.min', '/assets/css/app.min','/assets/css/custom']) ?>
</head>
<body>
<div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container"> 
            <?php echo $this->fetch('content'); ?>
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                            Lender Recording Services provides the real eState community (including lenders, title companies, attorneys, etc.) with a single contact vendor specializing in facilitating the delivery and return of real eState documents to the appropriate County recorder as well as City, and State recording jurisdictions nationwide. LRS understands the need to efficiently and effectively record real eState documents for our clients. Services include electronic filing; walk up services and standard service protocols.
                            </p>

                            <p class="mb-10 text-muted">
                                Developed By: <a target="_blank" href="https://www.tiuconsulting.com/" class="fw-bold text-primary text-decoration-underline">tiuconsulting</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

    <?= $this->Html->script(["/assets/libs/particles.js/particles","/assets/js/pages/particles.app","/assets/js/pages/password-addon.init"]) ?> 
</body>

</html>