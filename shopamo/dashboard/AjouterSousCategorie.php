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
    <form method="post" enctype="multipart/form-data" id="FormCategorie">
        <?php
            require '../databaseConnection.php';
            $con=Database::connect();
            echo '<select name="categorieGlobale" required>';
            $stmtCategorie = $con->query("SELECT * FROM categorieGlobale;");

            echo '<option value="" disabled selected hidden>Sélectionner catégorie globale</option>';
            while($line = $stmtCategorie->fetch()){
                echo "<option>";
                echo $line['categorieGlobaleName'];
                echo "</option>";
            }
            $con=Database::disconnect();
            echo "</select>" ;
        ?> 
        <input type="text" name="nomCategorie" placeholder="Nom categorie" required>
        <textarea name="descriptionCategorie" cols="61" rows="5" placeholder="Enter la description de categorie" required></textarea>
        <div class="buttons">
            <button class="btn" name="validerCategorie" type="submit">Valider</button>
            <button class="btn" name="annulerCategorie">Annuler</button>
        </div>        
    </form>
<?php
       if(isset($_POST['validerCategorie'])){
            $nom = $_POST['nomCategorie'];
            $categ = $_POST['descriptionCategorie'];
            $categoriesGlobale = $_POST['categorieGlobale'];

            if(empty($nom) || empty($categ) || empty($categorieGlobal)){
                // connection
                $con=Database::connect();
                $categorieGlobalTitre = $con->query("SELECT * FROM categorieGlobale WHERE categorieGlobaleName='$categoriesGlobale'");
                $donneTitreGlobal = $categorieGlobalTitre->fetch();

                $stmt = $con->prepare("INSERT Into sousCategories values('',?,?,?)");

                $stmt->bindParam(1,$nom);
                $stmt->bindParam(2,$categ);
                $stmt->bindParam(3,$donneTitreGlobal['categorieGlobaleId']);
                $stmt->execute();
                $con=Database::disconnect();
                echo"<script>alert('New record inserted sucessfelly')</script>";
                echo '<script>window.location = "toutesSousCategories.php"</script>';
            }else{
                echo "All fieled are required";   
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