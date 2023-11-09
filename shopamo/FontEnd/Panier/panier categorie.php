<?php
    if(isset($_POST['addcart'])){
        $idProduit=$_POST["idproduit"];
        $sizeProduit=$_POST['size'];
        $quantiteProduit=$_POST["quantite"];
        if(!empty($quantiteProduit) && !empty($sizeProduit) && !empty($idProduit)){
            if(isset($_SESSION['cart'])){

                $item_array_id = array_column($_SESSION['cart'], "product_id");
                $item_array_size= array_column($_SESSION['cart'], "product_size");
        
                if(in_array($idProduit, $item_array_id) && in_array($sizeProduit, $item_array_size)){
                    echo "<script>alert('Product is already added in the cart..!')</script>";
                }else{
        
                    $count = count($_SESSION['cart']);
                    $item_array = array(
                        'product_id' => $idProduit,
                        'product_size' => $sizeProduit,
                        'product_quantite' => $quantiteProduit,
                    );
                    $_SESSION['cart'][$count] = $item_array;
                    echo '<script>window.location = "afficherCategorie.php?idCategorie='.$id.'"</script>';
                }
        
            }else{
        
                $item_array = array(
                    'product_id' => $idProduit,
                    'product_size' => $sizeProduit,
                    'product_quantite' => $quantiteProduit,
                );
        
                // Create new session variable
                $_SESSION['cart'][0] = $item_array;
                print_r($_SESSION['cart']);
                echo '<script>window.location = "afficherCategorie.php?idCategorie='.$id.'"</script>';

            }    
        }
    }
    else if(isset($_POST["buynow"])){
        $idProduit=$_POST["idproduit"];
        $sizeProduit=$_POST["size"];
        $quantiteProduit=$_POST["quantite"];
        $item_array = array(
            'product_id' => $idProduit,
            'product_size' => $sizeProduit,
            'product_quantite' => $quantiteProduit,
        );

    // Create new session variable
        $_SESSION['buynow'][0] = $item_array;
        print_r($_SESSION['buynow']);
        echo '<script>window.location = "acheterMaintenant.php"</script>';
    }
?>