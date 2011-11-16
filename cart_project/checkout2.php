<?php
    require_once 'conn.php';
    require_once 'header.php';
    
    //set info


    //if checked
        $o_firstname = $_POST["c_firstname"];
        $o_lastname = $_POST["c_lastname"];
        $o_streetone = $_POST["c_streetone"];
        $o_streettwo = $_POST["c_streettwo"];
        $o_city = $_POST["c_city"];
        $o_state = $_POST["c_state"];
        $o_phonenumber = $_POST["c_phonenumber"];
        $o_zipcode = $_POST["c_zipcode"];
    //else
        $o_firstname = $_POST["o_firstname"];
        $o_lastname = $_POST["o_lastname"];
        $o_streetone = $_POST["o_streetone"];
        $o_streettwo = $_POST["o_streettwo"];
        $o_city = $_POST["o_city"];
        $o_state = $_POST["o_state"];
        $o_phonenumber = $_POST["o_phonenumber"];
        $o_zipcode = $_POST["o_zipcode"];
    
    //add into store_order
    $sql = "INSERT into store_order(customer_id,order_firstname,order_lastname,order_streetone,".
    "order_streettwo,order_city,order_state,order_zipcode,order_phone) ".
    "VALUES('".$_SESSION['customer_id']."','".$o_firstname."','".$o_lastname."','".$o_streetone.
    "','" . $o_streettwo . "','" . $o_city . "','" . $o_state . "','" . $o_zipcode . "','" .
    $o_phonenumber . "')";

    $result = mysql_query($sql,$conn) or die('insert order failed');

    $orderid = mysql_insert_id();

    //select cart
    $sql = "SELECT * FROM store_cart " .
    " LEFT OUTER JOIN store_product on store_product.product_id = store_cart.product_id " . 
    " WHERE customer_id='" .$_SESSION['customer_id']."' ";
   
    $result = mysql_query($sql,$conn) or die('cart failed');
    
    //order constants
    $shipping_constant = 4.95;
    $tax_constant = .056;
    $tax = 0;
    $shipping = 0;
    $subtotal = 0;
    $total = 0;

    while($row = mysql_fetch_array($result){
        //insert item into order detail
        $sql = "INSERT into store_orderdetail(order_id,product_id,cart_quantity) ".
        "VALUES('".$orderid."','".$row['product_id'] . "','" . $row['cart_quantity'] . "')";

        mysql_query($sql, $conn);

        $shipping += $shipping_constant; 
        $tax += $row["cart_quantity"] * $row["product_price"] * $tax_constant;
        $subtotal += $row["cart_quantity"] * $row["product_price"];
    }
    //calculate total
    $total = $shipping + $tax + $subtotal; 
    //update order
    $sql = "UPDATE store_order ".
    "SET order_subtotal ='".$subtotal."', order_shipping='".$shipping."', order_tax='".$tax."',".
    "order_total='".$total."' WHERE order_id ='".$orderid."'";

    mysql_query($sql,$conn);
    //print out


    $sql = "SELECT * from store_order LEFT OUTER JOIN store_customer on store_order.customer_id = store_customer.customer_id WHERE order_id = '".$orderid."'";
    $result = mysql_query($sql,$conn);
    $row = mysql_fetch_array($result);

    echo "<h2> Order Recap</h2>";

    echo "<p>Order Date:".$row['order_date'] . "</p>";
    echo "<p>Order Number:".$row['order_id'] . "</p>";
    echo "<p>Bill to:</p>";
    echo "<ul> " .
            "<li>".$row['customer_firstname'] ." ".$row['customer_lastname']."</li>".
            "<li>".$row['customer_streetone'] . "</li>" .
            "<li>".$row['customer_city'] . "," . $row['customer_state'] . " " . $row['customer_zip'] .
            "</li></ul>";
    echo "<p>Ship to:</p>";
    echo "<ul> " .
            "<li>".$row['order_firstname'] ." ".$row['order_lastname']."</li>".
            "<li>".$row['order_streetone'] . "</li>" .
            "<li>".$row['order_city'] . "," . $row['order_state'] . " " . $row['order_zip'] .
            "</li></ul>";
    
