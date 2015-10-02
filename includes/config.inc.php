<?php

  require_once "includes/class.database.php";
  //include authentication stuff.
  require_once "includes/class.auth.php";

  //create a database object which will stay alive for the duration of this page.
  $DBo = new QPDatabase();
  
  //check for user authentication
  $auth = new Jlogin($DBo);
  
  //get current version information from database
  $DBo->InternalQuery("SELECT version_name FROM version ORDER BY version_id DESC LIMIT 1");
  while( $row = $DBo->Fetch_Array() ) {
    $config['version'] = $row['version_name'];
  }

  $config['pagesdir'] = "pages/";
  $config['revisionsdir']= "revisions/";

?>
