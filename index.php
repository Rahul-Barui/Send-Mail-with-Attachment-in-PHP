<?php
	if(isset($_POST['send'])){
		
		// -------------------------- Uploaded File Details -----------------------
		
		$resume = $_FILES['resume'];
		$resume_name = $resume['name'];
		$resume_type = $resume['type'];
		$tmp_name = $resume['tmp_name'];
		$resume_size = $resume['size'];
		
		//------------------- Start Mail Function here ---------------------
		
		$to = "testingmail@gmail.com"; // Enter any valid Email
		$subject = 'Testing By RB';
		$from = "Software-Developer";
		$aa=filesize($tmp_name);
		$headers = "From: $from";
		$msg = "Your Attachment given Below...";
		$message = strip_tags($msg);
		
		$file = fopen($tmp_name,'rb');
		$data = fread($file,filesize($tmp_name));
		fclose($file);
		$semi_rand = md5(time());
	
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
		// Add a multipart boundary above the plain message
		$message .= "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" ."Content-Type: text/html; charset=\"iso-8859-1\"\n" ."Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
		// Base64 encode the file data
		$data = chunk_split(base64_encode($data));
		// Add file attachment to the message
		$message .= "--{$mime_boundary}\n" ."Content-Type: {$resume_type};\n" . " name=\"{$resume_name}\"\n" ."Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" ."--{$mime_boundary}--\n";
	
		// Send the message;
		$ok = @mail($to, $subject, $message, $headers);
		
		if($ok){
		?>
			<script type="text/javascript">
				alert('Pleasse check your Mail for Reg Id (also check on spam folder)');
				window.location.href="index.php";
			</script>
		<?php
		}else{
		?>
			<script type="text/javascript">
				alert('Something Wrong..Please Try Again');
				window.location.href="index.php";
			</script>
		<?php
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Php Send Email with Attachment [ Pdf, Doc, Docx ]</title>
</head>

<body>
	<br /><br /><br />
	<p align="center">
	<font color="#0033FF" size="3"><b>Php Send Email with Attachment [ Pdf, Doc, Docx ]</b></font><br /><br />
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
			<center>
				<input type="file" name="resume">
				<input type="submit" name="send" value="SEND MAIL" />
			</center>
		</form>
	</p>
</body>
</html>
