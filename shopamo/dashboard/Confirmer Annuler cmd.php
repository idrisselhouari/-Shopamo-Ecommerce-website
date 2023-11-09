<?php
    require '../databaseConnection.php';
    if(!empty($_GET['confirmerLivraison'])){
        $idOrder=$_REQUEST['confirmerLivraison'];
        $con=Database::connect();
        $confirmerSql=$con->query("UPDATE orders SET Livraison='Oui', statutPaiment='Payé' WHERE orderId=$idOrder");
        $con=Database::disconnect();
        echo '<script>window.location = "commandes.php";</script>';
    }
    if(!empty($_GET['annulerLivraison'])){
        $idOrder=$_REQUEST['annulerLivraison'];
        $con=Database::connect();
        $confirmerSql=$con->query("DELETE FROM orders WHERE orderId=$idOrder");
        $con=Database::disconnect();
        echo '<script>window.location = "commandes.php";</script>';
    }
?>
<script>
    ;
</script>