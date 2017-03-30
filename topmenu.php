<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="#">Navbar</a>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">

		<?php

		$tableName = "web_topmenu";
		$myPDO = MyPDO::getInstance();
		$result = $myPDO->searchAll($tableName);

		foreach($result as $row) {
			echo '<li class="nav-item active">';
			// <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			echo '<a class="nav-link" href="' . $row['link'] . '">' . $row['column_name'] . '<span class="sr-only">(current)</span></a>';
			echo "</li>";
		}

		?>

		</ul>
	<form class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2" type="text" placeholder="Search">
		<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	</form>
	</div>
</nav>



