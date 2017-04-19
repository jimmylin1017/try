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

<?php
	// three method: update, delete, insert
	$editColumnFormAction = $_SERVER['PHP_SELF'];
	
	if( isset($_POST["delete"]) ) {
		echo "delete: " . $_POST["delete"];
		
		$whereCommand = "column_name = ?";
		$arrCommand = array($_POST["delete"]);
		
		$myPDO->deleteData($tableName, $arrCommand, $whereCommand);
		
		header( "Location:" . $editColumnFormAction );
	}
	
	if( isset($_POST["edit"]) ) {
		echo "edit: " . $_POST["edit"] . " to " . $_POST[$_POST["edit"]];
		
		$whereCommand = "column_name = '" . $_POST["edit"] . "'";
		$arrCommand = array(
			"column_name" => (string)$_POST[$_POST["edit"]],
			"link" => (string)$_POST[$_POST["edit"] . "_link"],
		);
				
		$result = $myPDO->updateData($tableName, $arrCommand, $whereCommand);
				
		header( "Location:" . $editColumnFormAction );
	}
	
	if( isset($_POST["new"]) ) {
		echo "new: " . $_POST["add_new_column"] . " + " . $_POST["add_new_link"];
		
		$arrCommand = array(
			"column_name" => (string)$_POST["add_new_column"],
			"link" => (string)$_POST["add_new_link"],
		);
				
		$result = $myPDO->insertData($tableName, $arrCommand);
				
		header( "Location:" . $editColumnFormAction );
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
	<div class="row">
		<?php
			include_once("include/admineditmenu.php");
		?>
		
		<script type="text/javascript">
			var columnName = "";
			var columnValue = "";
			function CheckForm() {
				if(confirm("確定要 " + columnName + " " + columnValue + " 欄位嗎？") == true)   
					return true;
				else
					return false;
			}

			function buttonClick(buttonObject) {
				//alert(buttonObject.value);
				columnValue = buttonObject.value;
				if(buttonObject.name == "delete")
					columnName = "刪除";
				else if(buttonObject.name == "edit")
					columnName = "修改";
				else if(buttonObject.name == "new")
					columnName = "新增";
			}
		</script>  

		<div class="col col-8">
			<form method="post" action="<?php echo $editColumnFormAction ?>" onSubmit="return CheckForm();">
				<table class="table table-striped">
				  <thead>
					<tr>
						<?php
							$result = $myPDO->getColumnName($tableName);					
	
							foreach($result as $row) {
								echo "<th>";
								echo $row;
								echo "</th>";
								
							}
						?>
					</tr>
				  </thead>
				  <tbody>
					<?php
						/*******************************************
						
						
						Update and Delete
						===========================================
						input: name=$row["column_name"]
								value=$row["column_name"]
						input: name=$row["column_name"] . "_link"
								value=$row["link"]
						button: onclick="buttonClick(this)"
								name="edit"
								value=$row["column_name"]
						button: onclick="buttonClick(this)"
								name="delete"
								value=$row["column_name"]
								
						Delete: Only use $_POST["delete"] get value $row["column_name"]
						Update: Use $_POST["edit"] for where to find row and update column name
								then use $_POST[$_POST["edit"] . "_link"] to update link
						===========================================
						
						
						Insert
						===========================================
						input: name="add_new_column"
								value=""
						input: name="add_new_link"
								value=""
						button: name="new"
						
						Just use $_POST["add_new_column"] and $_POST["add_new_link"] to get data
						===========================================
						
						
						********************************************/
	
						$result = $myPDO->searchAll($tableName);					
	
						foreach($result as $row) {
							echo "<tr>";
							// column_name
							echo "<td>" . '<input type="text" name="' . $row["column_name"] . '" 
								value="' . $row["column_name"] . '"></input></td>';
							// link
							echo "<td>" . '<input type="text" name="' . 
								$row["column_name"] . "_link" . 
								'" value="' . $row["link"] . 
								'"></input></td>';
							// Edit
							echo "<td>" . '<button type="submit" onclick="buttonClick(this)" 
								class="btn btn-danger" name="edit" value="' . 
								$row["column_name"] . '">Edit</button>' . "</td>";
							// Delete
							echo "<td>" . '<button type="submit" onclick="buttonClick(this)" 
								class="btn btn-danger" name="delete" value="' . 
								$row["column_name"] . '">Delete</button>' . "</td>";
							
							echo "</tr>";
						}
				  
				  		// New
				  		echo "<td>" . '<input type="text" name="add_new_column"	value=""></input></td>';
				  		echo "<td>" . '<input type="text" name="add_new_link" value=""></input></td>';
					  	echo "<td>" . '<button type="submit" onclick="buttonClick(this)" class="btn btn-danger" name="new">New</button>' . "</td>";
					?>
				  </tbody>
				</table>
			</form>
		</div>
	</div>
</div>

</body>
</html>