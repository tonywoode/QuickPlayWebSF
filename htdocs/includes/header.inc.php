<?php
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
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="includes/main.css" title="Default Look" rel="stylesheet" type="text/css" />
    <link href="includes/old.css" title="Old Style" rel="alternate stylesheet" type="text/css">
  </head>
  <body>
    
    <div class="maincontainer">
      <div class="welcome">
        <img id="logo" src="images/qptext.png" alt="QuickPlay Logo" width="249" height="57" /> 
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
            [Main Page|news_show]
          </div>
          <div class="menuelement">
            <a href="http://sf.net/projects/quickplay">SF Project Page</a>
          </div>
          <div class="menuelement">
            [Change Log|changelog]
          </div>
          <div class="menuelement">
            [Contact Info|contact]
          </div>
          <div class="menuelement">
             [Download|download]
          </div>
          <div class="menuelement">
            [Features|features]
          </div>
          <div class="menuelement">
            <a href="http://sourceforge.net/forum/forum.php?forum_id=416870">Forums</a>
          </div>
          <div class="menuelement">
            [Links|links]
          </div>
          <div class="menuelement">
            [News Archive|news_archive]
          </div>
	  <div class="menuelement">
            <a href="http://quickplay.sf.net/wiki">QuickPlayWiki</a>
          </div>
          
	  <div class="menuelement">
            [ScreenShots|screenshots]
          </div>
          <div class="menuelement">
            [Source Code|sourcecode]
          </div>
        </div>
        
        <div class="menu">
          <div class="menuelement">
            <a href="http://sourceforge.net">
              <img src="http://sourceforge.net/sflogo.php?group_id=122303&amp;type=2" width="125" height="37" border="0" alt="SourceForge.net Logo" /></a>
          </div>
          <div class="menuelement">
            <a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=64">
              <img border="0" alt="Get Firefox!" title="Get Firefox!" src="http://www.spreadfirefox.com/community/images/affiliates/Buttons/110x32/get.gif"/></a>
          </div>
          <div class="menuelement">
            <a href="http://validator.w3.org/check?uri=referer">
              <img src="images/valid-xhtml10.gif" alt="Valid XHTML 1.0!" width="88" height="31" /></a>
          </div>
          <div class="menuelement"> 
            <a href="http://jigsaw.w3.org/css-validator/validator?uri=referer">
              <img src="images/vcss.gif" alt="Valid CSS" width="88" height="31" /></a>
          </div>
        </div>
        
      </div><!-- Main Content -->
      <div class="maincontent">
