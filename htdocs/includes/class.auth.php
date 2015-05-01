<?php

function clean($input, $maxlength = -1){
  
  if($maxlength != -1)
    $input = substr($input, 0, $maxlength);
	
  $input = EscapeShellCmd($input);
  return($input);
}

  class Jlogin{

    var $id, $name, $pwd, $authorised;

    //constructor
    function Jlogin($db){

      $this->authorised = false;

      if(  (isset($_POST['userid'])) && (isset($_POST['pwd'])) ){
        //cleaning of data here 
        $this->name = addslashes(clean($_POST['userid'], 20)); 
        $this->pwd = addslashes(crypt(clean($_POST['pwd'],20), substr($this->name, 0, 2)));
      }
      if(  (isset($_COOKIE['userid'])) && (isset($_COOKIE['pwd'])) ){
        //cleaning of data here
        $this->name = $_COOKIE['userid']; 
        $this->pwd = $_COOKIE['pwd'];
      }

      if( isset($this->name) ){


      if($db->Query("SELECT * FROM authors WHERE name='".$this->name."' AND password='".$this->pwd."'")){
        if($db->Num_Rows() == 1){

              if(  (!isset($_COOKIE['userid'])) && (!isset($_COOKIE['pwd']))  ){
                setcookie("userid", $this->name, time()+(60*60*24*7));
                setcookie("pwd", $this->pwd, time()+(60*60*24*7));
              }
              $this->authorised = true;
              $result = $db->Fetch_Full_Array();
              $this->id = $result[0]['id'];
              unset($result);

        }
        else
        {
          $this->GenerateFailure();
          exit;
        }
      }
      else
        die ("Database error - unable to retrieve user names");
        
      }
      
    }

    function LogOut(){
      setcookie("userid", "");
      setcookie("pwd", "");
      header("Location: index.php");
    }


    function GetID(){
      return $this->id;
    }
    
    function GetName(){
      return $this->name;
    }

    function IsLoggedOn(){
      return $this->authorised;
    }

    function GenerateLogin(){
      include "includes/login.inc.php";
    }

    function GenerateFailure(){
      include "includes/loginfail.inc.php";
    }


  }//end of class

?>
