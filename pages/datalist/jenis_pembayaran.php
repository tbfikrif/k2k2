<?php
   if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
        header("Location: ../../tampil/home");
    }
   if (strpos($_SESSION['jabatan'], 'Admin')===false) {
      echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
   }
?>
      <?php 
        $id_jenis = mt_rand(06,999);
      ?>

<section id="form_jenis-pembayaran" style="margin: 0 auto;">

<div class="content-header bounceInRight animated">
  
  <h2> JENIS PEMBAYARAN OPERASIONAL </h2>

</div>

<div class="container bounceInUp animated">
<hr>
  <div class="row">
        <div class="col-md-6">
        <h3> FORM TAMBAH DATA </h3>
         <!-- form start -->
            <form role="form" action="pages/proses/proses_save-jenispembayaran.php" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="ID">ID</label>
                  <input type="text" class="form-control" id="id_jenis" name="id_jenis" value="<?php echo "TR-$id_jenis"?>" readonly>
                </div>
                <div class="form-group">
                  <label for="jenis_pembayaran">Jenis Pembayaran</label>
                  <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Isi Jenis Pembayaran"
                  data-validation="required" data-validation-error-msg="Field Tidak Boleh Kosong !">
                </div>
                <button type="submit" name="submit_jenis" class="btn btn-primary">Tambah Data</button>
             </div>
            </form>
          </div>       
        
        <!-- left column -->
        <div class="col-md-6">
        <?php 
           $query = "SELECT * FROM tb_jenistransaksi";  
           $result = mysqli_query($koneksi, $query);  
        ?>
        <h3> LIST JENIS PEMBAYARAN </h3>
            <div class="table-responsive">  
               <table class="table" id="data-jenis-pembayaran">
               <thead>
                  <tr>  
                         <th> ID Jenis </th>  
                         <th> Jenis </th> 
                         <th> Action </th>
                  </tr>
               </thead>
               <tbody>
                 <?php  
                  $no = 1;
                      while($row = mysqli_fetch_array($result)) {  
               ?>
                    <tr>  
                         <td> <?php echo $row[id_jenis] ?> </td>  
                         <td> <?php echo $row[jenis] ?> </td>  
                         <td> <a id="<?php echo $row["id_jenis"]; ?>" class="btn btn-danger btn-xs delete_jenis_pembayaran"> HAPUS </a><a class="btn btn-warning btn-xs edit_jenis_pembayaran" id="<?php echo $row["id_jenis"]; ?>"> EDIT </a> </td>
                    </tr>
              <?php 
                  $no++;
                  } 
               ?>
               </tbody>
               </table>
            </div>
        </div>
        </div> 
</div>

       
</section>

<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Hapus Data</h4>  
                </div>  
                <div class="modal-body" id="detail_jenis">  
                </div>  
                <div class="modal-footer">    
                     <a href="pages/proses/proses_delete-jenispembayaran.php" class="btn btn-danger">HAPUS</a>
                     <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>  
                </div>  
           </div>  
      </div>  
 </div>  

  <div id="jenis_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">EDIT DATA JABATAN</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" action="pages/proses/proses_edit-jenispembayaran.php">  
                          <label>ID Jenis</label>
                          <input type="text" name="id_jenis" id="id_jenis1" class="form-control" readonly />   
                          <br />
                          <label>Jenis</label>  
                          <input type="text" name="jenis" id="jenis1" class="form-control" />  
                          <br />                       
                </div>  
                <div class="modal-footer"> 
                     <input type="submit" name="submit" id="insert" value="Update" class="btn btn-success" /> 
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </form>      
                </div>  
           </div>  
      </div>  
 </div>  