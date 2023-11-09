<?php session_start();
if (isset($_SESSION['user']) && isset($_SESSION['id'])) { 
    ?>
<?php
require '../databaseConnection.php';
$conx=Database::connect();
$products=$conx->query('SELECT * FROM products'); 
   
while($row=$products->fetch()){
    $productName=$conx->query("SELECT SUM(quantity) as Quantite  FROM orders WHERE productId=".$row["productId"]);
    $productInfo=$productName->fetch();
    $productname[]  = $row['productName'];
    $quantite[] = $productInfo['Quantite'];
}
$conx=Database::disconnect();

?>
<!DOCTYPE html>
<html lang="fr"> 
    <head>
        <meta charset="utf-8">
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
        <div id="mainDashboard">
            <div style="width:80%; height:80%; text-align:center;margin: 8% auto auto auto;">
                <canvas  id="chartjs_bar"></canvas> 
            </div>    
        </div>
    </body>
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript">
      var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($productname); ?>,
                        datasets: [{
                            backgroundColor: "#5969ff",
                            data:<?php echo json_encode($quantite); ?>,
                        }],
                        
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: true,
                            position: 'bottom',
    
                            labels: {
                                fontColor: 'black',
                                fontFamily: 'Circular Std Book',
                                fontSize: 8,
                            }
                        },
                        scales: {
                            yAxes: [{
                                stacked: true
                            }],
                            
                        },order: 1
                    }
                });
    </script>
</html>
<?php
}else{
    header("Location: index.php");
}
?>