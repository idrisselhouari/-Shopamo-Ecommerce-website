<?php session_start();
if (isset($_SESSION['user']) && isset($_SESSION['id'])) { 
    ?>

<?php  
require '../databaseConnection.php';
$SliderFile=null;
if(isset($_POST['ModifierSlider'])){
    if(!empty($_POST['titreSlider'])){
        $SliderName= $_POST['titreSlider'];
    }
    if(!empty($_FILES['imageSlider']['name'])){
        $SliderFile=file_get_contents($_FILES['imageSlider']['tmp_name']);
    }
    $SliderId=$_POST['idSlider'];
    if(!empty($SliderName) && !empty($SliderId) && empty($SliderFile)){
        $con=Database::connect();
        $stmt = $con->prepare("UPDATE  nouvels SET sliderName=? WHERE sliderId=?");
        $stmt->bindParam(1,$SliderName);
        $stmt->bindParam(2,$SliderId);
        $stmt->execute(); 
        $con=Database::disconnect();
        echo '<script>window.location = "nouvels.php";</script>';
    }
    else if((!empty($SliderName) && !empty($SliderFile)) && !empty($SliderId)){
        $con=Database::connect();
        $stmt = $con->prepare("UPDATE  nouvels SET sliderName=?, sliderPicture=? WHERE sliderId=?");
        $stmt->bindParam(1,$SliderName);
        $stmt->bindParam(2,$SliderFile);
        $stmt->bindParam(3,$SliderId);
        $stmt->execute(); 
        $con=Database::disconnect();
        echo '<script>window.location = "nouvels.php";</script>';
    }
    $_POST['Modifier']=NULL;
}

if(!empty($_GET["idSlider"])){
    $idSlider=$_REQUEST["idSlider"];
    $con=Database::connect();
    $stmt=$con->query("SELECT * FROM nouvels WHERE sliderId=$idSlider");
    $data=$stmt->fetch();
    $con=Database::disconnect();
}
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
    echo '<form method="post" enctype="multipart/form-data" action="" style="text-align:center;">';
        echo '<input type="text" name="titreSlider" placeholder="Titre de promotion" style="width:27%; padding-top:6px; padding-bottom:6px;" value="'.$data['sliderName'].'"> '; 
        echo '<input type="file" name="imageSlider" style="padding-top:3px; padding-bottom:2.5px; width:28%;" accept="image/png"> ';
        echo '<input type="hidden" value="'.$data['sliderId'].'" name="idSlider">';
        echo '<button name="ModifierSlider" class="btn" type="submit" style="height:30px: width: 6px; width:10%;" >Modifer</button>';
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
                            echo '<a href="deleteProduct.php?idProduct='.$line['sliderId'].'"><img src="dashboard icons/delete.svg" alt="Supprimer"></a>';  
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