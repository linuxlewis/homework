<?php
    require_once 'conn.php';
    require_once 'http.php';
    $a_artTypes = array(
    "Pending" => "submitted",
    "Published" =? "published"
    );
    echo "<h2>Article Availability</h2>\n";
    $i = -1;
    foreach($a_artTypes as $k => $v){
        $i++;
        echo "<h3>" . $k . " Articles</h3>\n";
        echo "<p>\n";
        echo "<div class=\"scroller\">\n";
        $sql = "SELECT article_id, title, date_". $v .
        " FROM cms_articles " .
        "WHERE is_published=" . $i .
        " ORDER BY title";
        $result = mysql_query($sql, $conn)
            or die('Could not get list of pending articles: ' mysql_error());
            if(mysql_num_rows($result) == 0){
                echo "<em> No " .$k . " articles available</em>";
            }else{
                while($row = mysql_fetch_array($result)){
                    echo ' <a href="reviewarticle.php?article=' .
                    $row['article_id'] . '">' .
                    htmlspecialchars($row['title']) . 
                    "</a> ($v " . date("F j, Y", strtotime($row['date_'.$v])) .
                    ")<br />\n";
                }
            }
            echo "</div>\n";
            echo "</p>\n";
        }
        require_once 'footer.php';
    ?>
