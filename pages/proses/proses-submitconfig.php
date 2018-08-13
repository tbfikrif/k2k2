<?php
	if(isset($_POST['email-admin']) && isset($_POST['password-admin']) && isset($_POST['secret-key']) && isset($_POST['secret-iv']) && isset($_POST['secret-iv']) && isset($_POST['api-google'])){
		$email_admin=antiInjection($_POST['email-admin']);
		$pass_admin=antiInjection($_POST['password-admin']);
		$secret_key=antiInjection($_POST['secret-key']);
		$secret_iv=antiInjection($_POST['secret-iv']);
		$api_google=antiInjection($_POST['api-google']);
		$errmsg=null;
		$qry = "INSERT INTO tb_konfigurasi_kakatu (email_admin,pass_email,secret_key,secret_iv,api_key_google,tanggal_set,jam_set) VALUES ('$email_admin','$pass_admin','$secret_key','$secret_iv','$api_google',CURRENT_DATE(),CURRENT_TIME())";
		inUpDel($qry,$errmsg);
		if ($errmsg!=null) {
			echo "error: ".$errmsg;
		} else {
			echo '<script>alert("Konfigurasi Berhasil disimpan");window.location="' . $obsolutePath . 'login/form"</script>';
		}
	}
?>