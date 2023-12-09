<!DOCTYPE html>

<html>

<head>

    <meta charset="utf=8">
    <title> Articles </title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="image/logo page.PNG">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!--(au dessus )logo billy sur la fenètre du site-->
</head>

<body>
    <?php
    include("Topnav.php");
    ?>
    <h3 class="txt-articles">Articles :</h3>
    <div class="multipleBlog">
        <?php
            $dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
            $utilisateur = 'if0_35451937';
            $motDePasseDB = 'lSWvbHhgzX73uaY';

            $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Utilisation de requête préparée pour éviter l'injection SQL
            $requete_selection = $connexion->prepare("SELECT id FROM blog");
            $requete_selection->execute();

            $resultats = $requete_selection->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultats as $resultat) {
                $article_id = $resultat["id"];

            echo '<div class="blog">';
            echo '<img src="chargementImg.php?article_id=' . $article_id . '" alt="img_article">';
            echo '<div class="info-blog">';
            
            // Utiliser un autre script ou une autre requête pour obtenir les détails spécifiques de chaque article
            // en fonction de l'ID de l'article (voir ci-dessous)

            // Utilisation de requête préparée pour éviter l'injection SQL
            $requete_details = $connexion->prepare("SELECT nom_article, type, pegi FROM blog WHERE id = ?");
            $requete_details->bindParam(1, $article_id);
            $requete_details->execute();

            $details = $requete_details->fetch(PDO::FETCH_ASSOC);

            if ($details) {
                $nom_article = $details["nom_article"];
                $type_jeux = $details["type"];
                $pegi = $details["pegi"];
        
                echo '<div class="game-name"><p>' . $nom_article . '</p></div>';
                echo '<div class="game-info"><p>' . $type_jeux . '</p></div>';
                echo '<div class="game-pegi"><p>PEGI : ' . $pegi . '</p></div>';
            } else {
                echo "Détails de l'article non trouvés.";
            }

            echo '</div>';
            echo '<div class="articleName"><a href="Page_article.php?article_id=' . $article_id . '" >'.$nom_article.'</a></div>';
            echo '</div>';
        }
        ?>

    </div>

</body>

</html>