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

<?php
	// connect to MySql
	$myPDO = MyPDO::getInstance();
	$tableName = "web_topmenu";
?>

<style type="text/css">
	body {
		margin-top: 20px;
	}
</style>

</head>

<body>

<div class="container">
	<div class="row">
		<?php
			include_once("include/admineditmenu.php");
		?>
		topmenu
	</div>
</div>

</body>
</html>