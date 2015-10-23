<?php

class iimysqli_result
{
	    public $stmt, $nCols;
}    
// This file is the MySQL database class, which wraps a lot of common MySQL functions in an object.
// Based on a class written by Dave Frame (www.phptrix.co.uk), and modified to suit this project.

class QPDatabase{

  var $dbhost, $dbport, $dbusername, $dbpassword, $dbname;
  var $type, $bindtype, $stmt, $result, $conn, $lastqueryresult, $lasterror, $lasterrno, $lastinsertid, $otherresult;

  // ---- Constructor ----

  function QPDatabase() {
    // Sourceforge Settings.
    
    $this->dbhost = "";
    $this->dbport = ;
    $this->dbusername = "";
    $this->dbpassword = "";
    $this->dbname = "";
    $this->otherresult = "";
    $this->lastqueryresult = "";
    $this->Open();
  }

  // ---- functions ----
  function Open() {
    //Opens the database connection and stores it in the conn variable.
    $this->conn = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword, $this->dbname, $this->dbport);
  }

	function iimysqli_stmt_get_result($stmt)
	{
	    $metadata = mysqli_stmt_result_metadata($stmt);
				    $ret = new iimysqli_result;
				    if (!$ret) return NULL;

						    $ret->nCols = mysqli_num_fields($metadata);
						    $ret->stmt = $stmt;

								    mysqli_free_result($metadata);
								    return $ret;
	}

	function iimysqli_result_fetch_array(&$result){
		  $ret = array();
			$code = "return mysqli_stmt_bind_result(\$result->stmt ";

			for ($i=0; $i<$result->nCols; $i++){
				$ret[$i] = NULL;
				$code .= ", \$ret['" .$i ."']";
			};

			$code .= ");";
			if (!eval($code)) { return NULL; };

			// This should advance the "$stmt" cursor.
			if (!mysqli_stmt_fetch($result->stmt)) { return NULL; };
								
			// Return the array we built.
			return $ret;
	}

	function Query($querystring, $arg1, $arg2){
		$stmt = $this->conn->prepare($querystring);
		#echo $querystring;
		#echo $arg1;
		#echo $arg2;
		if ($arg1 != "" && $arg2 == "") {
			$stmt->bind_param("s", $arg1); }
		elseif ($arg1 != "" && $arg2 != "") {
			$stmt->bind_param("ss", $arg1, $arg2); }
		$stmt->execute(); 
		$result = $stmt->get_result();	
		$otherresult = $this->iimysqli_stmt_get_result($stmt);
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
