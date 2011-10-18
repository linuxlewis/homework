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
                }
            redirect('index.php');
            break;
            case 'Edit':
                redirect('compose.php?a=edit&article=' . $_POST['article']);
                break;

            case 'Save Changes':
                if(isset($_POST['title'])
                    and isset($_POST['body'])
                    and isset($_POST['article'])
                    {
                        $sql = "UPDATE cms_articles " .
                        "SET title='" . $_POST['title'] .
                        "', body='" . $_POST['body'] .
                        "'. date_submitted='" . date("Y-m-d H:i:s", time()) . "' " .
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
                        redirec('pending.php');
                    }
                    break;
            case 'Publish':
                if($_POST['article']){
                    $sql = "UPDATE cms_artiles " .
                    "SET is_published = 1, date_published='" .
                    date("Y-m-d H:i:s", time()) . "' ".
                    "WHERE article_id=" . $_POST['article'];
                    mysql_query($sql,$conn) or die('Could not publish article: ' . mysql_error());
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
