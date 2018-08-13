<?php 
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	include "../../con_db.php";
	include "../../fungsi_kakatu.php";
	$target_dir = "../../dist/fotoprofile/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$file = basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["image"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		?>
	    <script> alert("<?php echo "Sorry, file already exists."; ?>");document.location.href="../../tampil/profile"</script>
	    <?php 
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["image"]["size"] > 2000000) {
	    ?>
	    <script> alert("<?php echo "Sorry, your file is too large.";?>");document.location.href="../../tampil/profile"</script>
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
	    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	    	?>
	         <script type="text/javascript"> alert(" <?php  echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded."; ?>"); </script>
	    	<?php
	    } else {
	    	?>
	        <script type="text/javascript"> alert("<?php echo "Sorry, there was an error uploading your file.";?>");</script>  
	        <?php
	    }

	$sql = "UPDATE tb_anggota SET foto_profile = '$file' WHERE id_anggota = '$_SESSION[id_anggota]'";
	$result = mysqli_query($koneksi, $sql);    

	if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
	} else {
		emitData();
		echo '<script>document.location.href="../../tampil/profile"</script> ';
	}
}
?>
