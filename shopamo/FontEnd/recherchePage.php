<?php  session_start(); ?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="JS/fileJs.js" defer></script>
    <style>
        #zeroRecherche{
            color: rgb(27, 148, 185);
            font-size: 45px;
            height: 390px;
            align-items: center;
            text-align: center;
        }
        .majbleu{
            color: rgba(9, 31, 105, 0.637);
            font-size: 50px;
        }
        .formCart{
            display: none;
            background-color: white;
            -webkit-box-shadow: 0 0 1900px #888888;
            box-shadow: 0 0 1900px #888888;
            width: 700px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            margin: 0 auto;
            max-width: 80%;
            max-height: 80%;
            z-index: 1;
        }
        .formCart .fermer{
            position: absolute;
            right: 0px;
            top: 0;
            padding: 10px;
            width: 32px;
            height: 32px;
            font-size: 15px;
            color: #666;
            cursor: pointer;
            z-index: 1;
        }
    </style>
</head>
<body style="margin: 0;">
        <!--the header block-->
    <?php
        require '../databaseConnection.php';
        include 'header footer/header.php';
    ?>
        <!--Block header end-->
    <div id="mainPage">
            <?php
            if(!empty($_GET['ProductName'])){
                $Name=$_REQUEST['ProductName'];
                
                $con=Database::connect();
                $products= $con->query('SELECT * FROM products WHERE productName like "%'.$Name.'%"');
                if($products->rowCount() > 0){
                    
                    echo '<div class = "container">';
                        echo '<div class = "product-items">';
                            $index=0;
                            while($row=$products->fetch()){        
                                echo '<div class = "product">';
                                    //For the product content (Images and Buttons)
                                    echo '<div class = "product-content">';
                                        echo '<a href="detailsProduits.php?idProduct='.$row['productId'].'">';
                                            echo '<div class = "product-img">';
                                                echo  '<img src="../showimageproduct.php?idProduct='.$row['productId'].'">';
                                            echo '</div>';
                                        echo '</a>';
                                        echo '<div class = "product-btns">';
                                            echo '<button id="btnCart'.$index.'" class="btn-cart" >Acheter</button>';
                                            echo '<input type="hidden" value="'.$row['productId'].'" name="idproduit">';
                                        echo '</div>';
                                    echo '</div>';
                                    /************************************************ */
                                    //For the product informations
                                    echo '<div class = "product-info">';
                                        echo '<a href = "detailsProduits.php?idProduct='.$row['productId'].'" class ="product-name">'.$row['productName'].'</a>';
                                        echo '<p class = "product-price">'.$row['productOldPrice'].' DH</p>';
                                        echo '<p class = "product-price">'.$row['productPrincipalPrice'].' DH</p>';
                                    echo '</div>';
                                    /********************************************** */
                                    /*echo '<div class = "off-info">';
                                        echo '<h2 class = "sm-title">25% off</h2>';
                                    echo '</div>';*/
                                    /*********************************************** */
                                echo '</div>';//div product END
                                ?>
                                <div id="formCart<?php echo $index?>" class="formCart">
                                    <span id="fermer<?php echo $index?>" class="fermer">&#10005;</span>
                                    <div id="productDetailles" style="margin: 0; width: 100%;"> 
                                        <div class="single-pro-img" style="margin: auto 5px; width:45%">
                                            <?php echo '<img src="../showimageproduct.php?idProduct='.$row['productId'].'" width="100%" alt="" id="MainImg">'?>

                                            <!--<div class="small-img-group">
                                                <div class="small-img-col">
                                                    <img src = "images/images-chaussures/shoe-1.png" width="100%" alt="" class="small-img">
                                                </div>
                                                <div class="small-img-col">
                                                    <img src = "images/images-chaussures/shoe-2.png" width="100%" alt="" class="small-img">
                                                </div>
                                                <div class="small-img-col">
                                                    <img src = "images/images-chaussures/shoe-3.png" width="100%" alt="" class="small-img">
                                                </div>
                                                <div class="small-img-col">
                                                    <img src = "images/images-chaussures/shoe-4.png" width="100%" alt="" class="small-img">
                                                </div>   
                                            </div>--> 
                                        </div>
                                        <div class="productInformations" style="width:55%">
                                            <h1><?php echo $row["productName"];?></h1>
                                            <h4><?php echo $row["productPrincipalPrice"]." EUR";?></h4>
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div id="productInfo">
                                                    <?php 
                                                        $table =array();
                                                        $table=explode(",",$row["productSize"]);
                                                    ?>
                                                    <label for="size">Taille: 
                                                        <select id="size" name="size" required>
                                                            <option value="" disabled selected hidden> Select Size </option>
                                                            <?php
                                                                foreach($table as $element){
                                                                    echo "<option>";
                                                                    echo $element;
                                                                    echo "</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </label>
                                                    
                                                    <label for="quantite">Quantite:
                                                        <input type="number" value="1" id="quantite" name="quantite" min="1" required>
                                                    </label>
                                                </div>
                                                    <button type="submit" class="btn" name="addcart">Ajouter au panier</button>
                                                    <button type ="submit" class ="btn" name="buynow">Acheter Maintenant</button>
                                                    <input type="hidden" value="<?php echo $row['productId'] ?>" name="idproduit">
                                                
                                            </form>
                                            <div id="description" style="margin-right: 20px; text-align:justify">
                                                <h3>Description</h3>
                                            
                                                <p><?php echo $row['productDescription']?></p>
                                            </div> 
                                        </div>  
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $("#btnCart<?php echo $index?>").click(function(){
                                            $("#formCart<?php echo $index?>").css("display","flex");
                                            $("#formCart<?php echo $index?>").css("position","fixed");
                                        }),
                                        $("#fermer<?php echo $index?>").click(function(){
                                            $("#formCart<?php echo $index?>").css("display","none");
                                        })
                                    })
                                </script>
                                <?php $index++; }  ?>  
                        </div>
                    </div>
                    <?php  Database::disconnect();
        
                }
                else{
                    echo '<div id="zeroRecherche">';
                    echo '<p><span class="majbleu">A</span>rticle non trouvé </br><span class="majbleu">V</span>euillez réessayer avec une orthographe différente <br>ou effectuer une recherche manuelle dans nos catégories</p>';
                    echo '</div>';
                }  
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