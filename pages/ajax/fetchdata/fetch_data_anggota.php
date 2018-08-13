<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$id = $_POST["id_anggota"];
if (isset($_POST['id_anggota'])) {
    $output = '';
    include "../../../con_db.php";
    $query = "SELECT tb_anggota.id_anggota, tb_anggota.nama, GROUP_CONCAT(tb_jabatan.jabatan SEPARATOR ', ') as 'jabatan', tb_anggota.alamat, CONCAT(tb_anggota.tempat_lahir, ', ', tb_anggota.tgl_lahir) as 'Tempat, Tanggal Lahir', tb_anggota.email, tb_anggota.jenis_kelamin FROM `tb_anggota`  JOIN jabatan_anggota ON tb_anggota.id_anggota = jabatan_anggota.id_anggota JOIN tb_jabatan ON tb_jabatan.id_jabatan = jabatan_anggota.id_jabatan WHERE tb_anggota.id_anggota = '$id' GROUP BY tb_anggota.id_anggota";
    $result = mysqli_query($koneksi, $query);
    $output .= '
      <div class="table-responsive">
           <table class="table table-bordered">';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '
                <tr>
                     <td width="30%"><label>ID Anggota</label></td>
                     <td width="70%">' . $row["id_anggota"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>Nama</label></td>
                     <td width="70%">' . $row["nama"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>TTL</label></td>
                     <td width="70%">' . $row["Tempat, Tanggal Lahir"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>Alamat</label></td>
                     <td width="70%">' . $row["alamat"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>Jenis Kelamin</label></td>
                     <td width="70%">' . $row["jenis_kelamin"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>Email</label></td>
                     <td width="70%">' . $row["email"] . '</td>
                </tr>
                <tr>
                     <td width="30%"><label>Jabatan</label></td>
                     <td width="70%">' . $row["jabatan"] . '</td>
                </tr>
           ';
    }
    $output .= '
           </table>
      </div>
      ';
    echo $output;
}
?>