<?php
// Initialisation de la session.
session_start();

// Détruit toutes les variables de session
$_SESSION=[]; //ou bien  $_SESSION=array();

//  on détruit la session/ fermer la sessiondu visiteur.
 session_destroy();
  
 header("Location: index.php");

?>