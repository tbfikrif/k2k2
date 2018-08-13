<html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
		 <!-- JS dependencies -->
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- bootbox code -->
    <script type="text/javascript" src="../../bower_components/bootbox/bootbox.min.js"></script>
</html>
<?php 
include "../../con_db.php";
include "../../fungsi_kakatu.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
date_default_timezone_set("Asia/Jakarta");
	$id = $_SESSION['id_pembayaran'];
	$jabatan = $_SESSION['jabatan'];
	list($one, $two) = explode(",", $_SESSION['jabatan'] , 2);
	
if($jabatan == 'Admin'){
	$sql = "UPDATE tb_konfirmasi SET konfirm_admin='2' WHERE id_pembayaran='$id'";
	$insert = mysqli_query($koneksi, $sql);
	$update_query1 = "UPDATE tb_pembayaran SET status='1' WHERE id_pembayaran='$id'";
	$insert_query1 = mysqli_query($koneksi,$update_query1);
	include "../../phpmailer/admin_send.php";
	?>
    <?php 
    	$sqldata = "SELECT tb_pembayaran.id_pembayaran,tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.status FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis WHERE id_pembayaran ='$id'";
		    	$resdata = mysqli_query($koneksi,$sqldata);
		    	$value_data = mysqli_fetch_assoc($resdata);
		    	$namajenis = $value_data['jenis'];
		    	$jumlah = number_format($value_data['nominal']);

		    	 $tgl_now = date("d-m-Y", strtotime($value_data['tanggal']));
	 			 $dayname = date('l', strtotime($value_data['tanggal']));

								  if($dayname =="Monday"){
							      	$hari = "Senin";
							      } else if($dayname == "Tuesday"){
							      	$hari = "Selasa";
							      } else if ($dayname == "Wednesday"){
							      	$hari = "Rabu";
							      } else if ($dayname == "Thursday"){
							      	$hari = "Kamis";
							      } else if ($dayname == "Friday"){
							      	$hari = "Jumat";
							      } else if($dayname == "Saturday"){
							      	$hari = "Sabtu";
							      } else if($dayname == "Sunday"){
							      	$hari = "Minggu";
							      }

    ?>
	 <script>
    var wa_admin_anggota = "whatsapp://send?text=Uang <?php echo $namajenis?> dengan ID Pembayaran <?php echo $id ?>, pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah ?> sudah di Transfer ke Rekening Bank Anda, silahkan di cek";
    var jabatan_share = <?php $_SESSION["jabatan"]?>

      bootbox.confirm({
            message: "<?php echo '<h4>' ?>Konfirmasi Sudah Terkirim. <?php echo '<br><br>' ?> Anda bisa mengingatkan Admin lewat share Whatsapp (<b>Khusus jika anda sedang menggunakan Smartphone, jika anda menggunakan PC/Desktop pilih 'NANTI'</b>). <?php echo '</h4><br><h3>' ?>  Share Sekarang? <?php echo '</h3>'?>",
            buttons: {
                confirm: {
                    label: 'SHARE',
                    className: 'btn-success btn-sm'

                },
                cancel: {
                    label: 'NANTI',
                    className: 'btn-danger btn-sm'
                }
            },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result)
        if (result){
        	window.location=wa_admin_anggota
        		bootbox.alert({ 
				  size: "small",
				  message: "<?php echo '<h4>' ?>Anda bisa Share lagi melalui Button Share yang tersedia di Form Detail Pembayaran <?php echo '</h4><br>' ?><?php echo '<h4>' ?>Klik Ok, Untuk kembali ke menu Pembayaran<?php echo '</h4>'?>", 
				  callback: function(){window.location="../../tampil/detail-pembayaran/<?php echo $id; ?>" }
			})
    	} else {
    		window.location="../../tampil/list-bayar"
    	}
    }
});

    </script>
	<?php

} else if($jabatan != 'Admin'){
	$sql = "UPDATE tb_konfirmasi SET konfirm_anggota='2' WHERE id_pembayaran='$id'";
	$insert = mysqli_query($koneksi, $sql);
	include "../../phpmailer/anggota_send_ok.php";
    	$sqldata = "SELECT tb_pembayaran.id_pembayaran,tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.status FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis WHERE id_pembayaran ='$id'";
		    	$resdata = mysqli_query($koneksi,$sqldata);
		    	$value_data = mysqli_fetch_assoc($resdata);
		    	$namajenis = $value_data['jenis'];
		    	$jumlah = number_format($value_data['nominal']);
		    	$tgl_now = date("d-m-Y", strtotime($value_data['tanggal']));
	 			 $dayname = date('l', strtotime($value_data['tanggal']));

								  if($dayname =="Monday"){
							      	$hari = "Senin";
							      } else if($dayname == "Tuesday"){
							      	$hari = "Selasa";
							      } else if ($dayname == "Wednesday"){
							      	$hari = "Rabu";
							      } else if ($dayname == "Thursday"){
							      	$hari = "Kamis";
							      } else if ($dayname == "Friday"){
							      	$hari = "Jumat";
							      } else if($dayname == "Saturday"){
							      	$hari = "Sabtu";
							      } else if($dayname == "Sunday"){
							      	$hari = "Minggu";
							      }
    ?>

	 <script>
    var wa_anggota_admin = "whatsapp://send?text=Uang <?php echo $namajenis ?> dengan ID Pembayaran <?php echo $id ?> , pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah?>. Sudah saya terima.";
    var jabatan_share = <?php $_SESSION["jabatan"]?>

      bootbox.confirm({
            message: "<?php echo '<h4>' ?>Konfirmasi Sudah Terkirim. <?php echo '<br><br>' ?> Anda bisa mengingatkan Admin lewat share Whatsapp (<b>Khusus jika anda sedang menggunakan Smartphone, jika anda menggunakan PC/Desktop pilih 'NANTI'</b> ). <?php echo '</h4><br><h3>' ?>  Share Sekarang? <?php echo '</h3>'?>",
            buttons: {
                confirm: {
                    label: 'SHARE',
                    className: 'btn-success btn-sm'

                },
                cancel: {
                    label: 'NANTI',
                    className: 'btn-danger btn-sm'
                }
            },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result)
        if (result){
        	window.location=wa_anggota_admin
        		bootbox.alert({ 
				  size: "small",
				  message: "<?php echo '<h4>' ?>Anda bisa Share lagi melalui Button Share yang tersedia di Form Detail Pembayaran <?php echo '</h4><br>' ?><?php echo '<h4>' ?>Klik Ok, Untuk kembali ke menu Pembayaran<?php echo '</h4>'?>", 
				  callback: function(){window.location="../../tampil/detail-pembayaran/<?php echo $id; ?>" }
			})
    	} else {
    	window.location="../../tampil/list-bayar"
    	}
    }
});

    </script>
    <?php
}

if (!$insert) {
    printf("Error: %s\n", mysqli_error($koneksi));
    exit();
    } 

$query = "SELECT * FROM tb_konfirmasi WHERE id_pembayaran='$id'";
$result = mysqli_query($koneksi, $query);

$row = mysqli_fetch_assoc($result);

if($row['konfirm_admin']=="2" && $row['konfirm_anggota']=="2"){
	$update_query = "UPDATE tb_pembayaran SET status='2' WHERE id_pembayaran='$id'";
	$insert_query = mysqli_query($koneksi,$update_query);
	$delete_query = "DELETE FROM tb_konfirmasi WHERE id_pembayaran='$id'";
	$remove_query = mysqli_query($koneksi,$delete_query);
}
emitData();
?>
 <script> alert("Konfirmasi Terkirim"); </script>