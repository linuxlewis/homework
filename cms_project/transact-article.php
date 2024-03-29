<?php

    session_start();
    require_once 'conn.php';
    require_once 'http.php';
    if(isset($_REQUEST['action'])){
        switch($_REQUEST['action']){
            case 'Submit New Article':
                if(isset($_POST['title'])
                    and isset($_POST['body'])
                    and isset($_SESSION['user_id']))
                {
                    $sql = "INSERT INTO cms_articles " .
                    "(title,body, author_id, date_submitted) " .
                    "VALUES ('".$_POST['title'] .
                    "','" . $_POST['body'] .
                    "'," . $_SESSION['user_id'] . ",'" . 
                    date("Y-m-d H:i:s". time()) . "')";
                    mysql_query($sql,$conn)
                        or die('Could not submit article: ' .mysql_error());
                
                //email notification system
                //sends email to admins
                    $sql = "SELECT * ".
                    "FROM cms_users " .
                    "WHERE access_lvl = 3 AND " .
                    "email_notify = 1";
                
              $result = mysql_query($sql,$conn) or die('Could not select admins' . mysql_error());

            for($i = 0; $i < mysql_num_rows($result); $i++){
                $row = mysql_fetch_assoc($result);
                $email = $row['email'];
                $subject = "New Article to Review";
                $message = "Hello, ". $row['name'] .
                "\nPlease log to review the new article submitted";
                $headers = "From:cms-spam@samb.webfactional.com\r\n";
                mail($email,$subject,$message,$headers);
            
            }
                }
            redirect('index.php');
            break;
            case 'Edit':
                redirect('compose.php?a=edit&article=' . $_POST['article']);
                break;

            case 'Save Changes':
                if(isset($_POST['title'])
                    and isset($_POST['body'])
                    and isset($_POST['article']))
                    {
                        $sql = "UPDATE cms_articles " .
                        "SET title='" . $_POST['title'] .
                        "', body='" . $_POST['body'] .
                        "', date_submitted='" . date("Y-m-d H:i:s", time()) . "' " .
                        "WHERE article_id=" . $_POST['article'];
                        if(isset($_POST['authorid'])){
                            $sql .= " AND author_id=" . $_POST['authorid'];
                        }
                        mysql_query($sql,$conn)
                            or die('Could not update article: ' . mysql_error());
                    }
                    if(isset($_POST['authorid'])){
                        redirect('cpanel.php');
                    }
                    else{
                        redirect('pending.php');
                    }
                    break;
            case 'Publish':
                if($_POST['article']){
                    $sql = "UPDATE cms_articles " .
                    "SET is_published = 1, date_published='" .
                    date("Y-m-d H:i:s", time()) . "' ".
                    "WHERE article_id=" . $_POST['article'];
                    mysql_query($sql,$conn) or die('Could not publish article: ' . mysql_error());
                    //mail system, sends email to author
                    $sql = "SELECT * from cms_users usr ".
                    "LEFT OUTER JOIN cms_articles ar on ".
                    "usr.user_id = ar.author_id ". 
                    "WHERE ar.article_id =".$_POST['article'];

                    $result = mysql_query($sql,$conn) or die ('Could not query users:' . mysql_error());
                    $row = mysql_fetch_assoc($result);
                    $subject ="Cms Article Published";
                    $message = "Hello , ". $row['name'] ."\n".
                    "Your article: ".$row['title'] . " has been published";
                    $email = $row['email'];
                    $headers = "From: cms-spam@samb.webfactional.com\r\n";
                    mail($email,$subject,$message,$headers); 
                }
                redirect('pending.php');
                break;
            case 'Retract':
                if($_POST['article']){
                    $sql = "UPDATE cms_articles " .
                    "SET is_published=0, date_published=''" .
                    "WHERE article_id=" . $_POST['article'];
                    mysql_query($sql,$conn)
                        or die('Could not retract article: ' . mysql_error());
                }
                redirect('pending.php');
                break;
            case 'Delete':
                if($_POST['article']){
                    $sql = "DELETE from cms_articles " .
                    "WHERE is_published=0 " .
                    "AND article_id=" . $_POST['article'];
                    mysql_query($sql, $conn)
                        or die('Could not delete article: ' . mysql_error());
                }
                redirect('pending.php');
                break;

            case 'Submit Comment':
                if(isset($_POST['article'])
                    and $_POST['article']
                    and isset($_POST['comment'])
                    and $_POST['comment'])
                {
                    $sql = "INSERT INTO cms_comments " .
                    "(article_id,comment_date,comment_user,comment) " .
                    "VALUES (" . $_POST['article'] . ",'".
                    date("Y-m-d H:i:s", time()).
                    "'," . $_SESSION['user_id'] .
                    ",'" . $_POST['comment'] . "')";
                    mysql_query($sql,$conn)
                        or die('Could not add comment: ' . mysql_error());
                }
                redirect('viewarticle.php?article='.$_POST['article']);
                break;

            case 'remove':
                if(isset($_GET['article'])
                    and isset($_SESSION['user_id']))
                {
                    $sql = "DELETE FROM cms_articles " .
                    "WHERE article_id=" . $_GET['article'] .
                    " AND author_id=" . $_SESSION['user_id'];
                    mysql_query($sql,$conn)
                        or die('Could not remove article: ' . mysql_error());
                }
                redirect('cpanel.php');
                break;
        }
    }
    else{
        redirect('index.php');
    }
?>
