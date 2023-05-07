<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LeSuperCoin">
    <title>SuperBackOffice</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php
    $servername = "localhost"; // Nom du serveur où se trouve la base de données
    $username = "root"; // Nom d'utilisateur pour accéder à la base de données
    $password = ""; // Mot de passe pour accéder à la base de données
    $dbname = "mastertheweb"; // Nom de la base de données
    
    // Crée une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    function checkAdminAccess() {
      // Vérifier si l'utilisateur est connecté
      if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
      }
      
      // Vérifier si l'utilisateur a le droit admin
      if ($_SESSION['Droits'] !== 'admin') {
        header("Location: reject.php");
        exit();
      }
    }
    ?>
</head>
<body>
    <div class="header d-flex">
        <img src="../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo"/>
        <div class="user-info">
            <img src="../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp"/>
            <div class="username mt-2 col-md-3 ">
            <?php 
            session_start();
            if (!isset($_SESSION['Pseudo'])) {
                $_SESSION['Pseudo'] = "root";
            }
            echo $_SESSION['Pseudo'];
            ?>
            </div>
            <button class="logout-button">Déconnexion</button>
        </div>
    </div>
    <div class="container">
        <div class="column-left" id="left">
            <h2>Menu</h2>
            <ul>
                <li><a href="../connect.php">Accueil</a></li>
                <li><a href="./backoffice.php">BackOffice</a></li>
                <li><a href="./user.php">Utilisateurs</a></li>
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <?php
            function modifier_topic($id_topic, $nouveau_titre, $nouveau_contenu) {
                global $conn;

                $stmt = $conn->prepare("UPDATE Topic SET titre = ?, contenu = ? WHERE id_topic = ?");

                if (!$stmt) {
                    die("Erreur de préparation de la requête : " . $conn->error);
                }

                $stmt->bind_param("ssi", $nouveau_titre, $nouveau_contenu, $id_topic);

                if (!$stmt->execute()) {
                    die("Erreur d'exécution de la requête : " . $stmt->error);
                }

                $stmt->close();

                if (isset($_POST['updateTopic'])) {
                $id_topic = $_POST['id_Topic'];
                $id_createur = $_POST['Id_créateur'];
                $createdate = $_POST['Date_création'];
                $useriduser = $_POST['Utilisateur_id_Utilisateur'];
                $commentidcomment = $_POST['Commentaires_id_Commentaires'];
                $sql = "UPDATE `topics` SET `Id_Topic` = '$id', `Id_créateur` = '$title', `Date_création` = '$date', `Utilisateur_id_Utilisateur` = '$useriduser', `Commentaires_id_Commentaires` = '$commentidcomment' WHERE `topics`.`Id_Topic` = $id;";

                if ($conn->query($sql) === TRUE) {
                    echo "Super Topic modifié avec succès !";
                } else {
                    echo "Erreur lors de la modification du SuperTopic: " . $conn->error;
                }
                }                
            }
        ?>
        <h3>Topics</h3>
        <p>Contenu de l'onglet Topics.</p>
        <form method="POST">
            <label for="id">ID du topic à modifier:</label>
            <input type="text" name="id" required>
            <br>
            <label for="title">Titre:</label>
            <input type="text" name="title">
            <br>
            <label for="content">Contenu:</label>
            <textarea name="content"></textarea>
            <br>
            <button type="submit" name="updateTopic">Modifier</button>
        </form>
    </div>
</body>
</html>