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


function mettreAJourEmploye($id_employe, $nom, $prenom, $email, $date_naiss, $date_embau, $salaire, $nationalite, $niveau_etu, 
                            $residence, $contact, $photo, $id_service, $sexe) {
    // Assurez-vous de sécuriser vos données avant de les utiliser dans des requêtes SQL pour éviter les attaques par injection SQL

    // Par exemple, utilisez des requêtes préparées avec PDO ou MySQLi
    // Voici un exemple d'utilisation de PDO :

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');

        // Préparez la requête SQL
        $stmt = $pdo->prepare("UPDATE Employe SET nom_emp = :nom, prenom_emp = :prenom, email_emp = :email, date_nais_emp = :date_naiss, date_embau_emp = :date_embau, salaire_emp = :salaire, nationalite_emp = :nationalite, niveau_etu_emp = :niveau_etu, lieu_res_emp = :residence, contact_emp = :contact, photo_emp = :photo, id_serv = :id_service, Sexe = :sexe WHERE id_emp = :id_employe");

        // Liez les valeurs aux paramètres de la requête
        $stmt->bindParam(':id_employe', $id_employe);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':date_naiss', $date_naiss);
        $stmt->bindParam(':date_embau', $date_embau);
        $stmt->bindParam(':salaire', $salaire);
        $stmt->bindParam(':nationalite', $nationalite);
        $stmt->bindParam(':niveau_etu', $niveau_etu);
        $stmt->bindParam(':residence', $residence);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':id_service', $id_service);
        $stmt->bindParam(':sexe', $sexe);

        // Exécutez la requête
        $stmt->execute();
        var_dump("Mise à jour réussie");
        return TRUE;
    } catch(PDOException $e) {
        var_dump($e);
        return FALSE;
    }

    // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
}


function insertOneEmploye($infoEmploye){
    // Paramètres de connexion à la base de données
    $servername = "localhost"; // Nom du serveur MySQL
    $username = "root"; // Nom d'utilisateur MySQL
    $password = ""; // Mot de passe MySQL
    $dbname = "graphi_print"; // Nom de la base de données

    try {
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM Employe WHERE id_emp = :id";
      
        $stmt = $conn->prepare($sql);
        $id_employe = $infoEmploye["id_emp"];
       
        $stmt->execute(array(':id' => $id_employe));
      
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;
        return $employee;
    } catch(PDOException $e) {
    
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



    function getAllServicesAndResponsable(){
        
        $servername = "localhost"; // Nom du serveur MySQL
        $username = "root"; // Nom d'utilisateur MySQL
        $password = ""; // Mot de passe MySQL
        $dbname = "graphi_print"; // Nom de la base de données
    
        try {
           
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT s.id_serv, nom_serv, description_serv, date_serv,nom_emp,prenom_emp FROM Service s, Employe e WHERE id_emp_resp = id_emp ";
            $stmt = $conn->query($sql);
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $services;
        } catch(PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        }


    function getOneService($id_serv){
        
                $servername = "localhost"; // Nom du serveur MySQL
                $username = "root"; // Nom d'utilisateur MySQL
                $password = ""; // Mot de passe MySQL
                $dbname = "graphi_print"; // Nom de la base de données
            
                try {
                
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM Service  WHERE id_serv= $id_serv";
                    $stmt = $conn->query($sql);
                    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $conn = null;
                    return $services;
                } catch(PDOException $e) {
                    // En cas d'erreur, afficher l'erreur
                    echo "Erreur de connexion à la base de données : " . $e->getMessage();
                }
        }


        

        function mettreAJourService($idServ, $nomServ, $descServ, $dateServ, $respServ) {
            // Assurez-vous de sécuriser vos données avant de les utiliser dans des requêtes SQL pour éviter les attaques par injection SQL
            // Par exemple, utilisez des requêtes préparées avec PDO ou MySQLi
            // Voici un exemple d'utilisation de PDO :

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');

                // Préparez la requête SQL
                $stmt = $pdo->prepare("UPDATE Service SET nom_serv = :nom, description_serv = :descr, date_serv = :datex, id_emp_resp = :resp WHERE id_serv = :id_serv");

                // Liez les valeurs aux paramètres de la requête
                $stmt->bindParam(':id_serv', $idServ);
                $stmt->bindParam(':nom', $nomServ);
                $stmt->bindParam(':descr', $descServ);
                $stmt->bindParam(':datex', $dateServ);
                $stmt->bindParam(':resp', $respServ);

                // Exécutez la requête
                $stmt->execute();
                return TRUE;
            } catch(PDOException $e) {
                var_dump($e);
                return FALSE;
            }

            // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
        }


        function insererService( $idServ,$nomServ, $descServ, $dateServ, $respServ) {
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');
        
                // Préparez la requête SQL pour l'insertion
                $stmt = $pdo->prepare("INSERT INTO Service (id_serv, nom_serv, description_serv, date_serv, id_emp_resp) VALUES (:id, :nom, :descr, :datex, :resp)");
        
                // Liez les valeurs aux paramètres de la requête
                $stmt->bindParam(':id', $idServ);
                $stmt->bindParam(':nom', $nomServ);
                $stmt->bindParam(':descr', $descServ);
                $stmt->bindParam(':datex', $dateServ);
                $stmt->bindParam(':resp', $respServ);
        
                // Exécutez la requête
                $stmt->execute();
                return TRUE;
            } catch(PDOException $e) {
                return FALSE;
            }
        
            // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
        }
        



        function supprimerService($idServ) {
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');
        
                // Préparez la requête SQL pour la suppression
                $stmt = $pdo->prepare("DELETE FROM Service WHERE id_serv = :id_serv");
        
                // Liez l'id_serv au paramètre de la requête
                $stmt->bindParam(':id_serv', $idServ);
        
                // Exécutez la requête
                $stmt->execute();
                return TRUE;
            } catch(PDOException $e) {
                return FALSE;
            }
        
            // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
        }
        


?>


<?php 
    //Tous ce qui concerne la gestion des catégories de consommables
    function getAllCategories(){
        
        $servername = "localhost"; // Nom du serveur MySQL
        $username = "root"; // Nom d'utilisateur MySQL
        $password = ""; // Mot de passe MySQL
        $dbname = "graphi_print"; // Nom de la base de données
    
        try {
           
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM Categorie";
            $stmt = $conn->query($sql);
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $services;
        } catch(PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        }


        function getOneCategorie($id){
        
            $servername = "localhost"; // Nom du serveur MySQL
            $username = "root"; // Nom d'utilisateur MySQL
            $password = ""; // Mot de passe MySQL
            $dbname = "graphi_print"; // Nom de la base de données
        
            try {
               
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM Categorie WHERE id_cat=$id";
                $stmt = $conn->query($sql);
                $categorie = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $conn = null;
                return $categorie;
            } catch(PDOException $e) {
                $reponse = $e;
               
            }
            }


            function insererCategorie( $idCat,$nomCat) {
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');
            
                    // Préparez la requête SQL pour l'insertion
                    $stmt = $pdo->prepare("INSERT INTO Categorie (id_cat, nom_cat) VALUES (:id, :nom)");
            
                    // Liez les valeurs aux paramètres de la requête
                    $stmt->bindParam(':id', $idCat);
                    $stmt->bindParam(':nom', $nomCat);
            
                    // Exécutez la requête
                    $stmt->execute();
                    return TRUE;
                } catch(PDOException $e) {

                    return FALSE;
                }
            
                // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
            }



            function mettreAjourCategorie( $idCat,$nomCat) {
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root', '');
            
                    // Préparez la requête SQL pour l'insertion
                    $stmt = $pdo->prepare("UPDATE Categorie SET  nom_cat = :nom WHERE id_cat = :id");
            
                    // Liez les valeurs aux paramètres de la requête
                    $stmt->bindParam(':id', $idCat);
                    $stmt->bindParam(':nom', $nomCat);
            
                    // Exécutez la requête
                    $stmt->execute();
                    return TRUE;
                } catch(PDOException $e) {

                    return FALSE;
                }
            
                // N'oubliez pas de gérer les exceptions et les erreurs appropriées selon vos besoins
            }


            function supprimerCategorie($idCat){
                /* La fonction permet de supprimer une catégorie de consommables grâce à son id
                    @parameter : $idCat: int 
                    @return : boolean
                */

                try{
                    $pdo = new PDO('mysql:host=localhost;dbname=graphi_print', 'root','');
                    $sql = $pdo->prepare("DELETE FROM Categorie WHERE id_cat= :id");
                    $sql->bindParam(':id',$idCat);
                    $sql->execute();
                    return TRUE;
                }
                catch(PDOException $e){
                    return FALSE;
                }
            }

?>



<?php  
    function getAllConsommables(){
        
        $servername = "localhost"; // Nom du serveur MySQL
        $username = "root"; // Nom d'utilisateur MySQL
        $password = ""; // Mot de passe MySQL
        $dbname = "graphi_print"; // Nom de la base de données
    
        try {
           
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM Consommable";
            $stmt = $conn->query($sql);
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $services;
        } catch(PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }


    function getOneConsommable($idCons){
        /* 
            function de récupération d'un consommables existants dans la base de données
            @param : id_cons
            @return: un array contenant le information du consommable s'il est trouvé. 
        */

        try{
            
            $conn = new PDO("mysql:host=localhost;dbname=graphi_print", 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM Consommable WHERE id_cons = $idCons";
            $stmt = $conn->query($sql);
            $conso = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $conso;
            

        }catch(PDOException $e){
            $reponse =$e;
        }
    }


    function getConsommablesOfCategorie($id){
        /* 
         Cette fonction permet de récupérer tous les consommables appartement à une catégorie données
        
        */
        $servername = "localhost"; // Nom du serveur MySQL
        $username = "root"; // Nom d'utilisateur MySQL
        $password = ""; // Mot de passe MySQL
        $dbname = "graphi_print"; // Nom de la base de données
    
        try {
           
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT id_cons, nom_cons, qtestock_cons, qteseuil_cons FROM Consommable WHERE id_cat=$id";
            $stmt = $conn->query($sql);
            $consommable = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conn = null;
            return $consommable;
        } catch(PDOException $e) {
            $reponse = $e;
           
        }
        }

    function mettreAjourConsommable($idCons,$nomCons, $idCat){
        /* 
            Function de mise à jour des informations d'un consommable
            @paraam: id_conso, nom_cons, id_cat
            @return: Boolean 
        */

        
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print",'root','');
            $sql = $pdo->prepare("UPDATE Consommable SET nom_cons= :nomcons, id_cat= :idcat WHERE id_cons = :idcons");
            
            $sql->bindParam(":idcons", $idCons);
            $sql->bindParam(":nomcons", $nomCons);
            $sql->bindParam(":idcat", $idCat);
            $sql->execute();

            return TRUE;


        }catch(PDOException $e){
            return FALSE;
        }
    }

    function insererConsommable($idCons, $nomCons, $puCons, $qteSeuilCons, $qtestockCons, $idCategorie){
        /* 
            Function pour insérer des consommables dans la base de données
            @param: id_cons, nom_cons, prix_unitaire_cons, qteseuil_cons, qtestock_cons, id_cat
            @return: Boolean 
        */

        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print",'root','');
            $sql = $pdo->prepare("INSERT INTO Consommable (id_cons, nom_cons, prix_unitaire_cons, qteseuil_cons, qtestock_cons, id_cat) VALUES (:idcons, :nomcons, :pucons, :qteseuilcons, :qtestockcons, :idcat)");

            $sql->bindParam(':idcons',$idCons );
            $sql->bindParam(':nomcons', $nomCons);
            $sql->bindParam(':pucons', $puCons);
            $sql->bindParam(':qteseuilcons',$qteSeuilCons);
            $sql->bindParam(':qtestockcons', $qtestockCons);
            $sql->bindParam(':idcat', $idCategorie);

            $sql->execute();

            return TRUE;
        }catch(PDOException $e){
            return FALSE;
        }

    }
?>


<?php

    /*  
        ===================================
        GESTION DES DEMANDES (ATTRIBUTIONS)
        ===================================
    */
    function insererDemande($idEmp, $idCons, $qteDemande, $date){
        /* 
            Cette fonction permet d'insérer des données dans la tables demandes:
            @param: id_emp, id_cons, ate_demande, date de la demande
            return : None
        */

        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", 'root', '');
            $sql = $pdo->prepare("INSERT INTO Demander (id_emp, id_cons, qte_demande, date_demande) VALUES (:idemp, :idcons, :qtedemande, :datedemande)");

            $sql->bindParam(":idemp",$idEmp);
            $sql->bindParam(":idcons", $idCons);
            $sql->bindParam(":qtedemande", $qteDemande);
            $sql->bindParam(":datedemande", $date);
            $sql->execute();

            }catch(PDOException $e){
                return FALSE;
            }


    }



    
?>


<?php
    /*
        =========================================
        GESTION DES COMMANDES (APPROVISIONNEMENT)
        =========================================
    */

    function derniereCommande(){
        /*  
            Cette fonction permet de récupérer l'id de la dernière commande effectuée
        */
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $pdo->prepare("SELECT id_com FROM Commande ORDER BY id_com DESC LIMIT 1");
            $sql->execute();
            $id = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $id[0]["id_com"];

        }catch(PDOException $e){
           
            return FALSE;
        }
    }


    function insererCommande( $id_com, $datecom, $idemp, $idfourn){
        /* 
        Fonction permettant d'insérer des données dans la table commande
        @param: date de la commande, id de l'employé ayant effectué la commande, id du fournisseur chez qui la commande a été effectué
        */
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
            $sql = $pdo->prepare("INSERT INTO Commande (id_com, date_com, id_emp, id_four) VALUES (:idcom, :datecom, :id_emp, :id_four)");

            $sql->bindParam(":idcom",$id_com);
            $sql->bindParam(":datecom", $datecom);
            $sql->bindParam(":id_emp", $idemp);
            $sql->bindParam(":id_four", $idfourn);
            $sql->execute();
            return TRUE;
        }catch(PDOException $e){
            return FALSE;
        }

    }



    function insererAppartenir($idcons, $idcom, $qte){
        /* 
        Fonction permettant d'insérer des données dans la table Appartenir
        @param: id du consommable commande, id la commande, quantité du consommable commandé  
        
        */
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
            $sql = $pdo->prepare("INSERT INTO Appartenir (id_com, id_cons, qte_com) VALUES (:idcom, :idcons, :qtecom)");

            $sql->bindParam(":idcons", $idcons);
            $sql->bindParam(":idcom", $idcom);
            $sql->bindParam(":qtecom", $qte);
            $sql->execute();
            $pdo->commit();
            return TRUE;
        }catch(PDOException $e){
            return FALSE;
        }

    }
?>


<?php
    /* 
    ===========================================================
    GESTION DES OURNISSEURS
    ===========================================================
    */

    function getAllFournisseurs(){
        /* 
            La fonction permet  récupérer tous les employés de la base de données

        */

        try{

            $dpo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
            $dpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $dpo->prepare("SELECT * FROM Fournisseur");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;

        }catch(PDOException $e)
        {
            
            return FALSE;
        }
    }

?>