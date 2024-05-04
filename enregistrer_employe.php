<link rel="stylesheet" href="style.css">

<?php
    ini_set('upload_max_filesize', '10M');

    include "fonctions.php";
    include "nav.php";

    $menuItems = array(
        "Accueil" => "./index.php",
        "Employe" => "./employe.php",
        "Ressources" => "./ressources.php",
        "Statistiques" => "",
        "Aides" => ""
    );

    $asideItems = array(
        "Liste des employés" =>["liste-employes-id", "./employe.php"],
        "Modification d'un employé" => ["modification-employe-id", "./modifier_employe.php"],
        "Enregistrez un emloyé" =>["enregistrer-employe-id", "./enregistrer_employe.php"],
        "Suppression d'un employé" =>["supprission-employe-id", "./supprimer_employe.php"],
        "Gestions des services" => ["gestion-services-id", "./gestion_services.php"]
    );

    
    echo create_nav_bar($menuItems);
    $services = getAllServices();
    $reponse =TRUE;

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

    //Verification du formulaire
    if( isset($_GET["soumettre"]) )
    {
        $nom= $_GET["nom"];
        $prenom= $_GET["prenom"];
        $email= $_GET["email"];
        $date_naiss= $_GET["date_naiss"];
        $date_embau= $_GET["date_embau"];
        $salaire= $_GET["salaire"];
        $nationalite = $_GET["nationalite"];
        $niveau_etu = $_GET["niveau_etu"];
        $residence = $_GET["residence"];
        $contact = $_GET["contact"];
        $photo = $_GET["btn-file"];
        $service = $_GET["service"];
        $id_service = intval(explode(" ", $service )[0]);
        $sexe = $_GET["sexe"];

        $valeurs = array(
            $option_de_recherche,
            $id_employe,
            $nom,
            $prenom,
            $email,
            $date_naiss,
            $date_embau,
            $salaire,
            $nationalite,
            $niveau_etu,
            $residence,
            $contact,
            $id_service,
            $sexe
        );
        
        if(empty($photo)){
            $valeurs[]=$photo;
        }

        //
        

       
        $resultat  = verifierValeursNonVides($valeurs);

        
        if($resultat){
        
            $reponse = mettreAJourEmploye($id_employe, $nom, $prenom, $email, $date_naiss, $date_embau, $salaire, $nationalite, $niveau_etu, 
            $residence, $contact, $photo, $id_service, $sexe);

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
            }else{
                echo "<h1>    VALEURS MANQUANTES  </h1>";
            }
        }
        else{

        }

        //Rendre les champs des formulaires vides  
    }
    elseif(isset($_GET["btn_file"])){
        $photo = $GET["btn_file"];
        var_dump($_GET["btn_file"]);
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
            <h1>Formulaire d'enrégistrement d'un employé</h1>
            
            <?php 

            ?>
            <div class= container-formulaire  id = "container-formulaire">
                
                <form action="./modifier_employe.php" method="get" id = formulaire  enctype="multipart/form-data">
                    <table id= table-employe >
                        <tr>
                        <td rowspan = 6 id= "image-td"><img src="<?php echo localPathToUrl($photo) ?>" alt="Photo de l'employé"
                             id= "<?php echo $id_employe; ?>" srcset="" 
                            width= 150px height = 150px>
                        </td>
                            
                            <td>Nom : <span class = formulaire>*</span></td>
                            <td> <input type="text" name="nom" id="nom" value = <?php if(isset($nom)) echo $nom;?>></td>
                        </tr>



                        <tr>
                            
                            
                            <td>Prénom : <span class= formulaire>*</span></td>
                            <td> <input type="text" name="prenom" id="prenom" value = "<?php if(isset($prenom)) echo $prenom;?>"></td>
                        </tr>


                        <tr>
                            
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
                            <td><input type="file" value="" name="btn-file"  id= "btn-file" onchange="afficherImage(event)"></td>
                            <td>Email : <span class = formulaire>*</span> </td>
                            <td> <input type="email" name="email" id="email" value = "<?php if(isset($email)) echo $email;?>"></td>
                        </tr>

                        <tr>
                            <td rowspan= 4></td>
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

         // Récupérer la valeur de la variable PHP dans JavaScript
        // var ma_variable_js = <?php echo json_encode($reponse); ?>;

        // Vérifier si la variable JavaScript est false
        //if (ma_variable_js === false) {
            // Afficher une alerte
        //    alert("La variable PHP est fausse.");
        //}

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
