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
    <style>
        .toutePromotion{
            margin-top: 3%;
        }
        .toutePromotion td, .toutePromotion th{
            padding-left: 15px;
        }
        .sousCategories{
            text-align: left;
        }
    </style>
</head>
<body style="margin: 0;">
    <?php
        include 'header sidebar dashboard/sidebar dashboard.php';
        include 'header sidebar dashboard/header dashboard.php';
    ?>
    <div id="mainDashboard">
    <?php
        require '../databaseConnection.php';    
        if(isset($_POST['creer'])){
                $NameCategGlob= $_POST['categorieGlobale'];

                if(!empty($NameCategGlob)){
                    $con=Database::connect();
                    $stmt = $con->prepare("INSERT INTO categorieGlobale VALUES('',?)");
                    $stmt->bindParam(1,$NameCategGlob);
                    $stmt->execute(); 
                    $con=Database::disconnect();
                    echo"<script>alert('New record inserted sucessfelly')</script>";
                    echo '<script>window.location = "categorieGlobale.php"</script>';
                }
                
        }

    echo '<form method="post" enctype="multipart/form-data" action="" style="text-align:center;">';
        echo '<label>Nom de categorie globale: <input type="text" name="categorieGlobale" id="categorieGlobale" placeholder="Nom de categorie globale" style="width:27%; padding-top:6px; padding-bottom:6px;" required></label> '; 
        echo '<button name="creer" class="btn" type="submit" style="height:30px: width: 6px; width:10%;" >Créer</button>';
    echo '</form>';
    //Affichage des promotions
    $con=Database::connect();
    $sql = $con->query("SELECT * FROM categorieGlobale");
    echo '<div class="toutePromotion" width:80%;>';
        echo '<table style="width: 50%; text-align:left;">';
            echo "<tr >";
                echo "<th>Nom</th>";
                echo "<th>Sous categorie</th>";
            echo "</tr>";
                while($line=$sql->fetch()){
                    echo "<tr >";
                    echo "<td>".$line['categorieGlobaleName']."</td>";
                    $sousCateg=$con->query('SELECT categorieName FROM souscategories WHERE categorieGlobaleId='.$line["categorieGlobaleId"]);
                    echo "<td class='sousCategories'>";
                    foreach($sousCateg as $lineCateg){
                        echo '<span>* '.$lineCateg["categorieName"].'</span><br>';
                    }
                    echo "</td>";
                    echo '<td >';
                            echo '<a href="updateCategorieGlobale.php?idCategorieGlobale='.$line['categorieGlobaleId'].'"><img src="dashboard icons/refresh.png" alt="Modifier"></a>'; 
                            echo '<a href="delete.php?idCategorieGlobale='.$line['categorieGlobaleId'].'"><img src="dashboard icons/delete.svg" alt="Supprimer"></a>';  
                    echo '</td>'; 
                echo "</tr>"; 
                }
                $con=Database::disconnect();
        echo "</table>";
    echo "</div>";
?>
    </div>
</script>
</body>
</html>
<?php
}else{
    header("Location: index.php");
}
?>