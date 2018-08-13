<?php
   if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
        header("Location: ../../tampil/home");
	}
	if (strpos($_SESSION['jabatan'], 'Admin')===false) {
		echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
	 } else {
			readfile('pages/views/datalist/tgllibur.html');
	 }
?>


