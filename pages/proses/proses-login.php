<?php
	if(isset($_POST['email']) && isset($_POST['password'])){
		$email=antiInjection($_POST['email']);
		$password=antiInjection($_POST['password']);
		$password=encodeData($password);
		$query = "SELECT a.id_anggota, a.password, a.nama, GROUP_CONCAT(c.jabatan SEPARATOR ', ') as 'jabatan', a.email FROM tb_anggota a JOIN jabatan_anggota b ON a.id_anggota = b.id_anggota JOIN tb_jabatan c ON c.id_jabatan = b.id_jabatan WHERE a.email = '$email' AND a.password = '$password' GROUP BY a.id_anggota";
		$result = mysqli_query($koneksi,$query);
		$values = mysqli_fetch_assoc($result);
		$nama = $values['nama'];
		$jabatan = $values['jabatan'];
		$id_anggota = $values['id_anggota'];
		$email = $values['email'];
		$pass_anggota = $values['password'];
		$_SESSION["nama"] = $nama;
		$_SESSION["jabatan"] = $jabatan;
		$_SESSION["id_anggota"] = $id_anggota;
		$_SESSION["email"] = $email;
		$_SESSION["pass"] = decodeData($pass_anggota);
		$count = mysqli_num_rows($result);
		if($count>0) {
			header('Location: ../tampil/home');
		} else {
			echo '<script>alert("Login Gagal!");window.location="../login/form"</script>';
		}
	} else {
		echo '<script>window.location="../tampil/home"</script>';
	}
?>