<?php
    require_once 'conn.php';
    require_once 'header.php';
    
    switch($_POST['action']){

        case 'add to cart':
            $_POST['product_id']
            $sql = "INSERT 
            break;

    
    }
    if($_SESSION['isLoggedIn'] == 1){

        $sql = "SELECT * from store_cart " .
        " WHERE customer_id='" .session_id()."' " .
        " LEFT OUTER JOIN store_product on store_product.product_id = store_cart.product_id ";

        $result = mysql_query($sql,$conn);

        if(mysql_num_rows($result) > 0){
            //iterate through rows
            echo """<table>
            <tr>
                <th>Quantity</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Extended Price</th>

            </tr>""";
            while($row = mysql_fetch_array($result)){
                
            }

        }
        else{
            echo "<h3> There are no items in your cart </h3>";
        }
    }
    else{
        echo "<script>window.location.href='http://www.sambolgert.com/static_web/cart_project/index.php';</script>";
    }
 
    require_once 'footer.php';

?>
