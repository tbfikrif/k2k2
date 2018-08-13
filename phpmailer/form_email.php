<html>

	<head>
		<title> Kirim Email </title>
	</head>

		<body>
			<form method="POST" action="email.php">
				<input type="email" name="email_to" placeholder="Send To :">
				<input type="text" name="subject" placeholder="Email Subject">
				<textarea name="email_body" placeholder="Say Something"></textarea>
				<input type="submit" name="send" value="SEND EMAIL">
			</form>						
		</body>

</html>