<?php
//echo '<script>alert("Dilarang coy");window.location="../../form/form_login"</script>';
if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
    header("Location: ../../tampil/home");
 }
 if (strpos($_SESSION['jabatan'], 'Admin')===false) {
  echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
}
?>
  <html>

  <head>
    <title>Bootstrap Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body style="background-color: #f9f9f9">

    <style>
      @import url('https://fonts.googleapis.com/css?family=Dosis');
    </style>

    <!-- jQuery 3 -->
    <div class="container">
      <h2 class="bounceInLeft animated">DAFTAR ANGGOTA TIM KAKATU</h2>
      <div>
        <hr class="bounceInLeft animated" style="  
      border: 0;
      height: 1px;
      background: #333;
      background-image: linear-gradient(to right, #ccc, #333, #ccc);">
        <div class="row">
          <div class="col col-xs-6 flipInX animated">
            <a href="tampil/form-anggota" class="btn btn-primary">
              <span class="glyphicon glyphicon-plus"></span>TAMBAH DATA ANGGOTA</a>
          </div>
        </div>
        <hr class="bounceInLeft animated" style="  
      border: 0;
      height: 1px;
      background: #333;
      background-image: linear-gradient(to right, #ccc, #333, #ccc);">
      </div>
    </div>
    <div class="bounceInUp animated">
      <table class="table" id="data-anggota">
        <thead>
          <tr align="center">
            <th>Id Anggota</th>
            <th>Nama Anggota</th>
            <th>Jabatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = "SELECT tb_anggota.id_anggota, tb_anggota.nama, GROUP_CONCAT(tb_jabatan.jabatan SEPARATOR ', ') as 'jabatan', tb_anggota.email, tb_anggota.jenis_kelamin FROM `tb_anggota` JOIN jabatan_anggota ON tb_anggota.id_anggota = jabatan_anggota.id_anggota JOIN tb_jabatan ON tb_jabatan.id_jabatan = jabatan_anggota.id_jabatan GROUP BY tb_anggota.id_anggota";

            $result = mysqli_query($koneksi,$sql);
            
            $idanggota = $_SESSION['id_anggota'];

            if (!$result) {
                printf("Error: %s\n", mysqli_error($koneksi));
                exit();
                } 
            
            $no = 1;
              while($r = mysqli_fetch_array($result))
              {
              ?>

            <tr>
              <td>
                <?php echo $r['id_anggota'] ?> </td>
              <td>
                <?php echo $r['nama'] ?> </td>
              <td>
                <?php echo $r['jabatan'] ?> </td>
              <?php 

                  if(strpos($r["jabatan"], 'Admin')!==false){

                ?>
              <td>
                  <input type="button" name="view" value="DETAIL" id="<?php echo $r["id_anggota"]; ?>" class="btn btn-info btn-xs view_data_anggota"
                  />
              </td>
              <?php
                } else {
                  ?>
                <td>
                    <input type="button" name="view" value="DETAIL" id="<?php echo $r["id_anggota"]; ?>" class="btn btn-info btn-xs view_data_anggota"/>
                    <input type="button" name="edit" value="EDIT" id="<?php echo $r["id_anggota"]; ?>" class="btn btn-success btn-xs edit_data_anggota"/>
                    <input type="button" name="reset" value="RESET PASS" id="<?php echo $r["id_anggota"]; ?>" class="btn btn-warning btn-xs reset_pass_anggota"/>
                    <input type="button" name="delete" id="<?php echo $r["id_anggota"]; ?>" class="btn btn-danger btn-xs delete_data_anggota" value="HAPUS"/>
                </td>
                <?php
                }
                ?>
            </tr>

            <?php
                  $no++;
                }
            ?>
        </tbody>
      </table>
    </div>
    <br>
    <form action="pages/proses/proses_convert-csv.php" method="POST">
      <input type="submit" id="btn_convert" class="btn btn-primary pull-right" value="Convert To CSV" name="submit_csv-anggota">
    </form>
    </div>
    </div>
  </body>

  <div id="dataModalAnggota" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Anggota</h4>
        </div>
        <div class="modal-body" id="employee_detail">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
    </div>
  </div>

  <?php 
                  if(strpos($_SESSION['jabatan'], 'Admin')!==false){
                    ?>
  <script type="text/javascript">
    document.getElementById('btn_convert').style.display = "block";
  </script>
  <?php
                  } else 

                  if(strpos($_SESSION['jabatan'], 'Admin')===false) {
                    ?>
    <script type="text/javascript">
      document.getElementById('btn_convert').style.display = "none";
    </script>
    <?php
                  }
  ?>
      <div id="dataModal_hapus" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Detail Anggota</h4>
            </div>
            <div class="modal-body" id="employee">
            </div>
            <div class="modal-footer">
              <a href="pages/proses/proses_delete-anggota.php" class="btn btn-danger">HAPUS DATA</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
          </div>
        </div>
      </div>
      <div id="dataModal_resetPass" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Detail Anggota</h4>
            </div>
            <div class="modal-body" id="employee_pass">
            </div>
            <div class="modal-footer">
              <a href="pages/proses/proses_reset-pass-anggota.php" class="btn btn-warning">RESET PASSWORD</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
          </div>
        </div>
      </div>
      <div id="edit_data_anggota" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">EDIT DATA ANGGOTA</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" action="pages/proses/proses_edit-anggota.php">  
                          <label>ID Anggota</label>
                          <input type="text" name="id_anggota" id="id_anggota" class="form-control" readonly />   
                          <br />
                          <label>Nama</label>  
                          <input type="text" name="nama" id="nama" class="form-control" />  
                          <br />
                          <label>Gmail </label></label>  
                          <input type="email" name="email" id="email" class="form-control" />
                          <br />
                          <label>Alamat</label>  
                          <textarea name="alamat" id="alamat" class="form-control"></textarea>  
                          <br />  
                          <label>Tempat Lahir</label>  
                          <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" />  
                          <br />  
                          <label>Tanggal Lahir</label>  
                          <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" />  
                          <br />
                          <label>Jenis Kelamin</label>  
                            <p><input type="radio" name="jenis_kelamin" id="jenis_kelamin_pria" class="minimal" value="L" style="margin-top: 10px;"> Laki - Laki</p>
                            <p><input type="radio" name="jenis_kelamin" id="jenis_kelamin_wanita" class="minimal" value="P" style="margin-top: 20px;"> Perempuan</p>
                          <br />
                          <div class="form-group">
                          <?php 
                            $sql_query = "SELECT * FROM tb_jabatan";
                            $result = mysqli_query($koneksi,$sql_query);
                          ?>   
                          <label>Jabatan</label>
                          <select class="form-control select2 btn-primary" multiple="multiple" data-placeholder="Pilih Jabatan" name="jabatan"
                                  style="width: 100%; color: #212121;"
                                  data-validation="length" data-validation-length="min1" data-validation-error-msg="Pilih Setidaknya 1 Jabatan"
                                  >
                                  <?php 
                                    while ($row = mysqli_fetch_array($result)){
                                  ?>
                                      <option value="<?php echo $row['id_jabatan']; ?>"> <?php echo $row['jabatan']; ?> </option>
                                  <?php
                                  }
                                  ?>
                          </select>
                        </div>   
                </div>  
                <div class="modal-footer"> 
                     <input type="submit" name="submit" id="insert" value="Update" class="btn btn-success" /> 
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </form>      
                </div>  
           </div>  
      </div>  
 </div>  


  </html>