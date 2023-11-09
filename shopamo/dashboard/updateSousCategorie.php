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
    ?>
    <div id="mainDashboard">
    <form method="post" enctype="multipart/form-data" id="FormCategorie">
        <?php
            require '../databaseConnection.php';
            if(!empty($_GET['idSousCategorie'])){
                $idSousCategorie=$_REQUEST['idSousCategorie'];
                $con=Database::connect();
                //For select information of line
                $info=$con->query("SELECT * FROM SousCategories WHERE categorieId=$idSousCategorie");
                $infoCateg=$info->fetch();
                //********************************************* */
                echo '<select name="categorieGlobale" required>';
                    $stmtCategorie = $con->query("SELECT * FROM categorieGlobale WHERE categorieGlobaleId=".$infoCateg["categorieGlobaleId"]); 
                    $categGlo=$stmtCategorie->fetch();
                    echo '<option>'.$categGlo["categorieGlobaleName"].'</option>';

                    $stmtCategorie = $con->query("SELECT * FROM categorieGlobale;");
                    while($line = $stmtCategorie->fetch()){
                        if($line['categorieGlobaleName']!= $categGlo["categorieGlobaleName"]){
                            echo "<option>";
                            echo $line['categorieGlobaleName'];
                            echo "</option>";
                        }
                    }
                echo "</select>" ;  
        ?> 
        <input type="text" name="nom" placeholder="Nom categorie" value="<?php echo $infoCateg['categorieName']; ?>" required>
        <textarea name="categ" cols="61" rows="5" placeholder="Enter la description de categorie" required><?php echo $infoCateg['categorieDescription'];?></textarea>
        <div class="buttons">
            <button class="btn" name="modifierCategorie" type="submit">Modifier</button>
            <button class="btn" name="annulerCategorie">Annuler</button>
        </div>       
        <?php 
            }
            $con=Database::disconnect(); 
        ?> 
    </form>
<?php
       if(isset($_POST['modifierCategorie'])){
            $nom = $_POST['nom'];
            $categ = $_POST['categ'];
            $categoriesGlobale = $_POST['categorieGlobale'];

            if(empty($nom) || empty($categ) || empty($categorieGlobal)){
                // connection
                $con=Database::connect();
                $categorieGlobalTitre = $con->query("SELECT * FROM categorieGlobale WHERE categorieGlobaleName='$categoriesGlobale'");
                $donneTitreGlobal = $categorieGlobalTitre->fetch();

                $stmt = $con->prepare("UPDATE sousCategories SET categorieName=? , categorieDescription=?, categorieGlobaleId=? WHERE categorieId=$idSousCategorie");

                $stmt->bindParam(1,$nom);
                $stmt->bindParam(2,$categ);
                $stmt->bindParam(3,$donneTitreGlobal['categorieGlobaleId']);
                $stmt->execute();
                $con=Database::disconnect();
                
                echo"<script>alert('record updated sucessfelly')</script>";
                echo "<script>window.location = 'toutesSousCategories.php'</script>";
                //header("Location: toutesSousCategories.php"); 
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