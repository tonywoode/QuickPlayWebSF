<?php

// This file is the MySQL database class, which wraps a lot of common MySQL functions in an object.
// Based on a class written by Dave Frame (www.phptrix.co.uk), and modified to suit this project.
require "iimysqli_result.php";

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
    
    $this->lastqueryresult = new iimysqli_result();
    $this->Open();
  }

  // ---- functions ----
  function Open() {
    //Opens the database connection and stores it in the conn variable.
    $this->conn = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword, $this->dbname, $this->dbport);
	}

	function Query($querystring, $arg1, $arg2){
		$stmt = $this->conn->prepare($querystring);
		//echo $querystring;
		//echo $arg1;
		//echo $arg2;
		if ($arg1 != "" && $arg2 == "") {
			$stmt->bind_param("s", $arg1); }
		elseif ($arg1 != "" && $arg2 != "") {
			$stmt->bind_param("ss", $arg1, $arg2); }
		$stmt->execute(); 
		//	$stmt->store_result();
		$this->lastqueryresult = iimysqli_stmt_get_result($stmt);
	$array = array();
		$array = iimysqli_result_fetch_array($this->lastqueryresult);  
		foreach ($array as $row){
			echo $row;
		}
		//var_dump($result);
	//	$result = $array;
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
	 //echo "answer is---------- " . count($this->lastqueryresult);//mysqli_num_rows($this->lastqueryresult);
    return count($this->lastqueryresult);//mysqli_num_rows($this->lastqueryresult);
  }

  function Affected_Rows(){
    return mysqli_affected_rows($this->lastqueryresult);
  }

  function Fetch_Array() {
		//http://www.tizag.com/mysqlTutorial/mysqlfetcharray.php
		//foreach($this->lastqueryresult as $link){
		//	foreach ($link as $item) {
		//	echo $item;
return iimysqli_result_fetch_array($this->lastqueryresult);
	}
		//}
		//echo "THE LAST QUERY RESULT WAS";
	//	return  var_dump($this->lastqueryresult);
	//	return $this->lastqueryresult;
  //}

  function Fetch_Full_Array() {
		
		return $this->lastqueryresult;
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
