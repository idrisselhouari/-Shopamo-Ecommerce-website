<?php
    require '../databaseConnection.php';
    $con=Database::connect();
    if(!empty($_GET['idProduct'])){
        $idprod=$_REQUEST['idProduct'];
        $sql=$con->query("DELETE FROM products WHERE productId=$idprod");
        $con=Database::disconnect();
        echo '<script>window.location = "toutesProduits.php"</script>';
    }
    else if(!empty($_GET['idSousCategorie'])){
        $idSousCateg=$_REQUEST['idSousCategorie'];
        $sql=$con->query("DELETE FROM souscategories WHERE categorieId=$idSousCateg");
        $con=Database::disconnect();
        echo '<script>window.location = "toutesSousCategories.php"</script>';
    }
    else if(!empty($_GET['idCategorieGlobale'])){
        $idCategGlob=$_REQUEST['idCategorieGlobale'];
        $sql=$con->query("DELETE FROM categorieGlobale WHERE categorieGlobaleId=$idCategGlob");
        $con=Database::disconnect();
        echo '<script>window.location = "categorieGlobale.php"</script>';
    }
    else if(!empty($_GET['idSlider'])){
        $idSlider=$_REQUEST['idSlider'];
        $sql=$con->query("DELETE FROM nouvels WHERE sliderId=$idSlider");
        $con=Database::disconnect();
        echo '<script>window.location = "nouvels.php"</script>';
    }
?>