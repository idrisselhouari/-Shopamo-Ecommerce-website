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
        <script src="JS/product.js" defer></script>
        <style>
            #MainImg,.small-img{
                background-color: #eee;
            }
        </style>
    </head>
    <body style="margin: 0; ">
        <!--the header block-->
        <?php
            require '../databaseConnection.php';
            include 'header footer/header.php'
        ?>
         <!--Block header end-->
        <main id="mainPage">
            <?php
                $idProduct=$_REQUEST['idProduct'];
                if(!empty($idProduct)){
                    $con=Database::connect();
                    $stmt=$con->query("SELECT * FROM Products WHERE productId=$idProduct");
                    $data=$stmt->fetch();
            ?>
                <div id="productDetailles"> 
                    <div class="single-pro-img">
                       <?php echo '<img src="../showimageproduct.php?idProduct='.$idProduct.'" width="100%" alt="" id="MainImg">'?>

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
            <?php } ?>
                    <div class="productInformations">
                        <h1><?php echo $data["productName"];?></h1>
                        <h4><?php echo $data["productPrincipalPrice"]." DH";?></h4>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div id="productInfo">
                                <?php 
                                    $table =array();
                                    $table=explode(",",$data["productSize"]);
                                ?>
                                <label for="size">Taille: 
                                    <select id="size" name="size" required>
                                        <option value="" disabled selected hidden>Aucune </option>
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
                                <input type="hidden" value="<?php echo $data['productId'] ?>" name="idproduit">
                            
                        </form>
                        <div id="description">
                            <h3>Description</h3>
                        
                            <p><?php echo $data["productDescription"];?></p>
                        </div> 
                    </div>  
                </div>
        </main>
        <!--the footer block-->
        <?php
            include 'header footer/footer.php'
        ?>
        <!--Block footer end-->
    </body>
</html>
<?php  require 'Panier/panier produit.php';?>