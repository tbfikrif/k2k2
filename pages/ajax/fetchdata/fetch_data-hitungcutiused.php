<?php  
    //fetch.php
    if (isset($_POST['start']) && isset($_POST['end'])) {
        include "../../../con_db.php";
        include "../../../fungsi_kakatu.php";
        $tglawal=$_POST['awal'];
        $tglakhir=$_POST['akhir'];
        $cutiUsed = countCuti($tglawal,$tglakhir,$koneksi);
        session_start();
        $data = array(
            'sisaCuti'  => $_SESSION["sisacuti"],
            'cutiUsed'  => $cutiUsed
           );
        echo json_encode($data);
    } 
?>