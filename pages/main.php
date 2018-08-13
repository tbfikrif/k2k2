<?php
if (!defined('DIDALAM_INDEX_PHP')) {
    //echo "Dilarang broh!";
    header("Location: tampil/home");
    exit();
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "chart-absensi-hari-ini")) {
    include_once "pages/ajax/fetchdata/fetch_chart-absenhariini.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "legenda-terlambat")) {
    include_once "pages/ajax/fetchdata/fetch_legend_terlambat.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "session-jabatan")) {
    include_once "pages/ajax/fetchdata/fetch_session_admin.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "data-libur")) {
    include_once "pages/ajax/fetchdata/fetch_data_libur.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "detail-delete-libur")) {
    include_once "pages/ajax/fetchdata/fetch_data_libur-fordelete.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "nama-anggota")) {
    include_once "pages/ajax/fetchdata/fetch-nama-anggota.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "sisa-cuti")) {
    include_once "pages/ajax/fetchdata/fetch-sisa-cuti.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "data-absen")) {
    include "pages/ajax/fetchdata/fetch_data_absen.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "detail-absen")) {
    include "pages/ajax/fetchdata/fetch_detail_absen.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-fetchdata") && ($_GET["sidebar-menu"] == "check-absen")) {
    include "pages/ajax/fetchdata/fetch_check_absensis_hari_ini.php";
} 
//Ajax Proses
elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-proses") && ($_GET["sidebar-menu"] == "submit-absensi")) {
    include_once "pages/ajax/proses/submit-absensi.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-proses") && ($_GET["sidebar-menu"] == "tambah-libur")) {
    include_once "pages/ajax/proses/tambah-libur.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-proses") && ($_GET["sidebar-menu"] == "edit-libur")) {
    include_once "pages/ajax/proses/edit-libur.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "ajax-proses") && ($_GET["sidebar-menu"] == "delete-libur")) {
    include_once "pages/ajax/proses/delete-libur.php";
}
//End Ajax Proses

//Proses CronJob
/*
elseif ((isset($_GET["action"])) && ($_GET["action"] == "cronjob-proses") && ($_GET["sidebar-menu"] == "notif-absen")) {
    include_once "pages/cronjob/admin_absen_notif.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "cronjob-proses") && ($_GET["sidebar-menu"] == "auto-absen")) {
    include_once "pages/cronjob/admin_auto_absen.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "cronjob-proses") && ($_GET["sidebar-menu"] == "auto-absen-alpha")) {
    include_once "pages/cronjob/admin_auto_absen_alpha.php";
}*/
//End Proses CronJob
else {
    ?>

    <!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,initial-scale=1.0, user-scalable=no">
        <title> Kinest Kreatif Ideata </title>
        <base href="<?php echo $obsolutePath ?>">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="dist/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="dist/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.css">
        <!-- Overlay CSS -->
        <link rel="stylesheet" href="dist/css/overlay.css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="dist/css/animate.css">
        <!-- Image Prev CSS -->
        <link rel="stylesheet" href="dist/css/img-prev.css">
        <!-- Morris charts -->
        <link rel="stylesheet" href="bower_components/morris.js/morris.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="dist/css/profile.css">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            * {
                /**border:1px dotted red;**/
            }
            @import url('https://fonts.googleapis.com/css?family=Dosis');
        </style>

       <link rel="shortcut icon" href="dist/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="dist/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.css">
        <!-- Overlay CSS -->
        <link rel="stylesheet" href="dist/css/overlay.css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="dist/css/animate.css">
        <!-- Image Prev CSS -->
        <link rel="stylesheet" href="dist/css/img-prev.css">
        <!-- Morris charts -->
        <link rel="stylesheet" href="bower_components/morris.js/morris.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="dist/css/profile.css">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            * {
                /**border:1px dotted red;**/
            }
            @import url('https://fonts.googleapis.com/css?family=Dosis');
        </style>

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="bower_components/jquery-ui/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Bootstrap show password 1.1.2 -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.1.2/bootstrap-show-password.js"></script>
        <!-- Select2 -->
        <script type="text/javascript" src="bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- ChartJS -->
        <script type="text/javascript" src="bower_components/chart.js/Chart.js"></script>

        <!-- InputMask -->
        <script type="text/javascript" src="plugins/input-mask/jquery.inputmask.js"></script>
        <script type="text/javascript" src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script type="text/javascript" src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
        <script type="text/javascript" src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script type="text/javascript" src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script type="text/javascript" src="bower_components/raphael/raphael.min.js"></script>
        <script type="text/javascript" src="bower_components/morris.js/morris.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script type="text/javascript" src="plugins/iCheck/icheck.min.js"></script>
        <!-- AdminLTE App -->
        <script type="text/javascript" src="dist/js/adminlte.min.js"></script>
        <!-- FastClick -->
        <script type="text/javascript" src="bower_components/fastclick/lib/fastclick.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
        <script type="text/javascript" src="inputmask/jquery.number.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <script type="text/javascript" src="inputmask-jquery/dist/jquery.maskMoney.js"></script>
        <!-- Google Maps API With API KEY -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo getLastConfig('api_key_google')?>"></script>
        <!-- fullCalendar -->
        <script src="bower_components/moment/moment.js"></script>
        <script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

        <!-- Socket IO -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
        <!-- bootbox code -->
        <script type="text/javascript" src="bower_components/bootbox/bootbox.min.js"></script>
        <!-- Page specific script -->
        <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.3/js/dataTables.select.min.js"></script>
        <!-- Untuk COnvert datatables ke PDF CSV PRINT EXCEL -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
        <!--END Untuk COnvert datatables ke PDF CSV PRINT EXCEL -->

        <!--FUNGSI KAKATU DAN CONFIG -->
        <script type="text/javascript" src="fungsi_kakatu.js"></script>

    </head>
    <!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

    <body class="hold-transition skin-blue sidebar-mini" id="updateSemua">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="tampil/home" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        <b>K</b>
                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-sm"> Kinest Kreatif Ideata </span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <?php
//list($one, $two) = explode(",", $_SESSION['jabatan'], 2);
    $sql1 = "SELECT id_anggota, foto_profile FROM tb_anggota WHERE id_anggota ='$_SESSION[id_anggota]' ";
    $result1 = mysqli_query($koneksi, $sql1);
    $values1 = mysqli_fetch_assoc($result1);
    $id_anggota = $values1['id_anggota'];
    //Hitung Total AKomodasi Bulan Ini
    $sql2 = "SELECT SUM(credit_in) AS total_credit FROM tb_detail_absen WHERE id_anggota='$_SESSION[id_anggota]' AND MONTH(tanggal)= MONTH(CURRENT_DATE()) AND credit_stat='unpaid' GROUP BY id_anggota";
    $result2 = mysqli_query($koneksi, $sql2);
    $values2 = mysqli_fetch_assoc($result2);
    $jumlah2 = $values2['total_credit'];
    $sql3 = "SELECT cuti_used,cuti_qty FROM tb_cuti_anggota WHERE id_anggota ='$_SESSION[id_anggota]' ";
    $result3 = mysqli_query($koneksi, $sql3);
    $values3 = mysqli_fetch_assoc($result3);
    $jumlah3 = $values3['cuti_qty'] - $values3['cuti_used'];
    $_SESSION['sisacuti'] = $jumlah3;
    $id_anggota = $values1['id_anggota'];
    if (strpos($_SESSION['jabatan'], 'Admin') !== false) {
        $sql = "SELECT COUNT(id_pembayaran) as jumlah FROM `tb_pembayaran` WHERE `status`= '0'";
        $result = mysqli_query($koneksi, $sql);
        $values = mysqli_fetch_assoc($result);
        $jumlah = $values['jumlah'];
        $notif_string = "Ada " . $jumlah . " yang belum di reimbers";
    } elseif (strpos($_SESSION['jabatan'], 'Admin') === false) {
        $sql = "SELECT COUNT(id_pembayaran) as jumlah FROM `tb_konfirmasi` WHERE `konfirm_admin`= '2' AND id_anggota = '$_SESSION[id_anggota]'";
        $result = mysqli_query($koneksi, $sql);
        $values = mysqli_fetch_assoc($result);
        $jumlah = $values['jumlah'];
        $notif_string = "Anda punya " . $jumlah . " konfirmasi reimbers";
    }
    ?>
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Notifications Menu -->
                                <li id="navbar-sisacuti">
                                    <a style="padding-top: 0px;padding-bottom: 0px;margin-top:0px;margin-bottom:0px;display:block;">
                                        <p style="padding-top: 0px;padding-bottom: 0px;margin-top:0px;margin-bottom:0px;font-size:10px;">Sisa Cuti</p>
                                        <p style="padding-top: 0px;padding-bottom: 0px;text-align: center;font-size:15px;">
                                            <span class="label label-default">
                                                <?php echo $jumlah3 ?> hari</span>
                                        </p>
                                    </a>
                                </li>
                                <li id="navbar-totalcredit">
                                    <a style="padding-top: 0px;padding-bottom: 0px;margin-top:0px;margin-bottom:0px;display:block;">
                                        <p style="padding-top: 0px;padding-bottom: 0px;margin-top:0px;margin-bottom:0px;font-size:10px;">Total AKomodasi</p>
                                        <p style="padding-top: 0px;padding-bottom: 0px;font-size:15px;">
                                            <span class="label label-default">
                                                <?php echo "Rp" . number_format($jumlah2) ?>
                                            </span>
                                        </p>
                                    </a>
                                </li>

                                <li class="dropdown notifications-menu">
                                    <!-- Menu toggle button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-danger" id="notif_label">
                                            <?php echo $jumlah ?>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu fadeIn animated">
                                        <li class="header">Anda Punya
                                            <?php echo $jumlah ?> Notifikasi ! </li>
                                        <li>
                                            <!-- Inner Menu: contains the notifications -->
                                            <ul class="menu">
                                                <li>
                                                    <!-- start notification -->
                                                    <a href="tampil/list-bayar/notif">
                                                        <?php
if (strpos($_SESSION['jabatan'], 'Admin') !== false) {
        ?>
                                                            <i class="fa fa-book text-aqua" style="float: center;"></i>
                                                                                                <?php echo $notif_string ?>
                                                            <?php
} elseif (strpos($_SESSION['jabatan'], 'Admin') === false) {
        ?>
                                                                <i class="fa fa-book text-aqua" style="float: center;"></i>
                                                                                                    <?php echo $notif_string ?>
                                                                <?php
}
    ?>
                                                    </a>
                                                </li>
                                                <!-- end notification -->
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!-- User Account Menu -->
                                <li class="dropdown user user-menu">
                                    <!-- Menu Toggle Button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!-- The user image in the navbar-->
                                        <?php
if ($values1['foto_profile'] != '-') {
        ?>
                                                                    <img alt="User Image" <?php echo "src='dist/fotoprofile/" . $values1['foto_profile'] . "'"; ?> class="user-image img-responsive">
                                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                            <span class="hidden-xs">
                                                <?php echo $_SESSION['nama']; ?>
                                            </span>
                                            <?php
} elseif ($values1['foto_profile'] == '-') {
        ?>
                                                                        <img alt="User Image" <?php echo "src='dist/fotoprofile/no-profile.jpg'"; ?> class="user-image img-responsive">
                                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                                <span class="hidden-xs">
                                                    <?php echo $_SESSION['nama']; ?>
                                                </span>
                                                <?php
}
    ?>
                                    </a>
                                    <ul class="dropdown-menu fadeIn animated">
                                        <!-- The user image in the menu -->
                                        <li class="user-header" style="height: 115px;">
                                            <?php
if ($values1['foto_profile'] != '-') {
        ?>
                                                <img alt="User Image" align="cen" <?php echo "src='dist/fotoprofile/" . $values1['foto_profile'] . "'"; ?> class="img-circle img-responsive pull-left">
                                                <?php
} elseif ($values1['foto_profile'] == '-') {
        ?>
                                                    <img alt="User Image" <?php echo "src='dist/fotoprofile/no-profile.jpg'"; ?> class="img-circle img-responsive pull-left">
                                                    <?php
}
    ?>
                                                        <p>
                                                            <?php echo $_SESSION['nama']; ?>
                                                            <br>
                                                            <?php echo $_SESSION['jabatan']; ?>
                                                        </p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="tampil/profile" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="login/proses-logout" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Control Sidebar Toggle Button -->
                            </ul>
                        </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php
if ($values1['foto_profile'] != '-') {
        ?>
                                    <img alt="User Pic" <?php echo "<img src='dist/fotoprofile/" . $values1['foto_profile'] . "'"; ?> class="img-circle img-responsive">
                                    <?php
} elseif ($values1['foto_profile'] == '-') {
        ?>
                                        <img alt="User Pic" <?php echo "<img src='dist/fotoprofile/no-profile.jpg'"; ?> class="img-circle img-responsive">
                                        <?php
}
    ?>
                        </div>
                        <div class="pull-left info">
                            <br>
                            <p>
                                <?php echo $_SESSION['nama']; ?>
                            </p>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree" id="sidebar-menu">
                        <li class="header">MENU</li>
                        <!-- Optionally, you can add icons to the links -->
                        <li>
                            <a href="tampil/home">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="tampil/list-bayar">
                                <i class="glyphicon glyphicon-usd"></i>
                                <span>Pembayaran</span>
                            </a>
                        </li>
                        <li id="menu_absensi" class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Absensi</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu" id="menu-absensi">
                                <li id="form_submit_absensi">
                                    <a href="tampil/form-absensi">
                                        <i class="glyphicon glyphicon-user"></i>
                                        <span> Form Absensi</span>
                                    </a>
                                    <li>
                                        <a href="tampil/data-absensi">
                                            <i class="fa fa-black-tie"></i> Data Absensi </a>
                                    </li>
                                    <li>
                                        <a href="tampil/calendar-absensi">
                                            <i class="fa fa-calendar"></i> Calendar Absensi </a>
                                    </li>
                            </ul>
                            </li>
                            <li id="menu_master" class="treeview">
                                <a href="#">
                                    <i class="fa fa-folder"></i>
                                    <span>Menu Admin</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="tampil/data-anggota">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span> Data Anggota</span>
                                        </a>
                                        <li>
                                            <a href="tampil/data-jabatan">
                                                <i class="fa fa-black-tie"></i> Data Jabatan </a>
                                        </li>
                                        <li>
                                            <a href="tampil/jenis-pembayaran">
                                                <i class="fa fa-cc-visa"></i> Jenis Pembayaran </a>
                                        </li>
                                        <li>
                                            <a href="tampil/data-absensi">
                                                <i class="fa fa-book"></i> Data Absensi </a>
                                        </li>
                                        <li>
                                            <a href="tampil/data-akomodasi">
                                                <i class="fa fa-money"></i> Data Uang Akomodasi </a>
                                        </li>
                                        <li>
                                            <a href="tampil/data-libur">
                                                <i class="fa fa-calendar"></i> Data Tanggal Libur</a>
                                        </li>
                                        <li>
                                            <a href="tampil/data-cuti">
                                                <i class="fa fa-files-o"></i> Data Quota Cuti </a>
                                        </li>
                                        <li>
                                            <a href="tampil/data-rekap">
                                                <i class="fa fa-table"></i> Data Rekap Absen </a>
                                        </li>
                                        <li>
                                            <a href="tampil/konfigurasi-kakatu">
                                                <i class="fa fa-key"></i> Konfigurasi Kakatu </a>
                                        </li>
                                </ul>
                                </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

        <?php
    if ($jumlah == "0") {
        ?>
                        <script type="text/javascript">
                            $("#notif_label").hide();
                        </script>
        <?php
}
    ?>

                            <!-- Content Wrapper. Contains page content -->
                            <div class="content-wrapper">
                                <!-- Content Header (Page header) -->
                                <section class="content-header">

                                </section>

                                <!-- Main content -->
                                <section class="content container-fluid">

                                    <!--------------------------
        | Your Page Content Here |
        -------------------------->
<?php
if ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "home")) {
        include_once "pages/home.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-anggota")) {
        include_once "pages/datalist/anggota.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "form-bayar")) {
        include_once "pages/forms/form_pembayaran.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "list-bayar")) {
        include_once "pages/datalist/pembayaran.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "form-anggota")) {
        include_once "pages/forms/form_add-anggota.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "detail-pembayaran")) {
        include_once "pages/detail_pembayaran.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "profile")) {
        include_once "pages/view_profile.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "form-edit-pembayaran")) {
        include_once "pages/forms/form_edit-pembayaran.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-jabatan")) {
        include_once "pages/datalist/jabatan.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "jenis-pembayaran")) {
        include_once "pages/datalist/jenis_pembayaran.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-absensi")) {
        include_once "pages/datalist/data_absen.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "calendar-absensi")) {
        include_once "pages/datalist/calendar-absensi.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "form-absensi")) {
        include_once "pages/forms/form_submit-absensi.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-akomodasi")) {
        include_once "pages/datalist/credits.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-cuti")) {
        include_once "pages/datalist/cuti.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-libur")) {
        include_once "pages/datalist/tgllibur.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-rekap")) {
        include_once "pages/datalist/rekap_absensi.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "konfigurasi-kakatu")) {
        include_once "pages/forms/form_konfigurasi.php";
    } elseif ((isset($_GET["action"])) && ($_GET["action"] == "proses-submit") && ($_GET["sidebar-menu"] == "absensi")) {
        include_once "pages/proses/proses_submit-absensi.php";
    } else {
        echo '<script>window.location="tampil/home"</script>';
    }
    ?>

                                </section>
                                <!-- /.content -->
                            </div>
                            <!-- /.content-wrapper -->

                            <!-- Main Footer -->
                            <footer class="main-footer">
                                <!-- Default to the left -->
                                <strong> OPERASIONAL KANTOR
                                    <a href="#"> KAKATU </a>
                                </strong>
                            </footer>
                            <!-- ./wrapper -->

    </body>
    <script>
        var sessionKakatu = <?php echo (strpos($_SESSION['jabatan'], 'Admin') !== false)?1:0; ?>;
        if (sessionKakatu==1) {
            $("#navbar-sisacuti").hide();
            $("#navbar-totalcredit").hide();
            $("#menu_master").show();
            $("#menu_absensi").hide();
        } else {
            $("#navbar-sisacuti").show();
            $("#navbar-totalcredit").show();
            $("#menu_master").hide();
            $("#menu_absensi").show();
        }
    </script>
    </html>
    <?php
}
?>
