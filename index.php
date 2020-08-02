<?php
//index.php
include('database_connection.php');

if(!isset($_SESSION["logged_in"]))
{
	header("location:login.php");
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
		<br />
		<h1 align="center">ระบบสมัครสมาชิกและการเข้าสู่ระบบโดยใช้ Two-Factor Authentication ผ่าน Email</h1>
		
		<h3 align="center">ยินดีต้อนรับเข้าสู่ระบบ</h3>
		
		<h4 align="center"><a href="logout.php">ออกจากระบบ</a></h4>
	
	</body>
	
</html>

