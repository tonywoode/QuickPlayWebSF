<?php
echo "<div class='about'>";
if (!$auth->IsLoggedOn() ) // Can't have just anyone uploading files
  echo "Please log in first.";
else {

$target_path = "extra/";

$target_path = $target_path . basename( (string) $_FILES['uploadedfile']['name']); 

 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( (string) $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
echo "<a href=" . $_SERVER["PHP_SELF"] . "?title=manage> Return";

}
echo "</div>";


?>
