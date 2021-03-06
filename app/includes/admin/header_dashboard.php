<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE ?> | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!--fontawesome5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/admin/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../assets/admin/css/OverlayScrollbars.min.css">
    <!--bootstrap select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../assets/admin/css/admin.css?id=<?php time(); ?>">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
</head>


<body class="hold-transition sidebar-mini layout-fixed">


    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v10.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat" attribution="page_inbox" page_id="112511400941122">
    </div>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=749751495614026&autoLogAppEvents=1" nonce="JUf8uuB4"></script>
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4
        <?php if ($_SESSION['position_id'] == 1) : ?>
    sidebar-admin
    <?php elseif ($_SESSION['position_id'] == 2) : ?>
      sidebar-faculty
    <?php else : ?>
      sidebar-monitoring
    <?php endif; ?>
        ">
            <!-- Brand Logo -->
            <a href="../index.php" class="brand-link d-flex align-items-center">
                <img src="../assets/imgs/logo.png" alt="TCS Monitoring" class="w-full brand-image">
                <span class="brand-text font-bold uppercase"><?php echo TITLE ?></span>
            </a>
            <?php include 'sidebar.php' ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="container-fluid relative">
                <img src="../assets/imgs/dashboard-banner.jpg" class="w-full h-full object-cover" alt="#">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div><!-- /.container-fluid -->

            <!-- /.content-header -->