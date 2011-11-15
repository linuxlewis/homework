<?php
    require_once 'conn.php';
    require_once 'header.php';
    $productID = $_GET['pid'];

    $sql = "SELECT * from store_product " .
        "WHERE product_id = '".$productID."'";

    $result = mysql_query($sql, $conn);
    if(mysql_num_rows($result)==0){
        echo "<br/>\n";
        echo " invalid product id \n";
    }
    else{

        $row = mysql_fetch_array($result);
        echo "<img src=\"data:image/gif;base64,". $row['product_image'] . "\" style=\"width:400px; height:400px;\" />";
        echo "<h1>" . $row['product_name'] . "</h1>";
        echo "<h3>" . $row['product_price'] . "</h3>";
        echo "<p>" . $row['product_description'] . "</p>";
?>
    <form method="post" action="modcart.php">
        <p>Quantity:<input type="text" name="quant" /> </p>
        <p><input type="submit" value="add to cart" /></p>
        <p><input type="submit" value="view cart" /></p>
        <p><input type="hidden" name="pid" value="<?php echo $row['product_id']; } ?>"/></p>
    </form>
    <hr/>
    <a href="index.php" title="home">Back to home</a>
<?php

    require_once 'footer.php';

?>
