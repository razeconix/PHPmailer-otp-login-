<?php

//login.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('database_connection.php');

$message = '';

if(isset($_POST["login"])){

	$query = "
	SELECT * FROM register_user 
		WHERE user_email = :user_email
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
				'user_email'	=>	$_POST["user_email"]
			)
	);
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if($row['user_email_status'] == 'verified')
			{
				if(password_verify($_POST["user_password"], $row["user_password"]))
				//if($row["user_password"] == $_POST["user_password"])
				{
			
					$rndno=rand(100000, 999999);
					$message = urlencode("otp number.".$rndno);
					
					$mail_body = "
			
			<p><h3>กรุณานำรหัส OTP ไปกรอกที่หน้าเว็บเพื่อเข้าสู่ระบบ(ต้องไม่มีช่องว่างระหว่างตัวเลข)</h3></p>
			<p><h2>รหัส OTP - ".$rndno."</h2></p>
			";
			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';

			$mail = new PHPMailer;
   $mail->IsSMTP();        //Sets Mailer to send message using SMTP
   $mail->Host = 'smtp.gmail.com';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
   $mail->Port = '587';        //Sets the default SMTP server port
   $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
   $mail->Username = '###YOUR EMAIL';     //Sets SMTP username
   $mail->Password = '####YOUR EMAIL PASSWORD';     //Sets SMTP password
   $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
   $mail->From = '###EMAIL TO DISPLAY';   //Sets the From email address for the message
   $mail->FromName = 'Two-Factor Authentication';     //Sets the From name of the message
   $mail->AddAddress($_POST['user_email'], $_POST['user_name']);  //Adds a "To" address   
   $mail->WordWrap = 50;      //Sets word wrapping on the body of the message to a given number of characters
   $mail->IsHTML(true);       //Sets message type to HTML    
   $mail->Subject = 'OTP Verification';   //Sets the Subject of the message
   $mail->Body = $mail_body;       //An HTML or plain text message body
   if($mail->Send())        //Send an Email. Return true on success or false on error
   {
    $message = '<label class="text-success"> รหัส OTP ถูกส่งไปแล้ว , กรุณาตรวจสอบ Email ของคุณ </label>';
			}

					$_SESSION['user_id'] = $row['register_user_id'];
					$_SESSION['otp']=$rndno;				
					header("location:otp.php");
				}
				else
				{
					$message = "<label class='text-danger'>กรุณาตรวจ Password ของคุณอีกครั้ง </label>";
				}
			}
			else
			{
				$message = "<label class='text-danger'> กรุณายืนยันตัวตนผ่านEmail ของคุณก่อนเข้าสู่ระบบ </label>";
			}
		}
	}
	else
	{
		$message = "<label class='text-danger'> กรุณาตรวจ Email address ของคุณอีกครั้ง </label>";
	}
}

?>


<script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script> 

<!DOCTYPE html>
<html>
	<head>
		<title>ระบบสมัครสมาชิกและการเข้าสู่ระบบโดยใช้ Two-Factor Authentication ผ่าน Email</title>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container" style="width:100%; max-width:600px">
			<h2 align="center">ระบบสมัครสมาชิกและการเข้าสู่ระบบโดยใช้ Two-Factor Authentication ผ่าน Email</h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading"><h4>เข้าสู่ระบบ</h4></div>
				<div class="panel-body">
					<form method="post">
						<?php echo $message; ?>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="user_email" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="user_password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" value="Login" class="btn btn-info" />
						</div>
					</form>
					<p align="right"><a href="register.php">สมัครสมาชิก</a></p>
				</div>
			</div>
		</div>
	</body>
</html>

