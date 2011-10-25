<?php
    require_once 'conn.php';
    require_once 'outputfunctions.php';
    require_once 'header.php';
?>
<form method="post" action="transact-article.php">
    <h2>Article Review</h2>
    <?php
        outputStory($_GET['article']);
        $sql = "SELECT ar.*, usr.name, usr.access_lvl " .
        "FROM cms_articles ar INNER JOIN cms_users usr " .
        "ON ar.author_id = usr.user_id " .
        "WHERE ar.article_id=" . $_GET['article'];
        $result = mysql_query($sql,$conn)
            or die('Could not retrieve article information: ' . mysql_error());
        $row = mysql_fetch_array($result);
        if($row['date_published'] and $row['is_published']){
            echo '<h4>Published: ' .
            date("l F j, Y H: i", strtotime($row['date_published'])) .
            "</h4>\n";
        }
        echo "<p><br />\n";
        if($row['is_published']){
            $buttonType = "Retract";
        }
        else{
            $buttonType = "Publish";
        }
        echo "<input type=\"submit\" class=\"submit\" " .
        "name=\"action\" value=\"Edit\" /> ";
        if(($row['access_lvl'] > 1) or ($_SESSION['access_lvl'] > 1)){
            echo "<input type=\"submit\" class=\"submit\" " .
            "name=\"action\" value=\"$buttonType\"/>";
        }
        echo "<input type=\"submit\" class=\"submit\" " .
            "name=\"action\" value=\"Delete\"> ";
        ?>
        <input type="hidden" name="article" value="<?php echo $_GET['article'] ?>"/>
        </p>
    </form>
<?php require_once 'footer.php'; ?>
