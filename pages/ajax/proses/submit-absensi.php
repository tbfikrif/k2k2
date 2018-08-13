
<?php
//Composer penggunaan library ElephantIO untuk SOCKET IO
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
//session_start();
//include "../../con_db.php"; //sambung ke database
//include "../../fungsi_kakatu.php"; //panggil fungsi
$id = $_SESSION["id_anggota"];
$target_dir = "dist/fotolokasi/";
$ukuran = 2000000;
//mengambil nilai dari form
$latKantor = getLastConfig("latKantor");
$lngKantor = getLastConfig("lngKantor");
$status = null;
$keterangan = null;
$tgl_awal = null;
$tgl_akhir = null;
$filename = null;
$url_location = null;
$errmsg = null;
$scsmsg = null;
$latitude = null;
$longitude = null;
$hariini1 = date("Y-m-d");
//jenis asen masuk atau keluar
$jenis = "masuk";
//Validasi Absen Hari ini

$isAbsen = "SELECT id_anggota,jam_masuk,jam_keluar,status_id,latitude,longitude FROM tb_detail_absen WHERE id_anggota='$id' AND tanggal='$hariini1'";
$conn = createConn();
$res = $conn->query($isAbsen);
if (!$res) {
    $errmsg = "Query: " . $qry . " Error: " . $conn->error;
    //echo "Error: " . $qry . "<br>" . $conn->error;
    $conn->close();
} elseif ($res->num_rows > 0) {
    //Jika sudah Absen masuk
    if (isset($_POST['latitude']) && !empty($_POST['latitude'])) {
        //Check Absen keluar
        $row=$res->fetch_assoc();
        $latMasuk=$row['latitude'];
        $lngMasuk=$row['longitude'];
        if ($row['jam_keluar']===null) {
            $now = date("H:i:s");
            $queryKeluar = "UPDATE tb_detail_absen SET jam_keluar='$now' WHERE id_anggota='$id' AND tanggal='$hariini1'";
            inUpDel($queryKeluar,$errmsg);
            $status=$row['status_id'];
            emitData();
            $tgl_awal = $row['jam_masuk'];
            $tgl_akhir = $now;
            $jenis = "keluar";
        } else {
            $errmsg = "Anda sudah mengisi absen hari ini!";
        }
        
    }
} else {
    //Jika Belum Absen
    if (isset($_POST['latitude']) && !empty($_POST['latitude'])) {
        $latitude = antiInjection($_POST['latitude']);
        $longitude = antiInjection($_POST['longitude']);
        $url_location = "https://maps.google.com/?q=" . trim($latitude) . "," . trim($longitude);
        if (isset($_POST["status"])) {
            $status = $_POST["status"];
            switch ($status) {
                case '1':
                    date_default_timezone_set('Asia/Jakarta');
                    $tgl_awal = date("Y-m-d");
                    $tgl_akhir = date("Y-m-d");
                    break;
                case '2':
                    if (isset($_POST['keterangan_hadirdiluar']) && !empty($_POST['keterangan_hadirdiluar'])) {
                        date_default_timezone_set('Asia/Jakarta');
                        $tgl_awal = date("Y-m-d");
                        $tgl_akhir = date("Y-m-d");
                        $keterangan = antiInjection($_POST['keterangan_hadirdiluar']);
                        $filename = "image_hadirdiluar";
                    } else {
                        $errmsg = "Keterangan Tugas Kantor tidak boleh kosong!";
                    }
                    break;
                case '3':
                    if (isset($_POST['keterangan_sakit']) && !empty($_POST['keterangan_sakit'])) {
                        if (isset($_POST['tglRentangSakit']) && !empty($_POST['tglRentangSakit'])) {
                            $keterangan = antiInjection($_POST['keterangan_sakit']);
                            $tgl = antiInjection($_POST['tglRentangSakit']);
                            $tgl_awal = formatDateSql(substr($tgl, 0, 11));
                            $tgl_akhir = formatDateSql(substr($tgl, 13, 25));
                            $filename = "image_sakit";
                        } else {
                            $errmsg = "Tanggal Sakit tidak boleh kosong!";
                        }
                    } else {
                        $errmsg = "Keterangan Sakit tidak boleh kosong";
                    }
                    break;
                case '4':
                    if (isset($_POST['keterangan_izin']) && !empty($_POST['keterangan_izin'])) {
                        if (isset($_POST['tglRentangIzin']) && !empty($_POST['tglRentangIzin'])) {
                            $keterangan = antiInjection($_POST['keterangan_izin']);
                            $tgl = antiInjection($_POST['tglRentangIzin']);
                            $tgl_awal = formatDateSql(substr($tgl, 0, 11));
                            $tgl_akhir = formatDateSql(substr($tgl, 13, 25));
                            $filename = "image_izin";
                        } else {
                            $errmsg = "Tanggal Izin tidak boleh kosong!";
                        }
                    } else {
                        $errmsg = "Keterangan Izin tidak boleh kosong";
                    }
                    break;
                case '5':
                    if (isset($_POST['keterangan_cuti']) && !empty($_POST['keterangan_cuti'])) {
                        if (isset($_POST['tglRentangCuti']) && !empty($_POST['tglRentangCuti'])) {
                            $keterangan = antiInjection($_POST['keterangan_cuti']);
                            $tgl = antiInjection($_POST['tglRentangCuti']);
                            $tgl_awal = formatDateSql(substr($tgl, 0, 11));
                            $tgl_akhir = formatDateSql(substr($tgl, 13, 25));
                            $filename = "image_cuti";
                        } else {
                            $errmsg = "Tanggal Cuti tidak boleh kosong!";
                        }
                    } else {
                        $errmsg = "Keterangan Cuti tidak boleh kosong";
                    }
                    break;
                case '7':
                    if (isset($_POST['keterangan_kerjaremote']) && !empty($_POST['keterangan_kerjaremote'])) {
                        date_default_timezone_set('Asia/Jakarta');
                        $tgl_awal = date("Y-m-d");
                        $tgl_akhir = date("Y-m-d");
                        $keterangan = antiInjection($_POST['keterangan_kerjaremote']);
                        $filename = "image_kerjaremote";
                    } else {
                        $errmsg = "Keterangan Kerja Remote tidak boleh kosong!";
                    }
                    break;
            }
        }
    } else {
        $errmsg = "Anda harus mengizinkan Permintaan Lokasi untuk bisa absen";
    }
    //Ambil Jarak
    //$filename = $_FILES[$filename2]["name"];
    if ($errmsg === null) {
        $distance = getDistance($latitude, $longitude, $latKantor, $lngKantor);
        if ($status == '1') {
            if ($distance <= 200) {
                //call fungsi submit absensi
                submitAbsensi($id, $status, $keterangan, $latitude, $longitude, $tgl_awal, $tgl_akhir, $target_dir, $filename, $ukuran, $errmsg, $scsmsg);
            } else {
                $errmsg = 'Absen Hadir Gagal karena Anda berada ' . round($distance / 1000, 3) . 'km dari kantor';
            }
        } else {
            if ($tgl_awal == $tgl_akhir) {
                //call fungsi submit absensi
                submitAbsensi($id, $status, $keterangan, $latitude, $longitude, $tgl_awal, $tgl_akhir, $target_dir, $filename, $ukuran, $errmsg, $scsmsg);
            } else {
                if ($status == '5') {
                    $cutiUsed = countCuti($tgl_awal, $tgl_akhir, $koneksi);
                    //echo $cutiUsed;
                    if ($cutiUsed <= $_SESSION['sisacuti'] && $_SESSION['sisacuti'] > 0) {
                        submitAbsensi($id, $status, $keterangan, $latitude, $longitude, $tgl_awal, $tgl_akhir, $target_dir, $filename, $ukuran, $errmsg, $scsmsg);
                    } else {
                        $errmsg = 'Cuti yang digunakan ' . $cutiUsed . ' hari melebihi SISA CUTI anda ' . $_SESSION['sisacuti'] . ' hari!';
                    }
                } else {
                    submitAbsensi($id, $status, $keterangan, $latitude, $longitude, $tgl_awal, $tgl_akhir, $target_dir, $filename, $ukuran, $errmsg, $scsmsg);
                }
            }
        }
    } 
}

//Pesan WA
$pesan = array(
    'errmsg' => $errmsg,
    'scsmsg' => $scsmsg,
    'nama' => $_SESSION['nama'],
    'status' => $status,
    'keterangan' => $keterangan,
    'tgl1' => $tgl_awal,
    'tgl2' => $tgl_akhir,
    'sisacuti' => $_SESSION['sisacuti'],
    'jenis' => $jenis
);
echo json_encode($pesan);
?>

