<?php

function getAllCategories(){

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
    //Recherche d'un d'un consommable par l'id de la catégorie à laquelle elle appartient
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

function insertCategorie($nomCat) {
    //Insertion de la catégorie
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Vérifiez d'abord si la catégorie existe déjà
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM Categorie WHERE nom_cat = :nom");
        $checkStmt->bindParam(":nom", $nomCat);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();
        
        if ($count > 0) {
            // La catégorie existe déjà, retournez false ou une autre valeur indiquant l'échec
            return false;
        }
        
        // Insérer la catégorie si elle n'existe pas
        $stmt = $pdo->prepare("INSERT INTO Categorie (nom_cat) VALUES (:nom)");
        $stmt->bindParam(":nom", $nomCat);
        $stmt->execute();
        
        return true;
    } catch (PDOException $e) {
        var_dump($e->errorInfo);
        return false;
    }
}



function updateCategorie($idCat, $nomCat){
    //Recherche d'un d'un consommable par l'id de la catégorie à laquelle elle appartient
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("UPDATE Categorie SET nom_cat = :nom WHERE id_cat = :id");
        $stmt->bindParam(":id", $idCat);
        $stmt->bindParam(":nom", $nomCat);
        $stmt->execute();
        
        return true;
    }catch(PDOException $e){
        return false;
    }

}


function deleteCategorie($idCat){
    //Recherche d'un d'un consommable par l'id de la catégorie à laquelle elle appartient
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("DELETE FROM Categorie WHERE id_cat = :id");
        $stmt->bindParam(":id", $idCat);
      
        $stmt->execute();
        
        return true;
    }catch(PDOException $e){
        return false;
    }

}



