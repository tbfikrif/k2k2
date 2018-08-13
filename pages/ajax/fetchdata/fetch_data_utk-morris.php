 <?php 
  include "../../../con_db.php";

        $sql_grafik_jenis = "SELECT tb_jenistransaksi.jenis, COUNT(tb_pembayaran.id_jenis) as 'jumlah' FROM tb_pembayaran JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis=tb_jenistransaksi.id_jenis WHERE YEAR(tb_pembayaran.tanggal) = '2017' GROUP BY tb_pembayaran.id_jenis";
        
        $res_donut = mysqli_query($koneksi, $sql_grafik_jenis);

        $data = array();

          while($row = mysqli_fetch_array($res_donut))
          {
           $data[] = array(
            'label'  => $row['jenis'],
            'value'  => $row['jumlah']
           );
          }
          $data = json_encode($data);
?>