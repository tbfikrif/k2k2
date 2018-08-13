   <?php  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "../../../fungsi_kakatu.php";
      
      $id = $_POST['id'];
      //$id='10001';
      echo fetchCreditForPaid($id);
 ?>