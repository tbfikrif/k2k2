<?php
if (!defined('DIDALAM_INDEX_PHP')) {
    //echo "Dilarang broh!";
    header("Location: ../../tampil/home");
} else {
    if ($_SESSION["isAbsenToday"] == -3) {
        echo '<script>alert("Admin tidak bisa absen ;)");window.location="tampil/home"</script>';
    } elseif ($_SESSION["isAbsenToday"] == -2) {
        echo '<script>alert("Absen ga bisa di hari Sabtu atau Minggu cuy!");window.location="tampil/home"</script>';
    } else
    if ($_SESSION["isAbsenToday"] == -1) {
        echo '<script>alert("Absen cuma bisa setelah jam 04:00 AM cuy!");window.location="tampil/home"</script>';
    } elseif ($_SESSION["isAbsenToday"] == 3) {
        echo '<script>alert("Kan sudah absen hari ini! Masa lupa?");window.location="tampil/data-absensi"</script>';
    } elseif ($_SESSION["isAbsenToday"] == 1) {
        $conn=createConn();
        $today1 = date("Y-m-d");
        $qry="SELECT jam_masuk FROM tb_detail_absen WHERE id_anggota='$_SESSION[id_anggota]' AND tanggal='$today1'";
        $res = $conn->query($qry);
        $row = $res->fetch_assoc();
        $jam_keluar=null;
        if (strtotime($row['jam_masuk']) >= strtotime('09:00')) {
            $jam_keluar = "17:00:00";
        } else {
            $jam_keluar = date('H:i:s', strtotime($row['jam_masuk'] . ' + 8hours'));
        }
        echo '<script>alert("Anda bisa absen pulang minimal pukul '.$jam_keluar.'");window.location="tampil/data-absensi"</script>';
    } elseif($_SESSION["isAbsenToday"] == 2) {
        readfile('pages/views/forms/submit-absensi.html');
    } elseif($_SESSION["isAbsenToday"] == 0) {
        readfile('pages/views/forms/submit-absensi.html');
    }
}
