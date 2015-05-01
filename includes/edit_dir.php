<?php

echo "<div class='about'>";
if (!$auth->IsLoggedOn() ) // The moat around the castle.
  echo "Please log in first.";
else { // Only load/execute page if logged in!
$dir = $_GET['dir'];
if($_GET['action'] == "delete") { //Begin delete section.

  ?> 

  <form name="delete" action="<?=$PHP_SELF?>" method="POST" enctype="multipart/form-data"> 
  <input type="hidden" name="id" value="<?=$_GET['id'] ?>" /> 
  Are you sure you wish to delete "<?echo $_GET['dir'].'/'.$_GET['id'];?>" ? 
  <input type="submit" name="doaction" value="YES" /> 
  </form> 

  <?php 


  if ($_POST['doaction']) 
  { 
    $file = $_POST['id']; 
      unlink($dir . '/' . $file);
      echo "Deleted '$file'"; 
      echo "<a href=" . $_SERVER['PHP_SELF'] . "?title=manage&dir=".$dir.">Return";
  } 


}
//End delete section

else //if no $_GET['action']  (the page will default to this) Begin main section
{
  echo "<a href=" . $_SERVER['PHP_SELF'] . "?title=manage&dir=extra>Extras</a> ||  ";
  echo "<a href=" . $_SERVER['PHP_SELF'] . "?title=manage&dir=sshots>Screenshots</a><br><br>";
  if ($handle = opendir($dir)) 
  {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && $file != ".htaccess" && substr($file,-4) != ".php" && substr($file,-1) != "~" && $file != "del.php")
        {
          $list .= '<a href="'.$dir.'/'.$file.'">'.$file.'</a> - 
          <font size="2"><a href="'. $_SERVER["PHP_SELF"] 
          .'?title=manage&action=delete&dir='.$dir.'&id='.$file.'">
          delete
          </a></font><br><br>';
        }
    }
    closedir($handle);
  }

  echo $list;
  echo '
  <form enctype="multipart/form-data" action="'
  . $_SERVER["PHP_SELF"] . "?title=upload".
  '" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
  Choose a file to upload: <input name="uploadedfile" type="file" /><br />
  <input type="submit" value="Upload File" />
  </form>';
}
}  
echo "</div>";

?>


