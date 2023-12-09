<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="icon" href="image/logo page.PNG">
    <title>Votre Compte</title>
</head>

<body>
    <?php include("Topnav.php"); ?>

    <section class="details">
        <?php
        
        // Connexion à la base de données
        $dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
        $utilisateur = 'if0_35451937';
        $motDePasseDB = 'lSWvbHhgzX73uaY';

        try {
            $conn = new PDO($dsn, $utilisateur, $motDePasseDB);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

            // Requête SQL
            $sql = "SELECT * FROM Users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                // Affichage des données
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='user-name'>Nom : " .$row["name"]. "</div>";
                    echo "<div class='user-email'>Email : " .$row["email"]. "</div>";
                    echo "<div class='user-age'>Age : " .$row["age"]. "</div>";
                    echo "<div class='user-sexe'>Sexe : " .$row["sexe"]. "</div>";
                    echo "<div class='user-account'>Compte : " .$row["account"]."</div>";
                }
            } else {
                echo "Aucun résultat trouvé";
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

        // Fermeture de la connexion à la base de données
        $conn = null;?>
    </section>

    <?php
$dsn = "mysql:host=sql110.infinityfree.com;dbname=if0_35451937_octechusers";
$utilisateur = 'if0_35451937';
$motDePasseDB = 'lSWvbHhgzX73uaY';

try {
    $connexion = new PDO($dsn, $utilisateur, $motDePasseDB);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

    $requete = "SELECT * FROM Users WHERE id = $id";
    $resultat = $connexion->query($requete);

    if ($resultat->rowCount() > 0) {
        $row = $resultat->fetch(PDO::FETCH_ASSOC);
        // Vérifiez si la valeur de "account" est égale à "Blogeur"
        if ($row["account"] == "Blogeur") {
            // Affichez votre formulaire HTML ici
?>
            <form action="creation_Blog.php" method="post" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom"><br>

    <label for="type_jeux">Type de jeux :</label>
    <select name="type_jeux" id="type_jeux">
        <option value="type 1">type 1</option>
        <option value="type 2">type 2</option>
        <!-- Ajoutez d'autres options selon vos besoins -->
    </select><br>

    <label for="image">Image :</label>
    <input type="file" name="image" id="image"><br>

    <label for="pegi">Pegi :</label>
    <select name="pegi" id="pegi">
        <option value="3">3</option>
        <option value="6">6</option>
        <option value="9">9</option>
        <option value="12">12</option>
        <option value="16">16</option>
        <option value="18">18</option>
    </select><br>

    <label for="contenu">Contenu :</label>
    <input type="text" name="contenu" id="contenu"><br>

    <input type="submit" value="Envoyer">
</form>

<?php
        } else {
        }
    } else {
        echo "Erreur : si vous voyez ce message de nous en faire part.";
    }
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>




</body>

</html>