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
    <style>
        .toutePromotion{
            margin-top: 3%;
            text-align: center;
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
        if(isset($_POST['validerPromotion'])){
                $titrePromotion= $_POST['titrePromotion'];
                $imagePromotion = file_get_contents($_FILES['imagePromotion']['tmp_name']);
                
                
                if(!empty($titrePromotion) && !empty($imagePromotion)){
                    $con=Database::connect();
                    $stmt = $con->prepare("INSERT INTO nouvels VALUES('',?,?)");
                    $stmt->bindParam(1,$titrePromotion);
                    $stmt->bindParam(2,$imagePromotion);
                    $stmt->execute(); 
                    $con=Database::disconnect();   
                }
        }

    echo '<form method="post" enctype="multipart/form-data" action="" style="text-align:center;">';
        echo '<input type="text" name="titrePromotion" placeholder="Titre de promotion" style="width:27%; padding-top:6px; padding-bottom:6px;"required> '; 
        echo '<input type="file" name="imagePromotion" style="padding-top:3px; padding-bottom:2.5px; width:28%;" accept="image/png" required> ';
        echo '<button name="validerPromotion" class="btn" type="submit" style="height:30px: width: 6px; width:10%;" >Valider</button>';
    echo '</form>';
    //Affichage des promotions
    $con=Database::connect();
    $sql = $con->query("SELECT * FROM nouvels");
    echo '<div class="toutePromotion" width:80%;>';
        echo '<table style="width: 50%;">';
            echo "<tr >";
                echo "<th>image</th>";
                echo "<th>titre</th>";
            echo "</tr>";
                while($line=$sql->fetch()){
                    echo "<tr >";
                    echo '<td ><img src="../showimageslider.php?id_slider='.$line['sliderId'].'" style="height:60px;"></td>';
                    echo "<td>".$line['sliderName']."</td>";
                    echo '<td >';
                            echo '<a href="updateSlider.php?idSlider='.$line['sliderId'].'"><img src="dashboard icons/refresh.png" alt="Modifier"></a>'; 
                            echo '<a href="delete.php?idSlider='.$line['sliderId'].'"><img src="dashboard icons/delete.svg" alt="Supprimer"></a>';  
                    echo '</td>'; 
                echo "</tr>"; 
                }
                $con=Database::disconnect();
        echo "</table>";
    echo "</div>";
?>
    </div>
</body>
</html>
<?php
}else{
    header("Location: index.php");
}
?>