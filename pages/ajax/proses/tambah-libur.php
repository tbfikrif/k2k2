<?php
    if(isset($_POST['nama']) && isset($_POST['tgl'])){
        $nama_libur = antiInjection($_POST["nama"]);
        $tgl = antiInjection($_POST["tgl"]);
        $tgl1 = substr($tgl,0,11);
        $tgl2 = substr($tgl,13,25);
        $qry = "INSERT INTO tb_tgllibur (nama_libur,tglawal,tglakhir) VALUES ('$nama_libur',STR_TO_DATE('$tgl1', '%m/%d/%Y'),STR_TO_DATE('$tgl2', '%m/%d/%Y'))";
        $errmsgTambahLibur=null;
        inUpDel($qry,$errmsgTambahLibur);
        echo $errmsgTambahLibur;
    }
?>