<?php
  if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../../tampil/home");
  }
?>
<body class="hold-transition skin-blue sidebar-mini">

<style>
@import url('https://fonts.googleapis.com/css?family=Dosis');
</style>
<?php 
session_start();
  setlocale(LC_ALL, 'IND');
  
  $_SESSION['jenis'] = $_GET['jenis'];
  $id_anggota = $_SESSION['id_anggota'];

  $tgl_now = date("d-m-Y"); 
  $dayname = date('l', strtotime($tgl_now));
  $day = date('j', strtotime($tgl_now));
  $month = date('F', strtotime($tgl_now));
  $year = date('Y', strtotime($tgl_now));
 
  $id = mt_rand(10000,99999);
  
  ?>
<div class="container fadeInLeft animated" style="width: 70%;">
<h3 style="float: right;"> <?php echo $dayname." , ".$day." - ".$month." - ".$year; ?> </h3>
<hr>
<br>
<br>
  <h2>FORM PEMBAYARAN</h2> 
  <br>
  <form action="pages/proses/proses_pembayaran.php" method="POST" enctype="multipart/form-data" id="form_pembayaran">
    
    <div class="form-group">
      <label for="id_pembayaran">ID</label>
      <input type="text" class="form-control" id="id_pembayaran" placeholder="Id Pembayaran" name="id_pembayaran" value="<?php echo $id; ?>" readonly>
    </div>

    <div class="form-group">
      <label for="Id_anggota">ID Anggota</label>
      <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="<?php echo $id_anggota; ?>" readonly>
    </div>

    <?php 

      if( $_SESSION['jenis']=='listrik'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar Listrik'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

    ?>
        <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control btn-success" id="jenis" name="jenis" onChange="myNewFunction(this);">
        <option value="<?php echo $value['id_jenis']?>"> <?php echo $value['jenis']?> </option>
      </select>
    </div>
    <?php
      } else if( $_SESSION['jenis']=='air'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar Air Minum'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

    ?> 
        <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control btn-info" id="jenis" name="jenis" onChange="myNewFunction(this);">
        <option value="<?php echo $value['id_jenis']?>"> <p style="color: #f9f9f9;"><?php echo $value['jenis']?></p> </option>
      </select>
      </div>
    <?php
      } else if( $_SESSION['jenis']=='ART'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar ART'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

        ?>
          <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control" style="background-color: #fffc4c;" id="jenis" name="jenis" onChange="myNewFunction(this);">
        <option value="<?php echo $value['id_jenis']?>"> <b><?php echo $value['jenis']?></b> </option>
      </select>
      </div>
        <?php
      } else if( $_SESSION['jenis']=='sampah'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar Sampah'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

        ?>
          <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control btn-warning" id="jenis" name="jenis" onChange="myNewFunction(this);">
        <option value="<?php echo $value['id_jenis']?>"> <?php echo $value['jenis']?> </option>
      </select>
      </div>
    <?php
      } else if( $_SESSION['jenis']=='konsumsi'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar Konsumsi'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

        ?>
          <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control btn-primary" id="jenis" name="jenis" onChange="myNewFunction(this);">
        <option value="<?php echo $value['id_jenis']?>"> <?php echo $value['jenis']?> </option>
      </select>
      </div>
    <?php
      } else if( $_SESSION['jenis']=='transport'){

        $sql = "SELECT * FROM tb_jenistransaksi WHERE jenis = 'Bayar transport'";
        $result = mysqli_query($koneksi, $sql);
        $value = mysqli_fetch_assoc($result);

        ?>
          <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select class="form-control btn-danger" id="jenis" name="jenis" onChange="myNewFunction(this);" >
        <option value="<?php echo $value['id_jenis']?>"> <?php echo $value['jenis']?> </option>
      </select>
      </div>
    <?php
      } else {

        $sql = "SELECT * FROM tb_jenistransaksi";
        $result = mysqli_query($koneksi, $sql);

    ?>
    <div class="form-group">
      <label for="jenis"> Jenis Pembayaran </label>
      <select 
      class="form-control" id="jenis" name="jenis"
      data-validation="required" data-validation-error-msg="Pilih Jenis Pembayaran !"
      >
      <option value=""> Pilih Pembayaran </option>
        <?php  while ($r = mysqli_fetch_array($result)) {
          ?>
          <option value="<?php echo $r[id_jenis]?>"> <?php echo $r[jenis]; ?> </option>
        <?php
        } ?>
        
      </select>
    </div>
    <?php } ?>
    <div class="form-group">
      <label for="nominal"> Nominal </label>
      <input 
      class="form-control" type="text" id="gaji" name="nominal"
      data-validation="required" data-validation-error-msg="Field Nominal Harus Diisi !"
      >
    </div>

    <div class="form-group">
      <label for="keterangan"> Keterangan </label>
      <textarea 
      class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Contoh : Pembayaran XXXX Lewat Transfer Bank dsb." 
      data-validation="required" data-validation-error-msg="Beri Keterangan Pada Pembayaran Anda !"
      ></textarea>
    </div>

    <div class="form-group">
      <label for="bukti"> Bukti Pembayaran <p>(Optional untuk Pembayaran dibawah Rp. 70,000)</p> </label>
      <input class="form-control" type="file" name="bukti" id="fotobukti" data-validation="size" data-validation-max-size="2M" data-validation-error-msg="File terlalu Besar ! (MAX 2MB) "/>
    </div>

    <div id="myAlert" class="alert alert-danger collapse">
    <a id="linkClose" href="#" class="close">&times;</a>
    <strong>Warning!</strong> Pembayaran diatas Rp. 70,000 harus disertai bukti !
    </div>
    <div id="myAlertTrans" class="alert alert-danger collapse">
    <a id="linkCloseTrans" href="#" class="close">&times;</a>
    <strong>Warning!</strong> Pembayaran Transport harus disertai bukti !
    </div>

    <br>
    <input name="submit" type="submit" id="btnSubmit" class="btn btn-primary" value="SUBMIT"> 
    <br>
    <br>
  </form>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {

        $('#btnSubmit').click(function () {
          var nominal = document.getElementById('numeric').value
          var value_1 = nominal.replace(/\./g,'');
          var value = value_1;

          var e = document.getElementById("jenis");
          var str = e.options[e.selectedIndex].value;

          if(document.getElementById("fotobukti").files.length == 0 && value >= 70000){
            $('#myAlert').show('fade');
            return false;
          } else if(document.getElementById("fotobukti").files.length == 0 && str == "TR-05"){
            $('#myAlertTrans').show('fade');
            return false;
          }
        });

        $('#linkClose').click(function () {
            $('#myAlert').hide('fade');
        });

         $('#linkCloseTrans').click(function () {
            $('#myAlertTrans').hide('fade');
        });

    });
</script>

