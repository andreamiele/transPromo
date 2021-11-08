<?php
require_once "includes/functions.php";
session_start();

// Si l'user est connecté
if(isUserConnected())
    redirect('accueil.php');

if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger">
        Mauvais identifiants...
    </div>
<?php } ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>ETƎ</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css"/>
</head>

<body>

<img src="img/logo.png" alt="Logo" class="logo"/>

<section class="d-flex align-items-center min-vh-100">
    <div class="container text-center">
        <h1>Bienvenue sur etƎ 😊</h1>
        <br/>
        <form method="POST" action="index.php">
            <div class="form-group">
                <input type="email" class="form-control" id="email" placeholder="Adresse e-mail" name="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" name="mdp">
            </div>
            <button type="submit" class="btn btn-primary">CONNEXION</button>
            <hr/>
            <h5>Pas encore de compte ? <a href="">S'inscrire</a></h5>
        </form>
    </div>
</section>


</body>

<?php
if (!empty($_POST['email']) and !empty($_POST['mdp'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $req = getDb()->prepare('Select * FROM users WHERE email=? and password=?');
    $req->execute(array($email, $mdp));
    $profileValide = 0;
    if ($req->rowCount() == 1) {
        while ($res = $req->fetch()) {
            $_SESSION['id'] = $res['id'];
            $_SESSION['prenom'] = $res['prenom'];
            $profileValide = 1;
        }
    }
    if($profileValide > 0)
        redirect("accueil.php");
    else
        redirect("index.php?error=true");
}
?>
</html>