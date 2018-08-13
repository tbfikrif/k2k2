<?php
	//include "../../../fungsi_kakatu.php";
	if (isset($_POST['id'])) {
		$id = antiInjection($_POST['id']);
		$qry = "DELETE FROM tb_tgllibur WHERE id='$id'";
		$errmsgDeleteLibur=null;
		inUpDel($qry,$errmsgDeleteLibur);
	}
?>
