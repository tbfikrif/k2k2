<?php
    //include "../../../fungsi_kakatu.php";
    $errmsgEditLibur=null;
    if (isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['start']) && isset($_POST['end'])) {
        $id_libur = antiInjection($_POST["id"]);
        $nama_libur = antiInjection($_POST["nama"]);
        $tgl1 = antiInjection($_POST["start"]);
        $tgl2 = antiInjection($_POST["end"]);
        $qry = "UPDATE tb_tgllibur SET nama_libur='$nama_libur',tglawal='$tgl1',tglakhir=('$tgl2'- interval 1 day) WHERE id='$id_libur'";
        inUpDel($qry,$errmsgEditLibur);
        echo $errmsgEditLibur;
    } else if(isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['tgl'])){
        $id_libur = antiInjection($_POST["id"]);
        $nama_libur = antiInjection($_POST["nama"]);
        $tgl = antiInjection($_POST["tgl"]);
        $tgl1 = substr($tgl,0,11);
        $tgl2 = substr($tgl,13,25);
        $qry = "UPDATE tb_tgllibur SET nama_libur='$nama_libur',tglawal=STR_TO_DATE('$tgl1', '%m/%d/%Y'),tglakhir=STR_TO_DATE('$tgl2', '%m/%d/%Y') WHERE id='$id_libur'";
        inUpDel($qry,$errmsgEditLibur);
        echo $errmsgEditLibur;
    }
    
    
?>