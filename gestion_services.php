<link rel="stylesheet" href="style.css">
<?php 

        include "fonctions.php";
        include "nav.php";
        include "graphi_print.php";
    
        $menuItems = array(
            "Accueil" => "./index.php",
            "Employe" => "./employe",
            "Ressources" => "./ressources.php",
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
        $lesEmlplyes = getAllEmployees();
        $idService = 0;
        $nomService="";
        $descService="";
        $idResponsable = 0;

        //Definition des couleurs d'informations
        $couleur = "#f5f5f5";
        $messageDalerte = "";
        
        if(isset($_GET["rechercher"])){
            
            $idService = intval($_GET["id_serv"]);
            $oneService = getOneService($idService);
            
            if(!empty($oneService))
            {
                $oneService = $oneService[0];
                $nomService = $oneService["nom_serv"];
                $descService = $oneService["description_serv"];
                $dateService = $oneService["date_serv"];
                $idResponsable=$oneService["id_emp_resp"];
                $couleur ="green";
                $messageDalerte = "Recherche Réussie !";
            }
            else{
                $idService = 0;
                $couleur ="red";
                $messageDalerte = "Recherche échouée !";
            }
                

            
            
        }elseif(isset($_GET["modifier"])){

            $idService = intval($_GET["id_serv"]);
            $nomService = $_GET["nom_serv"];
            $descService =$_GET["description_serv"];
            $dateService = $_GET["date_serv"];
            $idResponsable = intval($_GET["responsable"]);
               
            try{
                $reponse = mettreAJourService($idService, $nomService, $descService, $dateService, $idResponsable);
                if($reponse){
                    $couleur ="green";
                    $messageDalerte = "Modification Réussie !";
                    $idService = 0;
                    $nomService="";
                    $descService="";
                    $idResponsable = 0;
                }
                else{
                    $couleur ="red";
                    $messageDalerte = "Modification échouée !";
                }
                
            }catch(Exception $e){
                $couleur ="red";
                $messageDalerte = "Erreur! problème de connexion. Veillez réessayez!";
            }

        }elseif(isset($_GET["enregistrer"])){

            $idService = intval($_GET["id_serv"]);
            $nomService = $_GET["nom_serv"];
            $descService =$_GET["description_serv"];
            $dateService = $_GET["date_serv"];
            $idResponsable = intval($_GET["responsable"]);

            //Validation des champs de saisis
            $validation = $idService && $nomService && $dateService && $idResponsable;
            
            if($validation){
                //insertion des données
                $reponse = insererService( $idService,$nomService, $descService, $dateService, $idResponsable);

                //Confirmation de la réussite ou de l'échec de l'enrégistrement
                if($reponse){
                    $couleur ="green";
                    $messageDalerte = "Enregistrement réussie !";
                    $idService = 0;
                    $nomService="";
                    $descService="";
                    $idResponsable = 0;
                }else{
                    $couleur ="red";
                    $messageDalerte = "Enegistrement échoué !";
                }

            }else{
                //Alerte de non validation
                $couleur ="red";
                $messageDalerte = "Veuillez remplir tous les champs obligatoires (*)";
            }



        }elseif(isset($_GET["supprimer"])){

            $idService = intval($_GET["id_serv"]);

            $reponse = supprimerService($idService);

            if($reponse){
                $couleur ="green";
                $messageDalerte = "Suppression réussie !";
                $idService = 0;
                $nomService="";
                $descService="";
                $idResponsable = 0;
            }else{
                $couleur ="red";
                $messageDalerte = "Suppression échoué !";
            }


        }
        else{

            $couleur ="#f5f5f5";
            $messageDalerte = "";
            
        }


?>


<!--Definition du contenue de la page: l'aside bar et le menu principal -->
<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <article class= "main-article">
        <div id="formulaire-services" class= "lien-ancre">
            <a href="#liste-services" title="Aller au tableau des services">Voir la liste des services</a>
        </div>
        
        <!-- Message d'alerte de la soumission du formulaire-->
        
        
        
        
        
        <div class= "card-main">
            <form action="./gestion_services.php" method="get" class= formulaire style="border : 2 red">
                <legend class=formulaire-legend>
                    Formulaire de gestion des services
                </legend>

                <div class ="alerte" style = "background-color : <?php echo $couleur; ?>;"> 
                    <?php echo $messageDalerte  ;?>
                </div>
                <!--le formulaire de gestion des services -->
                <div>
                        <table class= table-formulaire>
                            <tr>
                                <td>ID <span>*</span> </td>
                                <td><input type="number" name="id_serv" id="id_serv" value = <?php  if(isset($idService)) echo $idService; ?>></td>
                            </tr>
                            <tr>
                                <td>Nom <span>*</span></td>
                                <td><input type="text" name="nom_serv" id="" value = <?php  if(isset($nomService)) echo $nomService; ?>></td>
                            </tr>
                            
                            <tr>
                                <td colspan=2>
                                    <textarea name="description_serv" id="description_serv" style="font-size: 15px; " cols="30" rows="10" placeholder = "Description du service" ><?php  if(isset($descService)) echo $descService; ?></textarea>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>Date de création <span>*</span></td>
                                <td><input type="date" name="date_serv" id="date_serv" value = <?php  if(isset($dateService)) echo $dateService; ?>></td>
                            </tr>
                            <tr>
                                <td>Responsable <span>*</span></td>
                                <td>
                                    <select name="responsable" id="responsable">
                                        <option value='0'> Choisir un responsable </option>
                                    <?php 
                                        $options = getAllEmployees();
                                        $selected = "";
                                    
                                        // Vérifier si l'option est sélectionnée  
                                        foreach($options as $index){
                                               
                                                // Vérifier si l'option est sélectionnée
                                                $selected = ($index["id_emp"] == $idResponsable) ? "selected" : "";
                                                echo  "<option value='{$index["id_emp"]}' $selected> {$index["id_emp"]} {$index["nom_emp"]} {$index["prenom_emp"]}</option>";
                                        }
                                        
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class = "formulaire-btn"><input type="submit" name="rechercher" value="Rechercher"></td>
                                <td class = "formulaire-btn"><input type="submit" name="enregistrer" value="Enregistrer"></td>
                            </tr>
                            <tr>
                                <td class = "formulaire-btn"><input type="submit" name="modifier" value="Modifier"></td>
                                <td class = "formulaire-btn"><input type="submit" name="supprimer" value="Supprimer"></td>
                            </tr>
                        </table>
                </div>

            </form>
        </div>
        
        
        <!--le tableau présentant la liste des services -->
        <div id="liste-services" class= "lien-ancre">
            <a href="#formulaire-services" title="--->Aller au formulaire">Voir le formulaire</a>
        </div>
        <div class="card-main">
            <h2>Liste des services</h2>
            <table class="table-liste">
                <thead class="table-header">
                    <tr >
                        <td>ID  </td>
                        <td>Nom</td>
                        <td>Description</td>
                        <td>Date</td>
                        <td>Responsable</td>
                    </tr>
                </thead>

                <tbody class = "table-body">
                    <?php  

                        //Importation des services
                        $services = getAllServicesAndResponsable();
                       
                        foreach($services as  $service){
                            echo <<<TR
                                <tr>
                                    <td> {$service['id_serv']}</td>
                                    <td> {$service['nom_serv']}</td>
                                    <td> {$service['description_serv']}</td>
                                    <td> {$service['date_serv']}</td>
                                    <td> {$service['nom_emp']} {$service['prenom_emp']}</td>
                                </tr>
                            TR;
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </article>
</div>
