<?php
  //create the database object
  $dbo = new QPDatabase();
  
  if (!$auth->IsLoggedOn())
    {
      die("Not Logged in");
    }
      
  if (isset($_POST['btnAdd']) && $_POST['btnAdd'] == "Add") 
  { 

    //check to see if we are editting or adding a post.
    if(isset($_POST['oldid']))
    {
      $query = "UPDATE changes SET title='{$_POST['txttitle']}', 
      changes='{$_POST['txtstory']}' WHERE id={$_POST['oldid']}";
    }
    else
    {
      $date = strftime('%Y-%m-%d');
      $query = "INSERT INTO changes SET date_posted='$date', title='{$_POST['txttitle']}', 
      changes='{$_POST['txtstory']}', author_id='".$auth->GetID()."'";
    }

    if($dbo->Query($query) == 1) {
      echo "<h2>Operation completed successfully</h2>";
    }
    else {
      echo "<h2>Error occurred during operation</h2>";
    }
    unset($query);  
        
  }
  else {
  
	//check to see if we are editting a post.
	$title = "";
	$changes = "";
	$id = -1;
	if (isset($_GET['post']))
        {
          $dbo = new QPDatabase();
          $dbo->Query("SELECT title, changes, id FROM changes WHERE id='{$_GET['post']}' LIMIT 1");
          if($dbo->Num_Rows() == 1)
          {
            $result = $dbo->Fetch_Full_Array();
            $title = $result[0]['title'];
            $id = $result[0]['id'];
            $changes = $result[0]['changes'];
          }
	}
?> 

    <form name="form1" method="post" action="<?=$_SERVER['PHP_SELF'] . "?title=update_changelog" ?>">
	
	<?php

          if ( !($id == -1) )
            echo "<input type=\"hidden\" name=\"oldid\" value=\"$id\">\n";
	?>
      <div>
        <h3>Version</h3>
        <input name="txttitle" type="text" id="txttitle" size="50" maxlength="50" value="<?=$title?>">
      </div>
            
      <div>
        <h3>Changes</h3>
        <textarea name="txtstory" cols="50" rows="10" id="txtstory"><?=$changes?></textarea>
      </div>
      
      <input name="btnAdd" type="submit" id="btnAdd" value="Add">
    </form>
<?php
  }
?>