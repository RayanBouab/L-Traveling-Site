<?php
// Connexion à une base de données SQLite (sans recréer la table)
try {
    $conn = new PDO('sqlite:gestion_client.db');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = sanitize_input($_POST['nom']);
    $prenom = sanitize_input($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $tel = sanitize_input($_POST['tel']);
    $datenaiss = sanitize_input($_POST['datenaiss']);
    $sexe = sanitize_input($_POST['sexe']);
    $pays = sanitize_input($_POST['pays']);
    $visa = sanitize_input($_POST['visa']);

    // Validation des champs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide.");
    }

    if (!preg_match("/^[0-9]{10,15}$/", $tel)) {
        die("Numéro de téléphone invalide.");
    }

    // Si les validations sont réussies, on procède à l'ajout dans la base de données
    Ajouter($conn, $nom, $prenom, $datenaiss, $sexe, $email, $tel, $pays, $visa);
    
    // Créer un message de succès stylisé
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription réussie</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="notification">Merci de votre Inscription.</div>
    </body>
    </html>';

    // Après le traitement, redirigez vers la page principale
    header("Refresh:2; url=index.html");
    exit();
}

// Fonction de sanitisation des entrées
function sanitize_input($data) {
    $data = trim($data); // Supprimer les espaces en début et fin
    $data = stripslashes($data); // Supprimer les backslashes \
    $data = htmlspecialchars($data); // Éviter les attaques XSS
    return $data;
}

function Ajouter($conn, $nom, $prenom, $datenaiss, $sexe, $email, $tel, $pays, $visa) {
    try {
        $sql = "INSERT INTO client (Nom, Prénom, Date_naissance, Sexe, Email, Téléphone, Pays, Visa)
                VALUES (:nom, :prenom, :datenaiss, :sexe, :email, :tel, :pays, :visa)";
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':datenaiss' => $datenaiss,
            ':sexe' => $sexe,
            ':email' => $email,
            ':tel' => $tel,
            ':pays' => $pays,
            ':visa' => $visa
        ]);

        /*// Envoyer les informations par e-mail
        $to = "rayanbouab263@gmail.com";
        $subject = "Nouveau client ajouté";
        
        // Construire le corps de l'e-mail
        $message = "
        Un nouveau client a été ajouté avec les informations suivantes :

        Nom : $nom
        Prénom : $prenom
        Date de naissance : $datenaiss
        Sexe : $sexe
        Email : $email
        Téléphone : $tel
        Pays de destination : $pays
        Type de Visa : $visa
        ";

        // En-têtes de l'e-mail
        $headers = "From: webmaster@example.com"; // Remplacez par une adresse d'expéditeur valide
        $headers .= "Reply-To: $email";

        // Envoyer l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "Les informations du client ont été envoyées à votre e-mail.";
        } else {
            echo "Erreur lors de l'envoi de l'e-mail.";
        }*/

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <title>Formulaire d'inscription à L - Traveling</title>
</head>
<body>

<section id="notification">
  <!-- Affiche la notification si le message de succès est dans l'URL -->
  <?php if (isset($_GET['message']) && $_GET['message'] == 'success') : ?>
    <div id="notification" class="notification" style="display:block;">
      Merci de votre Inscription.
    </div>
  <?php endif; ?>
</section>

<!-- JavaScript -->
<script src="script.js"></script>

<section id="formulaire">
    <div id="myModale" class="modal">
        <!-- Contenu de la fenêtre modale -->
        <div class="formulaire">
        <h3>Formulaire d'inscription</h3>
        <form method="post" action="fonction.php">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required><br>

            <label for="datenaiss">Date de Naissance :</label>
            <input type="date" id="datenaiss" name="datenaiss" required><br>

            <label for="sexe">Sexe :</label>
            <select id="sexe" name="sexe" required>
            <option value="Homme">H</option>
            <option value="Femme">F</option>
            </select><br>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required><br>

            <label for="tel">Numéro de Téléphone :</label>
            <input type="tel" id="tel" name="tel" required><br>

            <label for="pays">Pays de destination :</label>
            <select id="pays" name="pays" required>
            <option value="Canada">Canada</option>
            <option value="France">France</option>
            </select><br>

            <label for="visa">Type de votre Visa :</label>
            <select id="visa" name="visa" required>
            <option value="Etude">Etude</option>
            <option value="Touristique">Touristique</option>
            <option value="Instalation">Instalation</option>
            </select><br>

            <input type="submit" id="Envoyer" value="Envoyer" name="Envoyer">
        </form>
        </div>
    </div>
</section>

</body>
</html>
