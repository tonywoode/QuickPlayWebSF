<?php

//convenience class to give ourselves a results object to pass around like get_result would have done
class IImysqli_result {
	    public $stmt, $ncols;
}    
// This file is the MySQL database class, which wraps a lot of common MySQL functions in an object.
// Based on a class written by Dave Frame (www.phptrix.co.uk), and modified to suit this project.

class QPDatabase {

  var $dbhost, $dbport, $dbusername, $dbpassword, $dbname;
  var $type, $bindtype, $stmt, $result, $conn, $lastqueryresult, $lasterror, $lasterrno, $lastinsertid, $iilastqueryresult;

  // ---- Constructor ----

  function QPDatabase() {
    $this->dbhost = "";
    $this->dbport = ;
    $this->dbusername = "";
    $this->dbpassword = "";
    $this->dbname = "";
    $this->iilastqueryresult = "";
    //$this->lastqueryresult = "";//without a sqlnd driver on the server, we needed our own result object
    $this->Open();
  }

  // ---- functions ----
  function Open() {
    //Opens the database connection and stores it in the conn variable.
    $this->conn = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword, $this->dbname, $this->dbport);
  }

	/** ii methods based on anonymously-posted code at the mysqli_get_result_api docs
	 * however that guy's code assumed numeric array was fine for callsites. The code here uses assoc arrays exlusively
	 * original text follows:
	 *
	 * EXPLANATION:
	 * We are creating a fake "result" structure to enable us to have
	 * source-level equivalent syntax to a query executed via
	 * mysqli_query().
	 *
	 *    $stmt = mysqli_prepare($conn, "");
	 *    mysqli_bind_param($stmt, "types", ...);
	 *
	 *    $param1 = 0;
	 *      $param2 = 'foo';
	 *    $param3 = 'bar';
	 *    mysqli_execute($stmt);
	 *    $result _mysqli_stmt_get_result($stmt);
	 *        [ $arr = _mysqli_result_fetch_array($result);
	 *            || $assoc = _mysqli_result_fetch_assoc($result); ]
	 *	    mysqli_stmt_close($stmt);
	 *    mysqli_close($conn);
	 *
	 * At the source level, there is no difference between this and mysqlnd.
	 **/

	function iimysqli_get_result($stmt) {
	  $metadata = $stmt->result_metadata();
		$ret = new IImysqli_result;
		if (!$ret || !$metadata) return NULL; //the latter because this gets called whether we are adding/updating as well as returning
		$ret->ncols = $metadata->field_count;
		$ret->stmt = $stmt;
		$metadata->free_result();
		return $ret;
	}

	//this mimics mysqli_fetch_array by returning a new row each time until exhausted
	function iimysqli_result_fetch_array(&$result) {
		$stmt = $result->stmt;
		$stmt->store_result();
		$resultkeys = array();
		$thisName = "";
		for ( $i = 0; $i < $stmt->num_rows; $i++ ) {
				$metadata = $stmt->result_metadata();
				while ( $field = $metadata->fetch_field() ) {
					$thisName = $field->name;
					$resultkeys[] = $thisName;
				}
		}
			
		$ret = array();
		$code = "return mysqli_stmt_bind_result(\$result->stmt ";
		for ($i=0; $i<$result->ncols; $i++) {
			$ret[$i] = NULL;
			$theValue = $resultkeys[$i];
			$code .= ", \$ret['$theValue']";
		};
		
		$code .= ");";
		if (!eval($code)) { 
			return NULL; 
		};
		
		// This should advance the "$stmt" cursor.
		if (!mysqli_stmt_fetch($result->stmt)) { 
			return NULL; 
		};

		// Return the array we built.
		return $ret;
	}

	//quick fix in lieu of varags: I noticed we never have more than two prepared bindings
	function Query($querystring, $arg1, $arg2) {
		$stmt = $this->conn->prepare($querystring);
		if ($arg1 != "" && $arg2 == "") {
			$stmt->bind_param("s", $arg1); 
		}
		elseif ($arg1 != "" && $arg2 != "") {
			$stmt->bind_param("ss", $arg1, $arg2); 
		};

		$stmt->execute(); 
		$stmt->store_result(); 
		//$result = $stmt->get_result(); //lack of sqlnd on sourceforge servers prevents us using this. Really tough luck!	
		$iilastqueryresult = $this->iimysqli_get_result($stmt);
		$this->iilastqueryresult = $iilastqueryresult; 
		if ( mysqli_error($this->conn) != "" ) {
      $this->lasterror = mysqli_error($this->conn);
      $this->lasterrno = mysqli_errno($this->conn);
			$stmt->close();
			return 0;
    }
		else
			//$stmt->close();	//TODO:since we can't get_result, we can't close the statment now, we need lots more info from it
			return 1;
  }

	function Num_Rows() {
		return $this->iilastqueryresult->stmt->num_rows;
	}

  function Affected_Rows() {
    return mysqli_affected_rows($this->lastqueryresult);//not being used
  }

  function Fetch_Array() {
		return $this->iimysqli_result_fetch_array($this->iilastqueryresult);
	}

  function Fetch_Full_Array() {
    $allrows = array();
    while ( $currentrow = $this->iimysqli_result_fetch_array($this->iilastqueryresult) ) {
       array_push($allrows, $currentrow);
    }
    return $allrows;
  }

  function GetResult() {
    return $this->lastqueryresult;//not being used
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
  
  function WikiPageExists($pagename) {
    $query = "SELECT p_name FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, "") == 1) {
      if ($this->Num_Rows() > 0)
        return true;
      else
        return false;
    }
    else {
      //the query failed return false
      return false;
    }
    
  }
  
  function WikiGetPage($pagename) {
    $query = "SELECT * FROM pages WHERE p_name=(?)";
    if ($this->Query($query, $pagename, "") == 1) {
      if ($this->Num_Rows() == 1) {
        return $this->Fetch_Full_Array();
      }
      else
        return false;
    }
    else {
      //the query failed return false
      return false;
    }

  }

}//end of CLASS

?>
