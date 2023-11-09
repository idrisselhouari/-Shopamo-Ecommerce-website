<?php session_start();
if (isset($_SESSION['user']) && isset($_SESSION['id'])) { 
    ?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Shopamo Dashboard</title>
    <link rel="icon" href="dashboard icons/favicon copy.png">
    <link rel="stylesheet" href="css dashboard/styleDashboard.css">
    <link rel="stylesheet" href="css dashboard/stylePages.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js dashboard/dashboardJS.js"></script>
    <script>
       function synchronePage(fichier){
                var xmlhttp =new XMLHttpRequest();
                xmlhttp.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){
                        document.getElementById("mainDashboard").innerHTML=this.responseText;
                    }
                };
                xmlhttp.open("POST",fichier,true);
                xmlhttp.send();
        }   
    </script>
</head>
<body style="margin: 0;">
    <?php
        include 'header sidebar dashboard/sidebar dashboard.php';
        include 'header sidebar dashboard/header dashboard.php';
        require '../databaseConnection.php';
    ?>
    <div id="mainDashboard">
    <?php
        if(!empty($_GET['idProduct'])){
            $idProduct=$_REQUEST['idProduct'];
            $con=Database::connect();
            $stmtProduct=$con->query("SELECT * FROM products WHERE productId=$idProduct");
            $stmtProductCont=$stmtProduct->fetch();   
        }    
    ?>
        <form method="post" enctype="multipart/form-data" id="formProduit">
            <input type="text" name="nomProduit" placeholder="Nom produit" required value="<?php echo $stmtProductCont['productName']; ?>">
            <input type="file" name="imageProduit" style="padding-top:7px; padding-bottom:2.5px;">       
            <input type="text" name="taillesProduit" placeholder="les tailles de produit" required value="<?php echo $stmtProductCont['productSize']; ?>">
            <input type="text" name="ancienPrix" placeholder="Le prix ancien de produit" required value="<?php echo $stmtProductCont['productOldPrice']; ?>">
            <input type="text" name="prixPrincipal" placeholder="Le prix principale de produit" required value="<?php echo $stmtProductCont['productPrincipalPrice']; ?>">
            <?php
            //<!--This select for the sous categories options for add a product-->
                echo '<select name="categorieProduit" required>';
                    $stmtSousCategorie = $con->query("SELECT * FROM sousCategories WHERE categorieId=".$stmtProductCont['categorieId']); 
                    $SousCateg=$stmtSousCategorie->fetch();
                    echo '<option>'.$SousCateg["categorieName"].'</option>';

                    $stmtSousCategorie = $con->query("SELECT * FROM sousCategories;");
                    while($line = $stmtSousCategorie->fetch()){
                        if($line['categorieName']!=$SousCateg["categorieName"]){
                        echo "<option>".$line['categorieName']."</option>";
                        }
                    }
                echo "</select>" ;
            $con=Database::disconnect();
            //<!--end Select categories************************************-->  
            ?>     
            <textarea name="descriptionProduit" cols="70" rows="5" placeholder="Entrez la description de produit"><?php echo $stmtProductCont['productDescription']; ?></textarea>
            <div>
                <button name="ModifierProduit" class="btn">Modifier</button>
                <button name="annulerProduit" class="btn">Annuler</button>
            </div>
        </form>

<?php    
    if(isset($_POST['ModifierProduit'])){
                $imageProduit=null;
                $nomProduit= $_POST['nomProduit'];
                if(!empty($_FILES['imageProduit']['name'])){
                    $imageProduit = file_get_contents($_FILES['imageProduit']['tmp_name']);
                }
                $taillesProduit = $_POST['taillesProduit'];
                $ancienPrix = $_POST['ancienPrix'];
                $prixPrincipal = $_POST['prixPrincipal'];
                $descriptionProduit = $_POST['descriptionProduit'];
                
                $categorieProduit = $_POST['categorieProduit'];
                
                if(!empty($nomProduit) && !empty($taillesProduit) && !empty($ancienPrix) && !empty($prixPrincipal) && !empty($descriptionProduit) && !empty($categorieProduit)  && empty($imageProduit)){
                    $con=Database::connect();
                    $categorieId = $con->query("SELECT categorieId FROM sousCategories WHERE categorieName='$categorieProduit'");
                    $donneId = $categorieId->fetch();

                    $stmtUpdate = $con->prepare("UPDATE products set productName=?, productSize=?,
                    productDescription=?, productOldPrice=?, productPrincipalPrice=?, categorieId=? WHERE productId=$idProduct");
                    $stmtUpdate->bindParam(1,$nomProduit);
                    $stmtUpdate->bindParam(2,$taillesProduit);
                    $stmtUpdate->bindParam(3,$descriptionProduit);
                    $stmtUpdate->bindParam(4,$ancienPrix);
                    $stmtUpdate->bindParam(5,$prixPrincipal);
                    $stmtUpdate->bindParam(6,$donneId['categorieId']);
                    $stmtUpdate->execute();
                    $con=Database::disconnect();
                    echo '<script>alert("Ces informations bien modifieé")</script>'; 
                    echo '<script>window.location = "toutesProduits.php";</script>';       
                }
                else if(!empty($nomProduit) && !empty($imageProduit) && !empty($taillesProduit) && !empty($ancienPrix) && !empty($prixPrincipal) && !empty($descriptionProduit) && !empty($categorieProduit)){
                    $con=Database::connect();
                    $categorieId = $con->query("SELECT categorieId FROM sousCategories WHERE categorieName LIKE '$categorieProduit'");
                    $donneId = $categorieId->fetch();

                    $stmtUpdate = $con->prepare("UPDATE products set productName=?, productPicture=?, productSize=?,
                    productDescription=?, productOldPrice=?, productPrincipalPrice=?, categorieId=? WHERE productId=$idProduct");
                    $stmtUpdate->bindParam(1,$nomProduit);
                    $stmtUpdate->bindParam(2,$imageProduit);
                    $stmtUpdate->bindParam(3,$taillesProduit);
                    $stmtUpdate->bindParam(4,$descriptionProduit);
                    $stmtUpdate->bindParam(5,$ancienPrix);
                    $stmtUpdate->bindParam(6,$prixPrincipal);
                    $stmtUpdate->bindParam(7,$donneId['categorieId']);
                    $stmtUpdate->execute();
                    $con=Database::disconnect();
                    echo '<script>alert("Ces informations bien modifieé")</script>';
                    echo '<script>window.location = "toutesProduits.php";</script>';       
                }
    }
    else if(isset($_POST['annulerProduit'])){
        echo "<script>window.location = 'toutesProduits.php'</script>";
    }
?> 
</div>
</body>
</html>
<?php
}else{
    header("Location: index.php");
}
?>