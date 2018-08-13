 <?php
include "../../con_db.php";
include "../../fungsi_kakatu.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST['emailAdmin'])) {
    if (!empty($_POST['emailAdmin'])) {
        if (!empty($_POST['passEmail'])) {
            if (!empty($_POST['apiGoogleKey'])) {
                if (!empty($_POST['latKantor'])) {
                    if (!empty($_POST['lngKantor'])) {
                        if (!empty($_POST['ukuranUpload'])) {
                            if (!empty($_POST['secretKey'])) {
                                if (!empty($_POST['secretIV'])) {
                                    date_default_timezone_set('Asia/Jakarta');
                                    $today1 = date("Y-m-d");
                                    $now1 = date("H:i:s");
                                    //Mengambil dan memfilter nilai field Forms
                                    $emailAdmin = antiInjection($_POST['emailAdmin']);
                                    $passEmail = antiInjection($_POST['passEmail']);
                                    $apiGoogleKey = antiInjection($_POST['apiGoogleKey']);
                                    $latKantor = antiInjection($_POST['latKantor']);
                                    $lngKantor = antiInjection($_POST['lngKantor']);
                                    $ukuranUpload = antiInjection($_POST['ukuranUpload']);
                                    $secretKey = antiInjection($_POST['secretKey']);
                                    $secretIV = antiInjection($_POST['secretIV']);
                                    //validasi secret key dan secret iv
                                    $qry = "SELECT secret_key,secret_iv FROM tb_konfigurasi_kakatu ORDER BY tanggal_set DESC,jam_set DESC LIMIT 1";
                                    $conn = createConn();
                                    $res = $conn->query($qry);
                                    $secret_key_old = null;
                                    $secret_iv_old = null;
                                    $errmsg = null;
                                    if (!$res) {
                                        $errmsg = "Query: " . $qry . " Error: " . $conn->error;
                                        echo $errmsg;
                                        exit;
                                    } else {
                                        $row = $res->fetch_assoc();
                                        $secret_key_old = $row['secret_key'];
                                        $secret_iv_old = $row['secret_iv'];
                                    }
                                    $qry2 = "INSERT INTO tb_konfigurasi_kakatu (email_admin, pass_email,secret_key,secret_iv,api_key_google,latKantor,lngKantor,batas_ukuran_upload,tanggal_set,jam_set) VALUES ('$emailAdmin','$passEmail','$secretKey','$secretIV','$apiGoogleKey','$latKantor','$lngKantor','$ukuranUpload','$today1','$now1')";
                                    inUpDel($qry2, $errmsg);
                                    if ($errmsg !== null) {
                                        echo 'Terjadi Error: ' . $errmsg;
                                    } else {
                                        if ($secretKey !== $secret_key_old || $secretIV !== $secret_iv_old) {
                                            $passDefault = encodeData("kakatu");
                                            $qry3 = "UPDATE tb_anggota SET password='$passDefault'";
                                            inUpDel($qry3, $errmsg);
                                            if ($errmsg !== null) {
                                                echo 'Terjadi Error: ' . $errmsg;
                                            } else {
                                                echo '<script> alert("Konfigurasi Kakatu , Berhasil Di Update. Semua password telah di reset menjadi \'kakatu\'"); document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                                            }
                                        } else {
                                            echo '<script> alert("Konfigurasi Kakatu , Berhasil Di Update "); document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                                        }
                                    }
                                } else {
                                    echo '<script> alert("Secret IV tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                                }
                            } else {
                                echo '<script> alert("Secret Key tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                            }
                        } else {
                            echo '<script> alert("Batas Ukuran Upload tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                        }
                    } else {
                        echo '<script> alert("Longitude Kantor tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                    }
                } else {
                    echo '<script> alert("Latitude Kantor tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
                }
            } else {
                echo '<script> alert("API KEY Google Maps tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
            }
        } else {
            echo '<script> alert("Pass Email tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
        }
    } else {
        echo '<script> alert("Email Admin tidak boleh kosong!");document.location.href="../../tampil/konfigurasi-kakatu/"</script>';
    }
}
?>
