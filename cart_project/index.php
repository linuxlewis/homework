<?php
    require_once 'conn.php';
    require_once 'outputfunctions.php';
    require_once 'header.php';
    $sql = "SELECT article_id FROM cms_articles where is_published='1' " .
        "ORDER BY date_published DESC";
    $result = mysql_query($sql, $conn);
    if(mysql_num_rows($result)==0){
        echo "<br/>\n";
        echo " There are currently no articles to view.\n";
    }
    else{
        while($row=mysql_fetch_array($result)){
            outputStory($row['article_id'], TRUE);
        }
    }
    require_once 'footer.php';
?>
