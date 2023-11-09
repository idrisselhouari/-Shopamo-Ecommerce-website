<?php session_start();
if (isset($_SESSION['user']) && isset($_SESSION['id'])) { 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopamo Dashboard</title>
    <link rel="icon" href="dashboard icons/favicon copy.png">
    <link rel="stylesheet" href="css dashboard/styleDashboard.css">
    <link rel="stylesheet" href="css dashboard/stylePages.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js dashboard/dashboardJS.js"></script>
</head>
<body style="margin: 0;">
    <?php
        include 'header sidebar dashboard/sidebar dashboard.php';
        include 'header sidebar dashboard/header dashboard.php';
    ?>

    <div id="mainDashboard" >
        <table style="width: 90%; margin-left:5%;">
           <tr >
                <th>Nom</th>
                <th>Description</th>
                <th>Categorie Globale</th>
            </tr>
            <?php
                require '../databaseConnection.php';
                $con=Database::connect();
                $sql=$con->query("SELECT * FROM sousCategories");
                while($line=$sql->fetch()){
                    $cateGlo=$con->query('SELECT categorieGlobaleName FROM categorieGlobale WHERE categorieGlobaleId='.$line["categorieGlobaleId"]);
                    $cateGloName=$cateGlo->fetch();                    
                    echo "<tr >";
                    echo '<td style="width:18%">'.$line['categorieName'].'</td>';
                    echo '<td style="width:50%; text-align:left; padding-left:10px">'.$line['categorieDescription'].'</td>';
                    echo '<td style="width:18%;">'.$cateGloName['categorieGlobaleName'].'</td>';
                    echo '<td style="width:14%;">';
                            echo '<a href="updateSousCategorie.php?idSousCategorie='.$line['categorieId'].'"><img src="dashboard icons/refresh.png" alt="Modifier"></a>'; 
                            echo '<a href="delete.php?idSousCategorie='.$line['categorieId'].'"><img src="dashboard icons/delete.svg" alt="Supprimer"></a>';  
                    echo '</td>'; 
                echo "</tr>"; 
                }
                $con=Database::disconnect();
            ?> 
        </table>
    </div>
</body>
</html>
<?php
}else{
    header("Location: index.php");
}
?>