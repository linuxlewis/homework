<?php
    require_once 'conn.php';
    require_once 'http.php';

    if(isset($_REQUEST['action'])){
        switch($_REQUEST['action']){
            case 'Login':
                if(isset($_POST['email']) and isset($_POST['password'])){
                    $sql = "SELECT user_id, access_lvl, name " .
                    "FROM cms_users " .
                    "WHERE email='" . $_POST['email'] . "' " .
                    "AND password='" . $_POST['password'] . "'";
                    $result = mysql_query($sql,$conn) or die('Could not look up user information: ' . mysql_error());
                    if($row = mysql_fetch_array($result)){
                        session_start()
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['access_lvl'] = $row['access_lvl'];
                        $_SESSION['name'] = $row['name'];
                    }
                }
                redirect('index.php');
                break;
            case 'Logout':
                session_start();
                session_unset();
                session_destroy();
                redirect('index.php');
                break;

            case 'Create Account':
                if(isset($_POST['name'])
                    and isset($_POST['email'])
                    and isset($_POST['password'])
                    and isset($_POST['password2'])
                    and ($_POST['password']) == $_POST['password2']){
                    
                        $sql = "INSERT INTO cms_users (email,name,password) " .
                        "VALUES ('" . $_POST['email'] . "','" .
                        $_POST['name'] . "','" . $_POST['password' . "')";

                        mysql_query($sql,$conn)
                            or die('Could not create user account: ' .mysql_error());
                        session_start();
                        $_SESSION['user_id'] = mysql_insert_id($conn);
                        $_SESSION['access_lvl'] = 1;
                        $_SESSION['name'] = $_POST['name';
                    }
                    redirect('index.php');
                    break;




?>  
