<?php

function getAllService(){
    try {
       
        // Établir la connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        // Préparer la requête SQL pour rechercher l'employé par ID
        $stmt = $pdo->prepare("SELECT id_serv, nom_serv
                                FROM Service ORDER BY id_serv");
        
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
function getOneServiceWithId($idService){
    try {
      
        // Établir la connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        // Préparer la requête SQL pour rechercher l'employé par ID
        $stmt = $pdo->prepare("SELECT s.id_serv, nom_serv, description_serv,date_serv, id_emp_resp, photo_emp FROM Service s, Employe e WHERE s.id_serv = :id AND s.id_emp_resp = e.id_emp");
        $stmt->bindParam(":id", $idService);
        
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


function getAllEmployeReduite() {

    try {
       
        // Établir la connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        // Préparer la requête SQL pour rechercher l'employé par ID
        $stmt = $pdo->prepare("SELECT id_emp, nom_emp, prenom_emp,  photo_emp 
                                FROM Employe ORDER BY id_emp");
        
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

function updateService($idSev, $nomServ, $describeServ, $dateServ, $idResp,){
    //Mise à jour du service
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql ="UPDATE Service SET nom_serv=:nom, description_serv= :describe, date_serv= :dateS, id_emp_resp = :resp
                WHERE id_serv = :idServ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":idServ", $idSev);
        $stmt->bindParam(":nom", $nomServ);
        $stmt->bindParam(":describe", $describeServ);
        $stmt->bindParam(":dateS", $dateServ);
        $stmt->bindParam(":resp", $idResp);
        $stmt->execute();
        return True;

    }catch (PDOException $e) {
        return False;
    }
}

function insertService($nomServ, $describeServ, $dateServ, $idResp,){
    //Mise à jour du service
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql ="INSERT INTO  Service (nom_serv, description_serv, date_serv, id_emp_resp) 
                VALUES (:nom, :describe, :dateS, :resp)
                WHERE :nom NOT IN (SELECT nom_serv FROM Service)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nom", $nomServ);
        $stmt->bindParam(":describe", $describeServ);
        $stmt->bindParam(":dateS", $dateServ);
        $stmt->bindParam(":resp", $idResp);
        $stmt->execute();
        
        return True;
    }catch (PDOException $e) {
        return False;
    }
}

function deleteService($idSev){
    //Supprimer un service
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM Service WHERE id_serv=:idServ AND id_serv NOT IN (SELECT id_serv FROM Employe)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":idServ", $idSev);
        $stmt->execute();
        return True;
    }catch(PDOException $e) {
        return False;
    }
}


