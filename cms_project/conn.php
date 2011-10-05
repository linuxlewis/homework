<?php
    define('SQL_HOST', 'hostname');
    define('SQL_USER', 'skroot');
    define('SQL_PASS', 'Wdmd312#!');
    define('SQL_DB', 'skroot');
    $conn = mysql_connect(SQL_HOST,SQL_USER,SQL_PASS) or die('Could not connect to db'.mysql_error());

    mysql_select_db(SQL_DB, $conn) or die('Could not select db'); 
	

?>
