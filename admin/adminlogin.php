<?php
	include_once("include/reference.php");
?>

<?php

	// 啟動 SESSION
	if( !isset($_SESSION) ) 
	{
		session_start();
	}
	
	$myPDO = MyPDO::getInstance();	
	$loginFormAction = $_SERVER['PHP_SELF'];
	$redirectLoginSuccess = "admineditconfig.php";
	$redirectLoginFail = "adminlogin.php";
	
	if( !isset($_SESSION['Account']) ) {
		if( isset($_POST["login"]) ) {
			$tableName = "admin";
			$arrCommand = array($_POST["account"], $_POST["password"]);
			$whereCommand = "account = ? AND password = ?";
			$confirm = $myPDO->searchWhere( $tableName, $arrCommand, $whereCommand );
			
			if( $confirm == NULL ) {
				header( "Location:" . $redirectLoginFail );
			}
			else {
				$_SESSION['Account'] = $_POST["account"];
				$_SESSION['Password'] = $_POST["password"];
				$_SESSION['Username'] = $confirm[0]["username"];
				header( "Location:" . $redirectLoginSuccess );
			}
		}
	}
	else if( isset($_POST["login"]) && $_SESSION["Account"] == $_POST["account"] && $_SESSION["Password"] == $_POST["password"] )
	{
		header( "Location:" . $redirectLoginSuccess );
	}
	
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Lonin</title>
</head>

<body>

<div class="container">
  <form method="POST" action="<?php echo $loginFormAction ?>">
    <div class="form-group row">
      <label for="account" class="col-2 col-form-label">Account</label>
      <div class="col-2">
        <input type="text" class="form-control" name="account" id="account"  placeholder="Account">
      </div>
    </div>
    <div class="form-group row">
      <label for="password" class="col-2 col-form-label">Password</label>
      <div class="col-2">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
      </div>
    </div>
    <div class="form-group row">
      <div class="offset-2 col-2">
        <button type="submit" class="btn btn-primary" id="login" name="login" value="login">Sign in</button>
      </div>
    </div>
  </form>
</div>

<style>
.container {
    padding: 70px 0;
}
</style>

</body>
</html>

