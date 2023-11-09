    <header id="headerBlock">
    <div id="HlogoBlock"><!--the logo of header-->
        <a href="index.php"><img src="images/logos/Shopamo logo.svg" alt="Shopamo" id="headerLogo" width="40%" ></a>
        <a href="index.php"><img src="images/logos/home.svg" alt="Accueil" title="Accueil" height="30px" ></a>
    </div>
     <div id="searchBlock"><!--the  categories, -->
            
            <div onmouseover="mouseOver('headerMenu')" onmouseout="mouseOut('headerMenu')" id="searchCategorie">
                <img src="images/logos/menu_black.svg" alt="" id="CategorieMenu" >
                <div  id="headerMenu">
                    <ul >
                        <?php
                            $index=1;
                            $con=Database::connect();
                        ?>
                        <li class="categoriesTitle"><h4>Catégories</h4></li>
                        <?php
                            $stmt1=$con->query("SELECT * FROM categorieGlobale");
                            foreach($stmt1 as $row){
                        ?>
                                <li class="parentMenu" onmouseover="mouseOver('headerItem<?php echo $index ?>')" onmouseout="mouseOut('headerItem<?php echo $index ?>')"><?php echo $row['categorieGlobaleName'] ?>
                                    <?php
                                        echo '<div class="headerUnderMenu" id="headerItem'.$index.'">';
                                            $stmt2=$con->query("SELECT * FROM sousCategories WHERE categorieGlobaleId=".$row["categorieGlobaleId"]);
                                            echo "<ul>";
                                                foreach($stmt2 as $row2){
                                                    echo '<a href="afficherCategorie.php?idCategorie='.$row2["categorieId"].'" title="'.$row2["categorieName"].'"><li class="item" >'.$row2["categorieName"].'</li></a>';                                                                                                  
                                                }
                                            echo "</ul>";
                                        echo "</div>";
                                echo "</li>";
                                $index++;
                            }
                            $con=Database::disconnect();
                        ?>
                            
                    </ul>   
                </div>
            
        </div>
        <form method="POST" enctype="multipart/form-data" style="display: inline; width: 100%">
            <input type="text" id="search" name="searchValue" placeholder="Rechercher"/>
            <button type="submit" name="searchBtn" id="searchButton">Rechercher</button>
        </form>
    </div>
    <div id="cartBlock">
        <a href="panier.php">
            <h5 style="display: flex; align-items:center; margin:0%; font-size:1.3em;"><img src="images/logos/cart logo.svg" alt="" width="95%">
                <?php
                    if (isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        echo "<span id=\"cart_count\" class=\"cartCount\">$count</span>";
                    }else{
                        echo "<span id=\"cart_count\" class=\"cartCount\">0</span>";
                    }

                ?>
            </h5>
        </a>
        </a>
    </div>    
</header>
<?php
    if(isset($_POST['searchBtn'])){  
        if(!empty($_POST["searchValue"])){
            $productName=$_POST["searchValue"];
            echo '<script>window.location = "recherchePage.php?ProductName='.$productName.'"</script>';  
        }
    }
?>