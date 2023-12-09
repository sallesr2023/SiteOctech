<?php
// Vérifier si une session est déjà active avant d'appeler session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialiser la variable isConnected à false
$isConnected = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le formulaire a été soumis
    if (isset($_POST['email_C']) && isset($_POST['mdp_C'])) {
        // Récupérer les données du formulaire
        $email = $_POST['email_C'];
        $motDePasse = $_POST['mdp_C'];
        $name = "user";
        $id = 0;

        // Connexion à la base de données (à remplacer par vos propres informations)
        $dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
        $utilisateur = 'if0_35451937';
        $motDePasseDB = 'lSWvbHhgzX73uaY';

        try {
            $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête SQL pour vérifier l'existence de l'utilisateur avec des variables liées
            $requete = "SELECT * FROM Users WHERE email = :email";

            $statement = $connexion->prepare($requete);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $resultat = $statement->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                $motDePasseDeLaBase = trim($resultat['password'], "'");
                $emailDeLaBase = trim($resultat['email'], "'");
                if (password_verify($motDePasse, $motDePasseDeLaBase)) {
                    // Mot de passe correct, permettez l'accès à l'utilisateur

                    $isConnected = true;
                    $_SESSION['isConnected'] = $isConnected;

                    // Utilisez la même variable pour la seconde préparation et exécution
                    $requete = "SELECT id, name FROM Users WHERE email = :email";

                    $statement = $connexion->prepare($requete);
                    $statement->bindParam(':email', $emailDeLaBase);
                    $statement->execute();

                    $utilisateurDetails = $statement->fetch(PDO::FETCH_ASSOC);
                    $name = $utilisateurDetails['name'];
                    $id = $utilisateurDetails['id'];

                    $_SESSION['email'] = $emailDeLaBase;
                    $_SESSION['name'] = $name;
                    $_SESSION['id'] = $id;

                    header('Location: octech_accueil.php');
                    exit();
                } else {
                    // Mot de passe incorrect
                    echo "Mot de passe incorrect. Connexion refusée.";
                }
            } else {
                echo "Aucun utilisateur trouvé avec cette email !";
            }
        } catch (PDOException $e) {
            echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
        }
    }
}
?>
