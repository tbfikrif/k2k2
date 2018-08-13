<?php
chdir(dirname(__FILE__));
include "../../fungsi_kakatu.php";
date_default_timezone_set('Asia/Jakarta');
//Ambil Tanggal hari ini format Y-m-d
//Ambil Tanggal Hari ini format m-d untuk reset cuti
$tgl_now2 = date("m-d");
//Reset Cuti jika 31 desember
if ($tgl_now2 == "12-31") {
    $qry = "UPDATE tb_cuti_anggota SET cuti_used=0";
    inUpDel($qry, $errmsg);
    if ($errmsg !== null) {
        echo "Error: " . $errmsg;
    }
}
//nama hari
$tgl_now = date("Y-m-d");
$dayname = date('D', strtotime($tgl_now));
$latKantor = -6.8869112;
$lngKantor = 107.6168524;
$errmsg = null;
//Cek jika bukan hari sabtu dan minggu
if ($dayname != "Sun" && $dayname != "Sat") {
    autoAbsen($latKantor, $lngKantor, $tgl_now, $errmsg);
    echo $errmsg;
    //Emit Data dengan Socket IO
    emitData();
}

//Reset Cuti jika 31 desember
if ($tgl_now2 == "12-31") {
    $qry = "UPDATE tb_cuti_anggota SET cuti_used=0";
    inUpDel($qry, $errmsg);
    if ($errmsg !== null) {
        echo "Error: " . $errmsg;
    }
}
