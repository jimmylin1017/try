<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>後臺管理</title>

<?php
	include_once("include/reference.php");
?>

<?php
	// 啟動 SESSION
	if( !isset($_SESSION) ) 
	{
		session_start();
	}
	
	$redirectLoginPage = "adminlogin.php";
	
	if( $_SESSION['Account'] == NULL ) {
		header( "Location:" . $redirectLoginPage );
	}
?>

<style type="text/css">
	body {
		margin-top: 20px;
	}
</style>

</head>

<body>

<div class="container">

<?php
	include_once("include/admineditmenu.php");
?>

</div>

</body>
</html>