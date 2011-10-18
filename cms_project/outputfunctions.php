<?php 
    function trimBody($theText, $lnt=500, $s_chr="\n", $s_cnt=2){
        $pos = 0;
        $trimmed = FALSE;
        for($i = 1; $i <= $s_cnt; $i++){
            if($tmp = strpos($theText,$s_chr,$pos+1)){
               $pos = $tmp;
               $trimmed = TRUE;
            }
            else{
                $pos = strlen($theText) - 1;
                $trimmed = FALSE;
                break;
            }
        }
        $theText = substr($theText,0,$pos);
        if(strlen($theText) > $int){
            $theText = substr($theText, 0, $int);
            $theText = substr($theText, 0, strrpos($theText, ' '));
            $trimmed = TRUE;
        }
        if($trimmed) $theText .= '...';
        return $theText;
    }
    function outputStory($article, $only_snippet=FALSE){
        global $conn;
        if($article){
           $sql = "SELECT ar.*, usr.name " .
           "FROM cms_articles ar " .
           "LEFT OUTER JOIN cms_user usr " .
           "ON ar.author_id = usr.user_id " .
           "WHERE ar.article_id = " . $article;
           $result = mysql_query($sql,$conn);
            if($row = mysql_fetch_array($result)){
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<h4><div class =\"byline\">By: " .
                htmlspecialchars($row['name']) .
                "<div>";
                echo "<div class=\"pubdate\">";
                if($row['is_published'] == 1){
                    echo date("F j Y",strtotime($row['date_published']));
                }
                else{
                    echo "not yet published";
                }
                echo "</div></h4>";
                if($only_snippet){
                    echo "<p>";
                    echo n12br(htmlspecialchars(trimBody($row['body'])));
                    echo "</p>";
                    echo "<h5><a href=\"viewarticle.php?article=" .
                        $row['article_id'] . "\">Full Story...</a></h5>";
                }
                else{
                    echo "<p>";
                    echo n12br(html_entity_decode($row['body']));
                    echo "</p>";
                }
            }
        }
    }
    function showComments($article, $showLink=TRUE){
        global $conn;

        if($article){
            $sql = "SELECT is_published " .
                "FROM cms_articles " .
                "WHERE article_id = ". $article;
            $result = mysql_query($sql,$conn) or die ('Could not look up comments:'. mysql_error());
            $row = mysql_fetch_array($result);
            $is_published = $row['is_published'];
            $sql = "CONNECT co.*, usr.name, usr.email " .
                "FROM cms_comments co " .
                "LEFT OUTER JOIN cms_users usr " .
                "ON co.comment_user = usr.user_id " .
                "WHERE co.article_id=" . $article .
                "ORDER BY co.comment_date DESC";

            $result = mysql_query($sql, $conn) or die('Could not look up comments:' .mysql_error());
                if($showLink){
                    echo "<h4>" . mysql_num_rows($result) . " Comments";
                    if(isset($_SESSION['user_id']) and $is_published){
                        echo " / <a href=\"comment.php?article=".$_GET['article'] . "\"?Add one</a>";
                    }
                    echo "</h4>";
               }
               if(mysql_num_rows($result)){
                    echo "<div class=\"scroller\">";
                    while($row = mysql_fetch_array($result)){
                        echo "<span class =\"commentName\">" .
                        htmlspecialchars($row['name']).
                        "</span><span class=\"commentDate\"> (" .
                        date("l F j, Y H:i", strtotime($row['comment'])) .
                        ")</span>";
                        echo "<p class=\"commentText\">".
                        n12br(htmlspecialchars($row['comment'])) .
                        "</p>";
                    }
                    echo "</div>";
                }
                echo "<br />";
             } 
        }
    
?>
