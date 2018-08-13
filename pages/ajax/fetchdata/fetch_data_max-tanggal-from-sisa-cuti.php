<?php  
    //fetch.php
        include "../../../con_db.php";
        include "../../../fungsi_kakatu.php";
        session_start();
        //$sisaCuti=9;
        $akhir = countMaxDateFromSisaCuti($_SESSION["sisacuti"],$koneksi);
        //echo $tglawal;
        //var_dump($akhir);
        $awal= new DateTime();
        $begin=$awal->format('m/d/Y');
        $end=$akhir->format('m/d/Y');
        //echo $tglakhir;
        $data = array(
            'tglawal'  => $begin,
            'tglakhir'  => $end
        );
        echo json_encode($data);
?>