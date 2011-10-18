<?php
    require_once 'conn.php';
    $userid = '';
    $name = '';
    $email = '';
    $password = '';
    $access_lvl = '';
    if(isset($_GET['userid'])){
        $sql = "SELECT * FROM cms_users WHERE user_id=" . $_GET['userid'];
        $result = mysql_query($sql, $conn)
            or die('Could not look up user data: ' . mysql_error());
        $row = mysql_fetch_array($result);
        $userid = $_GET['userid'];
        $name = $row['name'];
        $email = $row['email'];
        $access_lvl = $row['access_lvl'];
    }
    require_once('header.php');
    echo "<form method=\"post\" action=\"transact-user.php\">\n";
    if($userid){
        echo "<h1>Modify Account</h1>\n";
    }
    else{
        echo "<h1>Create Account</h1>\n";
    }
?>
