<?php session_start();
 
    if(isset($_POST["supprimer"])){
        foreach ($_SESSION['cart'] as $key => $value){
            if($value["product_id"] == $_POST['produitId'] && $value["product_size"] == $_POST['produitSize']){
                unset($_SESSION['cart'][$key]);
                echo "<script>window.alert('Product has been Removed...!')</script>";
                echo "<script>window.location = 'panier.php'</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shopamo</title>
    <link rel="icon" href="images/logos/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleAcheter.css">
    <link rel="stylesheet" href="css/styleCart.css">
    <link rel="stylesheet" href="css/styleProduit.css">
    <link rel="stylesheet" href="css/styleCatgories.css">
    <link rel="stylesheet" href="css/pageCategoriesStyle.css">
    <script src="JS/fileJs.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AbyCqaUTwcFvK5fIoq_5BU4d0w7lZXl_frOK2CuKlMBxIR4vo0GuuR6-SjDfjz7pszwfGY4KqQi8eAzS&currency=USD"></script>
    <style>
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
        #productBar{
            height: 500px;
            overflow-x: scroll;
        }
            </style>
</head>
<body style="margin: 0;">
    <?php
        require '../databaseConnection.php';
        include 'header footer/header.php'; 
    ?>
    <main  id="mainPage">
        <div id="paiementPage">
            <div id="productBar">
                <div class="cart"> 
                    <?php
                        $total = 0;
                        $index=0;
                        if(isset($_SESSION['cart'])){
                            $con=Database::connect();
                            foreach ($_SESSION['cart'] as $key => $value){
                                if(!empty($value['product_quantite']) && !empty($value['product_size'])){
                                    $sql=$con->query('SELECT * FROM products WHERE productId='.$value['product_id']);
                                    $data=$sql->fetch();
                                    $table =array();
                                    $table=explode(",",$data["productSize"]);
                                    echo "<table>";
                                        echo "<tr>";
                                            echo '<form action="" method="post" class="cart-items">';
                                                echo '<td width="38%">';
                                                    echo '<div class=" information">';
                                                        echo  '<img src="../showimageproduct.php?idProduct='.$data['productId'].'">';
                                                        echo "<div>";
                                                            echo "<p>".$data['productName']."</p>";
                                                            echo "<small>Prix: ". $data['productPrincipalPrice']."</small>"; 
                                                        echo "</div>";
                                                    echo "</div>";
                                                echo "</td>";
                                                echo '<td width="14%"><button type="button" id="quantite'.$index.'" name="quantite" class="PanierQuantite" style="width:4rem;height:1.5rem;">'.$value['product_quantite'].'</button></td>';
                                                echo '<td width="14%"><button id="size'.$index.'"  class="PanierSize" type="button" name="size" style="width:4rem;height:1.5rem;">'.$value['product_size'].'</button></td>';
                                                echo '<td width="15%">'.$data['productPrincipalPrice']*$value['product_quantite'].' DH</td>';
                                                echo '<td ><input type="hidden" value="'.$data['productId'].'" name="produitId"></td>';
                                                echo '<td ><input type="hidden" value="'.$value['product_size'].'" name="produitSize"></td>';
                                                echo '<td><button type="submit" name="supprimer" style="padding:0px; border:0;"><img src="images/logos/delete_black.svg" alt="Supprimer" style="width:25px; height:25px"></button></td>';
                                            echo "</form>";
                                        echo "</tr>";
                                            $total = $total + $data['productPrincipalPrice']*$value['product_quantite']; 
                                    echo "</table>"; 
                                    ?>
                                    <div id="formCart<?php echo $index?>" class="formCart">
                                        <span id="fermer<?php echo $index?>" class="fermer">&#10005;</span>
                                        <div id="productDetailles" style="margin: 0; width: 100%;"> 
                                            <div class="single-pro-img" style="margin: auto 5px; width:45%">
                                                <?php echo '<img src="../showimageproduct.php?idProduct='.$data['productId'].'" width="100%" alt="" id="MainImg">'?>

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
                                                                <option ><?php echo $value['product_size']; ?></option>
                                                                <?php
                                                                    foreach($table as $element){
                                                                        if($element !=$value['product_size'] ){
                                                                            echo "<option>";
                                                                            echo $element;
                                                                            echo "</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </label>
                                                        <label for="quantite">Quantite:
                                                            <input type="number" value="<?php echo $value['product_quantite'];?>" id="quantite" name="quantite" min="1" required>
                                                        </label>
                                                    </div>
                                                        <button type="submit" class="btn" name="miseajour" style="width: 50%; margin-left: 30px;margin-top: 10px;">Mise à jour</button>
                                                        <input type="hidden" value="<?php echo $data['productId'] ?>" name="idproduit">
                                                        
                                                </form>
                                                <div id="description" style="margin-right: 20px; text-align:justify; ">
                                                    <h3>Description</h3>
                                                    <p style="width:90%;"><?php echo $data['productDescription']?></p>
                                                </div> 
                                            </div>  
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function(){
                                            $("#size<?php echo $index?>").click(function(){
                                                $("#formCart<?php echo $index?>").css("display","flex");
                                                $("#formCart<?php echo $index?>").css("position","fixed");
                                            }),
                                            $("#quantite<?php echo $index?>").click(function(){
                                                $("#formCart<?php echo $index?>").css("display","flex");
                                                $("#formCart<?php echo $index?>").css("position","fixed");
                                            }),
                                            $("#fermer<?php echo $index?>").click(function(){
                                                $("#formCart<?php echo $index?>").css("display","none");
                                            })
                                        })
                                    </script>
                                <?php $index++; 
                                } 
                            }
                            $con=Database::disconnect(); 
                            echo '<div class="total-price">';
                                echo '<table>';
                                    echo '<tr>';
                                        echo '<td>Total</td>';
                                        echo "<td>$total DH</td>";
                                    echo "</tr>";
                                echo '</table>';
                            echo '</div>';
                        }else{
                            echo "<h5>Le panier est vide</h5>";

                            echo '<div class="total-price">';
                                echo '<table>';
                                    echo '<tr>';
                                        echo '<td>Total</td>';
                                        echo "<td>$total DH</td>";
                                    echo "</tr>";
                                echo '</table>';
                            echo '</div>';
                    }?>
                </div>
            </div>
            <div id="paiementBar">
                <?php include 'FormulairesPaiment.php'; ?>

    <!--the footer block-->
    <?php
        include 'header footer/footer.php';
        $con=Database::disconnect();
    ?>
    <!--Block footer end-->    
</body>
</html>    
<?php
    if(isset($_POST['miseajour'])){
        $idproduct=$_POST["idproduit"];
        $nouvelleSize=$_POST['size'];
        $nouvelleQuantite=$_POST['quantite'];
        foreach ($_SESSION['cart'] as $key => $value){
            if($value['product_id']==$idproduct){
                 $item_array = array(
                    'product_id' => $idproduct,
                    'product_size' => $nouvelleSize,
                    'product_quantite' => $nouvelleQuantite,
                );
                $_SESSION['cart'][$key] = $item_array;
                echo '<script>window.location = "panier.php"</script>';
            }
        }
    }
?>             