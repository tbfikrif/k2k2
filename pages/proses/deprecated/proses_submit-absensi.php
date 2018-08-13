
<?php
	//Composer penggunaan library ElephantIO untuk SOCKET IO
	//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	//session_start();
	//include "../../con_db.php"; //sambung ke database
	//include "../../fungsi_kakatu.php"; //panggil fungsi
	$nama = $_SESSION["nama"];
	$id = $_SESSION["id_anggota"];
	$target_dir = "../../dist/fotolokasi/";
	$ukuran = 2000000;
	//mengambil nilai dari form
	$latKantor = -6.8869112;
	$lngKantor = 107.6168524;
	$status = null;
	$keterangan = null;
	$tgl_awal = null;
	$tgl_akhir = null;
	$filename = null;

	$url_location="https://maps.google.com/?q=".trim($latitude).",".trim($longitude);
	if (isset($_POST['latitude']) && !empty($_POST['latitude'])) {
		$latitude = antiInjection($_POST['latitude']);
		$longitude = antiInjection($_POST['longitude']);
		if (isset($_POST["submit_hadir_form"])) {
			$status =1;
			date_default_timezone_set('Asia/Jakarta');
			$tgl_awal = date("Y-m-d");
			$tgl_akhir= date("Y-m-d");
		} else if (isset($_POST["submit_hadirdiluar_modal"])) {
			if (isset($_POST['keterangan_hadirdiluar']) && !empty($_POST['keterangan_hadirdiluar'])) {
				$status =2;
				date_default_timezone_set('Asia/Jakarta');
				$tgl_awal = date("Y-m-d");
				$tgl_akhir= date("Y-m-d");
				$keterangan = antiInjection($_POST['keterangan_hadirdiluar']);
				$filename = "image_hadirdiluar";
			} else {
				echo '<script>alert("Keterangan Hadir Diluar tidak boleh kosong!");window.location="tampil/form-absensi"</script>';
			}
		} else if (isset($_POST["submit_sakit_modal"])) {
			if (isset($_POST['keterangan_sakit']) && !empty($_POST['keterangan_sakit'])) {
				if (isset($_POST['tglRentangSakit']) && !empty($_POST['tglRentangSakit'])) {
					$status =3;
					$keterangan =antiInjection($_POST['keterangan_sakit']);
					$tglRentangSakit = antiInjection($_POST['tglRentangSakit']);
					$tgl_awal = formatDateSql(substr($tglRentangSakit,0,11));
					$tgl_akhir= formatDateSql(substr($tglRentangSakit,13,25));
					$filename = "image_sakit";
				} else {
					echo '<script>alert("Tanggal Sakit tidak boleh kosong!");window.location="tampil/form-absensi"</script>';
				}
			} else {
				echo '<script>alert("Keterangan Sakit tidak boleh kosong");window.location="tampil/form-absensi"</script>';
			}
		} else if (isset($_POST["submit_izin_modal"])) {
			if (isset($_POST['keterangan_izin']) && !empty($_POST['keterangan_izin'])) {
				if (isset($_POST['tglRentangIzin']) && !empty($_POST['tglRentangIzin'])) {
					$status =4;
					$keterangan =antiInjection($_POST['keterangan_izin']);
					$tglRentangSakit = antiInjection($_POST['tglRentangIzin']);
					$tgl_awal = formatDateSql(substr($tglRentangIzin,0,11));
					$tgl_akhir= formatDateSql(substr($tglRentangIzin,13,25));
					$filename = "image_izin";
				} else {
					echo '<script>alert("Tanggal Izin tidak boleh kosong!");window.location="tampil/form-absensi"</script>';
				}
			} else {
				echo '<script>alert("Keterangan Izin tidak boleh kosong");window.location="tampil/form-absensi"</script>';
			}
		} else if (isset($_POST["submit_cuti_modal"])) {
			if (isset($_POST['keterangan_cuti']) && !empty($_POST['keterangan_cuti'])) {
				if (isset($_POST['tglRentangCuti']) && !empty($_POST['tglRentangCuti'])) {
					$status =5;
					$keterangan =antiInjection($_POST['keterangan_cuti']);
					$tglRentangSakit = antiInjection($_POST['tglRentanggCuti']);
					$tgl_awal = formatDateSql(substr($tglRentangCuti,0,11));
					$tgl_akhir= formatDateSql(substr($tglRentangCuti,13,25));
					$filename = "image_cuti";
				} else {
					echo '<script>alert("Tanggal Cuti tidak boleh kosong!");window.location="tampil/form-absensi"</script>';
				}
			} else {
				echo '<script>alert("Keterangan Cuti tidak boleh kosong");window.location="tampil/form-absensi"</script>';
			}
		}
	} else {
		echo '<script>alert("Anda harus mengizinkan Permintaan Lokasi untuk bisa absen");window.location="tampil/form-absensi"</script>';
	}
	//Ambil Jarak
	$distance = getDistance($latitude, $longitude,$latKantor, $lngKantor);
	if ($status==1) {
		if( $distance < 100 ) {
			//call fungsi submit absensi
			submitAbsensi($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir,$target_dir,$filename,$ukuran);
		} else {
				echo '<script>alert("Absen Hadir Gagal karena Anda berada '.round($distance/1000,3).'km dari kantor");window.location="tampil/form-absensi"</script>';
		}
	} else {
			if ($tgl_awal==$tgl_akhir) {
				//call fungsi submit absensi
				submitAbsensi($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir,$target_dir,$filename,$ukuran);
				//call fungsi update cuti
				updateCutiUsed($id,$status,$tgl_awal,$tgl_akhir);
			} else {
				if ($status==5) {
					$cutiUsed=countCuti($tgl_awal,$tgl_akhir,$koneksi);
					//echo $cutiUsed;
					if($cutiUsed<=$_SESSION['sisacuti']){
						submitAbsensi($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir,$target_dir,$filename,$ukuran);
						//call fungsi update cuti
						updateCutiUsed($id,$status,$tgl_awal,$tgl_akhir);
						//ambil nama foto untuk di masukkan ke tabel tb_cronjob_rencana_absen
						cronRencanaAbsen($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir);
					} else {
						echo '<script>alert("Cuti yang digunakan '. $cutiUsed.' melebihi SISA CUTI anda!");window.location="tampil/form-absensi"</script>';
					}
				} else {
					submitAbsensi($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir,$target_dir,$filename,$ukuran);
					//ambil nama foto untuk di masukkan ke tabel tb_cronjob_rencana_absen
					cronRencanaAbsen($id,$status,$keterangan,$latitude,$longitude,$tgl_awal,$tgl_akhir);
				}
			}
	}	
?>
 
