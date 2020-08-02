<?php

error_reporting(0);
session_start();
$sessionlifetime = 5; //กำหนดเป็นนาที
 
if(isset($_SESSION["timeLasetdActive"])){
	$seclogin = (time()-$_SESSION["timeLasetdActive"])/60;
	//หากไม่ได้ Active ในเวลาที่กำหนด
	if($seclogin>$sessionlifetime){
		//goto logout page
		session_destroy();
		header("location:login.php");
		exit;
	}else{
		$_SESSION["timeLasetdActive"] = time();
	}
}else{
	$_SESSION["timeLasetdActive"] = time();
}
//

if(isset($_POST['verifyotp']))
{
$rno=$_SESSION['otp'];
$urno=$_POST['otpvalue'];
if(!strcmp($rno,$urno))
{
$_SESSION['logged_in'] = $_SESSION['user_id'];
header("location:index.php");

}
else{
	$errormessage =  " <label class='text-danger'> รหัส OTP ไม่ถูกต้อง , กรุณาตรวจสอบอีกครั้ง </label> ";
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
		<title>ระบบยืนยันตัวตนด้วย One Time Password</title>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container" style="width:100%; max-width:600px">
			<h2 align="center">ระบบยืนยันตัวตนด้วย One Time Password</h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading"><h4>รหัส OTP ถูกส่งไปแล้ว, กรุณาตรวจสอบ Email ของคุณ.</h4></div>
				<div class="panel-body">
					<form method="post">
					<?php echo $errormessage; ?>
						<div class="form-group">
							<input type="password" name="otpvalue" class="form-control" required />
						</div>
				
						<div class="form-group">
							<input type="submit" name="verifyotp" value="Login" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>