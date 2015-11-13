--TEST--
SUCCESS: Simple mysql_connect - host, user, pass given, host with port
--FILE--
<?php
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

// Converter should extract the port
$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect('127.0.0.1',  $user,  $pass, NULL, 3306));
if (!$con) {
    printf("[connect_1] Failure: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "[connect_1] Success\n";
}
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
[connect_1] Success

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
[connect_1] Success

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
8, 8, 
--ENDOFTEST--
