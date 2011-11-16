<?php
    require_once 'conn.php';
    require_once 'header.php';
    $sql = "SELECT * from store_customer " . 
            "WHERE customer_id='" . $_SESSION['customer_id'] . "'";
        $result = mysql_query($sql, $conn) or die ('query failed');
        $row = mysql_fetch_array($result); 

?>
<form action="checkout2.php" method="post">
<table>
    <tr>
        <th>Billing Information</th>
    </tr>
    <tr>
        <td>First Name:</td>
        <td><input type="text" name="c_firstname" value="<?php echo $row["customer_firstname"]?>"/></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><input type="text" name="c_lastname" value="<?php echo $row["customer_lastname"]?>" /></td>
    </tr>
    <tr>
        <td>Billing Address:</td>
        <td><input type="text" name="c_streetone" value="<?php echo $row["customer_streetone"]?>"/></td>
    </tr>
    <tr>
        <td>Billing Address 2:</td>
        <td><input type="text" name="c_streettwo" value="<?php echo $row["customer_streettwo"]?>
        "/></td>
    </tr>
    </tr>
        <td>City</td>
        <td><input type="text" name="c_city" value="<?php echo $row["customer_city"]?>" /></td>
    </tr>
    <tr>
        <td>State:</td>
        <td><input type="text" name="c_state" maxlength="2" value="<?php echo $row["customer_state"]?>" /></td>
    </tr>
    <tr>
        <td>Phone Number</td>
        <td><input type="text" name="c_phonenumber" maxlength="10" value="<?php echo $row["customer_phone"] ?>" /> </td>
    </tr>
    <tr>
        <td>Zip Code</td>
        <td><input type="Text" name="c_zipcode" maxlength="5" value="<?php echo $row["customer_zip"] ?>" /></td>
    </tr>
</table>
<table>
    <tr>
        <th>Shipping Information</th>
    </tr>
    <tr>
        <td>
        Same info as Billing
        </td>
        <td>
        <input type="checkbox" name="sameInfo" />
        </td>
    </tr>
    <tr>
        <td>First Name:</td>
        <td><input type="text" name="o_firstname" value=""/></td>
    </tr>
    <tr>
        <td>Last Name:</td>
        <td><input type="text" name="o_lastname" value="" /></td>
    </tr>
    <tr>
        <td>Billing Address:</td>
        <td><input type="text" name="o_streetone" value=""/></td>
    </tr>
    <tr>
        <td>Billing Address 2:</td>
        <td><input type="text" name="o_streettwo" value="
        "/></td>
    </tr>
    </tr>
        <td>City</td>
        <td><input type="text" name="o_city" value="" /></td>
    </tr>
    <tr>
        <td>State:</td>
        <td><input type="text" name="o_state" maxlength="2" value="" /></td>
    </tr>
    <tr>
        <td>Phone Number</td>
        <td><input type="text" name="o_phonenumber" maxlength="10" value="" /> </td>
    </tr>
    <tr>
        <td>Zip Code</td>
        <td><input type="Text" name="o_zipcode" maxlength="5" value="" /></td>
    </tr>
</table>
<input type="submit" value="Send Order" />
</form>
<?php
 $sql = "SELECT * FROM store_cart " .
    " LEFT OUTER JOIN store_product on store_product.product_id = store_cart.product_id " . 
    " WHERE customer_id='" .$_SESSION['customer_id']."' ";

    $result = mysql_query($sql,$conn) or die('cart failed');

        if(mysql_num_rows($result) > 0){
                echo "<ul class=\"headings\" >".
                    "<li>Quantity</li>".
                    "<li>Image</li>".
                    "<li>Name</li>".
                    "<li>Price</li>".
                    "<li>Extended Price</li>".
            "</ul>"; 
            echo "<hr/>";
            //iterate through rows
            $total = 0;
            while($row = mysql_fetch_array($result)){
               echo "<div>".
               echo $row["cart_quantity"];
               "<img src=\"data:image/gif;base64,".$row['product_image']."\" style=\"width:100px;height:100px;\" />" .
               "<a href=\"getprod.php?pid=" . $row['product_id'] . "\">" . $row['product_name'] .
               "</a>".
               "<p class=\"price\" style=\"display:inline;\"> $" . $row['product_price'] . "</p>";
               $extend = $row['cart_quantity'] * $row['product_price'];
                $total += $extend; 
               echo "<p class=\"subtotal\" style=\"display:inline;\"> | $" . $extend . "</p>" .
               "<a href=\"modcart.php\">Make changes to cart</a>";
               echo "</div><hr/>";

            }
            echo "<p>Total before shipping: $" . $total . "</p>";
        }
        else{
            echo "<h3> There are no items in your cart </h3>";
        }
 
    require_once 'footer.php';
?>

