<?php
$error_message = isset($_GET['error']) ? urldecode($_GET['error']) : "";
$serveur = 'if0_35451937_octechusers';
$dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
$utilisateur = 'if0_35451937';
$motDePasseDB = 'lSWvbHhgzX73uaY';

// Validation et nettoyage des données
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialisation de la variable d'erreur
$validationError = false;

// Vérifiez si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire et validez-les
    $nom = validateInput($_POST['nom']);
    $email = validateInput($_POST['email']);
    $motDePasse = validateInput($_POST['mdp']);
    $mdpCrypted = password_hash($motDePasse, PASSWORD_ARGON2ID);
    $age = validateInput($_POST['age']);
    $sexe = validateInput($_POST['sexe']);
    $userType = validateInput($_POST['utilisation']);

    // Effectuez la validation ici et mettez à jour $validationError si nécessaire
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/';
    if (!preg_match($passwordRegex, $motDePasse)) {
        $validationError = true;
        $error_message = "Le mot de passe ne respecte pas les critères requis.";
        echo $error_message;
        header("Location: octech_inscription.php");
        exit();
    }

    // Si aucune erreur de validation n'est survenue, exécutez la requête SQL
    if (!$validationError) {
        try {
            $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Connexion à la base de données réussie <br/>';

            $insertion = "INSERT INTO Users (name, email, password, age, sexe, account) VALUES (:nom, :email, :mdpCrypted, :age, :sexe, :userType)";
            $stmt = $connexion->prepare($insertion);

            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdpCrypted', $mdpCrypted);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT); // Spécifiez que $age est un entier
            $stmt->bindParam(':sexe', $sexe);
            $stmt->bindParam(':userType', $userType);

            $stmt->execute();
            header("Location: octech_connexion.php");
            exit();
        } catch (PDOException $e) {
            // Loguez l'erreur dans un fichier journal
            error_log('Erreur de base de données: ' . $e->getMessage(), 0);
            $error_message = "Une erreur s'est produite lors du traitement de votre demande.";
        }
    } else {
        // Si des erreurs de validation sont survenues, mettez à jour $error_message
        $error_message = "Des erreurs de validation sont survenues. Veuillez corriger le formulaire.";
    }
} else {
    // Si le formulaire n'a pas été soumis, redirigez l'utilisateur vers le formulaire
    header("Location: octech_inscription.php");
    exit();
}
?>
