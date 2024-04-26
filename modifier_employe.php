<link rel="stylesheet" href="style.css">

<?php
   

    include "fonctions.php";
    include "nav.php";
    include "graphi_print.php";

    $menuItems = array(
        "Accueil" => "./index.php",
        "Employe" => "./employe",
        "Ressources" => "",
        "Statistiques" => "",
        "Aides" => ""
    );

    $asideItems = array(
        "Liste des employés" =>["liste-employes-id", "./employe.php"],
        "Modification d'un employé" => ["modification-employe-id", "./modifier_employe.php"],
        "Recherche d'un emloyé" =>["recherche-employe-id", "#"],
        "Suppression d'un employé" =>["supprission-employe-id", "#"],
        "Gestions des services" => ["gestion-services-id", "#"]
    );

    
    echo create_nav_bar($menuItems);
    $services = getAllServices();
   
    #Vérification des valeurs de recherches
    $option_de_recherche = "";
    $id_employe = 0;
    $nom ="";
    $prenom ="";
    $email ="";
    $date_naiss ="";
    $date_embau ="";
    $salaire = 0;
    $nationalite = "";
    $niveau_etu = "";
    $residence = "";
    $contact = "";
    $photo = "";
    $service = "";
    $sexe = "";

    
    if(!empty($_GET) ){
       
        $option_de_recherche = $_GET["option-recherche"];
        $id_employe = intval( explode(" ", $option_de_recherche)[0]);
    }else{
        $id_employe =1;
    }
    
?>

<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <main class= main>
        
        <?php
         
        $employees = getAllEmployees();
        $options = create_employe_options($employees);
        
        ?>

        <!-- Traitement et opération à effectuer sur les employés -->
        <article id=modification-id>
            <h1>Modification des informations d'un employé</h1>
            <?php $employe = getOneEmploye($id_employe);
                $nom = $employe["nom_emp"];
                $prenom = $employe["prenom_emp"];
                $email =$employe["email_emp"];
                $date_naiss =$employe["date_nais_emp"];
                $date_embau =$employe["date_embau_emp"];
                $salaire = $employe["salaire_emp"];
                $nationalite = $employe["nationalite_emp"];
                $niveau_etu = $employe["niveau_etu_emp"];
                $residence = $employe["lieu_res_emp"];
                $contact = $employe["contact_emp"];
                $photo = $employe["photo_emp"];
                $service = $employe["id_serv"];
                $sexe = $employe["Sexe"];
                
                
            ?>
            <div class= container-formulaire  id = "container-formulaire">
                
                <form action="./modifier_employe.php" method="get" id = formulaire>
                    <table id= table-employe >
                        <tr>
                            <td>
                                <select name="option-recherche" id="option-recherche" >
                                    <?php 
                                        foreach($options as $index => $option){
                                            // Vérifier si l'option est sélectionnée
                                            $selected = ($option == $option_de_recherche) ? "selected" : "";
                                            echo  "<option value='$option' $selected> $option </option>";
                                        }
                                    ?>
                                </select>
                            </td>

                            <td>Nom : </td>
                            <td> <input type="text" name="nom" id="nom" value = <?php if(isset($nom)) echo $nom;?>></td>
                        </tr>



                        <tr>
                            
                            <td><input type="submit" value="Recherche" ></td>
                            <td>Prénom : </td>
                            <td> <input type="text" name="prenom" id="prenom" value = "<?php if(isset($prenom)) echo $prenom;?>"></td>
                        </tr>


                        <tr>
                            <td rowspan = 4 id= image-td><img src="<?php echo localPathToUrl($photo) ?>" alt="Photo de l'employé <?php $id_employe ?> id= image-employe" srcset=""
                            width= 150px height = 150px></td>
                            <td>Sexe : </td>
                            <td>  
                                        <select name="sexe" id="sexe" >
                                        <?php 
                                            $sexe_options = ["Masculin","Féminin"];
                                            foreach($sexe_options as $index => $type){
                                               
                                                // Vérifier si l'option est sélectionnée
                                                $selected = ($type == $sexe) ? "selected" : "";
                                                echo  "<option value='$type' $selected> $type </option>";
                                            }
                                        ?>
                                    </select>
                            </td>
                        </tr>

                        <tr>
                            
                            <td>Nationalité : </td>
                            <td> <input type="text" name="nationalite" id="nationalite" value = <?php if(isset($nationalite)) echo $nationalite;?>></td>
                        </tr>

                        <tr>
                            
                            <td>Lieu de résidence : </td>
                            <td> <input type="text" name="residence" id="residence" value = "<?php if(isset($residence)) echo $residence;?>"></td>
                        </tr>


                        <tr>
                            
                            <td>Salaire (FCFA) : </td>
                            <td> <input type="number" name="salaire" id="salaire" value = "<?php if(isset($salaire)) echo $salaire;?>"></td>
                        </tr>


                        <tr>
                            <td><input type="file" value="Changer l'imagne" ></td>
                            <td>Email : </td>
                            <td> <input type="email" name="email" id="email" value = "<?php if(isset($email)) echo $email;?>"></td>
                        </tr>

                        <tr>
                            <td rowspan= 4></td>
                            <td>Téléphone : </td>
                            <td> <input type="text" name="contact" id="contact" value = "<?php if(isset($contact)) echo $contact;?>"></td>
                        </tr>


                        <tr>
                           
                            <td>Date de naissance </td>
                            <td><input type="date" name="date_naiss" id="date_naiss" value = <?php if(isset($date_naiss)) echo $date_naiss;?>></td>
                           
                        </tr>

                        <tr>
                            
                            <td>Date d'embauche </td>
                            <td> <input type="date" name="date_embau" id="date_embau" value = <?php if(isset($date_embau)) echo $date_embau;?>></td>
                        </tr>



                        <tr>
                            
                            <td>Service: </td>
                            <td>
                                <select name="service" id="service" >
                                        <?php 
                                            $services = getAllServices();
                                            $services_options = create_service_options($services);
                                         
                                            foreach($services_options as $index => $op){
                                            
                                                // Vérifier si l'option est sélectionnée
                                                $selected = ($index == $service) ? "selected" : "";
                                                echo  "<option value='$index.service' $selected> $op </option>";
                                            }
                                        ?>
                                    </select>
                                
                            </td>
                        </tr>



                        <tr>
                            <td><input type="submit" value="Soumettre" ></td>
                            <td>Niveau d'étude: </td>
                            <td> <input type="text" name="niveau_etu" id="niveau_etu" value = <?php if(isset($niveau_etu)) echo $niveau_etu;?>></td>
                        </tr>


                        
                    </table>
                    
                </form>
            </div>

        </article>
    </main>


</div>


