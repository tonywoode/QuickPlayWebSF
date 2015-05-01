<?php
    require "includes/config.inc.php";
    if ( !$auth->IsLoggedOn() )  //check if the user is logged in
  {
		// user is not logged in, bomb out!
    echo "Please log in!";
	}
	else
    phpinfo();
?>
