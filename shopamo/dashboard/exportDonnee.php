<?php      
        require '../databaseConnection.php'  ;

        $con=Database::connect(); 
        if(!empty($_GET["typeFileProducts"])){
            $typefile=$_REQUEST['typeFileProducts'];
            if($typefile=="csv"){
                $query =$con->query("SELECT * from products ORDER BY productId DESC"); 
            
                $fileName="product-data_".date('Y-m-d').".csv";

                
                header('Content-Type: text/csv'); 
                header('Content-Disposition: attachment; filename="'.$fileName.'";'); 
                $output = fopen("php://output", "w");  
                fputcsv($output, array("Product Id", "Product Name", "Product Size","Product Description","Product Old Price", "Product Principal Price", "Sous Categorie Id"));
                
                while($row = $query->fetch())  
                {  
                    $lineData=array($row['productId'],$row['productName'],$row['productSize'],$row['productDescription'],$row['productOldPrice'],$row['productPrincipalPrice'],$row['categorieId']);
                    fputcsv($output,$lineData);  
                }  
                
                fclose($output);
                exit;

            }
            else if($typefile=="excel"){
                $fileName = "product-data_" . date('Y-m-d') . ".xls"; 
                
                // Column names 
                $fields = array("Product Id", "Product Name", "Product Size","Product Description","Product Old Price", "Product Principal Price", "Sous Categorie Id"); 
                
                // Display column names as first row 
                $excelData = implode("\t", array_values($fields)) . "\n"; 
                
                // Fetch records from database 
                $query = $con->query("SELECT * from products ORDER BY productId DESC"); 
                if($query->rowCount() > 0){ 
                    // Output each row of the data 
                    while($row = $query->fetch()){ 
                        $lineData=array($row['productId'],$row['productName'],$row['productSize'],$row['productDescription'],$row['productOldPrice'],$row['productPrincipalPrice'],$row['categorieId']);
                        
                        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
                    } 
                }else{ 
                    $excelData = 'No records found...'. "\n"; 
                } 
                
                // Headers for download 
                header("Content-Type: application/vnd.ms-excel"); 
                header("Content-Disposition: attachment; filename=\"$fileName\""); 
                
                // Render excel data 
                echo $excelData; 
                
                exit;
            }
        }
        else if(!empty($_GET["typeFileCommandes"])){
            $typefile=$_REQUEST['typeFileCommandes'];
            if($typefile=="csv"){
                $query =$con->query("SELECT c.customerId,c.completeName,c.city,c.adresse,c.numberPhone,p.productId,p.productName,o.quantity,o.size,o.priceTotal FROM customers c, orders o,products p WHERE c.customerId=o.customerId and p.productId=o.productId ORDER BY c.customerId DESC"); 
            
                $fileName="commandes et clients-data_".date('Y-m-d').".csv";

                
                header('Content-Type: text/csv'); 
                header('Content-Disposition: attachment; filename="'.$fileName.'";'); 
                $output = fopen("php://output", "w");  
                fputcsv($output, array("Client Id", "Nom client", "Ville","Adresse","Telephone","Produit Id", "Nom Produit", "Quantite",'Taille','Prix Total'));
                
                while($row = $query->fetch())  
                {  
                    $lineData=array($row['customerId'],$row['completeName'],$row['city'],$row['adresse'],$row['numberPhone'],$row['productId'],$row['productName'],$row['quantity'],$row['size'],$row['priceTotal']);
                    fputcsv($output,$lineData);  
                }  
                
                fclose($output);
                exit;

            }
            else if($typefile=="excel"){
                $fileName = "commandes et clients-data_" . date('Y-m-d') . ".xls"; 
                
                // Column names 
                $fields =  array("Client Id", "Nom client", "Ville","Adresse","Telephone","Produit Id", "Nom Produit", "Quantite",'Taille','Prix Total');

                // Display column names as first row 
                $excelData = implode("\t", array_values($fields)) . "\n"; 
                
                // Fetch records from database 
                $query = $con->query("SELECT c.customerId,c.completeName,c.city,c.adresse,c.numberPhone,p.productId,p.productName,o.quantity,o.size,o.priceTotal FROM customers c, orders o,products p WHERE c.customerId=o.customerId and p.productId=o.productId ORDER BY c.customerId DESC"); 
                if($query->rowCount() > 0){ 
                    // Output each row of the data 
                    while($row = $query->fetch()){ 
                        $lineData=array($row['customerId'],$row['completeName'],$row['city'],$row['adresse'],$row['numberPhone'],$row['productId'],$row['productName'],$row['quantity'],$row['size'],$row['priceTotal']);
                        
                        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
                    } 
                }else{ 
                    $excelData = 'No records found...'. "\n"; 
                } 
                
                // Headers for download 
                header("Content-Type: application/vnd.ms-excel"); 
                header("Content-Disposition: attachment; filename=\"$fileName\""); 
                
                // Render excel data 
                echo $excelData; 
                
                exit;
            }
        } 
    
 
?>

