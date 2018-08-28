<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
$nama = $_SESSION["nama"];
if ($_SESSION["nama"] == '') {
    ?>
		<script>
		alert('Anda Belum Login, Silahkan Login dulu');
		window.open('pages/forms/form_login.php','_self');
		</script>
		<?php
}
include "../../con_db.php"; //sambung ke database
include "../../fungsi_kakatu.php"; //sambung ke database

//mengambil nilai dari form
$id = $_POST['id'];
$nama = $_POST['nama'];
$password = encodeData("kakatu");

if ($_POST['email'] != '') {
    $email = $_POST['email'];
} else {
    $email = "-";
}

if ($_POST['alamat'] != '') {
    $alamat = $_POST['alamat'];
} else {
    $alamat = "-";
}

if ($_POST['tempat_lahir'] != '') {
    $tempat_lahir = $_POST['tempat_lahir'];
} else {
    $tempat_lahir = '-';
}

if ($_POST['tanggal_lahir'] != '') {
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $tgl_new_format = date("Y-m-d", strtotime($tanggal_lahir));
} else {
    $tgl_new_format = '1000-01-01';
}

if ($_POST['jenis_kelamin'] != '') {
    $jenis_kelamin = $_POST['jenis_kelamin'];
} else {
    $jenis_kelamin = '-';
}if ($_POST['status'] != '') {
    $status = $_POST['status'];
} else {
    $status = '-';
}if ($_POST['noktp'] != '') {
    $noktp = $_POST['noktp'];
} else {
    $noktp = '-';
}if ($_POST['norek'] != '') {
    $norek = $_POST['norek'];
} else {
    $norek = '-';
}if ($_POST['npwp'] != '') {
    $npwp = $_POST['npwp'];
} else {
    $npwp = '-';
}

//query untuk memasukan ke database
$query = "INSERT INTO tb_anggota (id_anggota, nama, email, alamat, tempat_lahir, tgl_lahir, jenis_kelamin, password,status,no_ktp,no_rekening,npwp, foto_profile)VALUES('$id', '$nama', '$email', '$alamat', '$tempat_lahir', '$tgl_new_format' , '$jenis_kelamin',  '$password','$status','$noktp','$norek','$npwp','-')";
$insert = mysqli_query($koneksi, $query);

if (!$insert) {
    printf("Error: %s\n", mysqli_error($koneksi));
    exit();
}

$jabatan = $_POST['jabatan'];

if ($jabatan) {

    foreach ($jabatan as $value_jabatan) {
        mysqli_query($koneksi, "INSERT INTO jabatan_anggota (id_anggota, id_jabatan) VALUES ('$id','" . mysqli_real_escape_string($koneksi, $value_jabatan) . "')");
    }
}
echo '<script>alert("Data Anggota Berhasil Disimpan");document.location.href="../../tampil/data-anggota"</script>';
?>
