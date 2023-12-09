<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="icon" href="image/logo page.PNG">
    <title>Blog</title>
</head>
<body>
    <?php include("Topnav.php"); ?>

    <div class="article">
        <?php
        $dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
        $utilisateur = 'if0_35451937';
        $motDePasseDB = 'lSWvbHhgzX73uaY';

        $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'ID de l'article est passé dans l'URL
        if (isset($_GET['article_id'])) {
            $article_id = $_GET['article_id'];

            // Utilisation de requête préparée pour éviter l'injection SQL
            $requete_selection = $connexion->prepare("SELECT * FROM blog WHERE id = ?");
            $requete_selection->bindParam(1, $article_id);
            $requete_selection->execute();

            $resultat = $requete_selection->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                $nom_article = $resultat["nom_article"];
                $contenu_article = $resultat["contenu_article"];
                $img = $resultat["chemin_fichier"];

                echo '<div class="article-name">';
                echo '<h2>' . $nom_article . '</h2>';
                echo '</div>';
                echo '<div class="article-contenu">';
                echo '<p>' . $contenu_article . '</p>';
                echo '</div>';
                echo '<div class="article-img">';
                echo '<img src="chargementImg.php?article_id=' . $article_id . '" alt="img_article">';
                echo '</div>';
            } else {
                echo "Article non trouvé.";
            }
        } else {
            echo "ID d'article non spécifié.";
        }
        ?>
    </div>
</body>
</html>
