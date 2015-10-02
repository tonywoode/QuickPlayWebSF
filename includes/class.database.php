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
    $this->conn = new mysqli($this->dbhost . ":" . $this->dbport, $this->dbusername, $this->dbpassword, $this->dbname);
  }
  
	function Query($querystring, $thepage, $bindtype){
		$stmt = $this->conn->prepare($querystring);
		$stmt->bind_param($bindtype, $thepage);
		$stmt->execute(); 
		$result = $stmt->get_result();	
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

 function InternalQuery($querystring){
		$this->lastqueryresult = mysqli_query($this->conn, $querystring);
		if ( mysqli_error($this->conn) != "" ) {
			$this->lasterror = mysqli_error($this->conn);
			$this->lasterrno = mysqli_errno($this->conn);
			return 0;
		 }
		 else
			 return 1;
		 }

  function Num_Rows() { 
    return mysqli_num_rows($this->lastqueryresult);
  }

  function Affected_Rows(){
    return mysqli_affected_rows($this->lastqueryresult);
  }

  function Fetch_Array() {
    return mysqli_fetch_array($this->lastqueryresult);
  }

  function Fetch_Full_Array() {
    $allrows = array();
    while ( $currentrow = mysqli_fetch_array($this->lastqueryresult) ) {
            array_push($allrows, $currentrow);
    }
    return $allrows;
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
  
  function WikiPageExists($pagename, $type){
    $query = "SELECT p_name FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, $type) == 1){
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
  
  function WikiGetPage($pagename, $type){
    $query = "SELECT * FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, $type) == 1){
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
