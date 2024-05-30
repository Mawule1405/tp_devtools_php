<?php
    function getAllemploye() {

        try {
           
            // Établir la connexion à la base de données
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
           
            // Préparer la requête SQL pour rechercher l'employé par ID
            $stmt = $pdo->prepare("SELECT id_emp, nom_emp, prenom_emp, lieu_res_emp, nationalite_emp, 
                                    date_nais_emp, date_embau_emp, salaire_emp, Sexe, contact_emp, 
                                    niveau_etu_emp, email_emp, photo_emp, nom_serv 
                                    FROM Employe, Service  
                                    WHERE Employe.id_serv = Service.id_serv");
            
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer le résultat
            
            $employe = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            // Retourner le résultat
            return $employe;
    
        } catch (PDOException $e) {
            var_dump($e->errorInfo);
            return False;
        }
    }


    function getOneEmploye($id) {

        try {
           
            // Établir la connexion à la base de données
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
           
            // Préparer la requête SQL pour rechercher l'employé par ID
            $stmt = $pdo->prepare("SELECT id_emp, nom_emp, prenom_emp, lieu_res_emp, nationalite_emp, 
                                    date_nais_emp, date_embau_emp, salaire_emp, Sexe, contact_emp, 
                                    niveau_etu_emp, email_emp, photo_emp, nom_serv 
                                    FROM Employe, Service  
                                    WHERE id_emp = :id AND Employe.id_serv = Service.id_serv");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer le résultat
            
            $employe = $stmt->fetch(PDO::FETCH_ASSOC);
           
            // Retourner le résultat
            return $employe;
    
        } catch (PDOException $e) {
         
            return False;
        }
    }


    function getAllEmployeReduite() {

        try {
           
            // Établir la connexion à la base de données
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
           
            // Préparer la requête SQL pour rechercher l'employé par ID
            $stmt = $pdo->prepare("SELECT id_emp, nom_emp, prenom_emp,  photo_emp 
                                    FROM Employe ");
            
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer le résultat
            
            $employe = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            // Retourner le résultat
            return $employe;
    
        } catch (PDOException $e) {
         
            return False;
        }
    }

    function getAllService(){
        try {
           
            // Établir la connexion à la base de données
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
           
            // Préparer la requête SQL pour rechercher l'employé par ID
            $stmt = $pdo->prepare("SELECT id_serv, nom_serv
                                    FROM Service");
            
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer le résultat
            
            $employe = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            // Retourner le résultat
            return $employe;
    
        } catch (PDOException $e) {
         
            return False;
        }
    }
    

    //Get id of service with name
    function getOneServiceWithName($nameService){
        try {
           print_r($nameService);
            // Établir la connexion à la base de données
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
           
            // Préparer la requête SQL pour rechercher l'employé par ID
            $stmt = $pdo->prepare("SELECT id_serv FROM Service WHERE nom_serv = :nom");
            $stmt->bindParam(":nom", $nameService);
            
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer le résultat
            
            $service = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
            // Retourner le résultat
            return $service;

    
        } catch (PDOException $e) {
         
            return False;
        }
    }


    //Fonction pour mettre à jour les information d'un employé
    function updateEmploye($id_e, $nom_e, $prenom_e, $sexe_e, $nationalite_e, $residence_e, $salaire_e, $email_e, $contact_e, $dateNais_e, 
                            $dateEmbau_e, $niveau_e,$idserv_e ,$image_e){
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE Employe
                    SET nom_emp = :nom , prenom_emp = :prenom, Sexe = :sexe, nationalite_emp = :nationalite, lieu_res_emp = :residence,
                        salaire_emp = :salaire, email_emp = :email, contact_emp = :contact, date_nais_emp = :datenais, date_embau_emp = :dateembau,
                        id_serv = :idserv, niveau_etu_emp = :niveau, photo_emp = :photo
                    WHERE id_emp = :id";

            $bind= $pdo->prepare($sql);
            $bind->bindParam(":id", $id_e);
            $bind->bindParam(":nom", $nom_e);
            $bind->bindParam(":prenom", $prenom_e);
            $bind->bindParam(":sexe", $sexe_e);
            $bind->bindParam(":nationalite", $nationalite_e);
            $bind->bindParam(":residence", $residence_e);
            $bind->bindParam(":salaire", $salaire_e);
            $bind->bindParam(":email", $email_e);
            $bind->bindParam(":contact", $contact_e);
            $bind->bindParam(":datenais", $dateNais_e);
            $bind->bindParam(":dateembau", $dateEmbau_e);
            $bind->bindParam(":niveau", $niveau_e);
            $bind->bindParam(":idserv", $idserv_e);
            $bind->bindParam(":photo", $image_e);
            
        
            $bind->execute();

            return true;

        }catch(PDOException $e){
            var_dump($e->errorInfo);
            return false;
        }
    }



    function insertEmploye($nom_e, $prenom_e, $sexe_e, $nationalite_e, $residence_e, $salaire_e, $email_e, $contact_e, $dateNais_e, 
                            $dateEmbau_e, $niveau_e, $idserv_e, $image_e) {
    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour insérer un nouvel employé
        $sql = "INSERT INTO Employe ( nom_emp, prenom_emp, Sexe, nationalite_emp, lieu_res_emp, salaire_emp, email_emp, 
                                      contact_emp, date_nais_emp, date_embau_emp, id_serv, niveau_etu_emp, photo_emp)
                VALUES ( :nom, :prenom, :sexe, :nationalite, :residence, :salaire, :email, :contact, :datenais, :dateembau, :idserv, :niveau, :photo)";

        // Préparation de la requête
        $bind = $pdo->prepare($sql);

        // Association des paramètres
       
        $bind->bindParam(":nom", $nom_e);
        $bind->bindParam(":prenom", $prenom_e);
        $bind->bindParam(":sexe", $sexe_e);
        $bind->bindParam(":nationalite", $nationalite_e);
        $bind->bindParam(":residence", $residence_e);
        $bind->bindParam(":salaire", $salaire_e);
        $bind->bindParam(":email", $email_e);
        $bind->bindParam(":contact", $contact_e);
        $bind->bindParam(":datenais", $dateNais_e);
        $bind->bindParam(":dateembau", $dateEmbau_e);
        $bind->bindParam(":niveau", $niveau_e);
        $bind->bindParam(":idserv", $idserv_e);
        $bind->bindParam(":photo", $image_e);

        // Exécution de la requête
        $bind->execute();

        return true;
    } catch (PDOException $e) {
        // Affichage de l'erreur
        var_dump($e->errorInfo);
        return false;
    }
}
