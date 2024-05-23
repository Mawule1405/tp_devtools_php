<?php

function getAllemployes() {

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

function insertConsommable($nomCons, $idCat, $qteSeuil, $prixCons, $imageCons){
    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification de l'existence du consommable
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM Consommable WHERE nom_cons = :nomCons");
        $stmtCheck->bindParam(":nomCons", $nomCons);
        $stmtCheck->execute();
        $rowCount = $stmtCheck->fetchColumn();

        // Si le consommable existe déjà, retourne faux
        if ($rowCount > 0) {
            return false;
        }

        // Préparation de la requête SQL pour insérer un nouveau consommable
        $stmt = $pdo->prepare("INSERT INTO Consommable (nom_cons, id_cat, qteseuil_cons, prix_unitaire_cons, image) 
                               VALUES (:nomCons, :idCat, :qteSeuil, :prixCons, :imageCons)");
        
        // Liaison des paramètres
        $stmt->bindParam(":nomCons", $nomCons);
        $stmt->bindParam(":idCat", $idCat);
        $stmt->bindParam(":qteSeuil", $qteSeuil);
        $stmt->bindParam(":prixCons", $prixCons);
        $stmt->bindParam(":imageCons", $imageCons);

        // Exécution de la requête
        $stmt->execute();
        
        // Retourne vrai si l'insertion s'est bien déroulée
        return true;
    } catch(PDOException $e) {
        // Retourne faux en cas d'erreur
        var_dump($e->errorInfo);
        return false;
    }
}


function checkConsommableInTables($id_cons) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Vérifier dans la table Demander
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Demander WHERE id_cons = :id_cons");
        $stmt->bindParam(":id_cons", $id_cons, PDO::PARAM_INT);
        $stmt->execute();
        $countDemander = $stmt->fetchColumn();
        
        // Vérifier dans la table Appartenir
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Appartenir WHERE id_cons = :id_cons");
        $stmt->bindParam(":id_cons", $id_cons, PDO::PARAM_INT);
        $stmt->execute();
        $countAppartenir = $stmt->fetchColumn();
        
        // Retourner true si le consommable est présent dans l'une des tables, sinon false
        return ($countDemander > 0 || $countAppartenir > 0);
        
    } catch (PDOException $e) {
        // Gérer les erreurs
        var_dump($e->errorInfo);
        return false;
    }
}
function attribuerConsommable($id_cons, $id_emp, $qteDemande, $date) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Vérifier si la combinaison de ces quatre valeurs existe déjà dans la table Demander
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Demander WHERE id_cons = :id_cons AND id_emp = :id_emp AND qte_demande = :qte_demande AND date_demande = :date_cons");
        $stmt->bindParam(":id_cons", $id_cons, PDO::PARAM_INT);
        $stmt->bindParam(":id_emp", $id_emp, PDO::PARAM_INT);
        $stmt->bindParam(":qte_demande", $qteDemande, PDO::PARAM_INT);
        $stmt->bindParam(":date_cons", $date, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Insérer dans la table Demander
            $stmt = $pdo->prepare("INSERT INTO Demander (id_cons, id_emp, qte_demande, date_demande) VALUES (:id_cons, :id_emp, :qte_demande, :date_cons)");
            $stmt->bindParam(":id_cons", $id_cons, PDO::PARAM_INT);
            $stmt->bindParam(":id_emp", $id_emp, PDO::PARAM_INT);
            $stmt->bindParam(":qte_demande", $qteDemande, PDO::PARAM_INT);
            $stmt->bindParam(":date_cons", $date, PDO::PARAM_STR);
            $stmt->execute();
            
            return true;
        } else {
            // Une ligne avec ces valeurs existe déjà
            return false;
        }
    } catch (PDOException $e) {
        // Gérer les erreurs
        var_dump($e->errorInfo);
        return false;
    }
}


function deleteConsommable($idCons){
    //Supprimer un consommable par l'id 
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print","root","");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("DELETE FROM Consommable WHERE id_cons = :id");
        $stmt->bindParam(":id", $idCons);
      
        $stmt->execute();
        
        return true;
    }catch(PDOException $e){
        return false;
    }

}


function updateConsommable($idCons, $idCat, $nomCons, $prixCons, $photo) {
    //Fonction de mise à jour du consommables
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!empty($photo)) {
            // Mise à jour avec la photo
            $stmt = $pdo->prepare("
                UPDATE consommable
                SET id_cat = :idCat, nom_cons = :nomCons, prix_unitaire_cons = :prixCons, image = :photo
                WHERE id_cons = :idCons
            ");
            $stmt->bindParam(":photo", $photo);
        } else {
            // Mise à jour sans la photo
            $stmt = $pdo->prepare("
                UPDATE consommable
                SET id_cat = :idCat, nom_cons = :nomCons, prix_unitaire_cons = :prixCons
                WHERE id_cons = :idCons
            ");
        }

        $stmt->bindParam(":idCat", $idCat, PDO::PARAM_INT);
        $stmt->bindParam(":nomCons", $nomCons, PDO::PARAM_STR);
        $stmt->bindParam(":prixCons", $prixCons, PDO::PARAM_STR);
        $stmt->bindParam(":idCons", $idCons, PDO::PARAM_INT);

        $stmt->execute();
        
        return true;
    } catch (PDOException $e) {
        // Gérer les erreurs
        var_dump($e->errorInfo);
        return false;
    }
}


function getNombreCommandes() {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour compter le nombre d'éléments dans la table Commande
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Commande");
        $stmt->execute();

        // Récupération du nombre de commandes
        $nombreCommandes = $stmt->fetchColumn();

        return $nombreCommandes;
    } catch (PDOException $e) {
        // Gérer les erreurs de connexion ou d'exécution de la requête
        var_dump($e->errorInfo);
        return false;
    }
}


function insertCommande($idCom, $idEmp, $idFour, $dateCom) {
    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO Commande (id_com, id_emp, id_four, date_com) VALUES (:id_com, :id_emp, :id_four, :date_com)");

        // Liaison des paramètres
        $stmt->bindParam(':id_com', $idCom);
        $stmt->bindParam(':id_emp', $idEmp);
        $stmt->bindParam(':id_four', $idFour);
        $stmt->bindParam(':date_com', $dateCom);

        // Exécution de la requête
        $stmt->execute();

        return true; // Retourne true si l'insertion a réussi
    } catch (PDOException $e) {
        // Gérer les erreurs d'exécution de la requête
        var_dump($e->errorInfo);
        return false; // Retourne false en cas d'erreur
    }
}

function insertAppartient($idCons, $idCom, $qteCom) {
    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=graphi_print", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO Appartenir (id_cons, id_com, qte_com) VALUES (:id_cons, :id_com, :qte_com)");

        // Liaison des paramètres
        $stmt->bindParam(':id_cons', $idCons);
        $stmt->bindParam(':id_com', $idCom);
        $stmt->bindParam(':qte_com', $qteCom);

        // Exécution de la requête
        $stmt->execute();

        return true; // Retourne true si l'insertion a réussi
    } catch (PDOException $e) {
        // Gérer les erreurs d'exécution de la requête
        var_dump($e->errorInfo);
        return false; // Retourne false en cas d'erreur
    }
}




