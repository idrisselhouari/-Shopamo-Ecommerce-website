<?php
session_start();
require('../databaseConnection.php') ;

//validation de formulaire
if (isset($_POST['validate'])) {
  
    //virifier si tous les champs est complet
   if (!empty($_POST['username']) && !empty($_POST['pwd']) ) {
       
     //htmlspecialchars:pour eviter que l'utilisateur entrer un code html
        $username=htmlspecialchars($_POST['username']);
        //on met htmlspecialchars au lieu de  password_hash car on ne va pas cripter le mot de passe on veut juste verifier  
        $user_password=htmlspecialchars($_POST['pwd']);
        
             // verifier si l'utilisateur existe
             $pdo = Database::connect(); 
             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $checkUserExist=$pdo->prepare("SELECT * FROM admin where user=?");
        $checkUserExist->execute(array($username));

        if ($checkUserExist->rowCount()>0) {
           
            //recuperer les donnees de l'utilisateur
            $userInfo=$checkUserExist->fetch();
            echo password_hash($user_password,PASSWORD_DEFAULT);
            //virifier si le mot de  passe est correcte
            if (password_verify($user_password,$userInfo['password'])) {
                    //authentifier l'utilisateur sur le site et recupere ses donnees dans des variables globales session
                $_SESSION['auth'] = true;
                $_SESSION['id']=$userInfo['userId'];
                $_SESSION['user']=$userInfo['user']; 
                $_SESSION['email'] = $userInfo['userEmail'];

                header("Location: dashboard.php");
            }
            else {
                $errorMsg="votre mot de passe est incorrect !";
            }
        }
        else {
            $errorMsg="votre email est incorrect !";
        }
        }
   else{
       $errorMsg="veuillez completer tous les champs !";
   }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Shopamo Dashboard</title>
    <link rel="icon" href="dashboard icons/favicon copy.png">
    <link rel="stylesheet" href="css dashboard/styleDashboard.css">
    <link rel="stylesheet" href="css dashboard/stylePages.css"> 
</head>
<body style="background-color: #eee;">
<div class="containerSign">
       <div class="title">CONNECTION :</div>
       <form  method="post" >
            <?php
            //gerer les erreurs :soit pseudo quel existe deja ou les champs pas remplir 
            if(isset($errorMsg)){
            echo '<p style="font-color:red">'.$errorMsg.'</p>';
            }
            ?>

           <div class="user-details">

               <div class="input-box">
                   <span class="details">Email</span>
                   <input type="text" placeholder="Entrer votre Email" name="username" required>  
               </div>

               <div class="input-box">
                   <span class="details">Mot de passe</span>
                   <input type="password" placeholder="Entrer votre Mot de passe" name="pwd" required>  
               </div>
           </div>
           <div class="button">
                   <input type="submit" value="Se connecter" name="validate" class="btn">
                  <!-- <div class="signup_link">je n'ai pas de compte ,<a href="signup.php">  je m'inscris</a></div>  -->
            </div>
       </form>
   </div> 
</body>
</html> 
<style>
    .containerSign{
        width: 40%;
        height: max-content;
        text-align: center;
        border: 1px solid #eee;
        border-radius: 15px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        margin: 0 auto;
        background-color: #fff;
    }
    .title{
        margin: 20px;
        font-weight: bold;
    }
    .user-details{
        margin: auto;
        display: inline-flex;
        text-align: center;
    }
    .user-details .input-box input{
        height: 26px;
        display: inline-flex;
        align-items: center;
        border: 0.5px solid rgb(118, 118, 118);
        border-radius: 10px;
        outline: 0;
        margin: 8px;
        padding: 3px 3px;
    }
    .btn{
        display: inline;
        background: #44bae6;
        color: #fff;
        margin: 20px auto;
        padding: 8px 10px;
        text-align: center;
        border: 0;
        border-radius: 15px;
        width: 90%;
        font-weight: bold;
        font-size: large;
    }
</style>