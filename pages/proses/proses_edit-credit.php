 <?php  
      include "../../fungsi_kakatu.php";
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      //$nominal1 = str_replace(',', '', $nominal);
      //$topup = str_replace('Rp ', '', $nominal1);
      $errmsg=null;
      prosesEditCredit($_POST["id_credit"],str_replace('.', '', $_POST["topup_credit"]),str_replace('.', '', $_POST["uang_makan"]),$errmsg);
      if ($errmsg!==null) {
            echo '<script>alert("Terjadi Error:'.$errmsg.'")</script>';
      } else {
            echo '<script>alert("Data Jumlah Akomodasi dengan ID '.$id.', Berhasil Di Update"); document.location.href="../../tampil/data-akomodasi"</script>';
      }
?>   
