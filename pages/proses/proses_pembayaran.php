<html>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	    <!-- bootbox code -->
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../bower_components/bootbox/bootbox.min.js"></script>
</html>
<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	$nama = $_SESSION["nama"];
	if($_SESSION["nama"]==''){
		?>
		<script>
		alert('Anda Belum Login, Silahkan Login dulu');
		window.open('pages/forms/form_login.php','_self');
		</script>
		<?php
	} 
	include "../../con_db.php"; //sambung ke database
	include "../../fungsi_kakatu.php";

     $tgl_new_format = date("Y-m-d H:i:s");

     $tgl_now = date("d-m-Y", strtotime($tgl_new_format));
	 $dayname = date('l', strtotime($tgl_now));

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

	//mengambil nilai dari form
	$id = $_POST['id_pembayaran'];
	$id_anggota = $_POST['id_anggota'];
	$jenis = $_POST['jenis'];
	$jumlah = $_POST['nominal'];
	$nominal= str_replace('.','',$jumlah);
	$keterangan = $_POST['keterangan'];

	//query untuk memasukan ke database
	$query = "INSERT INTO tb_pembayaran VALUES ('$id', '$id_anggota', '$tgl_new_format', '$jenis', '$nominal', '$keterangan', '0' )";
	$insert = mysqli_query($koneksi, $query);

	$query2 = "INSERT INTO tb_konfirmasi (id_pembayaran, id_anggota, konfirm_anggota, konfirm_admin) VALUES ('$id','$id_anggota','0','0')";
	$insert2 = mysqli_query($koneksi, $query2);

	$target_dir = "../../dist/fotobukti/";
	$target_file = $target_dir . basename($_FILES["bukti"]["name"]);
	$filename = basename($_FILES["bukti"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["bukti"]["tmp_name"]);
    if($check !== false) {
        	// Check if file already exists
	if (file_exists($target_file)) {
		?>
	    <script> alert("<?php echo "Sorry, file already exists."; ?>"); </script>
	    <?php 
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["bukti"]["size"] > 2000000) {
	    ?>
	    <script> alert("<?php echo "Sorry, your file is too large.";?>"); </script>
	    <?php
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		?>
	    <script type="text/javascript"> alert("<?php echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; ?>");</script> 
	    <?php
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		?>
	    <script type="text/javascript"> alert("<?php echo "Sorry, your file was not uploaded."; ?>");</script>  
		<?php
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
	    	?>
	         <script type="text/javascript"> alert(" <?php  echo "The file ". basename( $_FILES["bukti"]["name"]). " has been uploaded."; ?>"); </script>
	    	<?php
	    } else {
	    	?>
	        <script type="text/javascript"> alert("<?php echo "Sorry, there was an error uploading your file.";?>");</script>  
	        <?php
	    }

	
	$sql = "INSERT INTO tb_buktipembayaran (id_pembayaran, bukti) VALUES ('$id','$filename')";
	$result = mysqli_query($koneksi,$sql);

	 if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 
	}

	include "../../phpmailer/anggota_send.php";

	$sql_c = "DELETE FROM tb_buktipembayaran WHERE bukti = ''";
	mysqli_query($koneksi,$sql_c);
	
	?>
	<script> alert("Pembayaran Berhasil");  </script> 
	<!-- JS dependencies -->
    <!-- bootbox code -->
    <script src="../../bootbox.min.js"></script>
    <?php 
    	$sqljenis = "SELECT jenis FROM tb_jenistransaksi WHERE id_jenis = '$jenis'";
    	$resjenis = mysqli_query($koneksi,$sqljenis);
    	$value_jenis = mysqli_fetch_assoc($resjenis);
    	$namajenis = $value_jenis['jenis'];
    ?>
     <script>
    var wa_admin_anggota = "whatsapp://send?text=Uang <?php echo $namajenis?> dengan ID Pembayaran <?php echo $id ?>, pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah ?> sudah di Transfer ke Rekening Bank Anda, silahkan di cek";
    var wa_anggota_admin = "whatsapp://send?text=Saya baru saja <?php echo $namajenis ?> dengan ID Pembayaran <?php echo $id ?> , pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah?>. Mohon segera di Reimburse";
    var jabatan_share = <?php $_SESSION["jabatan"]?>

      bootbox.confirm({
            message: "<?php echo '<h4>' ?>Pembayaran Berhasil Dilakukan, Email Konfirmasi Sudah Terkirim. <?php echo '<br><br>' ?> Anda bisa mengingatkan Admin lewat share Whatsapp (<b>Khusus jika anda sedang menggunakan Smartphone, jika anda menggunakan PC/Desktop pilih 'NANTI'</b>). <?php echo '</h4><br><h3>' ?>  Share Sekarang? <?php echo '</h3>'?>",
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
			  callback: function(){window.location="../../tampil/list-bayar" }
			})
    	} else {
    	window.location="../../tampil/list-bayar"
    	}
    }
});

    </script>
	<?php

    } else {
        include "../../phpmailer/anggota_send.php";

    $sql_c = "DELETE FROM tb_buktipembayaran WHERE bukti = ''";
	mysqli_query($koneksi,$sql_c);    

	?>
	<script> alert("Pembayaran Berhasil");  </script> 
	<!-- JS dependencies -->
<?php 
    	$sqljenis = "SELECT jenis FROM tb_jenistransaksi WHERE id_jenis = '$jenis'";
    	$resjenis = mysqli_query($koneksi,$sqljenis);
    	$value_jenis = mysqli_fetch_assoc($resjenis);
    	$namajenis = $value_jenis['jenis'];
    ?>
    <!-- bootbox code -->
    <script>
    var wa_admin_anggota = "whatsapp://send?text=Uang <?php echo $namajenis?> dengan ID Pembayaran <?php echo $id ?>, pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah ?> sudah di Transfer ke Rekening Bank Anda, silahkan di cek";
    var wa_anggota_admin = "whatsapp://send?text=Saya baru saja <?php echo $namajenis ?> dengan ID Pembayaran <?php echo $id_pembayaran ?> , pada hari <?php echo $hari.", ".$tgl_now?>. Sebesar Rp.<?php echo $jumlah?>. Mohon segera di Reimburse";
    var jabatan_share = <?php $_SESSION["jabatan"]?>

      bootbox.confirm({
            message: "<?php echo '<h4>' ?>Pembayaran Berhasil Dilakukan, Email Konfirmasi Sudah Terkirim. <?php echo '<br><br>' ?> Anda bisa mengingatkan Admin lewat share Whatsapp (<b>Khusus jika anda sedang menggunakan Smartphone, jika anda menggunakan PC/Desktop pilih 'NANTI'</b>). <?php echo '</h4><br><h3>' ?>  Share Sekarang? <?php echo '</h3>'?>",
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
			  callback: function(){
				  window.location="../../tampil/list-bayar/"
				}
			})
    	} else {
    		window.location="../../tampil/list-bayar/";
    	}
    }
});
</script>
<?php 
}
emitData();
?>