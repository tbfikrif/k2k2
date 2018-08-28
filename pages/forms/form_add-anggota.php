<!DOCTYPE html>
<?php
  if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../../tampil/home");
  }
  if (strpos($_SESSION['jabatan'], 'Admin')===false) {
    echo '<script>alert("Maaf, Anda bukan Admin"); window.location="../../tampil/home"</script>';
 }
?>
<html>
<head>
  <title>Form Tambah Anggota</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

 </head>

  <body>

  <style>
  @import url('https://fonts.googleapis.com/css?family=Dosis');
  </style>

  <?php 
    $id = mt_rand(10000,99999);
  ?>
  <div class="container fadeInLeft animated" style="width: 70%;">
    <h2>FORM TAMBAH ANGGOTA</h2>
    <br>
    <form action="pages/proses/proses_save-anggota.php" method="POST">
      <div class="form-group">
        <label for="id">ID Anggota </label>
        <input type="text" class="form-control" id="id" placeholder="Id Anggota" name="id" value="<?php echo $id; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="email"> Google Mail (Wajib) </label>
        <input type="email" class="form-control" id="email" placeholder="Isi Gmail" name="email" data-validation="required" data-validation-error-msg="Field Email Harus Diisi !">
        <span class="label label-warning">*Setting Gmail Harus: 'Allow less secure apps': ON dan '2-Step Verificaiton': Off</span>
      </div>
      <div class="form-group">
        <label for="nama"> Nama </label>
        <input 
        type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="nama"
        data-validation="required" data-validation-error-msg="Field Nama Harus Diisi !"
        >
      </div>

      <?php 
        include "../../con_db.php";

        $sql_query = "SELECT * FROM tb_jabatan";
        $result = mysqli_query($koneksi,$sql_query);
      ?>      
              <div class="form-group">
                <label>Jabatan</label>
                <select class="form-control select2 btn-primary" multiple="multiple" data-placeholder="Pilih Jabatan" name="jabatan[]"
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
              <div class="form-group">
                          <label>Status</label>  
                          <select class="form-control select2 btn-primary" data-placeholder="Pilih Status" name="status"
                                  style="width: 100%; color: #212121;"
                                  data-validation="length" data-validation-length="min1" data-validation-error-msg="Pilih Status"
                                  value="<?php echo $row['status']; ?>">
                                <option value="Aktif">Aktif</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                          </select>   
                        </div>
      <div class="form-group">
        <label for="alamat"> Alamat </label>
        <textarea  class="form-control" rows="5" id="alamat" name="alamat" placeholder="Alamat Anggota (Optional)"></textarea>  
      </div>
        <!-- radio -->
              <div class="form-group">
                <label for="jenis_kelamin"> Jenis Kelamin </label>
              <div class="form-group">
                  <p><input type="radio" name="jenis_kelamin" id="jenis_kelamin" class="minimal" value="L" style="margin-top: 10px;"> Laki - Laki</p>
                  <p><input type="radio" name="jenis_kelamin" id="jenis_kelamin" class="minimal" value="P" style="margin-top: 20px;"> Perempuan</p>
              </div>
              </div>
              <div class="form-group">
              <label>No. KTP</label> <?php echo $r['status']; ?>
              <input type="text" placeholder="No KTP" name="noktp" id="noktp" class="form-control" value="<?php echo $res['no_ktp'];?>" data-validation-error-msg="No ktp masih kosong"/>  
              </div>
              <div class="form-group">
                          <label>No. Rekening</label>  
                          <input type="text" placeholder="No Rekening" name="norek" id="norek" class="form-control" value="<?php echo $res['no_rekening'];?>" data-validation-error-msg="No rekening masih kosong">  
                          </div>
              <div class="form-group">
                          <label>NPWP</label>  
                          <input type="text" placeholder="NPWP" name="npwp" id="npwp" class="form-control" value="<?php echo $res['npwp'];?>" data-validation-error-msg="Npwp masih kosong"/>  
                          </div>
       <!-- Date dd/mm/yyyy -->
      <div class="form-group">
        <label for="tempat_lahir"> Tempat Lahir </label>
        <input type="text" class="form-control" id="tempat_lahir" placeholder="Masukan Tempat Lahir (Optional)" name="tempat_lahir">
      </div>
              <div class="form-group">
                <label> Tanggal Lahir </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" id="tanggal_lahir" placeholder="(Optional)" name="tanggal_lahir" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
      <input type="submit" name="submit" class="btn btn-primary" value="Save Data">
    </form>
  </div>

  </body>  
</html>

