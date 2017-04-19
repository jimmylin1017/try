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
	$tableName = "web_banner";
?>

<?php
	// three method: update, delete, insert
	$editColumnFormAction = $_SERVER['PHP_SELF'];
	
	if( isset($_POST["delete"]) ) {
		
		$whereCommand = "tmp_id = ?";
		$arrCommand = array($_POST["delete"]);
		
		$results = $myPDO->searchWhere($tableName, $arrCommand, $whereCommand);
		exec('rm ../img/banner/' . $results[0]['picture']);
		//echo 'rm ../img/banner/' . $results[0]['picture'];
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo "Delete " . $results[0]['picture'];
		echo '</div>';
		
		$myPDO->deleteData($tableName, $arrCommand, $whereCommand);
		
		//header( "Location:" . $editColumnFormAction );
	}
	
	if( isset($_POST["edit"]) ) {
		echo "edit: " . $_POST["edit"] . " to " . $_POST[$_POST["edit"]];
		
		$whereCommand = "tmp_id = '" . $_POST["edit"] . "'";
		$arrCommand = array(
			"picture" => (string)$_POST[$_POST["edit"]],
			"description" => (string)$_POST[$_POST["edit"] . "_description"],
		);
				
		$result = $myPDO->updateData($tableName, $arrCommand, $whereCommand);
				
		header( "Location:" . $editColumnFormAction );
	}
	
	
	if( isset($_POST["new"]) ) {
		$fileAmount = count($_FILES["add_new_picture"]["name"]);
		$correctAmount = 0;
		
		for($i=0; $i<$fileAmount; $i++) {
			if($_FILES["add_new_picture"]["error"][$i] > 0) {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				echo "Error: " . $_FILES["add_new_picture"]["error"][$i];
				echo '</div>';
			}
			else if(file_exists("../img/banner/" . $_FILES["add_new_picture"]["name"][$i])) {
				echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				echo "File " . $_FILES["add_new_picture"]["name"][$i] . " already exist!";
				echo '</div>';
			}
			else {
				move_uploaded_file($_FILES["add_new_picture"]["tmp_name"][$i], "../img/banner/" . $_FILES["add_new_picture"]["name"][$i]);
				
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				echo "Upload " . $_FILES["add_new_picture"]["name"][$i] . " : " . $_POST["add_new_description"];
				echo '</div>';
				
				$arrCommand = array(
					"picture" => (string)$_FILES["add_new_picture"]["name"][$i],
					"description" => (string)$_POST["add_new_description"],
				);
						
				$result = $myPDO->insertData($tableName, $arrCommand);
				
				$correctAmount++;
			}
		}
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
				if(confirm("確定要" + columnName + " " + columnValue + " 欄位嗎？") == true)   
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
			}
		</script>  

		<div class="col col-8">
			<form method="post" action="<?php echo $editColumnFormAction ?>" onSubmit="return CheckForm();" enctype="multipart/form-data">
				<table class="table table-striped">
				  <thead>
					<tr>
						<?php
							$result = $myPDO->getColumnName($tableName);					
							echo "<th>";
								echo 'picture_demo';
							echo "</th>";
							foreach($result as $row) {
								if($row == "tmp_id") continue;
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
							// picture_demo
							echo "<td>" . '<a href="../img/banner/' . $row["picture"] . '" target="_blank"><img src="../img/banner/' . $row["picture"] . '" height="50"></td></a>';
							// column_name
							echo "<td>" . '<input type="text" name="' . $row["tmp_id"] . '" 
								value="' . $row["picture"] . '"></input></td>';
							// link
							echo "<td>" . '<input type="text" name="' . 
								$row["tmp_id"] . "_description" . 
								'" value="' . $row["description"] . 
								'"></input></td>';
							// Edit
							echo "<td>" . '<button type="submit" onclick="buttonClick(this)" 
								class="btn btn-danger" name="edit" value="' . 
								$row["tmp_id"] . '">Edit</button>' . "</td>";
							// Delete
							echo "<td>" . '<button type="submit" onclick="buttonClick(this)" 
								class="btn btn-danger" name="delete" value="' . 
								$row["tmp_id"] . '">Delete</button>' . "</td>";
							
							echo "</tr>";
						}

				  		// New
						echo "<td> </td>";
				  		echo "<td>" . '<input type="file" name="add_new_picture[]" value="" multiple></input></td>';
				  		echo "<td>" . '<input type="text" name="add_new_description" value=""></input></td>';
					  	echo "<td>" . '<button type="submit" class="btn btn-danger" name="new">Upload</button>' . "</td>";
					?>
				  </tbody>
				</table>
			</form>
		</div>
	</div>
</div>

</body>
</html>