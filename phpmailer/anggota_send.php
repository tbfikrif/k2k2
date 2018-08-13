<?php
	$id_pembayaran = $_SESSION['id_pembayaran'];

	$sql = "SELECT jenis FROM tb_jenistransaksi WHERE id_jenis = '$jenis'";

	$result=mysqli_query($koneksi,$sql);

	 if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 

	$value=mysqli_fetch_assoc($result);

	$email = $_SESSION['email'];
	$pass = $_SESSION['pass'];
	$nama = $_SESSION['nama'];

	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 2;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $email;    					 // SMTP username
	$mail->Password = $pass;                         // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->setFrom($email,$nama);



	$mail->addAddress(getLastConfig("email_admin"));     // Add a recipient
	
	//$mail->addReplyTo('info@example.com', 'Information');

	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	$mail->isHTML(true);                                  // Set email format to HTML

	$jml_uang = number_format($nominal);

	  $datenow = date('d-m-Y', strtotime($tgl_new_format)); 
      $dayname = date('l', strtotime($tgl_new_format));
      $day = date('j', strtotime($tgl_new_format));
      $month = date('F', strtotime($tgl_new_format));
      $year = date('Y', strtotime($tgl_new_format));

       if($dayname =="Monday"){
      	$hari = "Senin";
      } else if($dayname == "Tuesday"){
      	$hari = "Selasa";
      } else if ($dayname == "Wednesday"){
      	$hari = "Rabu";
      } else if ($dayname == "Thursday"){
      	$hari = "Kamis";
      } else if ($dayname == "Friday"){
      	$hari = "Jumat";
      } else if($dayname == "Saturday"){
      	$hari = "Sabtu";
      } else if($dayname == "Sunday"){
      	$hari = "Minggu";
      }

	$mail->Subject = "NEW REIMBURSE (ID Pembayaran: $id, Perihal : $value[jenis])";
	$mail->Body    = "Admin, <br><br>
	Saya baru saja <b> $value[jenis]</b> dengan ID Pembayaran <b>$id</b>, pada hari <b>$hari, $datenow</b>. Sebesar <b>Rp.$jml_uang</b>. Mohon segera di Reimburse. <br><br>
	Regards, <br>
	$nama
	";
	
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			 echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Email berhasil terkirim";
		}
?>