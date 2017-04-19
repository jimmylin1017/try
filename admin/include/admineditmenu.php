<script type="text/javascript">
	function checkLogOut() {
		return confirm("確定要登出嗎？");
	}
	
</script>


<div class="col col-2">
	<h1>MENU</h1>
	<?php
		if( !isset($_SESSION) ) {
			session_start();
		}
		
		if( isset($_SESSION["Account"]) ) {
			echo "<small>Welcome : " . $_SESSION['Username'] . "</small>";
		}
	?>
	<nav class="nav flex-column">
		<a class="nav-link" href="adminlogout.php" onClick="return checkLogOut()">登出</a>
		<a class="nav-link" href="admintopmenu.php">Topmenu</a>
        <a class="nav-link" href="admineditbanner.php">Banner</a>
		<a class="nav-link" href="admineditwebtopmenu.php">欄位設定</a>
		<a class="nav-link disabled" href="#">Disabled</a>
	</nav>
	<!--
	<ul class="nav flex-column">
		<li class="nav-item">
			<a class="nav-link" href="adminlogout.php">登出</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="admintopmenu.php">Topmenu</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="admineditwebtopmenu.php">欄位設定</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled" href="#">Disabled</a>
		</li>
	</ul>
	-->
</div>




