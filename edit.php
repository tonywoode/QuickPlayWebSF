<?php
  require "includes/config.inc.php";
  echo "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      QuickPlay Homepage - Current Version <?=$config['version']?>
    </title>
    <meta name="keywords" content="quickplay, emulation, frontend, mame, zsnes, multi, emulator, universal" />
    <meta name="description" content="Quickplay the universal emulator Frontend" />
    <link rel="shortcut icon" href="http://www.smackdown-hotel.fsnet.co.uk/favicon.ico" />
    <link href="includes/main.css" title="Default Look" rel="stylesheet" type="text/css" />
    <link href="includes/old.css" title="Old Style" rel="alternate stylesheet" type="text/css">
  </head>
  <body>
    
<?php

  //first check that  page has been specified
	if (isset($_GET['title']) == false and (isset($_POST['title']) == false))
  {
    print "<div>No page specified</div>";
	}
  else if ( !$auth->IsLoggedOn() )  //check if the user is logged in
  {
		// No login cookie present
    echo "Please log in!";
	}
  else if (isset($_POST['node']))
  {
    $t= $_POST['title'];
    
    $content = $_POST['node'];

    //make sure the content variable is UNSLASHED!
    if (get_magic_quotes_gpc() == 1)
      $content = StripSlashes($content);
      
    $content = htmlentities($content, ENT_QUOTES);
    $content = AddSlashes($content);

		// Write new data
		if ($DBo->WikiPageExists($t)==true){
      //the page exists, we are doing an UPDATE query
      $query = "UPDATE pages SET p_body='".addslashes($content)."' WHERE p_name='$t'";
    }
    else
    {
      //the page doesnt exist its an INSERT query
      $query = "INSERT INTO pages SET p_name='$t', p_body='".addslashes($content) . "'";
    }

    $DBo->Query($query);
    
    print "<div class=\"features\">Page edited. 
    Returning to 
    <a href=\"index.php?title=$t\">$t</a>. 
    <META HTTP-EQUIV=REFRESH CONTENT=4;URL=\"index.php?title=" 
    . urlencode($t) . "\"></div>";

	}
  else
  {

		// Node edit form

    $theTitle = $_GET['title'];
    
    ?>

    <div class="newshead">Editing <?=$theTitle?></div>
    <div class="newscontent">
		<form method="post" action="edit.php">
		<p />
		<table width="100%">
      <tr>
        <td width="65%">
          Text
        </td>
        <td>
          CSS File
        </td>
      </tr>
      <tr>
        <td>

		      <textarea wrap="soft" name="node" style="display: inline; width: 100%; height: 300px;">
          <?php
            if($DBo->WikiPageExists($theTitle) == true){
              $rec = $DBo->WikiGetPage($theTitle);
              if ($rec != False)
              {
                $mybody = StripSlashes($rec[0]['p_body']);
                echo html_entity_decode($mybody, ENT_QUOTES);
              }
              else
                echo "Failed to get page from database";
            }


		echo "</textarea>\n</td><td>\n";

    if (file_exists("includes/main.css")){
      $css = file_get_contents("includes/main.css");
      echo "<textarea wrap=\soft\" name=\"css\" 
        style=\"display : inline; width:100%; height: 300px;\">\n";
      echo $css;
      echo "</textarea>";
    }
    else
      echo "CSS File not Found";
    
    ?>
    </td>
    </tr>
    <tr>
      <td colspan="2">

    <input type="hidden" name="title" value="<?=$theTitle?>">
    <input type="submit" name="submit" value="Submit">
      </td>
    </tr>
    
    </table>
    </form>
    </div>
		<div class="newsfooter">
      <a href="index.php?title=<?=$theTitle?>">Return to <?=$theTitle?></a>
    </div>
		
  <?php
   
	}

?>
    </div><!-- end of main content div -->
  </div>
  </body>
</html>
