<?php
// Fonction pour récupérer tous les éléments de la table "Employe"
function getAllEmployees() {
    // Paramètres de connexion à la base de données
    $servername = "localhost"; // Nom du serveur MySQL
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "graphi_print"; // Nom de la base de données

    try {
        // Connexion à la base de données avec PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Définition du mode d'erreur PDO à Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour récupérer tous les éléments de la table "Employe"
        $sql = "SELECT * FROM Employe";
        // Exécution de la requête SQL
        $stmt = $conn->query($sql);
        // Récupération des résultats
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourner les résultats
        return $employees;
    } catch(PDOException $e) {
        // En cas d'erreur, afficher l'erreur
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}

function getOneEmploye($id_employe) {
    // Paramètres de connexion à la base de données
    $servername = "localhost"; // Nom du serveur MySQL
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "graphi_print"; // Nom de la base de données

    try {
        // Connexion à la base de données avec PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Définition du mode d'erreur PDO à Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour récupérer un employé par son ID
        $sql = "SELECT * FROM Employe WHERE id_emp = :id";
        // Préparation de la requête SQL
        $stmt = $conn->prepare($sql);
        // Exécution de la requête SQL en liant le paramètre :id
        $stmt->execute(array(':id' => $id_employe));
        // Récupération des résultats
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourner l'employé trouvé
        return $employee;
    } catch(PDOException $e) {
        // En cas d'erreur, afficher l'erreur
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}




?>


<?php 

    function getAllServices(){
        
    $servername = "localhost"; // Nom du serveur MySQL
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "graphi_print"; // Nom de la base de données

    try {
       
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Service";
        $stmt = $conn->query($sql);
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $services;
    } catch(PDOException $e) {
        // En cas d'erreur, afficher l'erreur
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
    }

?>
