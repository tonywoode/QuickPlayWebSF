<div class="about">     
  <div>Welcome to the QuickPlay homepage. QuickPlay is a powerful universal emulator
    frontend, which has support for countless emulators and systems.
    QuickPlay is written in Delphi 2005 Personal Edition and is released under a BSD license which
    means its free AND you can take the source code and do whatever you want with 
    it, as long as you leave my name in it somewhere.
  </div>
</div>

<h2>Change Log</h2>

<?php
  // Begin loading in the news entries from the database.
  $dbo = new QPDatabase();
  $dbo->Query("SELECT title, changes, authors.name, date_posted, changes.id FROM changes, authors 
    WHERE changes.author_id=authors.id and changes.date_posted > '2004-10-12' 
    ORDER BY date_posted DESC LIMIT 5");


  while( $row = $dbo->Fetch_Array() ) 
  {
    echo "<div class=\"newshead\">\n{$row['title']}";
    if ( $auth->IsLoggedOn() )
      echo "  - <a href=\"index.php?title=news_add&post={$row['id']}\">edit</a>";
    echo "\n</div>\n";
    echo "<div class=\"newscontent\">\n";
    echo $row['changes'];           
    echo "</div>\n";
    echo "<div class=\"newsfooter\">\nPosted by {$row['name']} on ";
    echo date("d-m-Y", strtotime($row['date_posted']));
    echo "\n</div>\n";

  }
?>

<div class="about">
  [Change Log|changelog]        
</div>"