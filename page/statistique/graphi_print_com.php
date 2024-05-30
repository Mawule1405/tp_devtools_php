<?php


function getAllemployes() {
    //Récupération des employés
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



function getAllFournisseurs(){
    //Récupération des fournisseurs
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT * FROM Fournisseur ORDER BY nom_four");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        return false;
    }

}

function getAllCategories(){
    //Récupération des catégories
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT * FROM Categorie ORDER BY nom_cat");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        return false;
    }

}



function getConsommableWithId($idCat){
    //Recherche d'un consommable par l'id de la catégorie à laquelle elle appartient
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT * FROM Consommable WHERE id_cat= :id ORDER BY nom_cons");
        $stmt->bindParam(":id", $idCat);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        return false;
    }

}
