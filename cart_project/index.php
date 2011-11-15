<?php
    require_once 'conn.php';
    require_once 'header.php';
    //login 
    if(isset($_SESSION['customer_id'])){
        //hello user
        $sql = "SELECT * from store_customer " . 
            "WHERE customer_id='" . $_SESSION['customer_id'] . "'";
        $result = mysql_query($sql, $conn) or die ('query failed');
        $userRow = mysql_fetch_array($result); 
        echo "<h3>Hello " . $userRow['customer_firstname'] . ", Welcome Back!</h3>";
        echo "<input type=\"submit\" name=\"action\" value=\"logout\" />";
    }
    else if(isset($_POST['user']) && isset($_POST['password'])){
        //login
        $sql = "SELECT * from store_customer " . 
            "WHERE customer_email='" . $_POST['user'] . "'";
        $result = mysql_query($sql, $conn) or die ('query failed');
        if(mysql_num_rows($result) > 0){
            //user exists
            $userRow = mysql_fetch_array($result); 

            $encrypt_pw = hash("SHA256",$_POST['password']);

            if($userRow['customer_password'] == $encrypt_pw){
                $_SESSION['isLoggedIn'] = 1;
                $_SESSION['customer_id'] = $userRow['customer_id'];
            }
            else{
                echo "<h3 style=\"color:red;\">Login Error -- Please Check Credentials</h3>";
                echo "<form method='post' action='index.php' id='login'>";
                echo "<p>User:<input type=\"text\" name=\"user\" /></p>";
                echo "<p>Password:<input type=\"password\" name=\"password\" /></p>";
                echo "<p><input type=\"submit\" value=\"login\" /></p>";
                echo "</form>";
            }
        }
        else{
            echo "<h3 style=\"color:red;\">Login Error -- Please Check Credentials</h3>";
            echo "<form method='post' action='index.php' id='login'>";
            echo "<p>User:<input type=\"text\" name=\"user\" /></p>";
            echo "<p>Password:<input type=\"password\" name=\"password\" /></p>";
            echo "<p><input type=\"submit\" value=\"login\" /></p>";
            echo "</form>";
        }
    }
    else if(isset($_REQUEST['action'])){
        if($_REQUEST['action'] == 'logout'){
            unset($_SESSION['customer_id']);
            unset($_SESSION['isLoggedIn']);
            header('Location:index.php');
        }
    }
    else{
        //login form
        echo "<form method='post' action='index.php' id='login'>";
        echo "<p>User:<input type=\"text\" name=\"user\" /></p>";
        echo "<p>Password:<input type=\"password\" name=\"password\" /></p>";
        echo "<p><input type=\"submit\" value=\"login\" /></p>";
        echo "</form>";
    }
    //end login

    //Start Product Page
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
    //end product page
    require_once 'footer.php';
?>
