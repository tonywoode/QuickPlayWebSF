<div class="adminmenu">
  [Add News Post|news_add] -
  [Add Version|version_add] -
  <?php
    if (isset($_GET['title']))
      echo "<a href=\"edit.php?title={$_GET['title']}\">Edit this page</a> - ";
  ?>
  <a href="editincludes.php">Edit Includes</a> -
  <a href="phpinfo.php">PHP Info</a> -
  <a href="index.php?logout=1">Log Out</a>
</div>
