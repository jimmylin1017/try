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
<title>Login</title>
</head>

<body>

<div class="container">

  <form class="form-signin" method="POST" action="<?php echo $loginFormAction ?>">
  	<h2 class="form-signin-heading">Please log in</h2>
    <label for="inputAccount" class="sr-only">Account</label>
    <input type="text" id="inputAccount" name="account" class="form-control" placeholder="Account" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login" name="login" value="login">Log in</button>
  </form>

</div> <!-- /container -->


<!--
<div class="container">
  <form class="form-signin" method="POST" action="<?php //echo $loginFormAction ?>">
  <h2 class="form-signin-heading">Please sign in</h2>
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
-->

<style>

body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

/*.container {
    padding: 70px 0;
}*/
</style>


</body>
</html>

