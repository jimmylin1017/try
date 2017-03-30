<?php
	// 啟動 SESSION
	if( !isset($_SESSION) ) 
	{
		session_start();
	}
		
	unset($_SESSION['Account']);
	unset($_SESSION['Password']);
	
	$redirectLoginPage = "adminlogin.php";
	
	header( "Location:" . $redirectLoginPage );

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Logout</title>
</head>

<body>

</body>
</html>