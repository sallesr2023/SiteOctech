<?php

$dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
$utilisateur = 'if0_35451937';
$motDePasseDB = 'lSWvbHhgzX73uaY';

$connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $type_jeux = $_POST["type_jeux"];
    $pegi = $_POST["pegi"];
    $contenu = $_POST["contenu"];


    // Traitement de l'image (téléchargement, validation, etc.)
    $dossier_cible = "image/imgBlog/";
    $nom_fichier = $_FILES["image"]["name"];
    $chemin_fichier = $dossier_cible . $nom_fichier;

    // Déplacer l'image téléchargée vers le dossier cible
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier)) {
        // Utilisation de requête préparée pour éviter l'injection SQL
        $requete_insertion = $connexion->prepare("INSERT INTO blog (nom_article, type, chemin_fichier, pegi, contenu_article) VALUES (?, ?, ?, ?, ?)");
        $requete_insertion->bindParam(1, $nom);
        $requete_insertion->bindParam(2, $type_jeux);
        $requete_insertion->bindParam(3, $chemin_fichier);
        $requete_insertion->bindParam(4, $pegi);
        $requete_insertion->bindParam(5, $contenu);

        // Exécution de la requête préparée
        $requete_insertion->execute();
        header("Location: octech_accueil.php");
    } else {
        echo "Erreur lors du téléchargement du fichier.";
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
}
?>
