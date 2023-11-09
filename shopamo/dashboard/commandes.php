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
    <style>
        .confirmationLivraison a{
            text-decoration: none;
            color: white;
        }
        .confirmationLivraison a:hover{
            color: #44bae6;
        }
    </style>
</head>
<body style="margin: 0;">
    <?php
        include 'header sidebar dashboard/sidebar dashboard.php';
        include 'header sidebar dashboard/header dashboard.php';
        include '../databaseConnection.php';
    ?>

    <div id="mainDashboard">
        <div id="exportdata" >
            <button type="button"><a href="exportDonnee.php?typeFileCommandes=csv"> Telecharger se format .csv</a></button>
            <button type="button"><a href="exportDonnee.php?typeFileCommandes=excel"> Telecharger se format .excel</a></button>
        </div>
        <table>
            <tr>
                <th>Ref client</th>
                <th>Nom client</th>
                <th>Nom produit</th>
                <th>Taille</th>
                <th>Quantite</th>
                <th>Date commande</th>
                <th>Totale prix</th>
                <th>Type paiment</th>
                <th>Statut de paiment</th>
                <th>Livraison</th>
                <th style="width:180px;">Action</th> 
            </tr>
            <?php
                $con=Database::connect();
                $dataOrder=$con->query("SELECT * FROM orders ORDER BY orderId DESC");
                while($line=$dataOrder->fetch()){
                    $dataNameClient=$con->query("SELECT completeName FROM customers WHERE customerId=".$line["customerId"]);
                    $NameClient=$dataNameClient->fetch();
                    $dataNameProduit=$con->query("SELECT productName FROM products WHERE productId=".$line["productId"]);
                    $NameProduct=$dataNameProduit->fetch();
                    echo '<tr>';  
                        echo '<td>'.$line["customerId"].'</td>';
                        echo '<td>'.$NameClient["completeName"].'</td>';
                        echo '<td>'.$NameProduct["productName"].'</td>';
                        echo '<td>'.$line["size"].'</td>';
                        echo '<td>'.$line["quantity"].'</td>';
                        echo '<td>'.$line["orderDate"].'</td>';
                        echo '<td>'.$line["priceTotal"].'</td>';
                        echo '<td >'.$line["typePaiment"].'</td>';
                        if($line["statutPaiment"]=="Non payé"){
                        echo '<td style="background-color: #33528b;; color: white;font-weight: bold;">'.$line["statutPaiment"].'</td>';
                        }
                        else{
                        echo '<td style="background-color:#44bae6;color: white;font-weight: bold;">'.$line["statutPaiment"].'</td>';
                        }
                        echo '<td>'.$line["Livraison"].'</td>';
                        echo '<td class="confirmationLivraison" id="confirmationLivraison'.$line["orderId"].'" style="width:170px;text-align:center">';
                        if($line["Livraison"]=="Non"){
                        echo '<button class="btn" style="width:80px;"><a href="Confirmer Annuler cmd.php?confirmerLivraison='.$line["orderId"].'">Confirmer</a></button>';
                        echo '<button class="btn" style="width:80px;"><a href="Confirmer Annuler cmd.php?annulerLivraison='.$line["orderId"].'">Annuler</a></button>';
                        }
                        else{
                            echo "Commande Confirmé";
                        }
                        echo '</td>';
                    echo '</tr>';
                }
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