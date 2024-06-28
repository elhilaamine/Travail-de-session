<?php
require_once('./config.php');




$formulaireSoumis = false;
$erreur = "";
$nbErreurs = 0;

if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["nom_utilisateur"]) && isset($_POST["mot_de_passe"]) && isset($_POST["mot_de_passe_confirmation"])) {
    $formulaireSoumis = true;

    // Vérifier si le nom d'utilisateur est déjà utilisé
    $requete = $conn->prepare("SELECT * FROM `usagers` WHERE `nom_utilisateur` = :nom_utilisateur");
    $requete->bindValue(":nom_utilisateur", $_POST["nom_utilisateur"]);
    $requete->execute();

    if ($requete->fetch()) {
        $nbErreurs++;
        $erreur .= "Le nom d'utilisateur existe déjà!";
    }

    // Vérifier si les deux mots de passe sont identiques
    if ($_POST["mot_de_passe"] !== $_POST["mot_de_passe_confirmation"]) {
        $nbErreurs++;
        $erreur .= "Les mots de passe ne correspondent pas!";
    }

    // Vérifier si le mot de passe comporte au moins 8 caractères
    if (strlen($_POST["mot_de_passe"]) < 8) {
        $nbErreurs++;
        $erreur .= "Le mot de passe doit comporter au moins 8 caractères!";
    }

    // Vérifier si le nom et le prénom ne sont pas laissés vides
    if (empty($_POST["nom"]) || empty($_POST["prenom"])) {
        $nbErreurs++;
        $erreur .= "Le nom et le prénom ne doivent pas être laissés vides!";
    }

    if (!$nbErreurs) {
        $requete = $conn->prepare("INSERT INTO `usagers` (`nom`, `prenom`, `nom_utilisateur`, `mot_de_passe`) VALUES (:nom, :prenom, :nom_utilisateur, PASSWORD(:mot_de_passe))");
        $requete->bindValue(":nom", $_POST["nom"]);
        $requete->bindValue(":prenom", $_POST["prenom"]);
        $requete->bindValue(":nom_utilisateur", $_POST["nom_utilisateur"]);
        $requete->bindValue(":mot_de_passe", $_POST["mot_de_passe"]);
        if ($requete->execute()) {

            // Rediriger vers login.php
            header("Location: login.php");
            exit();
            
        } else {
            $nbErreurs++;
            $erreur .= "Erreur lors de l'insertion dans la base de données.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription</title>
   
    <link rel="stylesheet" href="./styles.css?val=1" />
</head>
<body>
<header>
    <div class="container-titre">
        <h1>L'ÉTS a du goût</h1>
    </div>
</header>

<div class="container my-4">
    <section id="nouvelUsager" class="mb-4">
        <h2>Créer un compte</h2>
        <?php if ($nbErreurs > 0): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erreur); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?= isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : "" ?>" required />
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="<?= isset($_POST["prenom"]) ? htmlspecialchars($_POST["prenom"]) : "" ?>" required />
            </div>
            <div class="form-group">
                <label for="nom_utilisateur">Nom d'utilisateur:</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" class="form-control" value="<?= isset($_POST["nom_utilisateur"]) ? htmlspecialchars($_POST["nom_utilisateur"]) : "" ?>" required />
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="mot_de_passe_confirmation">Confirmer le mot de passe:</label>
                <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </section>
</div>

<footer>
    <p>© 2024 Recettes de cuisine. Tous droits réservés.</p>
    <p>Auteurs: Amine El Hila & Aya Rehimi</p>
</footer>
</body>
</html>
