<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Shopamo</title>
        <link rel="icon" href="images/logos/favicon.png">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/styleproduit.css">
        <link rel="stylesheet" href="css/styleCatgories.css">
        <link rel="stylesheet" href="css/styleSlider.css">
        <link rel="stylesheet" href="css/pageCategoriesStyle.css">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> 
        <script src="JS/fileJs.js" defer></script>
        <script src="JS/slider.js" defer></script>
    </head>
    <body style="margin: 0;">
        <!--the header block-->
        <?php
            require '../databaseConnection.php';
            include 'header footer/headerIndex.php';  
        ?>
         <!--Block header end-->
        <div id="mainPage">
            <div id="bar">
                <aside id="asideCategories" class="sidebar">
                    <div id="verticalMenu" >
                        <ul >
                            <?php
                                $index=1;
                               $con=Database::connect();
                            ?>
                            <li class="categoriesTitle"><h4>Catégories</h4></li>
                            <?php
                                
                                $stmt1=$con->query("SELECT * FROM categorieGlobale");
                                foreach($stmt1 as $row){?>
                                    <li class="parentMenu" onmouseover="mouseOver('item<?php echo $index ?>')" onmouseout="mouseOut('item<?php echo $index ?>')"><?php echo $row['categorieGlobaleName'] ?>
                            <?php
                                        echo '<div class="underMenu" id="item'.$index.'">';
                                            $stmt2=$con->query("SELECT * FROM sousCategories WHERE categorieGlobaleId=".$row["categorieGlobaleId"]);
                                            echo "<ul>";
                                            foreach($stmt2 as $row2){
                                                echo '<a href="afficherCategorie.php?idCategorie='.$row2["categorieId"].'" title="'.$row2["categorieName"].'"><li class="item" >'.$row2["categorieName"].'</li></a>';                                                                                                  
                                            }
                                            echo "</ul>";
                                        echo "</div>";
                                    echo "</li>";
                                    $index++;
                                }

                                $con=Database::disconnect();
                            ?>
                        </ul>
                </aside> 
                <div id="sliderbar">
                    <!-- For the previons button for the slider-->
                    <div class="prev-btn">
                        <img src="images/logos/icon privious.png" alt="">
                    </div>
                    <!--For the images in the slider-->
                    <div class="main-slider">
                        <?php
                            $con=Database::connect();
                            $sql=$con->query("SELECT * FROM nouvels");
                            while($line=$sql->fetch()){
                                echo '<div class="slide-image">';
                                echo '<img src="../showimageslider.php?id_slider='.$line['sliderId'].'" title="'.$line['sliderName'].'">';
                                echo "</div>"; 
                            }
                            $con=Database::disconnect();
                        ?>
                    </div>
                    <!-- For the next button for the slider-->
                    <div class="next-btn">
                        <img src="images/logos/icon next.png" alt="">
                    </div>
                    <!--The navigation dots is the dots like the buttons-->
                    <div class="navigation-dots"></div>
                </div>        
            </div>
            <?php
                $con=Database::connect();
                 $categ=$con->query("SELECT * FROM sousCategories");
                 foreach($categ as $line){
                     echo '<div class="categoriesExemples">';
                         echo '<div class="tout" style="width:100%;">';
                            echo '<h2 class="names">'.$line["categorieName"].'</h4>';  
                            $con=Database::connect(); 
                            $exempleImage=$con->query('SELECT * FROM products WHERE categorieId='. $line["categorieId"]);
                            echo '<div class="produit-list">';
                                echo '<div class="content">';
                                $indice=0;
                                foreach($exempleImage as $lineImage){
                                    if($indice<4){
                                        echo '<div class="img" style="width:25%;">';
                                        echo '<img src="../showimageproduct.php?idProduct='.$lineImage['productId'].'" width="100%" height="130px";>';
                                        echo '</div>'; 
                                        $indice++;
                                    }
                                }
                                echo '</div>';
                                echo '<a href="afficherCategorie.php?idCategorie='.$line["categorieId"].'" id="linkCategories">Voir plus</a>';
                            echo '</div>';
                         echo '</div>';
                     echo '</div>';
                    $con=Database::disconnect();         
                 }
            ?>
        </div>
         
        <!--the footer block-->
        <?php
            include 'header footer/footer.php'
        ?>
        <!--Block footer end-->
    </body>
</html>
<?php  require 'Panier/panier index.php';?>