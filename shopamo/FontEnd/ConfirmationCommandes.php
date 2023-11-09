<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Shopamo</title>
    <link rel="icon" href="images/logos/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styleproduit.css">
    <link rel="stylesheet" href="css/styleCatgories.css">
    <link rel="stylesheet" href="css/styleSlider.css">
    <link rel="stylesheet" href="css/pageCategoriesStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="JS/fileJs.js" defer></script>
    <style>
        #commandeValider{
            color: rgb(27, 148, 185);
            font-size: 60px;
            margin: 64px 0;
            text-align: center;
        }
        #commandeValider img{
            display: flex;
            margin: auto;
            width: 9%;
        }
        .majbleu{
            color: rgba(9, 31, 105, 0.637);
            font-size: 65px;
        }
    </style>
    </head>
    <body style="margin: 0;">
        <?php
            require '../databaseConnection.php';
            include 'header footer/header.php';
        ?>
        <div id="mainPage">
            <div id="commandeValider">
                <span class="majbleu"> V</span>otre commande été validée<span class="majbleu">.</span>
                <img src="images/logos/imgValide.svg">
            </div>
        </div>
        
        <?php
        include 'header footer/footer.php';
        ?>
    </body>
</html>
<?php include 'Panier/panier index.php';  ?>
