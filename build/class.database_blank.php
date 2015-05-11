<?php

// This file is the MySQL database class, which wraps a lot of common MySQL functions in an object.
// Based on a class written by Dave Frame (www.phptrix.co.uk), and modified to suit this project.

class QPDatabase{

  var $dbhost, $dbport, $dbusername, $dbpassword, $dbname;
  var $conn, $lastqueryresult, $lasterror, $lasterrno, $lastinsertid;

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
    $this->conn = mysql_connect($this->dbhost . ":" . $this->dbport, $this->dbusername, $this->dbpassword);
    mysql_select_db($this->dbname, $this->conn);
  }
  
  function Query($querystring){ 
    $this->lastqueryresult = mysql_query($querystring, $this->conn);  
    if ( mysql_error($this->conn) != "" ) {
      $this->lasterror = mysql_error($this->conn);
      $this->lasterrno = mysql_errno($this->conn);
      return 0;
    }
    else
      return 1;
  }

  function Num_Rows() { 
    return mysql_num_rows($this->lastqueryresult);
  }

  function Affected_Rows(){
    return mysql_affected_rows($this->lastqueryresult);
  }

  function Fetch_Array() {
    return mysql_fetch_array($this->lastqueryresult);
  }

  function Fetch_Full_Array() {
    $allrows = array();
    while ( $currentrow = mysql_fetch_array($this->lastqueryresult) ) {
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
    mysql_close($this->conn);
  }
  
  function WikiPageExists($pagename){
    $query = "SELECT p_name FROM pages WHERE p_name='$pagename'";
    if ($this->Query($query) == 1){
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
    $query = "SELECT * FROM pages WHERE p_name='$pagename'";
    if ($this->Query($query) == 1){
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
