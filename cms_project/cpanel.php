<?php
    require_once 'conn.php';
    require_once 'header.php';
    $sql = "SELECT name, email, email_notify " .
    "FROM cms_users " .
    "WHERE user_id=" . $_SESSION['user_id'];
    $result = mysql_query($sql,$conn)
        or die('Could not look up user data: ' . mysql_error());
    $user = mysql_fetch_array($result);
?>
<form method="post" action="transact-user.php">
<p>
    Name:<br/>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']);?>"/>
</p>
<p>
    Email: <br/>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"/>
</p>
<p>
    Email Notifications:<br/>
On    <input type="radio" name="email_notify" value="1" <?php if($user['email_notify'] == 1){echo 'checked="checked"';} ?>/>
  <br/>  
  Off
     <input type="radio" name="email_notify" value="0" <?php if($user['email_notify'] == 0){echo 'checked="checked"';} ?>/>

</p>
<p>
    <input type="submit" class="submit" name="action" value="Change my info" />
</p>
</form>
<h1>Pending Articles</h1>
    <div class="scroller">
        <table>
<?php
    $sql = "SELECT article_id, title, date_submitted " .
    "FROM cms_articles " .
    "WHERE is_published=0 " .
    "AND author_id=" . $_SESSION['user_id'] . " " .
    "ORDER BY date_submitted";
    $result = mysql_query($sql,$conn)
        or die('Could not get list of pending articles: ' . mysql_error());
    if(mysql_num_rows($result) == 0){
        echo '<em>There are no pending articles </em>.';
    }
    else{
        while($row = mysql_fetch_array($result)){
            echo "<tr>\n";
            echo '<td><a href="reviewarticle.php?article=' . 
            $row['article_id'] . '">' . htmlspecialchars($row['title']) .
            "</a> (submitted " .
            date("F j, Y" , strtotime($row['date_submitted'])) .
            ")</td>\n";
            echo "</tr>\n";
        }
    }
?>
</table>
</div>
<br />
<h2>Published Stories<h2>
<div class="scroller">
<table>
<?php
    $sql = "SELECT article_id, title, date_published " .
    "FROM cms_articles " .
    "WHERE is_published=1 " .
    "AND author_id=" . $_SESSION['user_id'] . "  " .
    "ORDER BY date_submitted";
    $result = mysql_query($sql, $conn)
        or die('Could not get list of published articles:' . mysql_error());
    if(mysql_num_rows($result) == 0){
        echo " <em>No published articles available</em>.";
    } else {
        while($row = mysql_fetch_array($result)){
            echo "<tr>\n";
            echo '<td><a href="viewarticle.php?article=' . 
            $row['article_id'] . '">' . htmlspecialchars($row['title']) .
            "</a> (published " .
            date("F j, Y", strtotime($row['date_published'])) .
            ")</td>\n";
            echo "</tr>\n";
        }
    }
?>
</table>
</div>
<br />
<?php require_once 'footer.php' ?>

