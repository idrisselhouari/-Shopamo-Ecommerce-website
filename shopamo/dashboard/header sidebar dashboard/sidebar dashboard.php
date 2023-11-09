<style>
    .lien{
        text-decoration: none;
        color: white;
    }
    .lien2:hover span:last-child, .lien2:active span:last-child{
        color:#44bae6;
    }
</style>
<aside class="aside_bar" id="aside_bar">
        <div class="title_dashboard">
            <h2><span><a href="dashboard.php" class="lien"><img src="dashboard icons/favicon.png" alt=""></span><span>hopamo</span></a></h2>
        </div>

        <div class="aside_bar_menu" >
            <ul>
                <li class="item"><span class="List lien2"><a href="dashboard.php" class="lien">
                    <span class="icon" style="padding: 7px 2px 2.5px 2px;"><img src="dashboard icons/statistic.svg" alt=""></span>
                    <span>Tableau de bord</span>
                </a></span></li>
                <li class="item"><span class="List lien2"><a href="commandes.php" class="lien">
                    <span class="icon" style="padding: 7px 2px 2.5px 2px;"><img src="dashboard icons/commande.svg" alt=""></span>
                    <span>Commandes</span>
                </a></span></li>
                <li class="item"><span id="productList" class="List"><span class="icon"><img src="dashboard icons/product (2).png" alt=""></span><span>Produits</span></span> 
                    <div id="productSousList" class="sousList">
                        <ul>
                            <li ><span><a href="ajouterProduit.php" class="lien">Ajouter un produit</a> </span></li>
                            <li ><span><a href="toutesProduits.php" class="lien">Toutes les produits</a> </span></li>
                        </ul> 
                    </div>
                </li>
                <li class="item" ><span id="categoriesList" class="List"><span class="icon"><img src="dashboard icons/category_white.svg" alt=""></span><span>Catégories</span></span>
                    <div id="categoriesSousList" class="sousList">
                        <ul>
                            <li><span><a href="ajouterSousCategorie.php" class="lien">Ajouter une sous categorie</a> </span></li>
                            <li ><span><a href="toutesSousCategories.php" class="lien">Toutes les sous categories</a></span></li>
                            <li><span><a href="categorieGlobale.php" class="lien"> Les categories globales</a></span></li>
                        </ul>
                    </div>
                </li>
                <li class="item"><span class="List lien2"><a href="client.php" class="lien">
                    <span class="icon" style="padding: 7px 2px 2.5px 2px;"><img src="dashboard icons/clients.svg" alt=""></span>
                    <span>Clients</span>
                </a></span></li>
                <li class="item"><span class="List lien2"><a href="nouvels.php" class="lien">
                    <span class="icon" style="padding: 7px 2px 2.5px 2px;"><img src="dashboard icons/promotions.png" alt=""></span>
                    <span>Slider</span>
                </a></span></li>
                <li class="item"><span class="List lien2"><a href="graph.php" class="lien">
                    <span class="icon" style="padding: 7px 2px 2.5px 2px;"><img src="dashboard icons/statistic.svg" alt=""></span>
                    <span>Statistiques</span>
                </a></span></li>
                <li class="item"><span class="List lien2"><a href="logout.php" class="lien">
                    <span class="icon" style="padding: 8px 2px 2.5px 4px;"><img src="dashboard icons/deconnexion.png" alt=""></span>
                    <span>Deconnexion</span>
                </a></span></li>
            </ul>
        </div>
    </aside>