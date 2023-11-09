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
            require '../databaseConnection.php';
            include 'header sidebar dashboard/sidebar dashboard.php';
            include 'header sidebar dashboard/header dashboard.php';
        ?>

        
        <div id="mainDashboard" style="margin: 0px 0px 0px 20%;">
            <div class="tableauBord">
                <div class="cards">
                    
                    <div class="card-single">
                        <div>
                            <?php
                            $con=Database::connect();
                            $customersSql=$con->query("SELECT COUNT(DISTINCT customerId) as customers FROM orders WHERE orderDate=CURRENT_DATE()");
                            $customers=$customersSql->fetch();
                            ?> 
                            <h1><?php echo $customers['customers']; ?></h1>
                            <span>Clients</span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <?php
                            $ordersSql=$con->query("SELECT COUNT(*) as sumOrders FROM orders WHERE orderDate=CURRENT_DATE()");
                            $orders=$ordersSql->fetch();
                            ?>  
                            <h1><?php echo $orders['sumOrders']; ?></h1>
                            <span>Commandes</span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <?php
                            $con=Database::connect();
                            $quantitySql=$con->query("SELECT SUM(quantity) as quantity FROM orders WHERE orderDate=CURRENT_DATE()");
                            $quantity=$quantitySql->fetch();
                            if($quantity['quantity'] != NULL){
                                
                                echo '<h1>'.$quantity['quantity'].'</h1>';
                            }
                            else{
                                echo '<h1>0</h1>';
                            }
                            ?>
                            <span>Quantités</span>
                        </div>
                    </div>
                    <div class="Income">
                        <div>
                            <?php
                            $incomeSql=$con->query("SELECT SUM(priceTotal) as income  FROM orders WHERE orderDate=CURRENT_DATE()");
                            $income=$incomeSql->fetch();
                            
                            if($income['income']!=NULL){
                                
                                echo '<h1>'.$income['income'].' $</h1>';
                            }
                            else{
                                echo '<h1>0 $</h1>';
                            }
                            ?>
                            <span>Prix total</span>
                        </div>
                    </div>
                </div>
                <div class="recent-grid">
                    <div class="orders">
                        <div class="card">
                            <div class="card-header">
                                <h3>Nouvelles  commandes</h3>
                                <a href="commandes.php"><button>Voir tous</button></a>
                            </div>
                            <div class="card-body">
                                <?php
                                $con=Database::connect();
                                $newOrdersSql=$con->query("SELECT productId, quantity, priceTotal FROM orders WHERE orderDate=CURRENT_DATE()");
                                ?> 
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Nom de produit</td>
                                            <td>Quantite</td>
                                            <td>Totale prix</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($line=$newOrdersSql->fetch()){
                                            $productNameSql=$con->query("SELECT productName FROM products WHERE productId=".$line['productId']);
                                            $productName=$productNameSql->fetch();
                                            echo "<tr>";
                                                echo "<td>".$productName['productName']."</td>";
                                                echo "<td>".$line['quantity']."</td>";
                                                echo "<td>".$line['priceTotal']."</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </div>

                    </div>

                    </div>
                    <div class="customers">
                        <div class="card">
                            <div class="card-header">
                                <h3>Nouvels clients</h3>
                                <a href="client.php"><button>Voir tous</button></a>
                            </div>
                            <div class="card-body">
                                <div class="customer">
                                    <?php
                                    $con=Database::connect();
                                    $customersId=$con->query("SELECT customerId FROM orders WHERE orderDate=CURRENT_DATE()");
                                    ?> 
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>Nom complet</td>
                                                <td>City</td>
                                                <td>Numero de Telephone</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while($line=$customersId->fetch()){
                                                $customersSql=$con->query("SELECT completeName, city, numberPhone FROM customers WHERE customerId=".$line['customerId']);
                                                $customers=$customersSql->fetch();
                                                echo "<tr>";
                                                    echo "<td>".$customers['completeName']."</td>";
                                                    echo "<td>".$customers['city']."</td>";
                                                    echo "<td>".$customers['numberPhone']."</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}else{
    header("Location: index.php");
}
?>