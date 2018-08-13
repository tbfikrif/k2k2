<?php
include "../../con_db.php";
include "../../fungsi_kakatu.php";
session_start();
$resetpassid = $_SESSION['resetpassid'];
$passReset = encodeData('kakatu');
mysqli_query($koneksi, "UPDATE tb_anggota SET password='$passReset' WHERE id_anggota='$resetpassid'");
echo '<script> alert("Password Anggota dengan id ' . $resetpassid . ', Berhasil Direset "); document.location.href="../../tampil/data-anggota" </script>';
