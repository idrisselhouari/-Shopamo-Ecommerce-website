<?php
    include 'databaseConnection.php';
    $con=Database::connect();
 
        $id=$_REQUEST['idProduct'];
        $productLine=  $con->query("SELECT * FROM products WHERE productId=$id");
        while($line=$productLine->fetch()){
            $imageData=$line['productPicture'];
        }
        header("Content-Type: image/jpeg");
        echo $imageData;
?>