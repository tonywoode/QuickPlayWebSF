<?php

// This file is the MySQL database class, which wraps a lot of common MySQL functions in an object.
// Based on a class written by Dave Frame (www.phptrix.co.uk), and modified to suit this project.

class QPDatabase{

  var $dbhost, $dbport, $dbusername, $dbpassword, $dbname;
  var $type, $bindtype, $stmt, $result, $conn, $lastqueryresult, $lasterror, $lasterrno, $lastinsertid;

  // ---- Constructor ----

  function QPDatabase() {
    // Sourceforge Settings.
    
    $this->dbhost = "";
    $this->dbport = ;
    $this->dbusername = "";
    $this->dbpassword = "";
    $this->dbname = "";
    
    $this->lastqueryresult = "";
    $this->Open();
  }

  // ---- functions ----
  function Open() {
    //Opens the database connection and stores it in the conn variable.
    $this->conn = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword, $this->dbname, $this->dbport);
	}


	function getResultWithoutSQLND($stmt) {
		$result = array();
		$stmt->store_result();
		for ( $i = 0; $i < $stmt->num_rows; $i++ ) {
			$Metadata = $stmt->result_metadata();
			$params = array();
			while ( $Field = $Metadata->fetch_field() ) {
				$params[] = &$result[ $i ][ $Field->name ];
			}
			call_user_func_array( array( $stmt, 'bind_result' ), $params );
			$stmt->fetch();
		}
		return $result;
	}

	function Query($querystring, $arg1, $arg2){
		$stmt = $this->conn->prepare($querystring);
		echo $querystring;
		echo $arg1;
		echo $arg2;
		if ($arg1 != "" && $arg2 == "") {
			$stmt->bind_param("s", $arg1); }
		elseif ($arg1 != "" && $arg2 != "") {
			$stmt->bind_param("ss", $arg1, $arg2); }
		$stmt->execute(); 
		$stmt->store_result();
		$array = $this->getResultWithoutSQLND($stmt);
		var_dump($array);
		$result = $array;
		$this->lastqueryresult = $result; 
    if ( mysqli_error($this->conn) != "" ) {
      $this->lasterror = mysqli_error($this->conn);
      $this->lasterrno = mysqli_errno($this->conn);
			$stmt->close();
			return 0;
    }
		else
			$stmt->close();
      return 1;
  }

	function Num_Rows() {
	 echo "answer is---------- " . count($this->lastqueryresult);//mysqli_num_rows($this->lastqueryresult);
    return count($this->lastqueryresult);//mysqli_num_rows($this->lastqueryresult);
  }

  function Affected_Rows(){
    return mysqli_affected_rows($this->lastqueryresult);
  }

  function Fetch_Array() {
		return var_dump($this->lastqueryresult);
  }

  function Fetch_Full_Array() {
		
		return var_dump($this->lastqueryresult);
		//$allrows = array();
    //while ( $currentrow = mysqli_fetch_array($this->lastqueryresult) ) {
    //        array_push($allrows, $currentrow);
   // }
   // return $allrows;
  }

  function GetResult(){
    return $this->lastqueryresult;
  }

  function Error() {
    return $this->lasterror;
  }

  function Errno() {
    return $this->lasterrno;
  }

  function Insert_ID() {
    return $this->lastinsertid;
  }

  function Close() {
    mysqli_close($this->conn);
  }
  
  function WikiPageExists($pagename){
    $query = "SELECT p_name FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, "") == 1){
      if ($this->Num_Rows() > 0)
        return true;
      else
        return false;
    }
    else{
      //the query failed return false
      return false;
    }
    
  }
  
  function WikiGetPage($pagename){
    $query = "SELECT * FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, "") == 1){
      if ($this->Num_Rows() == 1){
        return $this->Fetch_Full_Array();
      }
      else
        return false;
    }
    else{
      //the query failed return false
      return false;
    }

  }

}//end of CLASS

?>
