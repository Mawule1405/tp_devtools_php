<link rel="stylesheet" href="style.css">
<?php
   


    $menuItems = array(
        "Accueil" => "./index.php",
        "Employe" => "./employe.php",
        "Ressources" => "./ressources.php",
        "Statistiques" => "",
        "Aides" => ""
    );

    $asideItems = array(
        "Liste des employés" =>["liste-employes-id", "#"],
        "Modification d'un employé" => ["modification-employe-id", "./modifier_employe.php"],
        "Enregistrez un emloyé" =>["enregistrer-employe-id", "./enregistrer_employe.php"],
        "Suppression d'un employé" =>["supprission-employe-id", "suppression_employe.php"],
        "Gestions des services" => ["gestion-services-id", "./gestion_services.php"]
    );

    include "nav.php";
    echo create_nav_bar($menuItems);
    
    
?>

<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <main class= main>
        <article class= employes id= "liste-employes-id">
            <h1>Liste des employés</h1>
            <?php 

               
                include "fonctions.php";
                $allEmployees = getAllEmployees();
               
                // Affichage des résultats (à titre d'exemple)
                foreach ($allEmployees as $employee) {
                    $photoEmploye = localPathToUrl( $employee["photo_emp"]) ;

                    echo <<<EMP

                    <table class= table-employe>
                        <tr> 
                            <td colspan=3 >Information de l'employé(e) N°: {$employee["id_emp"]} </td>
                            

                        </tr>
                        <tr> 
                            <td rowspan = 4>  <img src="{$photoEmploye }" alt="photo de employé {$employee["id_emp"]}" srcset=""
                             width= 150px height= 150px> </td>
                            <td>Nom : {$employee["nom_emp"]}  </td>
                            <td>Prénoms : {$employee["prenom_emp"]}  </td>
                            
                        </tr>

                        <tr> 
                          
                            <td> Né(e) le : {$employee["date_nais_emp"]} </td>
                            <td> Embauché(e) le : {$employee["date_embau_emp"]}  </td>
                        </tr>

                        <tr> 
                          
                            <td>Nationalité :   {$employee["nationalite_emp"]}  </td>
                            <td>Niveau d'étude:  {$employee["niveau_etu_emp"]}   </td>
                        </tr>
                        <tr> 
                            <td> Salaire :  {$employee["salaire_emp"]}  </td>
                            <td> Lieu de résidence :  {$employee["lieu_res_emp"]} FCFA  </td>
                            
                        </tr>

                        <tr> 
                            <td colspan=2> Email :  {$employee["email_emp"]}  </td>
                            <td> Téléphone :  {$employee["contact_emp"]}   </td>
                            
                        </tr>

                        <tr> 
                            <td colspan = 2> Service :  {$employee["id_serv"]}  </td>
                            <td> Sexe :  {$employee["Sexe"]}   </td>
                            
                        </tr>
                    </table>
                   
                    EMP;
                }

            
                
            ?>
        </article>
    </main>


</div>


