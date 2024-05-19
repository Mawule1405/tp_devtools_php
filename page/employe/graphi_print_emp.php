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

?>