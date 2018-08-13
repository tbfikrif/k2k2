<?php  
include "../../con_db.php";
include "../../fungsi_kakatu.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST["submit"])) {
      session_start();
      $statusid_lama=$_SESSION["status_id_absenAdminEdit"];
      $id = $_POST["id_absen"];
      $id_anggota = $_POST["id_anggota_absen"];
      $status_id = $_POST["status_id"];
      $keterangan = $_POST["keterangan_absen"];
      $tglRentang = $_POST["tglRentangAbsenAdmin"];
      $tgl1 = substr($tglRentang,0,10);
      $tgl2 = substr($tglRentang,13,25);
      if ($status_id!=1 && $status_id!=2 && $status_id!=5) {
            if ($statusid_lama==1 || $statusid_lama==2 || $statusid_lama==5) {
                  //echo "<script>alert( 'Debug Objects: Masuk1' );</script>";
                  $query2= "UPDATE tb_detail_absen SET credit_id=null,credit_in=null,credit_stat=null WHERE id='$id'";
                  $update = mysqli_query($koneksi, $query2);
                  if (!$update) {
                        printf("Error: %s\n", mysqli_error($koneksi));
                        exit();
                  }
            }
      } else {
            //$output = ($statusid_lama!=1 && $statusid_lama!=2);
            //echo "<script>alert( 'Debug Objects: " . $output . "' );</script>";
            if ($statusid_lama!=1 && $statusid_lama!=2 && $statusid_lama!=5) {
                  //echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
                  echo "<script>console.log( 'Debug Objects: Masuk2' );</script>";
                  $query2= "UPDATE  tb_detail_absen a JOIN tb_credits_anggota b ON a.id_anggota=b.id_anggota SET a.credit_id=b.id,a.credit_in=b.topup_credit,a.credit_stat='unpaid' WHERE a.id='$id'";
                  $update = mysqli_query($koneksi, $query2);
                  if (!$update) {
                        printf("Error: %s\n", mysqli_error($koneksi));
                        exit();
                  }
            }
      }
      
      if ($status_id!=5) {
            if ($statusid_lama==5) {
                  $queryCuti= "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used - 1) WHERE id_anggota='$id_anggota'";
                  $updateCuti = mysqli_query($koneksi, $queryCuti);
                  //$printf($updateCuti);
                  if (!$updateCuti) {
                        printf("Error: %s\n", mysqli_error($koneksi));
                        exit();
                  }
            }
            
      } else {
            if ($statusid_lama!=5) {
                  $queryCuti= "UPDATE tb_cuti_anggota SET cuti_used=(cuti_used +1) WHERE id_anggota='$id_anggota'";
                  $updateCuti = mysqli_query($koneksi, $queryCuti);
                  //$printf($updateCuti);
                  if (!$updateCuti) {
                        printf("Error: %s\n", mysqli_error($koneksi));
                        exit();
                  }
            }
      }
      //Cek status baru
      if ($status_id==1 || $status_id==2) {
            //Jika status hadir maka range tanggal harus sama, karena absen hadir hanya untuk sehari
            $query = "UPDATE tb_detail_absen SET status_id='$status_id',keterangan='$keterangan',tgl_awal=STR_TO_DATE('$tgl1', '%m/%d/%Y'),tgl_akhir=STR_TO_DATE('$tgl1', '%m/%d/%Y') WHERE id='$id'";        
            $result =  mysqli_query($koneksi, $query);
            if (!$result) {
                  printf("Error: %s\n", mysqli_error($koneksi));
                  exit();
            }
            emitData();
      } else {
            $cek=($tgl1===$tgl2);
            if ($tgl1==$tgl2) {
                  $query = "UPDATE tb_detail_absen SET status_id='$status_id',keterangan='$keterangan',tgl_awal=STR_TO_DATE('$tgl1', '%m/%d/%Y'),tgl_akhir=STR_TO_DATE('$tgl2', '%m/%d/%Y') WHERE id='$id'";        
                  $result =  mysqli_query($koneksi, $query);
                  if (!$result) {
                        printf("Error: %s\n", mysqli_error($koneksi));
                        exit();
                  }
                  emitData();
            } //else {
                  # code...
           // }
      }
}
echo '<script> alert("Data Absen dengan ID'.$id.', Berhasil Di Update"); document.location.href="../../tampil/data-absensi" </script>';
?>
