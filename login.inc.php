<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      QuickPlay Admin Login
    </title>
  </head>
  <body>
    <h2>Login</h2>
      
      <form name="loginfrm" method="post" action="<?= basename($_SERVER["PHP_SELF"]) ."?title=" . $_GET['title']?>">
        
        <div>
          UserName <input name="userid" type="text" id="userid" size="20" maxlength="20">
        </div>
        <div>
          Password <input name="pwd" type="password" id="pwd" size="20" maxlength="20">
        </div>
        
        <input type="submit" name="Submit" value="Login">
      </form>

  </body>
</html>
