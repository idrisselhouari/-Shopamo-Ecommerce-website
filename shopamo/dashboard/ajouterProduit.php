<?php session_start();
if (isset( $_SESSION['user']) && isset($_SESSION['id'])) { 
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
    ?>
    <div id="mainDashboard">
    <?php
    require '../databaseConnection.php';
    
    echo '<form method="post" enctype="multipart/form-data" id="formProduit">';
        echo '<input type="text" name="nomProduit" placeholder="Nom produit" required> '; 
        echo '<input type="file" name="imageProduit" style="padding-top:7px; padding-bottom:2.5px;" accept="image/png" required> ';       
        echo '<input type="text" name="taillesProduit" placeholder="les tailles de produit" required> ';
          //<!--This select for the categories options for add a product-->
        $con=Database::connect();
            echo '<select name="categorieProduit" required>';
            $stmtCategorie = $con->query("SELECT * FROM sousCategories");

            echo '<option value="" disabled selected hidden>Le nom de sous categorie</option>';
            while($line = $stmtCategorie->fetch()){
                echo "<option>".$line['categorieName']."</option>";
            }
            echo "</select>" ;
        $con=Database::disconnect();
        //<!--end Select categories************************************-->        
        echo '<input type="text" name="ancienPrix" placeholder="Le prix ancien de produit" required>';
        echo '<input type="text" name="prixPrincipal" placeholder="Le prix principale de produit" required>';
      
        echo '<textarea name="descriptionProduit" cols="70" rows="5" placeholder="Entrez la description de produit"></textarea>';
        echo '<div>';
            echo '<button name="validerProduit" class="btn">Valider</button>';
            echo '<button name="annulerProduit" class="btn">Annuler</button>';
        echo '</div>';
    echo '</form>';
    
    if(isset($_POST['validerProduit'])){
                $nomProduit= $_POST['nomProduit'];
                $imageProduit = file_get_contents($_FILES['imageProduit']['tmp_name']);
                $taillesProduit = $_POST['taillesProduit'];
                $ancienPrix = $_POST['ancienPrix'];
                $prixPrincipal = $_POST['prixPrincipal'];
                $descriptionProduit = $_POST['descriptionProduit'];
                
                $categorieProduit = $_POST['categorieProduit'];
                if(!empty($nomProduit) && !empty($imageProduit)  && !empty($taillesProduit) && !empty($ancienPrix) && !empty($prixPrincipal) && !empty($descriptionProduit) && !empty($categorieProduit)){
                    $con=Database::connect();
                    $categorieId = $con->query("SELECT categorieId FROM sousCategories WHERE categorieName='$categorieProduit'");
                    $donneId = $categorieId->fetch();

                    $stmt = $con->prepare("INSERT INTO products VALUES('',?,?,?,?,?,?,?)");
                    $stmt->bindParam(1,$nomProduit);
                    $stmt->bindParam(2,$imageProduit);
                    $stmt->bindParam(3,$taillesProduit);
                    $stmt->bindParam(4,$descriptionProduit);
                    $stmt->bindParam(5,$ancienPrix);
                    $stmt->bindParam(6,$prixPrincipal);
                    $stmt->bindParam(7,$donneId['categorieId']);
                    $stmt->execute();
                    $con=Database::disconnect();   
                    echo"<script>alert('New record inserted sucessfelly')</script>";
                    echo '<script>window.location = "toutesProduits.php"</script>';
                }
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