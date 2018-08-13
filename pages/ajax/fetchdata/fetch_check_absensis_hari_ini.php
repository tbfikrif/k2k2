<?php
//fetch.php
unset($_SESSION["isAbsenToday"]);
date_default_timezone_set('Asia/Jakarta');
$today1 = date("Y-m-d");
$namahari = date('D', strtotime($today1));
if (strpos($_SESSION['jabatan'], 'Admin') !== false) {
    $_SESSION["isAbsenToday"] = -3;
} elseif ($namahari == "Sat" || $namahari == "Sun") {
    $_SESSION["isAbsenToday"] = -2;
} elseif (time() <= strtotime("04:00 AM")) {
    $_SESSION["isAbsenToday"] = -1;
} else {
    unset($_SESSION["isAbsenToday"]);
    $conn = createConn();
    $id_anggota = $_SESSION['id_anggota'];
    $query = "SELECT id_anggota FROM tb_anggota WHERE id_anggota IN (SELECT id_anggota FROM tb_detail_absen WHERE id_anggota='$id_anggota' AND tanggal='$today1')";
    $res = $conn->query($query);
    $row = $res->num_rows;
    if ($row > 0) {
        $query2 = "SELECT status_id,jam_masuk,jam_keluar FROM tb_detail_absen WHERE id_anggota='$id_anggota' AND tanggal='$today1'";
        $res2 = $conn->query($query2);
        if (!$res2) {
            $errmsg = "Query: " . $query2 . " Error: " . $conn->error;
            //echo "Error: " . $qry . "<br>" . $conn->error;
            $conn->close();
            echo $errmsg;
        } else {
            $row2 = $res2->fetch_assoc();
            if ($row2['jam_keluar'] === null && ($row2['status_id'] == 1 || $row2['status_id'] == 2 || $row2['status_id'] == 7)) {
                date_default_timezone_set('Asia/Jakarta');
                $current_time=date("H:i:s");
                if (strtotime($row2['jam_masuk']) >= strtotime('09:00')) {
                    $jam_keluar = "17:00:00";
                } else {
                    $jam_keluar = date('H:i:s', strtotime($row2['jam_masuk'] . ' + 8hours'));
                }
                if  (strtotime($current_time) >= strtotime($jam_keluar)) {
                    $_SESSION["isAbsenToday"] = 2;
                } else {
                    $_SESSION["isAbsenToday"] = 1;
                }
            } else {
                $_SESSION["isAbsenToday"] = 3;
            }
        }
    } else {
        $_SESSION["isAbsenToday"] = 0;
    }
}
echo $_SESSION["isAbsenToday"];