<?php
include "vendor/autoload.php";
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
//Fungsi Format Date Javascript to MySQL pakai PHP
function formatDateSql($tgl)
{
    $tgl = date('Y-m-d', strtotime($tgl));
    return $tgl;
}
//END Fungsi Format Date Javascript to MySQL pakai PHP

//Fungsi buat filter form dari XSS dan SQL Injection attack
function antiInjection($post_get)
{
    include "con_db.php";
    $post_get = mysqli_real_escape_string($koneksi, $post_get);
    $post_get = htmlspecialchars($post_get);
    return $post_get;
}
//Fungsi buat Koneksi
function createConn()
{
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "kakatuco_absensi";
    $conn = new mysqli($db_host, $db_user, $db_pass);
    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
    }
    $conn->select_db($db_name);
    return $conn;
}
//List Fungsi Submit Absensi
//fungsi ambil alamat dari lattitude
function getAddress($latitude, $longitude)
{
    if ($latitude !== null && $longitude !== null) {
        //Send request and receive json data by address
        $API_KEY = getLastConfig('api_key_google');
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=true&key=' . trim($API_KEY));
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        //Get address from json data
        $address = ($status == "OK") ? $output->results[0]->formatted_address : null;
        //Return address of the given latitude and longitude
        if ($address !== null) {
            return $address;
        } else {
            return "API KEY Google MAP anda tidak bekerja atau tidak diizinkan atau salah";
        }
    } else {
        return "null";
    }
}

//fungsi submit absensi
function submitAbsensi($id, $stat, $ket, $lat, $lng, $tgl1, $tgl2, $tgtdir, $filename, $size, &$errmsg, &$scsmsg)
{
    //query untuk memasukan ke database
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $now1 = date("H:i:s");
    $last_inserted_id = null;
    $conn = createConn();
    if ($conn->connect_error) {
        $errmsg = "Error: " . $conn->connect_error;
        die("Connection failed: " . $conn->connect_error);
    } else {
        //echo "<script>alert('Query: '".$qry." Error: ".$conn->error."')</script>";
        //echo "Error: " . $qry . "<br>" . $conn->error;
        if ($stmt = $conn->prepare("INSERT INTO tb_detail_absen (id_anggota, tanggal, jam_masuk,status_id,keterangan,latitude,longitude,tgl_awal,tgl_akhir) VALUES (?, '$today1','$now1',?,?,?,?,?,?)")) {
            $stmt->bind_param("sisddss", $id, $stat, $ket, $lat, $lng, $tgl1, $tgl2);
            $stmt->execute();
            $last_inserted_id = $stmt->insert_id;
            $stmt->close();
            $conn->close();
        } else {
            $errmsg = "Query: " . $qry . " Error: " . $conn->error;
        }
        //inUpDel($qry);
        if ($errmsg === null) {
            if ($stat != 1) {
                $foto = basename($_FILES[$filename]["name"]);
                if (!empty($foto)) {
                    uploadSingleGambar($last_inserted_id, $tgtdir, $filename, $size, $errmsg, $scsmsg);
                }
            }
            if ($errmsg === null) {
                //Tambah Credit
                topupCredit($last_inserted_id, $stat, $errmsg);
                if ($errmsg === null) {
                    //Update Cuti jika satus = 5
                    updateCutiUsed($id, $stat, $tgl1, $tgl2, $errmsg);
                    //$now1 = date("Y-m-d");
                    if ($errmsg === null) {
                        if ($tgl2 != $tgl1) {
                            cronRencanaAbsen($id, $stat, $ket, $lat, $lng, $tgl1, $tgl2, $last_inserted_id, $errmsg);
                        }
                        //Emit Data dengan Socket IO
                        emitData();
                    }
                }
            }
        }
    }
}

//Fungsi update cuti
function updateCutiUsed($id, $stat, $tgl1, $tgl2, &$errmsg)
{
    if ($stat == 5) {
        //$queryCuti= "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used +DATEDIFF(STR_TO_DATE('$tgl2', '%m/%d/%Y'),STR_TO_DATE('$tgl1', '%m/%d/%Y'))+1) WHERE id_anggota='$id'";
        $qry = "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used +1) WHERE id_anggota='$id'";
        inUpDel($qry, $errmsg);
        if ($errmsg !== null) {
            $qry = "DELETE FROM tb_detail_absen WHERE id='$id'";
            inUpDel($qry, $errmsg);
        }
        $sql3 = "SELECT cuti_used,cuti_qty FROM tb_cuti_anggota WHERE id_anggota ='$_SESSION[id_anggota]'";
        $conn = createConn();
        $result3 = $conn->query($sql3);
        $values3 = $result3->fetch_assoc($result3);
        $jumlah3 = $values3['cuti_qty'] - $values3['cuti_used'];
        $_SESSION['sisacuti'] = $jumlah3;
        $conn->close();
    }
}

//FUngsi Upload satu gambar
function uploadSingleGambar($id, $targetdir, $filename, $ukuran, &$errmsg, &$scsmsg)
{
    $target_file = $targetdir . basename($_FILES[$filename]["name"]);
    $file = basename($_FILES[$filename]["name"]);
    $newfilename = null;
    if (!empty($file)) {
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES[$filename]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        // Check if file already exists
        /*
        if (file_exists($target_file)) {
        ?>
        <script> alert("<?php echo "Maaf, file sudah ada."; ?>"); </script>
        <?php
        $uploadOk = 0;
        }*/
        // Check file size
        if ($_FILES[$filename]["size"] > $ukuran) {
            $errmsg = "Maaf, file anda terlalu besar!";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errmsg = "Maaf, hanya file format JPG, JPEG, PNG & GIF yang diizinkan!";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk != 0) {
            // if everything is ok, try to upload file
            $namatgl = new DateTime();
            $namatgl->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $namabaru = $namatgl->format('YmdHis');
            $sementara = explode(".", $_FILES[$filename]["name"]);
            $newfilename = $namabaru . '.' . end($sementara);
            if (move_uploaded_file($_FILES[$filename]["tmp_name"], $targetdir . $newfilename)) {
                $scsmsg = $newfilename;
            } else {
                $errmsg = "Maaf, terjadi error saat mengupload file anda!";
            }
            $qry = "UPDATE tb_detail_absen SET foto_lokasi = '$newfilename' WHERE id='$id'";
            inUpDel($qry, $errmsg);
        } else {
            $errmsg .= " File anda tidak terupload!";
            //Jika upload gagal, hapus data absensi yang masuk
            $qry = "DELETE FROM tb_detail_absen WHERE id='$id'";
            inUpDel($qry, $errmsg);
        }
    }
}

//Fungsi tambah credit atau uang akomodasi
function topupCredit($last_id, $stat, &$errmsg)
{
    if ($stat == 1 || $stat == 2 || $stat == 5) {
        $qry = "UPDATE tb_detail_absen a JOIN tb_credits_anggota b ON a.id_anggota=b.id_anggota SET a.credit_id=b.id,a.credit_in=(b.topup_credit+b.uang_makan),a.credit_stat='unpaid' WHERE a.id='$last_id'";
        inUpDel($qry, $errmsg);
        if ($errmsg !== null) {
            $qry = "DELETE FROM tb_detail_absen WHERE id='$last_id'";
            inUpDel($qry, $errmsg);
        }
    } else if ($stat == 7) {
        $qry = "UPDATE tb_detail_absen a JOIN tb_credits_anggota b ON a.id_anggota=b.id_anggota SET a.credit_id=b.id,a.credit_in=b.uang_makan,a.credit_stat='unpaid' WHERE a.id='$last_id'";
        inUpDel($qry, $errmsg);
        if ($errmsg !== null) {
            $qry = "DELETE FROM tb_detail_absen WHERE id='$last_id'";
            inUpDel($qry, $errmsg);
        }
    }
}
//Fungsi validasi Hitungan Cuti dari range tanggal
function countCuti($tgl_awal, $tgl_akhir, $conn)
{
    $begin = new DateTime($tgl_awal);
    $end = new DateTime($tgl_akhir);
    //$end = $end->modify('+1 day');
    //$tgl_akhir = $end->format('Y-m-d');
    //echo $tgl_awal." ".$tgl_akhir;
    //echo "<br>";
    //Query untuk mengambil tgl_libur yang berada diantara range tanggal yg dipilih

    //hitung interval
    $interval = DateInterval::createFromDateString('1 day');
    //dapatkan periode increment per 1 hari
    $period = new DatePeriod($begin, $interval, $end);
    //$tgl_onrange=null;
    //loop ke tanggal range increment satu hari
    $cutiUsed = 0;
    foreach ($period as $dt) {
        $validAbsen = true;
        $tgl_onrange = $dt->format("Y-m-d");
        $dayNameOnTglRange = date('D', strtotime($tgl_onrange));
        //Check tanggal apakah tanggal ada di hari sabtu atau tidak
        if ($dayNameOnTglRange == "Sat" || $dayNameOnTglRange == "Sun") {
            $validAbsen = false;
        } else {
            $SELECTLIBUR = "SELECT tglawal,tglakhir FROM tb_tgllibur WHERE (tglawal>=STR_TO_DATE('$tgl_awal', '%m/%d/%Y') AND tglakhir<=STR_TO_DATE('$tgl_akhir', '%m/%d/%Y')) AND tglakhir>=STR_TO_DATE('$tgl_awal', '%m/%d/%Y')";
            $reslibur = mysqli_query($conn, $SELECTLIBUR);
            while ($rowlibur = mysqli_fetch_array($reslibur)) {
                $awal = $rowlibur['tglawal'];
                $akhir = $rowlibur['tglakhir'];
                if ($tgl_onrange >= $awal && $tgl_onrange <= $akhir) {
                    $validAbsen = false;
                }
            }
        }
        if ($validAbsen == true) {
            $cutiUsed++;
        }
    }
    return $cutiUsed;
}
//End Fungsi validasi Hitungan Cuti dari range tanggal
//Fungsi validasi Hitungan Cuti dari range tanggal
function countMaxDateFromSisaCuti($sisaCuti, $conn)
{
    date_default_timezone_set('Asia/Jakarta');
    //var_dump($begin);

    date_default_timezone_set('Asia/Jakarta');
    $begin = new DateTime();
    $tgl = $begin->format('Y-m-d');
    $namaHariBegin = date('D', strtotime($tgl));
    $cutiUsed = 0;
    while ($cutiUsed < $sisaCuti) {
        //echo $tgl."<br>";
        $validAbsen = 1;
        $namaHariBegin = date('D', strtotime($tgl));
        if ($namaHariBegin == "Sat" || $namaHariBegin == "Sun") {
            $validAbsen = 0;
        } else {
            $SELECTLIBUR21 = "SELECT tglawal,tglakhir FROM tb_tgllibur WHERE tglawal<='$tgl' AND tglakhir>='$tgl'";
            $reslibur21 = mysqli_query($conn, $SELECTLIBUR21);
            if (!$reslibur21) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            if (mysqli_num_rows($reslibur21) != 0) {
                $validAbsen = 0;
            }
        }
        if ($validAbsen == 1) {
            $cutiUsed++;
        }
        $begin = $begin->modify('+1 day');
        $tgl = $begin->format('Y-m-d');
    }
    //if ($sisaCuti != 0) {
    $begin = $begin->modify('-1 day');
    //}
    //echo $cutiUsed;
    return $begin;
}
//End Fungsi validasi Hitungan Cuti dari range tanggal
//Fungsi Haversine Formula hitung jarak dari dua lat lng
function getDistance2($latitude1, $longitude1, $latitude2, $longitude2)
{
    $earth_radius = 6371;

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return $d;
}

// Fungsi jarak Vincenty formula to calculate great circle distance between 2 locations
function getDistance($lat1, $lon1, $lat2, $lon2)
{
    $a = 6378137 - 21 * sin(lat);
    $b = 6356752.3142;
    $f = 1 / 298.257223563;

    $p1_lat = $lat1 / 57.29577951;
    $p2_lat = $lat2 / 57.29577951;
    $p1_lon = $lon1 / 57.29577951;
    $p2_lon = $lon2 / 57.29577951;

    $L = $p2_lon - $p1_lon;

    $U1 = atan((1 - $f) * tan($p1_lat));
    $U2 = atan((1 - $f) * tan($p2_lat));

    $sinU1 = sin($U1);
    $cosU1 = cos($U1);
    $sinU2 = sin($U2);
    $cosU2 = cos($U2);

    $lambda = $L;
    $lambdaP = 2 * PI;
    $iterLimit = 20;

    while (abs($lambda - $lambdaP) > 1e-12 && $iterLimit > 0) {
        $sinLambda = sin($lambda);
        $cosLambda = cos($lambda);
        $sinSigma = sqrt(($cosU2 * $sinLambda) * ($cosU2 * $sinLambda) + ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda));

        //if ($sinSigma==0){return 0;}  // co-incident points
        $cosSigma = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosLambda;
        $sigma = atan2($sinSigma, $cosSigma);
        $alpha = asin($cosU1 * $cosU2 * $sinLambda / $sinSigma);
        $cosSqAlpha = cos($alpha) * cos($alpha);
        $cos2SigmaM = $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha;
        $C = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
        $lambdaP = $lambda;
        $lambda = $L + (1 - $C) * $f * sin($alpha) * ($sigma + $C * $sinSigma * ($cos2SigmaM + $C * $cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM)));
    }

    $uSq = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
    $A = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
    $B = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));

    $deltaSigma = $B * $sinSigma * ($cos2SigmaM + $B / 4 * ($cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) - $B / 6 * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma) * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)));

    $s = $b * $A * ($sigma - $deltaSigma);
    return $s;
}

//fungsi untuk mengemit data dari SocketIO
function emitData()
{
    //Socket IO mulai
    //$version = new Version2X("https://localhost:9731", ['context' => ['ssl' => ['verify_peer_name' => false, 'verify_peer' => false]]]);
    $version = new Version2X("https://absensi.kakatu.co:9731", ['context' => ['ssl' => ['verify_peer_name' => false, 'verify_peer' => false]]]);
    $client = new Client($version);
    $client->initialize();
    $masuk = array("Submit");
    $client->emit("submit_baru", $masuk);
    $client->close();
}
//End List Fungsi Submit Absensi
//CronJob Fungsi
function autoAbsen($lat, $lng, $tgl_skrg, &$errmsg)
{
    $conn = createConn();
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $now1 = date("H:i:s");
    $SELECTLIBUR2 = "SELECT tglawal,tglakhir FROM tb_tgllibur WHERE tglawal<='$tgl_skrg' AND tglakhir>='$tgl_skrg'";
    //echo $SELECTLIBUR2;
    $reslibur2 = $conn->query($SELECTLIBUR2);
    if (!$reslibur2) {
        $errmsg = "Query: " . $SELECTLIBUR2 . " Error: " . $conn->error;
        //echo "Error: " . $qry . "<br>" . $conn->error;
        $conn->close();
    }
    //$tes = mysqli_num_rows($reslibur2);
    //echo "tes".$tes."<br>";
    //Jika hari libur bukan dihari sabtu minggu
    if ($reslibur2->num_rows != 0) {
        //$address = getAddress($lat, $lng);
        //$address = $address?$address:'Tidak Ketemu';
        $select = "SELECT a.id_anggota AS id_anggota FROM tb_anggota a JOIN jabatan_anggota b ON a.id_anggota = b.id_anggota JOIN tb_jabatan c ON c.id_jabatan = b.id_jabatan GROUP BY a.id_anggota HAVING GROUP_CONCAT(c.jabatan SEPARATOR ', ') NOT LIKE '%Admin%'";
        $result = $conn->query($select);
        if (!$result) {
            $errmsg = "Query: " . $select . " Error: " . $conn->error;
            //echo "Error: " . $qry . "<br>" . $conn->error;
            $conn->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                $id_anggota = $row['id_anggota'];
                $query = "INSERT INTO tb_detail_absen (id_anggota, tanggal, jam_masuk,jam_keluar,status_id,latitude,longitude,tgl_awal,tgl_akhir) VALUES ('$id_anggota', '$today1','$now1','11:45:01',1,'$lat','$lng','$today1','$today1')";
                //echo $query;
                $insert = $conn->query($query);
                if (!$insert) {
                    $errmsg = "Query: " . $query . " Error: " . $conn->error;
                } else {
                    $last_id = $conn->insert_id;
                    topupCredit($last_id, 1, $errmsg);
                }
            }
        }
    } else {
        //echo "rencana<br>";
        //Jika hari kerja
        $selectRencanaAbsen = "SELECT * FROM tb_cronjob_rencana_absen WHERE tglawal<='$today1' AND tglakhir>='$today1'";
        $resRencanaAbsen = $conn->query($selectRencanaAbsen);
        if (!$resRencanaAbsen) {
            $errmsg = "Query: " . $selectRencanaAbsen . " Error: " . $conn->error;
        } else {
            while ($rowRencanaAbsen = $resRencanaAbsen->fetch_array()) {
                //$alamat=getAddress($rowRencanaAbsen['lat'], $rowRencanaAbsen['lng']);
                $insertAbsen = "INSERT INTO tb_detail_absen (id_anggota, tanggal, jam_masuk,status_id,keterangan,latitude,longitude,tgl_awal,tgl_akhir,foto_lokasi,rencana_id) VALUES ('$rowRencanaAbsen[id_anggota]', '$today1','$now1','$rowRencanaAbsen[status_id]','$rowRencanaAbsen[keterangan]','$rowRencanaAbsen[lat]','$rowRencanaAbsen[lng]','$today1','$rowRencanaAbsen[tglakhir]','$rowRencanaAbsen[foto_lokasi]','$rowRencanaAbsen[id]')";
                $resInsertAbsen = $conn->query($insertAbsen);
                if (!$resInsertAbsen) {
                    $errmsg = "Query: " . $insertAbsen . " Error: " . $conn->error;
                } else {
                    $last_id = $conn->insert_id;
                    topupCredit($last_id, $rowRencanaAbsen['status_id'], $errmsg);
                    if ($rowRencanaAbsen['status_id'] == 5) {
                        //$queryCuti= "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used +DATEDIFF(STR_TO_DATE('$tgl2', '%m/%d/%Y'),STR_TO_DATE('$tgl1', '%m/%d/%Y'))+1) WHERE id_anggota='$id'";
                        $qry = "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used +1) WHERE id_anggota='$rowRencanaAbsen[id_anggota]'";
                        inUpDel($qry, $errmsg);
                    }
                }
            }
        }
    }

}
function autoAbsenAlpha($conn, $tgl_skrg)
{
    $errmsg = null;
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $now1 = date("H:i:s");
    $SELECTLIBUR2 = "SELECT tglawal,tglakhir FROM tb_tgllibur WHERE tglawal<='$tgl_skrg' AND tglakhir>='$tgl_skrg'";
    $reslibur2 = mysqli_query($conn, $SELECTLIBUR2);
    if (!$reslibur2) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    if (mysqli_num_rows($reslibur2) === 0) {
        $selectalpha = "SELECT a.id_anggota FROM tb_anggota a JOIN jabatan_anggota b ON a.id_anggota = b.id_anggota JOIN tb_jabatan c ON c.id_jabatan = b.id_jabatan WHERE a.id_anggota NOT IN (SELECT id_anggota FROM tb_detail_absen WHERE tanggal='$today1') GROUP BY a.id_anggota HAVING GROUP_CONCAT(c.jabatan SEPARATOR ', ') NOT LIKE '%Admin%'";
        $resalpha = mysqli_query($conn, $selectalpha);
        if (!$resalpha) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        } else {
            while ($row = mysqli_fetch_array($resalpha)) {
                $query = "INSERT INTO tb_detail_absen (id_anggota, tanggal, jam_masuk,status_id,tgl_awal,tgl_akhir) VALUES ('$row[id_anggota]', '$today1','$now1',6,'$today1','$today1')";
                $insert = mysqli_query($conn, $query);
                if (!$insert) {
                    printf("Error: %s\n", mysqli_error($conn));
                    exit();
                }
                //topupCredit($row['id_anggota'],6,$errmsg);
            }
        }
    }
}
//functions
function formatkanRekap($jumlah, $format)
{
    if ($jumlah == 0 || is_null($jumlah)) {
        return "-";
    } else {
        switch ($format) {
            case 'hari':
                return $jumlah . " hari";
                break;
            case 'rupiah':
                return "Rp" . number_format($jumlah);
                break;
            case 'orang':
                return $jumlah . " orang";
                break;
        }
    }
}
//End Cronjob Fungsi

//Fungsi Cron Rencana Absen
function cronRencanaAbsen($id, $stat, $ket, $lat, $lng, $tawal, $takhir, $last_id, &$errmsg)
{
    $qry = "SELECT foto_lokasi FROM tb_detail_absen WHERE id='$last_id'";
    $conn = createConn();
    $res = $conn->query($qry);
    if (!$res) {
        $errmsg = "Error: " . $qry . "<br>" . $conn->error;
        $qry = "DELETE FROM tb_detail_absen WHERE id='$last_id'";
        inUpDel($qry, $errmsg);
    } else {
        //$ambilNamaFoto=$res->fetch_assoc();
        $rowNamaFoto = $res->fetch_assoc();
        //$conn->close();
        $insertRencanaAbsen = "INSERT INTO tb_cronjob_rencana_absen (id_anggota,status_id,keterangan,lat,lng,tglawal,tglakhir,foto_lokasi) VALUES ('$id','$stat','$ket','$lat','$lng','$tawal','$takhir','$rowNamaFoto[foto_lokasi]')";
        //$resRencanaAbsen=mysqli_query($conn,$insertRencanaAbsen);
        if (!$conn->query($insertRencanaAbsen)) {
            $errmsg = "Error: " . $insertRencanaAbsen . "<br>" . $conn->error;
            //exit();
            $qry = "DELETE FROM tb_detail_absen WHERE id='$last_id'";
            inUpDel($qry, $errmsg);
        } else {
            $last_id2 = $conn->insert_id;
            $updateRencanaID = "UPDATE tb_detail_absen SET rencana_id='$last_id2' WHERE id='$last_id'";
            if (!$conn->query($updateRencanaID)) {
                $errmsg = "Error: " . $updateRencanaID . "<br>" . $conn->error;
                $qry = "DELETE FROM tb_detail_absen WHERE id='$last_id'";
                inUpDel($qry, $errmsg);
            }
            $conn->close();
        }
    }
}
//End Fungsi Cron Rencana Absen

//Enkripsi dan Dekripsi Data (Encode atau Decode) - Deprecated
/*
function getSaltKey(){
//Tidak Boleh Diubah
$key = "#k@KaTu_1nT3rNEt_$3H@t";
//$key2 = "#k@KaTu_1nT3rNEt_$3H@t";
return $key;
}
 */
/*
function executeQueryPro($qry,$action,$format){
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_operasional-kantor";
$con = mysqli_connect($db_host, $db_user, $db_pass);
$find_db = mysqli_select_db($con, $db_name);
$res = mysqli_query($con, $qry);
if (!$resRencanaAbsen) {
printf("Error: %s\n", mysqli_error($conn));
mysqli_close($con);
exit();
}
if($action=="select"){
switch ($format) {
case 'fassoc':
return mysqli_fetch_assoc($res);
break;
case 'farray':
return mysqli_fetch_array($res);
break;
case 'frows':
return mysqli_fetch_row($res);
break;
case 'fnumrows':
return mysqli_num_rows($res);
break;
case 'fall':
return mysqli_fetch_all($res,MYSQLI_ASSOC);
break;
default:
echo "belom ada";
break;
}
}
}
 */
//Fungsi Update Delete Query
function inUpDel($qry, &$errmsg)
{
    $conn = createConn();
    $res = $conn->query($qry);
    if ($res) {
        //$res->free();
        $conn->close();
    } else {
        if ($errmsg !== null) {
            $errmsg .= ". Query: " . $qry . " Error: " . $conn->error;
            //echo "Error: " . $qry . "<br>" . $conn->error;
            $conn->close();
        } else {
            $errmsg = "Query: " . $qry . " Error: " . $conn->error;
            //echo "Error: " . $qry . "<br>" . $conn->error;
            $conn->close();
        }
    }
}
//DataList Credit
function fetchCreditsJSON($id)
{
    $qry = "SELECT id,id_anggota,topup_credit,uang_makan FROM tb_credits_anggota WHERE id = '$id'";
    $conn = createConn();
    if (!$conn->query($qry)) {
        echo "Error: " . $qry . "<br>" . $conn->error;
        exit();
    }
    echo json_encode($conn->query($qry)->fetch_array());
    $conn->close();
}
function fetchCreditForPaid($id)
{
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $now1 = date("H:i:s");
    $output = '';
    $id = antiInjection($id);
    $qry = "SELECT a.id_anggota AS id_anggota,b.nama AS nama,(c.topup_credit+c.uang_makan) AS jumlah,DATE_FORMAT(a.tanggal,'%Y-%m') AS bulan,SUM(a.credit_in) AS total,a.credit_stat AS status FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota JOIN tb_credits_anggota c ON a.credit_id=c.id WHERE a.id_anggota='$id' AND a.credit_stat='unpaid' AND MONTH(a.tanggal)=MONTH('$today1') AND YEAR(a.tanggal)=YEAR('$today1') GROUP BY a.id_anggota";
    $conn = createConn();
    $res = $conn->query($qry);
    if (!$res) {
        echo "Error: " . $qry . "<br>" . $conn->error;
        exit();
    }
    //$conn->close();
    $output .= ' <br><table class="table table-hover table-responsive">';
    //$topupcredit = 0;
    //$id_anggota="";
    //$row = fetchArray($qry);

    while ($row = $res->fetch_array()) {
        $id_anggota = $row['id_anggota'];
        $topupcredit = formatkanRekap($row['jumlah'], "rupiah");
        echo "<script>console.log(" . $topupcredit . ")</script>";
        $total_credit = formatkanRekap($row['total'], "rupiah");
        $output .= '
				  <tbody>
				  <tr>
					   <td width="30%"><label>ID Anggota</label></td>
					   <td width="30%">' . $id_anggota . '</td>
				  </tr>
				  <tr>
						<td width="30%"><label>Nama</label></td>
						<td width="30%">' . $row["nama"] . '</td>
				  </tr>
				  <tr>
					<td width="30%"><label>Bulan</label></td>
					<td width="30%">' . $row["bulan"] . '</td>
				  </tr>
				  <tr>
					<td width="40%"><label>Jumlah Akomodasi(Makan+Transport)</label></td>
					<td width="40%">' . $topupcredit . '</td>
				</tr>
				  <tr>
					   <td width="40%"><label>Total Akomodasi</label></td>
					   <td width="40%">' . $total_credit . '</td>
				  </tr>
				  <tr>
					<td width="30%"><label>Status</label></td>
					<td width="30%"><span class=\'label label-danger\'>' . strtoupper($row['status']) . '</span></td>
				  </tr>
				  </tbody>
			 ';
    }
    $output .= '
			 </table>
		';
    $conn->close();
    session_start();
    $_SESSION["id_anggota_credit"] = $id;
    return $output;
}
function prosesEditCredit($id, $nominal,$nominal2, &$errmsg)
{
    $id = antiInjection($id);
    $nominal = antiInjection($nominal);
    $nominal2 = antiInjection($nominal2);
    $qry = "UPDATE tb_credits_anggota SET topup_credit='$nominal',uang_makan='$nominal2' WHERE id='$id'";
    inUpDel($qry, $errmsg);
}
function prosesPaidCredit($id, $errmsg)
{
    $errmsg = null;
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $now1 = date("H:i:s");
    $qry = "UPDATE tb_detail_absen SET credit_stat='paid' WHERE id_anggota='$id' AND credit_stat='unpaid' AND MONTH(tanggal)=MONTH('$today1') AND YEAR(tanggal)=YEAR('$today1')";
    inUpDel($qry, $errmsg);
}
//DataList Credit
//Enkripsi dan Dekripsi Data (Encode atau Decode) dengan open SSL encrypt decrypt metode AES-256-CBC
function getKey()
{
    //$secret_key = '"#k@KaTu_1nT3rNEt_$3H@t"';
    $secret_key = getLastConfig('secret_key');
    $key = hash('sha256', $secret_key);
    return $key;
}
function getIv()
{
    //$secret_iv = '"#k1N3sH_kR3at1F_iDe@tA"';
    $secret_iv = getLastConfig('secret_iv');
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    return $iv;
}
function getEncryptMethod()
{
    $encrypt_method = "AES-256-CBC";
    return $encrypt_method;
}

function encodeData($data)
{
    //echo "MasukEncode<br>";
    //$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(getSaltKey()), $data, MCRYPT_MODE_CBC, md5(md5(getSaltKey()))));
    //return $encoded;
    $output = openssl_encrypt($data, getEncryptMethod(), getKey(), 0, getIv());
    $output = base64_encode($output);
    return $output;
}
function decodeData($data)
{
    //echo "MasukDecode<br>";
    //$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(getSaltKey()), base64_decode($data), MCRYPT_MODE_CBC, md5(md5(getSaltKey()))), "\0");
    //return $decoded;
    $output = openssl_decrypt(base64_decode($data), getEncryptMethod(), getKey(), 0, getIv());
    return $output;
}
//END Enkripsi dan Dekripsi Data (Encode atau Decode)
function getLastConfig($str)
{
    //$qry = "SELECT lat_kantor AS lat,lng_kantor AS lng, api_key_google AS apigoogle, metode_enkripsi AS metode, secret_key AS key, secret_iv AS iv FROM tb_konfigurasi_kakatu ORDER BY tanggal_set DESC,jam_set DESC LIMIT 1";
    $qry = "SELECT " . $str . " FROM tb_konfigurasi_kakatu ORDER BY tanggal_set DESC,jam_set DESC LIMIT 1";
    $conn = createConn();
    if (!$conn->query($qry)) {
        echo "Error: " . $qry . "<br>" . $conn->error;
        exit();
    }
    $row = $conn->query($qry)->fetch_assoc();
    $conn->close();
    return $row[$str];
    /*
switch ($str) {
case 'lat_kantor':
return $row['lat'];
break;
case 'lng_kantor':
return $row['lng'];
break;
case 'api_key_google':
return $row['apigoogle'];
break;
case 'metode_enkripsi':
return $row['metode'];
break;
case 'api_key_google':
return $row['apigoogle'];
break;
}
 */
}
