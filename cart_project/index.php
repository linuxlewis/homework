<?php
    require_once 'conn.php';
    require_once 'header.php';
    if(isset($_SESSION['cusomer_id'])){
        //hello user
        $sql = "SELECT * from store_customer " . 
            "WHERE customer_id='" . $_SESSION['customer_id'] . "'";
        $result = mysql_query($sql, $conn) or die ('query failed');
        $userRow = mysql_fetch_array($result); 
        echo "<h3>Hello " . $userRow['customer_firstname'] . ", Welcome Back!</h3>";
        $_SESSION['isLoggedIn'] = 1;
    }
    else if(isset($_POST['user']) && isset($_POST['password'])){
        //login

    }

    else{
        //login form
        echo "<form method='post' action='index.php' id='login'>";
        echo "<p>User:<input type=\"text\" name=\"user\" /></p>";
        echo "<p>Password:<input type=\"password\" name=\"password\" /></p>";
        echo "</form>";



    }
    $sessionID = session_id();
        if(mysql_num_rows($result)==0){
        $sql = "INSERT into store_customer(customer_id) VALUES('".$sessionID."')";
        mysql_query($sql, $conn);
        $_SESSION['isLoggedIn'] = 1;
    }
    else{
        $_SESSION['isLoggedIn'] = 1;
    }
    $sql = "SELECT * from store_product";

    $result = mysql_query($sql, $conn);
    if(mysql_num_rows($result)==0){
        echo "<br/>\n";
        echo " There are currently no products to view.\n";
    }
    else{
        echo "<div id=\"products\">";
        while($row=mysql_fetch_array($result)){
            echo "<div class=\"product_row\" style=\"width:400px; float:left;\">";
            echo "<img src=\"data:image/gif;base64,". $row['product_image'] . "\" style=\"width:100px; height:100px;\" />";
            echo "<a href=\"getprod.php?pid=".$row["product_id"]."\">";
            echo "<h3>".$row["product_name"]."</h3>";
            echo "</a>";
            echo "<h4 class=\"price\">" . $row['product_price'] . "</h4>";
            echo "<p>" . $row['product_description'] . "</p>";
            echo "<hr/>";
            echo "</div>";

        }

        echo "</div>";
    }
    require_once 'footer.php';
?>
