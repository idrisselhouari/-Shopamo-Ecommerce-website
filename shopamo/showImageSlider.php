<?php
   require 'databaseConnection.php';
   $con=Database::connect();
 
        $id=$_REQUEST['id_slider'];
        $productLine = $con->query("SELECT sliderPicture FROM nouvels WHERE sliderId =$id");
        $line=$productLine->fetch();
        header("Content-Type: image/jpeg");
        echo $line['sliderPicture'];
?>