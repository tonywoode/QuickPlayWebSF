<?php
/*
 * TODO:
 *  Upgrade Screenshots page with some snazzy JQuery
 * 
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(-1);

function rewrite($body)
/*
 * The purpose of this function is to convert the text in the sidebar
 * into valid links. 
 */
  {
    $content = $body;
    $terms="!-=+\\\"$%^\(\)@ \w";
    $content=preg_replace (
      array (
              "/\[([$terms]+)\]/",
              "/\[([$terms]+)\|([$terms]+)\]/"),
      array (
              "<a href=\"index.php?title=\\1\">\\1</a>",
              "<a href=\"index.php?title=\\2\">\\1</a>"), $content);

    return $content;
  }
  
/*
 * Content is buffered so that [foo|bar] links can be parsed afterwards.
 */
ob_start('rewrite');

require "includes/config.inc.php"; // Initializes Database and Login
require "includes/header.inc.php"; // Includes sidebar

if(isset($_GET['logout'])){
  $auth->LogOut();
  }
    
// If it's an admin user, add the admin menu
if ( $auth->IsLoggedOn() ){
  echo "<h3>Welcome " . $auth->GetName() . "</h3>";
  include "includes/adminmenu.inc.php";
  }


  if (isset($_GET['title']) == false){
    $title = "news_show";
  }
  else{
    $title= $_GET['title'];
  }

  
  
  if ($title=='login'){
    $auth->GenerateLogin();
  }
  // File management section. Sort of hack-ish..
  else if ($title=='manage') // For managing upload (needs authentication!)
    {
      require "includes/edit_dir.php";
    }
  else if ($title=='upload') 
    {
      require "includes/uploader.php";
    }
  else if ($title=='displaychanges')
    {
      require "displaychanges.php";
    }
  else 
  {
    if ($DBo->WikiPageExists($title, "s") == true) // Pulls pages out of database
    {
      $pgrec = $DBo->WikiGetPage($title, "s"); // Holds page id, name, and body
      if ($pgrec != False)
      {
        $text = StripSlashes($pgrec[0]['p_body']); // For escaped characters
        $text = html_entity_decode($text, ENT_QUOTES); // Because the editor converts HTML to character entities
      
        ob_start(); // Buffering this eval circumvents the issue of double SQL output.
          eval("?> <div class=fenix-content>". $text ."</div><?"); // Short tag used, as <?php throws errors.
          $eval_buffer = ob_get_contents();
        ob_end_clean();
        $body = $eval_buffer;
        
        echo $body, $text, "s";//this doesn't work but has the side-effect of spitting out the db call into the page, which will help me see the problem....
      }
      else
      {
        echo "Failed to read page from database";
      }
    }
    else
    {
      echo "<div>This page does not exist. Return to the <a href=\"index.php\">index</a>.</div>";
    }
  }
  
require("includes/footer.inc.php");
ob_end_flush(); // Immediately calls rewrite
?>

