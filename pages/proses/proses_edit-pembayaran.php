 <?php  
    include "../../con_db.php";
    include "../../fungsi_kakatu.php";
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $id_pembayaran = $_POST["id_pembayaran"];
    $target_dir = "../../dist/fotobukti/";
    $target_file = $target_dir . basename($_FILES["bukti"]["name"]);
    $filename = basename($_FILES["bukti"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["bukti"]["tmp_name"]);
    if($check !== false) {
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

          
          $sql = "INSERT INTO tb_buktipembayaran (id_pembayaran, bukti) VALUES ('$id_pembayaran','$filename')";
          $res = mysqli_query($koneksi,$sql);

          if (!$res) {
             printf("Error: %s\n", mysqli_error($koneksi));
             exit();
             }

    }

  } else {
    
    $sql_c = "DELETE FROM tb_buktipembayaran WHERE bukti = ''";
    mysqli_query($koneksi,$sql_c); 
      
        $jenis = $_POST["jenis"];  
        $jumlah = $_POST['nominal'];
        $nominal = str_replace('.','',$jumlah);
        $keterangan = $_POST["keterangan"];

            $query = "UPDATE tb_pembayaran SET id_jenis='$jenis', nominal = '$nominal', keterangan = '$keterangan'   
            WHERE id_pembayaran='$id_pembayaran'";   
             
             $result =  mysqli_query($koneksi, $query);
             
             if (!$result) {
                printf("Error: %s\n", mysqli_error($koneksi));
                exit();
                }
  }
  emitData();
  ?>
      <script> alert("Data Pembayaran dengan ID <?php echo $id_pembayaran ?>, Berhasil Di Update "); document.location.href="../../tampil/detail-pembayaran/<?php echo $id_pembayaran?>" </script>   
