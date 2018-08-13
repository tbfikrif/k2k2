<?php  
 //fetch.php  
 include "../../../fungsi_kakatu.php";
 if(isset($_POST["id_credit"])){
     $id = antiInjection($_POST["id_credit"]);
     fetchCreditsJSON($id);
 }
 ?>