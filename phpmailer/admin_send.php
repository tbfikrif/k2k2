<?php
$id_pembayaran = $_SESSION['id_pembayaran'];

$sql = "SELECT tb_pembayaran.id_pembayaran, tb_anggota.id_anggota, tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.id_jenis, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.keterangan, tb_pembayaran.status, tb_anggota.email FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis WHERE tb_pembayaran.id_pembayaran='$id_pembayaran'";

$result = mysqli_query($koneksi, $sql);

if (!$result) {
    printf("Error: %s\n", mysqli_error($koneksi));
    exit();
}

$value = mysqli_fetch_assoc($result);

$recipient = $value['email'];

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
//Konfig
$mailAdmin = getLastConfig("email_admin");
$passAdmin = getLastConfig("pass_email");
//End Konfig
$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
//$mail->Username = 'operasionalkantorkp@gmail.com';    // SMTP username
//$mail->Password = 'kiwikiwi12';
$mail->Username = $mailAdmin; // SMTP username
$mail->Password = $passAdmin; // SMTP password
$mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
$mail->SMTPOptions = array(
	'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	)
);
$mail->Port = 465; // TCP port to connect to
$mail->setFrom($mailAdmin, 'Admin');

$mail->addAddress($recipient); // Add a recipient

//$mail->addReplyTo('info@example.com', 'Information');

//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

$mail->isHTML(true); // Set email format to HTML

$jml_uang = number_format($value[nominal]);
date_default_timezone_set("Asia/Jakarta");

$date = date('d-m-Y', strtotime($value[tanggal]));
$dayname = date('l', strtotime($value[tanggal]));
$day = date('j', strtotime($value[tanggal]));
$month = date('F', strtotime($value[tanggal]));
$year = date('Y', strtotime($value[tanggal]));

if ($dayname == "Monday") {
    $hari = "Senin";
} else if ($dayname == "Tuesday") {
    $hari = "Selasa";
} else if ($dayname == "Wednesday") {
    $hari = "Rabu";
} else if ($dayname == "Thursday") {
    $hari = "Kamis";
} else if ($dayname == "Friday") {
    $hari = "Jumat";
} else if ($dayname == "Saturday") {
    $hari = "Sabtu";
} else if ($dayname == "Sunday") {
    $hari = "Minggu";
}

$mail->Subject = "CEK REIMBURSE (ID Pembayaran: $id_pembayaran, Perihal : $value[jenis])";
$mail->Body = "$value[nama], <br><br>
	Uang <b>$value[jenis]</b> dengan ID Pembayaran <b>$value[id_pembayaran]</b>, pada hari <b>$hari, $date</b>. Sebesar <b>Rp. $jml_uang</b> sudah di Transfer ke Rekening Bank Anda, silahkan di cek. <br><br>
	Regards, <br>
	Admin
	";

//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send()) {
    ?>
			<script type="text/javascript">
		    alert('Gagal Mengirim Email Konfirmasi.'. $mail->ErrorInfo);
			</script>
			<?php
} else {
    ?>
			<script type="text/javascript">
		    alert('Email Konfirmasi Terkirim');
			</script>
			<?php
}

?>