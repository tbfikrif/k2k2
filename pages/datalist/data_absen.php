<?php
if (!defined('DIDALAM_INDEX_PHP')) {
    //echo "Dilarang broh!";
    header("Location: ../../home");
}
//if (strpos($_SESSION['jabatan'], 'Admin')===false) {
  //  echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
//}

//Untuk link filter dari menu tabel rekap
unset($_SESSION['id-anggota-rekap']);
unset($_SESSION['id-anggota-rekap']);
if (isset($_GET["id-anggota-rekap"])) {
  //echo '<script>console.log("tai")</script>';
  $_SESSION['id-anggota-rekap'] = antiInjection($_GET["id-anggota-rekap"]);
  $_SESSION['status-rekap'] = antiInjection($_GET["status-rekap"]);
}
//End Untuk link filter dari menu tabel rekap
?>

  <section id="form_data-absen-admin" style="margin: 0 auto;">

    <div class="container fadeIn animated">

      <h2> DATA ABSENSI <span id="filterLabelAbsen"></span></h2>
      <hr style="
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #ccc, #333, #ccc);">
    </div>
    <div class="container bounceInLeft animated">
      <div class="row">
        <div class="row">
          <div class="col col-xs-6 flipInX animated">
            <div class="form-group flipInX animated">
              <label> FILTER TANGGAL </label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" id="tglRentangFilterAbsen" name="tglRentangFilterAbsen" style="width: 165px;" placeholder="Isikan Filter Tangal">
                </div>
            </div>
          </div>
        </div>
        <div class="form-group flipInX animated">
          <label> FILTER STATUS </label>
            <div class="input-group">
              <button id="buttom_filter_status_view_all" class="btn btn-default btn-xs">VIEW ALL</button>
              <button id="buttom_filter_status_hadir" class="btn btn-info btn-xs" style="margin-left: 3px;">HADIR</button>
              <button id="buttom_filter_status_hadir_diluar" class="btn btn-primary btn-xs" style="margin-left: 3px;">TUGAS KANTOR</button>
              <button id="buttom_filter_status_sakit" class="btn btn-danger btn-xs" style="margin-left: 3px;">SAKIT</button>
              <button id="buttom_filter_status_izin" class="btn btn-warning btn-xs" style="margin-left: 3px;">IZIN</button>
              <button id="buttom_filter_status_cuti" class="btn btn-success btn-xs" style="margin-left: 3px;">CUTI</button>
              <button id="buttom_filter_status_kerja_remote" class="btn btn-default btn-xs" style="margin-left: 3px;">KERJA REMOTE</button>
              <button id="buttom_filter_status_alpha" class="btn btn-default btn-xs" style="margin-left: 3px;">ALPHA</button>
            </div>
        </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="data_absen_admin">
              <thead>
                <tr>
                  <th> ID </th>
                  <th> Tanggal</th>
                  <th> Jam Masuk</th>
                  <th> Jam Keluar</th>
                  <th> ID Anggota </th>
                  <th> Nama </th>
                  <th> Status</th>
                  <th> Action </th>
                </tr>
              </thead>
            </table>
          </div>
      </div>
    </div>
  </section>
  <div id="dataModal" class="modal fade" style="overflow: auto !important;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Kehadiran</h4>
        </div>
        <div class="modal-body" id="detail_kehadiran">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
    </div>
  </div>
  <!--Modal Preview Gambar -->
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="min-height: 100%;height: auto;border-radius: 0;background: transparent;">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <img src="" class="imagepreview" style="width: 100%;">
        </div>
      </div>
    </div>
  </div>
  <!--Modal Edit Absen -->
  <div id="editAbsen_Modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">EDIT DATA ABSEN</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="pages/proses/proses_edit-absen-admin.php">
            <label>ID Absen</label>
            <input type="text" name="id_absen" id="id_absen" class="form-control" readonly />
            <label>ID Anggota</label>
            <input type="text" name="id_anggota_absen" id="id_anggota_absen" class="form-control" readonly />
            <br />
            <select class="form-control" id="status_id_adminEdit" name="status_id">
              <?php
                $sql = "SELECT * FROM tb_absen";
                $result = mysqli_query($koneksi, $sql);
                while ($row_status_absen = mysqli_fetch_array($result)) {
              ?>
                <option style="background-color:<?php echo $row_status_absen['warna'] ?>;color:white;font-weight:bold" value="<?php echo $row_status_absen['status_id'] ?>">
                  <?php echo $row_status_absen['status'] ?>
                </option>
              <?php
                }
              ?>
            </select>
            <label>Alasan/Keterangan</label>
            <textarea class="form-control" rows="3" id="keterangan_absen" name="keterangan_absen" placeholder="Isi Keterangan"></textarea>
            <!-- Date -->
            <div class="form-group">
              <label>Date:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <!-- Bukan untuk cuti -->
                <input type="text" class="form-control pull-right tglRentang" id="tglRentangAbsenAdmin" name="tglRentangAbsenAdmin">
              </div>
              <!-- /.input group -->
            </div>
            <!-- /.form group -->
        </div>
        <div class="modal-footer">
          <input type="submit" name="submit" id="insert" value="Update" class="btn btn-success" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
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