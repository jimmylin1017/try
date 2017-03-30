<?php

// PHP Version 5.5.38

require_once( "pdo_config.php" );

class MyPDO {
	
	private $_database = DB_TYPE;
	private $_host = DB_HOST;
	private $_port = DB_PORT;
	private $_name = DB_NAME;
	private $_username = DB_USER;
	private $_password = DB_PASSWD;
	private $_encode = DB_ENCODE;
	private $_driver = NULL;
	private $_conn = NULL;
	private static $_instance = NULL;
	
	private function __construct() {
		// private construct
		$this->_driver = "{$this->_database}:host={$this->_host};port={$this->_port};dbname={$this->_name};charset={$this->_encode}";
		/*
		echo "$this->_username<br>";
		echo "$this->_password<br>";
		echo "$this->_driver<br>";
		*/
		try {
			$this->_conn = new PDO( $this->_driver, $this->_username, $this->_password );
    		$this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "connect success<br>";
		} catch( PDOException $e ) {
			die("Database connect fail: " . $e->getMessage());
		}
	}
	
	public static function getInstance() {
		if( !self::$_instance ) {
			self::$_instance = new MyPDO();
			//echo "create instance<br>";
		}
		//echo "return instance<br>";
		return self::$_instance;
	}
	
	/*
	$behavior: INSERT or UPDATE
	$tableName: target table name
	$arrCommand: need Key => Value array
	whereCommand: an expression after WHERE in SQL, like "Name='Jimmy'" ( String need '' inside )
	*/
	private function _insertUpdate( $behavior, $tableName, $arrCommand, $whereCommand = "" ) {
		if( empty($arrCommand) ) return false;
		
		$statement = NULL;
		$result = NULL;
		
		if( $behavior == "INSERT" ) {
			$columnCommand = "";
			$valueCommand = "";
			foreach( $arrCommand as $column => $value) {
				if( strlen($valueCommand) > 0 ) {
					$columnCommand .= ", " . $column;
					$valueCommand .= ", ?";
				}
				else {
					$columnCommand .= $column;
					$valueCommand .= "?";
				}
			}
			
			$sqlCommand = "INSERT INTO {$tableName} ({$columnCommand}) VALUES({$valueCommand})";
			//echo "$sqlCommand<br>";
			$statement = $this->_conn->prepare($sqlCommand);
			
			try {
				$result = $statement->execute(array_values($arrCommand));
			} catch( PDOException $e ) {
				//die("Insert data fail: " . $e->getMessage());
				return false;
			}
		}
		else if( $behavior == "UPDATE" ) {
			$setCommand = "";
			foreach( $arrCommand as $column => $value) {
				if( strlen($setCommand) > 0 ) {
					$setCommand .= ", " . $column . "= ?";
				}
				else {
					$setCommand .= $column . "= ?";
				}
			}
			
			$sqlCommand = "UPDATE {$tableName} SET {$setCommand} WHERE {$whereCommand}";
			//echo "$sqlCommand<br>";
			//print_r(array_values($arrCommand));
			$statement = $this->_conn->prepare($sqlCommand);
			
			try {
				$result = $statement->execute(array_values($arrCommand));
			} catch( PDOException $e ) {
				//die("Update data fail: " . $e->getMessage());
				return false;
			}
		}
		
		return $result;
	}
	
	/*
	$tableName: target table name
	*/
	public function searchOne( $tableName ) {
		$statement = $this->_conn->query("SELECT * FROM {$tableName}");
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
	
	/*
	$tableName: target table name
	*/
	public function searchAll( $tableName ) {
		$statement = $this->_conn->query("SELECT * FROM {$tableName}");
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*
	$tableName: target table name
	$arrCommand: need array(value1, value2, ...), with $whereCommand
	$whereCommand: an expression after WHERE in SQL, like "Name='Jimmy'" ( String need '' inside )
	*/
	public function searchWhere( $tableName, $arrCommand=NULL, $whereCommand="" ) {
		$statement = $this->_conn->prepare("SELECT * FROM {$tableName} WHERE {$whereCommand}");
		$statement->execute($arrCommand);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*
	$tableName: target table name
	$limit: number of row you need
	$start: start point of row you need
	$arrCommand: need array(value1, value2, ...), with $whereCommand
	$whereCommand: an expression after WHERE in SQL, like "Name='Jimmy'" ( String need '' inside )
	*/
	public function searchLimit( $tableName, $limit=5, $start=0, $arrCommand=NULL, $whereCommand="" ) {
		$limitData = array();
		$result = $this->searchAll($tableName);
		for( $i = $start, $j = 0; $i < $start + $limit; $i++, $j++ ) {
			$limitData[$j] = $result[$i];
		}
		return $limitData;
	}
	
	public function getColumnName( $tableName ) {
		$columnName = array();
		$result = $this->searchAll($tableName);
		foreach($result[0] as $key => $value) {
			array_push($columnName, $key);
		}
		return $columnName;
	}
	
	/*
	$tableName: target table name
	$arrCommand: need Key => Value array
	*/
	public function insertData( $tableName, $arrCommand ) {
		$this->_insertUpdate( "INSERT", $tableName, $arrCommand );
	}
	
	/*
	$tableName: target table name
	$arrCommand: need Key => Value array
	whereCommand: an expression after WHERE in SQL, like "Name='Jimmy'" ( String need '' inside )
	*/
	public function updateData( $tableName, $arrCommand, $whereCommand ) {
		$this->_insertUpdate( "UPDATE", $tableName, $arrCommand, $whereCommand );
	}
	
	/*
	$tableName: target table name
	whereCommand: an expression after WHERE in SQL, like "Name='Jimmy'" ( String need '' inside )
	*/
	public function deleteData( $tableName, $arrCommand, $whereCommand ) {
		$statement = $this->_conn->prepare("DELETE FROM {$tableName} WHERE {$whereCommand}");
		$statement->execute($arrCommand);
	}
	
	
}

?>