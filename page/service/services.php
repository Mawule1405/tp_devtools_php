<?php
    include "unService.php";
    
   

    if (isset($_POST)) {
        if($_POST["actionService"] === "modifierService"){
            $idService = intval($_POST["id_service"]);
            $nomService = $_POST["nom_service"];
            $dateService = $_POST["date_creation"];
            $description = $_POST["mission"];
            $responsable = intval(explode(" ", $_POST["responsable"])[0]);

            updateService($idService, $nomService, $description, $dateService, $responsable);
            
        }elseif($_POST["actionService"] === "okPourLaSuppressionService"){
            $idService = intval(explode(" ", $_POST["serviceConfirmation"])[0]);
            deleteService($idService);

        }elseif($_POST["actionService"] === "enregistrerNouveauService"){
           $nomService = $_POST["nom_service_new"];
           $dateService = $_POST["date_creation_new"];  
           $describeService = $_POST["mission_new"];
           $responsableService = $_POST["responsable_new"];
          
           
           if($nomService !=='' && $dateService !== ''){
                $reponse = insertService($nomService, $describeService, $dateService, $responsableService);
                // Redirection avec un message de succès
                echo $reponse;
               
           }
          
        }
    }
?>

<link rel="stylesheet" href="style_service.css">

<main class = "body-card">
    
<aside class="aside-card">
       <form action="" method="post" id="recherche-forme" class="search-form">
            <input type="search" name="recherche" id="recherche" class="search-input" placeholder="Rechercher...">
        </form>

        <p>
            <?php $serviceReduites = getAllService();?>
            Nombre de service:<strong> <?php echo count($serviceReduites);?> </strong>
        </p>
        <!--Affichage des informations réduites des employés  -->
        <?php 
                
                //Affichage de tous les employés
                
            
                foreach($serviceReduites as $index => $serv){
                    if($serv) {
                        buildServiceReduite($serv["id_serv"]);
                    }
                }
        ?>
    </aside>

    <article >

        <div class="article-card" >
            <form action="" method="post" id="enregistrement-formulaire" class="enregistrer-formulaire">
                <button type="button" name="enregistrerService" id="enregistrerService" onclick="createService()">Enrégistrer un nouveau service</button>
            </form>
            <!--Affichage des informations détaillés des employés  -->
            <?php  
            
            $serviceReduites = getAllService();
        
                //Affichage de tous les employés
                foreach($serviceReduites as $index => $service){
                    if($service) {
                        buildService($service['id_serv']);
                        
                    }
                }
            ?>
        </div>
    </article>
</main>


<script>
    
function createService(){
    //Afficher la fenetre de création d'un nouveau service
    document.getElementById("myModalNew").style.display ="block";
}
</script>
