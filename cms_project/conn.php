<?php
    define('SQL_HOST','127.0.0.1'); 
    define('SQL_USER', 'samb_skroot');
    define('SQL_PASS', 'Wdmd312#!');
    define('SQL_DB', 'samb_skroot');
    $conn = mysql_connect(SQL_HOST,SQL_USER,SQL_PASS) or die('Could not connect to db'.mysql_error());

    mysql_select_db(SQL_DB, $conn) or die('Could not select db'); 
	

?>
