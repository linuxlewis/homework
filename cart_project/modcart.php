<?php
    require_once 'conn.php';
    require_once 'header.php';
    //check login
    if($_SESSION['isLoggedIn' != 1){
        header('Location:index.php');
    }
    else if(isset($_POST['cart_action'])){
        //check action
        switch($_POST['cart_action']){

        case 'add to cart':
            $sql = "INSERT into store_cart(customer_id,product_id) VALUES('".$_SESSION['customer_id'] .
            "','".$_POST['product_id']."')";
            mysql_query($sql, $conn) or die('add failed');
            break;

        case 'delete item':
            $sql = "DELETE from store_cart WHERE product_id = '" . $_POST['product_id'] . "'";
            mysql_query($sql, $conn) or die('delete failed');
            break;

        case 'empty cart':
            $sql = "DELETE from store_cart WHERE customer_id = '" . $_SESSION['customer_id'] . "'";
            mysql_query($sql, $conn) or die('empty failed');
            break;
        case 'change qty':
            $sql = "UPDATE store_cart" . 
            "SET cart_quantity='" . $_POST['cart_qty'] . "' " . 
            "WHERE product_id='".$_POST['product_id'] . "' " .
            "AND customer_id='".$_SESSION['customer_id']."'";

            mysql_query($sql, $conn) or die ('update failed');

        default:
            break;

        }

    }
    else{
        
    }
    
    //start cart display;

    $sql = "SELECT * FROM store_cart " .
    " LEFT OUTER JOIN store_product on store_product.product_id = store_cart.product_id " . 
    " WHERE customer_id='" .$_SESSION['customer_id']."' ";

    $result = mysql_query($sql,$conn) or die('cart failed');

        if(mysql_num_rows($result) > 0){
            echo """
                <ul style=\"display:inline;\">
                    <li>Quantity</li>
                    <li>Image</li>
                    <li>Name</li>
                    <li>Price</li>
                    <li>Extended Price</li> 
            </ul>""";
            //iterate through rows
            while($row = mysql_fetch_array($result)){
               echo "<tr>";
               echo "<td><input type=\"text\" name=\"cart";
            }

            echo "</table>";
        }
        else{
            echo "<h3> There are no items in your cart </h3>";
        }
    //end cart display 
    require_once 'footer.php';

?>
