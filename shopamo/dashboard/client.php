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
        include '../databaseConnection.php';
    ?>

    <div id="mainDashboard">
        <form action="" method="POST" enctype="multipart/form-data" id="exportdata" >
            <button type="button"><a href="exportDonnee.php?typeFileCommandes=csv"> Telecharger se format .csv</a></button>
            <button type="button"><a href="exportDonnee.php?typeFileCommandes=excel"> Telecharger se format .excel</a></button>
        </form>
        <table>
            <tr>
                <th>Ref Produit</th>
                <th>Ref client</th>
                <th>Nom client</th>
                <th>Numero telephone</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Date commande</th>
                <th>Type paiment</th>
                <th>Statut de paiment</th>
                <th>Livraison</th>
             </tr>
            <?php
                $con=Database::connect();
                $dataCustomers=$con->query("SELECT p.productId,c.customerId,completeName,numberPhone,city,adresse,statutPaiment,typePaiment,orderDate,Livraison FROM customers c,orders o,products p WHERE c.customerId=o.customerId and p.productId=o.productId ORDER BY c.customerId DESC;");
                while($line=$dataCustomers->fetch()){
                    echo '<tr>';  
                        echo '<td>'.$line["productId"].'</td>';
                        echo '<td>'.$line["customerId"].'</td>';
                        echo '<td>'.$line["completeName"].'</td>';
                        echo '<td>'.$line["numberPhone"].'</td>';
                        echo '<td>'.$line["city"].'</td>';
                        echo '<td>'.$line["adresse"].'</td>';
                        echo '<td >'.$line["orderDate"].'</td>';
                        echo '<td>'.$line["typePaiment"].'</td>';
                        if($line["statutPaiment"]=="Non payé"){
                            echo '<td style="background-color: #33528b;; color: white;font-weight: bold;">'.$line["statutPaiment"].'</td>';
                        }
                        else{
                            echo '<td style="background-color:#44bae6;color: white;font-weight: bold;">'.$line["statutPaiment"].'</td>';
                        }
                        echo '<td>'.$line["Livraison"].'</td>';
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