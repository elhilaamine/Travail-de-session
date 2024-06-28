<?php
require_once('./config.php');


// unset($_SESSION["user_loggedin"])

if (isset($_SESSION["user_loggedin"])) {
    header("Location: index.php");
    exit();
}

$nbErrors = 0;
$errMessage = "";

if (isset($_POST["nom_utilisateur"]) && isset($_POST["mot_de_passe"])) {
    // Le formulaire a été soumis => Traiter l'authentification

    // On vérifie si l'utilisateur existe dans la base de données
    $requete = $conn->prepare("SELECT * FROM `usagers` WHERE `nom_utilisateur`=:nom_utilisateur AND `mot_de_passe`=PASSWORD(:mot_de_passe)");
    $requete->bindParam(":nom_utilisateur", $_POST["nom_utilisateur"]);
    $requete->bindParam(":mot_de_passe", $_POST["mot_de_passe"]);
    $requete->execute();

    if ($requete->fetch()) {
        $_SESSION["user_loggedin"] = $_POST["nom_utilisateur"];
        header("Location: index.php");
        exit();
    } else {
        $nbErrors++;
        $errMessage = "Code d'accès incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ets recette</title>
  
    <link rel="stylesheet" href="./styles.css" />
</head>
<body>
    <header>
        <div class="container-titre">
            <h1>L'ÉTS a du goût</h1>
        </div>
    </header>

    <div class="container my-4">
        <section id="authentification" class="mb-4">
            <h2>Authentification</h2>
            <?php if ($nbErrors > 0): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errMessage); ?></div>
            <?php endif; ?>
            <form id="loginForm" class="form-group" action="" method="post">
                <label for="nom_utilisateur">Nom d'utilisateur:</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" class="form-control" 
                       value="<?= isset($_POST["nom_utilisateur"]) ? htmlspecialchars($_POST["nom_utilisateur"]) : "" ?>"
                       required  />
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required />
                <button type="submit" class="btn btn-primary mt-2 align-top">Se connecter</button>
                <button class="btn btn-secondary mt-2" onclick="window.location.href='./nouveau_compte.php';" type="button">Créer un compte</button>
            </form>
        </section>
    </div>

    <footer>
        <p>© 2024 Recettes de cuisine. Tous droits réservés.</p>
        <p>Auteurs: Amine El Hila & Aya Rehimi</p>
    </footer>
</body>
</html>
