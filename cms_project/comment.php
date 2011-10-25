<?php
    require_once 'conn.php';
    require_once 'outputfunctions.php';
    require_once 'header.php';
    outputStory($_GET['article']);
?>
<h1>Add a comment:</h1>
<form method="post" action="transact-article.php">
<p>
    Comment:<br/>
    <textarea id="comment" name="comment" rows="10" cols="60"></textarea>
</p>
<p>
    <input type="submit" class="submit" name="action" value="Submit Comment" />
    <input type="hidden" name="article" value="<?php echo $_GET['article'];?>" />
</p>
</form>
<?php
showComment($_GET['article'], FALSE);
require_once 'footer.php';
?>
