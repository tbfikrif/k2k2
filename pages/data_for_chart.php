    <?php 
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    header('Content-Type : application/json');
    include "../con_db.php";

         $sql_grafik = sprintf("SELECT DISTINCT MONTH(`tanggal`) as Bulan, SUM(`nominal`) as Total FROM `tb_pembayaran` WHERE `status` = '2' GROUP BY `tanggal`");
         $hasil = $koneksi->query($sql_grafik);

              if (!$hasil) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 


         $data = array();

         foreach ($hasil as $row_hasil) {
         	$data[] = $row_hasil;
         }

         print json_encode($data);
      ?> 