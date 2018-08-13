 <?php

include "../../con_db.php";
include "../../fungsi_kakatu.php";
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST["id_anggota"])) {
    session_start();
    $id = antiInjection($_POST["id_anggota"]);
    $nama = antiInjection($_POST["nama"]);
    $alamat = antiInjection($_POST["alamat"]);
    $tempat_lahir = antiInjection($_POST["tempat_lahir"]);
    $tgl_lahir = antiInjection($_POST["tgl_lahir"]);
    $jenis_kelamin = antiInjection($_POST['jenis_kelamin']);
    $email = antiInjection($_POST["email"]);
    if (isset($_GET["action"]) && ($_GET["action"] == "tampil") && ($_GET["sidebar-menu"] == "data-anggota")) {
        $id_jabatan_sebelumnya = $_SESSION["id_jabatan_sebelumnya_edit"];
        $id_jabatan = antiInjection($_POST["jabatan"]);
    } 
    if (isset($_POST["password"])) {
        $pass = antiInjection($_POST["password"]);
        $_SESSION["pass"] = $pass;
        $pass = encodeData($pass);
        $query = "UPDATE tb_anggota SET nama='$nama', alamat='$alamat', tempat_lahir='$tempat_lahir', tgl_lahir = '$tgl_lahir',jenis_kelamin='$jenis_kelamin', email = '$email', password = '$pass'
        WHERE id_anggota='$id'";
        $result = mysqli_query($koneksi, $query);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($koneksi));
            exit();
        }
        echo '<script>alert("Data Anggota Berhasil Di Update ' . $id . '"); document.location.href="../../tampil/profile" </script>';
    } else {
        $query = "UPDATE tb_anggota SET nama='$nama', alamat='$alamat', tempat_lahir='$tempat_lahir', tgl_lahir = '$tgl_lahir',jenis_kelamin='$jenis_kelamin', email = '$email'
        WHERE id_anggota='$id'";
         $result = mysqli_query($koneksi, $query);
         if (!$result) {
             printf("Error: %s\n", mysqli_error($koneksi));
             exit();
         }
         $query = "UPDATE jabatan_anggota SET id_jabatan='$id_jabatan' WHERE id_anggota='$id' AND id_jabatan='$id_jabatan_sebelumnya'";
          $result = mysqli_query($koneksi, $query);
          if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
          }
         echo '<script>alert("Data Anggota Berhasil Di Update ' . $id . '"); document.location.href="../../tampil/data-anggota" </script>';
    }
}
?>