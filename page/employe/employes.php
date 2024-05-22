<?php

include "un_employe.php";
$modifierAvant = 0;
$modifierApres =0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données envoyées via POST
   
    if($_POST['action'] === 'Sauvegarder'){
        //Recupération des données
        $idEmploye = intval($_POST['id_emp']);
        $nomEmploye = $_POST['nom_emp'];
        $prenomEmploye = $_POST['prenom_emp'];
        $sexeEmploye = $_POST['sexe_emp'];
        $nationaliteEmploye = $_POST['nationalite_emp'];
        $lieuResEmploye = $_POST['lieu_res_emp'];
        $salaireEmploye = floatval($_POST['salaire_emp']);
        $emailEmploye = $_POST['email_emp'];
        $contactEmploye = $_POST['contact_emp'];
        $dateNaisEmploye = $_POST['date_nais_emp'];
        $dateEmbauEmploye = $_POST['date_embau_emp'];
        $serviceEmploye = $_POST['nom_serv'];
        $niveauEtudeEmploye = $_POST['niveau_etu_emp'];
        
        //Téléchargement de la photo
        $dossierTelechargement = "C:/wamp64/www/DEV_VERSION_2/image/photo_employe/";
        $cheminFichierCible ="";
        if(isset($_FILES)){
            $fichierTelecharge = $_FILES['photo_emp'];
            $nomFichier = basename($fichierTelecharge['name']);
            $cheminFichierCible = $dossierTelechargement . $nomFichier;

            // Vérifiez si le dossier de destination existe, sinon créez-le
            if (!file_exists($dossierTelechargement)) {
                mkdir($dossierTelechargement, 0777, true);
            }
            // Déplacer le fichier téléchargé vers le dossier cible
            if (!move_uploaded_file($fichierTelecharge['tmp_name'], $cheminFichierCible)) {
                $nomFichier = $_POST['photo_emp_ent'];
                $cheminFichierCible = $dossierTelechargement.$nomFichier;
                
            } 
        }
        
       
        $idService =getOneServiceWithName($serviceEmploye)[0]["id_serv"];
    
        if ($modifierAvant === 0 && $modifierApres === 0){
            $answer = updateEmploye($idEmploye, $nomEmploye, $prenomEmploye, $sexeEmploye, $nationaliteEmploye,$lieuResEmploye, $salaireEmploye
                                    , $emailEmploye, $contactEmploye, $dateNaisEmploye, 
                            $dateEmbauEmploye, $niveauEtudeEmploye,$idService ,$cheminFichierCible);
            echo $answer;

            if($answer){
                echo "supper";
                $modifierApres =1;
            }else{
                $modifierApres = 0;
            }
        }
        
        
        

        
    }elseif($_POST['action'] === "enregistrernouvel"){
        
        $idEmploye = $_POST['id_emp_new'];
        $nomEmploye = $_POST['nom_emp_new'];
        $prenomEmploye = $_POST['prenom_emp_new'];
        $sexeEmploye = $_POST['Sexe_new'];
        $nationaliteEmploye = $_POST['nationalite_emp_new'];
        $lieuResEmploye = $_POST['lieu_res_emp_new'];
        $salaireEmploye = $_POST['salaire_emp_new'];
        $emailEmploye = $_POST['email_emp_new'];
        $contactEmploye = $_POST['contact_emp_new'];
        $dateNaisEmploye = $_POST['date_nais_emp_new'];
        $dateEmbauEmploye = $_POST['date_embau_emp_new'];
        $serviceEmploye = $_POST['nom_serv_new'];
        $niveauEtudeEmploye = $_POST['niveau_etu_emp_new'];

        //Téléchargement de la photo
        $dossierTelechargement = 'C:/wamp64/www/DEV_VERSION_2/image/photo_employe/';
        $cheminFichierCible ="";
        if(isset($_FILES)){
            $fichierTelecharge = $_FILES['photo_emp_new'];
            $nomFichier = basename($fichierTelecharge['name']);
            $cheminFichierCible = $dossierTelechargement . $nomFichier;

            // Vérifiez si le dossier de destination existe, sinon créez-le
            if (!file_exists($dossierTelechargement)) {
                mkdir($dossierTelechargement, 0777, true);
            }
            // Déplacer le fichier téléchargé vers le dossier cible
            if (!move_uploaded_file($fichierTelecharge['tmp_name'], $cheminFichierCible)) {
                $nomFichier = $_POST['photo_emp_new_ent'];
                $cheminFichierCible = $dossierTelechargement."photo_de_profile.jpeg";
                
            }

        }
        echo $cheminFichierCible;
        var_dump($_FILES);
        var_dump($_POST);
    }
    elseif($_POST['action']==="supprimerEmployeConfirme"){
        var_dump($_POST);
    }
    elseif($_POST['action']==="exporterEmployeInfo"){
        var_dump($_POST);
    }


    

    // Ici, vous pouvez ajouter le code pour traiter ces données, comme les enregistrer dans une base de données
}else{
    echo "nnnnnnnnnnnnnnnnnnnnnn";
}

  
?>

<link rel="stylesheet" href="style_employe.css">


<main class = "body-card">
    
    <aside class="aside-card">
        <form action="" method="post" id="recherche-forme" class="search-form">
            <input type="search" name="recherche" id="recherche" class="search-input" placeholder="Rechercher...">
        </form>
        <!--Affichage des informations réduites des employés  -->
        <?php 
                $employesReduites = getAllEmployeReduite();
                //Affichage de tous les employés
                
            
                foreach($employesReduites as $index => $employe){
                    if($employe) {
                        buildEmployeReduite($employe);
                    }
                }
        ?>
    </aside>

    <article >

        <div class="article-card" >
            <form action="" method="post" id="enregistrement-forme" class="enregistrer-form">
                <button type="button" name="enregistrerEmploye" id="enregistrerEmploye" onclick="enregistrerNouvelEmploye()">Enrégistrer un(e) nouvel(le) employé(e)</button>
            </form>
            <!--Affichage des informations détaillés des employés  -->
            <?php  
            
                $employes = getAllEmploye();
        
                //Affichage de tous les employés
                

                foreach($employes as $index => $employe){
                    if($employe) {
                        buildEmploye($employe);
                        
                    }
                }
            ?>
        </div>
    </article>
</main>

