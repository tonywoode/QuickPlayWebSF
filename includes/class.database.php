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

	function iimysqli_stmt_get_result($stmt){
	    //$metadata = mysqli_stmt_result_metadata($stmt);
				    $ret = new iimysqli_result;
				    if (!$ret) return NULL;
						  $result = array();
						  $stmt->store_result();
							for ( $i = 0; $i < $stmt->num_rows; $i++ ) {
									$Metadata = $stmt->result_metadata();
						    $ret->nCols = mysqli_num_fields($Metadata);
									$params = array();
									while ( $Field = $Metadata->fetch_field() ) {
										$params[] = &$result[ $i ][ $Field->name ];
									}
								  call_user_func_array( array( $stmt, 'bind_result' ), $params );
									$stmt->fetch();
							}
							

						    $ret->stmt = $result;

								   // mysqli_free_result($metadata);

								return $ret;
	}

	function iimysqli_result_fetch_array(&$result){
		//	echo "here IS result:";
		//	print_r($result);
		//echo "here's &result in the fetcharray method";	
		//var_dump($result);	
	echo "here we are echoing statement from result_fetch_array";
	var_dump($result->stmt);
	echo "now get version name value";
	echo ($result->stmt[0]["version_name"]);
	echo "and lastly the key";
	foreach($result->stmt[0] as $key=>$value) { echo $key; };	
		$ret = array();
			$code = "return mysqli_stmt_bind_result(\$result->stmt ";
			for ($i=0; $i<$result->nCols; $i++){
				$ret[$i] = NULL;
				$code .= ", \$ret['" .$i ."']";
			};

			$code .= ");";
		echo "code is:";
			print_r($code);
			if (!eval($code)) { return NULL; };

			// This should advance the "$stmt" cursor.
			if (!mysqli_stmt_fetch($result->stmt)) { return NULL; };
								
			// Return the array we built.
			return $ret;
	}

	function Query($querystring, $arg1, $arg2){
		
	//		echo "you said do this query:";
	//		echo $querystring;
	//		echo $arg1;
	//		echo $arg2;
		$stmt = $this->conn->prepare($querystring);
		if ($arg1 != "" && $arg2 == "") {
			$stmt->bind_param("s", $arg1); }
		elseif ($arg1 != "" && $arg2 != "") {
			$stmt->bind_param("ss", $arg1, $arg2); }
		$stmt->execute(); 
		//$stmt->store_result(); //this is about buffering the result, get more output with iimysqli arrays, but breaks mysqli ones
		//$result = $stmt->get_result();	
		//var_dump( $this->iimysqli_stmt_get_result($stmt));
		$otherresult = $this->iimysqli_stmt_get_result($stmt);
		//echo "here's the results object";
		//var_dump($otherresult);
		$this->otherresult = $otherresult; 
		//$this->lastqueryresult = $result; 
		//var_dump($this->Fetch_Full_array());
		//	echo "here's global result var";
		//var_dump($this->otherresult);	
		//	print_r($this->otherresult);
		//var_dump( $result);
	  //var_dump($result->fetch_array(MYSQLI_ASSOC));//this gives assoc array only 
		//var_dump( $this->iimysqli_result_fetch_array($this->otherresult));//this gives numeric array
		
		if ( mysqli_error($this->conn) != "" ) {
      $this->lasterror = mysqli_error($this->conn);
      $this->lasterrno = mysqli_errno($this->conn);
		//	$stmt->close();
			return 0;
    }
		else
			//$stmt->close();
			return 1;
  }

  function Num_Rows() { 
		//return count($this->iimysqli_result_fetch_array($this->otherresult));
		//return mysqli_num_rows($this->lastqueryresult);
		return $this->otherresult->stmt->affected_rows;
	}

  function Affected_Rows(){
    return mysqli_affected_rows($this->lastqueryresult);
  }

  function Fetch_Array() {
		//	echo "here's global result var in the fetch array function";
		//var_dump($this->otherresult);	
			
			//var_dump( mysqli_fetch_array($this->lastqueryresult));
		//return mysqli_fetch_array($this->lastqueryresult);
		//echo "array is";
		//print_r($this->iimysqli_result_fetch_array($this->otherresult));
		echo "here's the result var being called from fetch array";
		var_dump( $this->iimysqli_result_fetch_array($this->otherresult));
	}

  function Fetch_Full_Array() {
    $allrows = array();
    //while ( $currentrow = mysqli_fetch_array($this->lastqueryresult) ) {
    while ( $currentrow = $this->iimysqli_result_fetch_array($this->otherresult) ) {
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
