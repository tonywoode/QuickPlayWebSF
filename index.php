<?php
/*
 * TODO:
 *  Upgrade Screenshots page with some snazzy JQuery
 * 
 */

//PRINT ERRORS TO THE PAGE NOT JUST YOUR PHP.INI
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

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

  $lightboxRequires = " <script src='js/jquery-1.7.2.min.js'></script>
<script src='js/lightbox.js'></script>
   <link href='css/lightbox.css' rel='stylesheet' />  
<link href='css/gallery.css' rel='stylesheet' /> ";

  //change the images depending on which page is loaded
  if ($title=='news_show') { 
    $image1 = 'sshots/MAME_ARCADE1.png';     
    $image1Small = 'sshots/SMALL/MAME_ARCADE1.png';
    $image2 = 'sshots/MESS2.png';     
    $image2Small = 'sshots/SMALL/MESS2.png';
    $image3 = 'sshots/MESS3.png';     
    $image3Small = 'sshots/SMALL/MESS3.png';
    $image4 = 'sshots/MAME_EMBDEDDED1.png';     
    $image4Small = 'sshots/SMALL/MAME_EMBDEDDED1.png';
    $image5 = 'sshots/MAME_ARCADE2.png';     
    $image5Small = 'sshots/SMALL/MAME_ARCADE2.png';
    $image6 = 'sshots/MAME_ARCADE4.png';     
    $image6Small = 'sshots/SMALL/MAME_ARCADE4.png';
   //this is the resulting block we'll add to the pages
  $imageHeader = "
    $lightboxRequires.
      <div id='images'>
        <ul class='gallery'>
          <a href=$image1 data-lightbox='page-images'>
            <li><img src=$image1Small></li>.
          </a>
          <a href=$image2 data-lightbox='page-images'>
            <li><img src=$image2Small></li>.
          </a>
          <a href=$image3 data-lightbox='page-images'>
            <li><img src=$image3Small></li>.
          </a>
        </ul>
      </div>
    </div>
    ";
  $imageFooter = "
      <div id='images'>
        <ul class='gallery'>
          <a href=$image4 data-lightbox='page-images'>
            <li><img src=$image4Small></li>.
          </a>
          <a href=$image5 data-lightbox='page-images'>
            <li><img src=$image5Small></li>.
          </a>
          <a href=$image6 data-lightbox='page-images'>
            <li><img src=$image6Small></li>.
          </a>
        </ul>
      </div>
    </div>
    ";
  
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
    if ($DBo->WikiPageExists($title) == true) // Pulls pages out of database
    {
      $pgrec = $DBo->WikiGetPage($title); // Holds page id, name, and body
      if ($pgrec != False)
      {
        $text = StripSlashes($pgrec[0]['p_body']); // For escaped characters
        $text = html_entity_decode($text, ENT_QUOTES); // Because the editor converts HTML to character entities
      
        ob_start(); // Buffering this eval circumvents the issue of double SQL output.
        eval("?> <div class=fenix-content>".$imageHeader.$text.$imageFooter."</div><?"); // Short tag used, as <?php throws errors.
          $eval_buffer = ob_get_contents();
        ob_end_clean();
        $body = $eval_buffer;
        
        echo $body;//change to $text to spit out the db calls made into the page
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
  
if (!$auth->IsLoggedOn() ) { 
  if ($title!='login') { 
    require("includes/footer.inc.php");
  }
}

ob_end_flush(); // Immediately calls rewrite
?>

