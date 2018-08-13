<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
session_start();
define("DIDALAM_INDEX_PHP", true);
date_default_timezone_set('Asia/Jakarta');
require_once "con_db.php";
require_once "fungsi_kakatu.php";
$obsolutePath = 'https://localhost/kakatu/'; // EDIT
$today = date("Y-m-d");
$now = date("H:i:s");
//Proses Check Login
if (empty($_GET)) {
    header('Location: tampil/home');
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "login") && ($_GET["sidebar-menu"] == "form")) {
    include_once "pages/forms/form-login.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "login") && ($_GET["sidebar-menu"] == "proses-login")) {
    include_once "pages/proses/proses-login.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "setup") && ($_GET["sidebar-menu"] == "config")) {
    include_once "pages/proses/proses-submitconfig.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "setup") && ($_GET["sidebar-menu"] == "add-admin")) {
    include_once "pages/proses/proses-add-admin.php";
} elseif ((isset($_GET["action"])) && ($_GET["action"] == "login") && ($_GET["sidebar-menu"] == "proses-logout")) {
    include_once "pages/proses/proses-logout.php";
} else {
    if ($_SESSION["id_anggota"] == '') {
       echo '<script>alert("Anda Belum Login!");window.location="' . $obsolutePath . 'login/form"</script>';
    } else {
        include_once "pages/main.php";
    }
}
//End Proses Check Login
