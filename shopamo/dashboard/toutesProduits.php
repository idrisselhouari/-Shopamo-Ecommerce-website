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
        <form action="" method="POST" enctype="multipart/form-data" id="exportdata" >
        <button type="button"><a href="exportDonnee.php?typeFileProducts=csv"> Telecharger se format .csv</a></button>
        <button type="button"><a href="exportDonnee.php?typeFileProducts=excel"> Telecharger se format .excel</a></button>
        </form>
        <table style="width: 95%; margin-left:2%;">
           <tr >
                <th>image</th>
                <th>Nom</th>
                <th>Tailles</th>
                <th>Prix ancien</th>
                <th>Prix principale</th>
                <th >Description</th>
                <th>Categorie</th>
            </tr>
            <?php
                require '../databaseConnection.php';
                $con=Database::connect();
                $sql=$con->query("SELECT * FROM products");
                while($line=$sql->fetch()){
                    $cate=$con->query('SELECT categorieName FROM sousCategories WHERE categorieId='.$line["categorieId"]);
                    $cateName=$cate->fetch();                    
                    echo "<tr >";
                    echo '<td ><img src="../showimageproduct.php?idProduct='.$line['productId'].'" style="height:60px;"></td>';
                    echo "<td>".$line['productName']."</td>";
                    echo "<td>".$line['productSize']."</td>";
                    echo "<td>".$line['productOldPrice']." DH</td>";
                    echo "<td>".$line['productPrincipalPrice']." DH</td>";
                    echo '<td style="width:32%;" >'.$line['productDescription'].'</td>';
                    echo "<td>".$cateName['categorieName']."</td>";
                    echo '<td style="width:6%">';
                            echo '<a href="updateProduct.php?idProduct='.$line['productId'].'" title="Modifier"><img src="dashboard icons/refresh.png" alt="Modifier"></a>'; 
                            echo '<a href="delete.php?idProduct='.$line['productId'].'" title="Supprimer"><img src="dashboard icons/delete.svg" alt="Supprimer"></a>'; 
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