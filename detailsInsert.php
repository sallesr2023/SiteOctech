<?php
        $dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
                $utilisateur = 'if0_35451937';
                $motDePasseDB = 'lSWvbHhgzX73uaY';

                $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $article_id = 2;

                    // Utilisation de requête préparée pour éviter l'injection SQL
                    $requete_selection = $connexion->prepare("SELECT * FROM blog WHERE id = ?");
                    $requete_selection->bindParam(1, $article_id);
                    $requete_selection->execute();

                    $resultat = $requete_selection->fetch(PDO::FETCH_ASSOC);

                    if ($resultat) {
                        $nom_article = $resultat["nom_article"];
                        $type_jeux = $resultat["type"];
                        $pegi = $resultat["pegi"];

                        // Affichage des données dans le HTML
                        echo '<div class="info-blog">';
                        echo '<div class="game-name"><p>' . $nom_article . '</p></div>';
                        echo '<div class="game-info"><p>' . $type_jeux . '</p></div>';
                        echo '<div class="game-pegi"><p>PEGI : ' . $pegi . '</p></div>';
                        echo '</div>';
                        echo '<div class="articleName">';
                        echo '<p>' .$nom_article. '</p>';
                        echo '</div>';
                    } else {
                        echo "Article non trouvé.";
                    }
                } else {
                    echo "Requête invalide.";
                }
        ?>