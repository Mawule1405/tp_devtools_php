<link rel="stylesheet" href="style.css">

<?php
    ini_set('upload_max_filesize', '10M');

    include "fonctions.php";
    include "nav.php";


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
        "Enrégistrez un emloyé" =>["enregistrer-employe-id", "./enregistrer_employe.php"],
        "Suppression d'un employé" =>["supprission-employe-id", "./supprimer_employe.php"],
        "Gestions des services" => ["gestion-services-id", "./gestion_services.php"]
    );

    
    echo create_nav_bar($menuItems);
    $services = getAllServices();
    $reponse = FALSE;

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
    $photo = "C:\wamp64\www\DEV\image\images_app\pgoto_de_profile.jpeg";
    $service = "";
    $sexe = "";

    if(isset($_GET["recherche"])){
        $option_de_recherche = $_GET["option-recherche"];
        $id_employe = intval( explode(" ", $option_de_recherche)[0]);

    }
    elseif( isset($_GET["soumettre"]) ){
       
        $option_de_recherche = $_GET["option-recherche"];
        $id_employe = intval( explode(" ", $option_de_recherche)[0]);
        

    
        //vérification avant suppression de données
        
        if($resultat){
        
            
        
            if($reponse){
                
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
                $photo = "C:\wamp64\www\DEV\image\images_app\pgoto_de_profile.jpeg";
                $service = "";
                $sexe = "";     
            }
        }
        else{

        }

        //Rendre les champs des formulaires vides
        
    }
    
    else{
        $id_employe =0;
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
            <h1>Supprimer un enployé </h1>
            
            <?php 
            
                if($id_employe != 0){
                    $employe = getOneEmploye($id_employe);
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
                }


                
            
            ?>
            <div class= container-formulaire  id = "container-formulaire">
                
                <form action="./supprimer_employe.php" method="get" id = formulaire  enctype="multipart/form-data">
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
                            
                            <td>Nom : <span class = formulaire>*</span></td>
                            <td> <input type="text" name="nom" id="nom" value = <?php if(isset($nom)) echo $nom;?>></td>
                        </tr>



                        <tr>
                            
                            <td><input type="submit" value="recherche" name="recherche"></td>
                            <td>Prénom : <span class= formulaire>*</span></td>
                            <td> <input type="text" name="prenom" id="prenom" value = "<?php if(isset($prenom)) echo $prenom;?>"></td>
                        </tr>


                        <tr>
                            <td rowspan = 4 id= "image-td"><img src="<?php echo localPathToUrl($photo) ?>" alt="Photo de l'employé"
                             id= "<?php echo $id_employe; ?>" srcset="" 
                            width= 150px height = 150px></td>
                            <td>Sexe :  <span class= formulaire>*</span></td>
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
                            
                            <td>Nationalité :<span class = formulaire>*</span> </td>
                            <td> <input type="text" name="nationalite" id="nationalite" value = <?php if(isset($nationalite)) echo $nationalite;?>></td>
                        </tr>

                        <tr>
                            
                            <td>Lieu de résidence : <span class = formulaire>*</span> </td>
                            <td> <input type="text" name="residence" id="residence" value = "<?php if(isset($residence)) echo $residence;?>"></td>
                        </tr>


                        <tr>
                            
                            <td>Salaire (FCFA) : <span class = formulaire>*</span> </td>
                            <td> <input type="number" name="salaire" id="salaire" value = "<?php if(isset($salaire)) echo $salaire;?>"></td>
                        </tr>


                        <tr>
                        <td rowspan= 5></td>
                            <td>Email : <span class = formulaire>*</span> </td>
                            <td> <input type="email" name="email" id="email" value = "<?php if(isset($email)) echo $email;?>"></td>
                        </tr>

                        <tr>
                           
                            <td>Téléphone : <span class = formulaire>*</span> </td>
                            <td> <input type="text" name="contact" id="contact" value = "<?php if(isset($contact)) echo $contact;?>"></td>
                        </tr>


                        <tr>
                           
                            <td>Date de naissance : <span class = formulaire>*</span></td>
                            <td><input type="date" name="date_naiss" id="date_naiss" value = <?php if(isset($date_naiss)) echo $date_naiss;?>></td>
                           
                        </tr>

                        <tr>
                            
                            <td>Date d'embauche: <span class = formulaire>*</span> </td>
                            <td> <input type="date" name="date_embau" id="date_embau" value = <?php if(isset($date_embau)) echo $date_embau;?>></td>
                        </tr>



                        <tr>
                            
                            <td>Service:  <span class = formulaire>*</span> </td>
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
                            <td><input type="submit" value="soumettre" name="soumettre"></td>
                            <td>Niveau d'étude: <span class = formulaire>*</span> </td>
                            <td> <input type="text" name="niveau_etu" id="niveau_etu" value = <?php if(isset($niveau_etu)) echo $niveau_etu;?>></td>
                        </tr>


                        
                    </table>
                    
                </form>
            </div>

        </article>
    </main>


</div>






<script>


        document.getElementById('monInputFile').addEventListener('change', function() {
            var input = this;
            var image = document.getElementById('image-td');
            image.style.display = 'block';
            var reader = new FileReader();
            reader.onload = function(){
                image.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        });
</script>
