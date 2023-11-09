<?php session_start();?>
<?php
include '../../databaseConnection.php';
    if(isset($_POST["validerPL"])){
        if(!empty($_POST["NomComplet"]) && !empty($_POST["Telephone"]) && !empty($_POST["Ville"]) && !empty($_POST["Adresse"])){
        
            $con=Database::connect();
            $stmtClient=$con->prepare("INSERT INTO customers (customerId,completeName,numberPhone,city,adresse) VALUES('',?,?,?,?)");
            $stmtClient->bindParam(1,$_POST["NomComplet"]);
            $stmtClient->bindParam(2,$_POST["Telephone"]);
            $stmtClient->bindParam(3,$_POST["Ville"]);
            $stmtClient->bindParam(4,$_POST["Adresse"]);
            
            if($stmtClient->execute()){
                $idCustomer=$con->lastInsertId();
                foreach($_SESSION['cart'] as $key => $value){
                    $sql=$con->query("SELECT * FROM products WHERE productID=".$value['product_id']);
                    $data=$sql->fetch();

                    $stmtOrder=$con->prepare("INSERT INTO orders VALUES ('',?,?,?*".$data['productPrincipalPrice'].",NOW(),'PL','Non payé','Non',?,?)");
                    $stmtOrder->bindParam(1,$value['product_size']);
                    $stmtOrder->bindParam(2,$value['product_quantite']);
                    $stmtOrder->bindParam(3,$value['product_quantite']);
                    $stmtOrder->bindParam(4,$value['product_id']);
                    $stmtOrder->bindParam(5,$idCustomer);
                    $stmtOrder->execute();
                }
                session_destroy();
                header("Location: ../ConfirmationCommandes.php");
            }
        }
    }
    else if(isset($_POST["validerCB"])){
        if(!empty($_POST["NomComplet"]) && !empty($_POST["Telephone"]) && !empty($_POST["Ville"]) && !empty($_POST["Adresse"]) && !empty($_POST["NumeroCarte"]) && !empty($_POST["NomProprietere"]) && !empty($_POST["DateExperation"]) && !empty($_POST["CCV"])){
            $con=Database::connect();
            $numCarte=intval($_POST["NumeroCarte"]);
            echo '<script>alert("'.$numCarte.'")</script>';
            $stmtClient=$con->prepare("INSERT INTO customers VALUES('',?,?,?,?,?,?,?,?)");
            $stmtClient->bindParam(1,$_POST["NomComplet"]);
            $stmtClient->bindParam(2,$_POST["Telephone"]);
            $stmtClient->bindParam(3,$_POST["Ville"]);
            $stmtClient->bindParam(4,$_POST["Adresse"]);
            $stmtClient->bindParam(5,$numCarte);
            $stmtClient->bindParam(6,$_POST["DateExperation"]);
            $stmtClient->bindParam(7,$_POST["NomProprietere"]);
            $stmtClient->bindParam(8,$_POST["CCV"]);
            
            if($stmtClient->execute()){
                $idCustomer=$con->lastInsertId();
                foreach($_SESSION['cart'] as $key => $value){
                    $sql=$con->query("SELECT * FROM products WHERE productID=".$value['product_id']);
                    $data=$sql->fetch();

                    $stmtOrder=$con->prepare("INSERT INTO orders VALUES ('',?,?,?*".$data['productPrincipalPrice'].",NOW(),'CB','Payé','Non',?,?)");
                    $stmtOrder->bindParam(1,$value['product_size']);
                    $stmtOrder->bindParam(2,$value['product_quantite']);
                    $stmtOrder->bindParam(3,$value['product_quantite']);
                    $stmtOrder->bindParam(4,$value['product_id']);
                    $stmtOrder->bindParam(5,$idCustomer);
                    $stmtOrder->execute();
                }
                session_destroy();
                header("Location: ../ConfirmationCommandes.php");
            }
        }
    }
    else if(isset($_POST["validerCBbuynow"])){
        if(!empty($_POST["NomComplet"]) && !empty($_POST["Telephone"]) && !empty($_POST["Ville"]) && !empty($_POST["Adresse"]) && !empty($_POST["NumeroCarte"]) && !empty($_POST["NomProprietere"]) && !empty($_POST["DateExperation"]) && !empty($_POST["CCV"])){
            $con=Database::connect();
            $numCarte=intval($_POST["NumeroCarte"]);
            echo '<script>alert("'.$numCarte.'")</script>';
            $stmtClient=$con->prepare("INSERT INTO customers VALUES('',?,?,?,?,?,?,?,?)");
            $stmtClient->bindParam(1,$_POST["NomComplet"]);
            $stmtClient->bindParam(2,$_POST["Telephone"]);
            $stmtClient->bindParam(3,$_POST["Ville"]);
            $stmtClient->bindParam(4,$_POST["Adresse"]);
            $stmtClient->bindParam(5,$numCarte);
            $stmtClient->bindParam(6,$_POST["DateExperation"]);
            $stmtClient->bindParam(7,$_POST["NomProprietere"]);
            $stmtClient->bindParam(8,$_POST["CCV"]);
            
            if($stmtClient->execute()){
                $idCustomer=$con->lastInsertId();
                foreach($_SESSION['buynow'] as $key => $value){
                    $sql=$con->query("SELECT * FROM products WHERE productID=".$value['product_id']);
                    $data=$sql->fetch();

                    $stmtOrder=$con->prepare("INSERT INTO orders VALUES ('',?,?,?*".$data['productPrincipalPrice'].",NOW(),'CB','Payé','Non',?,?)");
                    $stmtOrder->bindParam(1,$value['product_size']);
                    $stmtOrder->bindParam(2,$value['product_quantite']);
                    $stmtOrder->bindParam(3,$value['product_quantite']);
                    $stmtOrder->bindParam(4,$value['product_id']);
                    $stmtOrder->bindParam(5,$idCustomer);
                    $stmtOrder->execute();
                }
                header("Location: ../ConfirmationCommandes.php");
            }
        }
    }
    else if(isset($_POST["validerPLbuynow"])){
        if(!empty($_POST["NomComplet"]) && !empty($_POST["Telephone"]) && !empty($_POST["Ville"]) && !empty($_POST["Adresse"])){
            $con=Database::connect();
            $stmtClient=$con->prepare("INSERT INTO customers (customerId,completeName,numberPhone,city,adresse) VALUES('',?,?,?,?)");
            $stmtClient->bindParam(1,$_POST["NomComplet"]);
            $stmtClient->bindParam(2,$_POST["Telephone"]);
            $stmtClient->bindParam(3,$_POST["Ville"]);
            $stmtClient->bindParam(4,$_POST["Adresse"]);
            
            if($stmtClient->execute()){
                $idCustomer=$con->lastInsertId();
                foreach($_SESSION['buynow'] as $key => $value){
                    $sql=$con->query("SELECT * FROM products WHERE productID=".$value['product_id']);
                    $data=$sql->fetch();

                    $stmtOrder=$con->prepare("INSERT INTO orders VALUES ('',?,?,?*".$data['productPrincipalPrice'].",NOW(),'PL','Non payé','Non',?,?)");
                    $stmtOrder->bindParam(1,$value['product_size']);
                    $stmtOrder->bindParam(2,$value['product_quantite']);
                    $stmtOrder->bindParam(3,$value['product_quantite']);
                    $stmtOrder->bindParam(4,$value['product_id']);
                    $stmtOrder->bindParam(5,$idCustomer);
                    $stmtOrder->execute();
                }
                header("Location: ../ConfirmationCommandes.php");
            }
        }
    }
?>