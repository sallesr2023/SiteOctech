<?php

$dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
$utilisateur = 'if0_35451937';
$motDePasseDB = 'lSWvbHhgzX73uaY';

$connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["article_id"])) {
    $article_id = $_GET["article_id"];

    // Utilisation de requête préparée pour éviter l'injection SQL
    $requete_selection = $connexion->prepare("SELECT * FROM blog WHERE id = ?");
    $requete_selection->bindParam(1, $article_id);
    $requete_selection->execute();

    $resultat = $requete_selection->fetch(PDO::FETCH_ASSOC);

    if ($resultat && isset($resultat["chemin_fichier"])) {
        $chemin_fichier = $resultat["chemin_fichier"];

        // Récupérer le type MIME de l'image
        $type_mime = mime_content_type($chemin_fichier);

        // Envoyer les en-têtes appropriés pour l'affichage de l'image
        header("Content-Type: $type_mime");
        readfile($chemin_fichier);
        exit;
    } else {
        // L'article avec l'ID spécifié n'a pas été trouvé
        echo "Article non trouvé.";
    }
} else {
    // Requête invalide
    echo "Requête invalide.";
}
?>