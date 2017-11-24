<?php
  echo "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
     QuickPlay Homepage - Current Version <?=$config['version']?>
    </title>
    <meta name="keywords" content="quickplay, emulation, frontend, retro, gaming, mame, mess, retroarch, gamebase, mednafen, bluemsx, winuaeloader, multi, emulator, universal" />
    <meta name="description" content="Quickplay the universal emulator Frontend" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="includes/main.css" title="Default Look" rel="stylesheet" type="text/css" />
    <link href="includes/old.css" title="Old Style" rel="alternate stylesheet" type="text/css">
  </head>
  <body>
    
    <!-- Logo: Top Center -->
    <div class="maincontainer">
     <div id="branding">
      <div id="logo">
        <a href="http://www.quickplayfrontend.com" title="Go to community index" rel="home" accesskey="1">
          <img src="images/5__3_QuickPlay_black.png" alt="Logo"></a>
      </div>
     </div>

      <div class="sidebar">
        
        <!-- The version tracker -->
        <div class="menu">
          <div class="menuelement">          
            Current Version <?=$config['version']?>
          </div>
        </div>
        
        <!-- Main Menu begins here -->
        <div class="menu">
          <div class="menuelement">
            [News|news_show]
          </div>
	      <div class="menuelement">
            <a href="https://sourceforge.net/projects/quickplay/files/latest/download?source=files">Download</a>
          </div>
          <div class="menuelement">
            <a href="http://forums.quickplayfrontend.com/">Forums</a>
          </div>
          <div class="menuelement">
            <a href="wiki">Wiki</a>
          </div>
	      <div class="menuelement">
            [ScreenShots|screenshots]
          </div>
          <div class="menuelement">
            [Change Log|changelog]
          </div>
          <div class="menuelement">
            [Contact|contact]
          </div>
        </div>
        
       <!-- Possibly add donation button later? 
       <div class="menu">
          <div align="left" class="menuelement">
            <a href="http://sourceforge.net/donate/index.php?group_id=122303">
              <img src="http://images.sourceforge.net/images/project-support.jpg" width="88" height="32" border="0" alt="Support This Project" /> 
            </a>
          </div>
      </div>
       -->
       
       <div class="menu">
	<div class="menuelement">
		<a href="http://sourceforge.net/projects/quickplay">QuickPlay at Sourceforge</a> <!--img src="http://sflogo.sourceforge.net/sflogo.php?group_id=122303&amp;type=15" width="150" height="40" alt="" /> -->
		</a>
	</div>
	<div class="menuelement">
          <a href="http://sourceforge.net/tracker/?group_id=122303&atid=693044">
          Submit Bug</a>
	</div>
	<div class="menuelement">
          <a href="http://sourceforge.net/tracker/?group_id=122303&atid=693047">
          Request Feature</a>
	</div>

</div>
        
        
      </div>

<!-- Main Content -->
      <div class="maincontent">

        
