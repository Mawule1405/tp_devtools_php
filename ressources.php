<link rel="stylesheet" href="style.css">
<?php 

        include "fonctions.php";
        include "nav.php";

    
        $menuItems = array(
            "Accueil" => "./index.php",
            "Employe" => "./employe",
            "Ressources" => "./ressources.php",
            "Statistiques" => "",
            "Aides" => ""
        );
    
        $asideItems = array(
            "Catégories de consommables" =>["categories-id", "./ressources.php"],
            "Les consommables" => ["consommable-id", "./consommables.php"],
            "Attribution de consommables" =>["attribution-id", "./attribution.php"],
            "Approvisionnement" =>["approvisionner-id", "./approvisionnement"]
        );
    
        
        echo create_nav_bar($menuItems);
        
        
        $idCategorie = 0;
        $nomCategorie = "";
        $couleur = "#f5f5f5";
        $messageDalerte ="";

        if(isset($_GET["rechercher"])){
           
            $idCategorie = intval($_GET["id_cat"]);
            $cat = getOneCategorie($idCategorie);
            if(!empty($cat)){
                $idCategorie = $cat[0]["id_cat"];
                $nomCategorie = $cat[0]["nom_cat"];
                $couleur = "green";
              
                $messageDalerte= "Recherche réussie";
            }
            else{
                $idCategorie = 0;
                $nomCategorie = "";
                $couleur = "red";
                $messageDalerte = "Echec de la recherche";
            }
            
        }
        elseif(isset($_GET["enregistrer"])){
            $idCategorie = intval($_GET["id_cat"]);
            $nomCategorie = $_GET["nom_cat"];
            $validation = $idCategorie && $nomCategorie;

            if($validation){
                $reponse = insererCategorie($idCategorie, $nomCategorie);

                if($reponse){
                    $couleur = "green";
                    $messageDalerte= "Enregistrement réussie";
                    $idCategorie = 0;
                    $nomCategorie = "";
                }
                else{
                    $couleur = "red";
                    $messageDalerte= "Echec d'enregistrement";
                }
            }else{
                    $couleur = "red";
                    $messageDalerte= "Valeurs manquantes (*)";
                }
        }
        elseif(isset($_GET["modifier"])){
            $idCategorie = intval($_GET["id_cat"]);
            $nomCategorie = $_GET["nom_cat"];
            $validation = $idCategorie && $nomCategorie;

            if($validation){
                $reponse = mettreAjourCategorie($idCategorie, $nomCategorie);

                if($reponse){
                    $couleur = "green";
                    $messageDalerte= "Modification réussie";
                    $idCategorie = 0;
                    $nomCategorie = "";
                }
                else{
                    $couleur = "red";
                    $messageDalerte= "Echec de modification";
                }
            }else{
                    $couleur = "red";
                    $messageDalerte= "Valeurs manquantes (*)";
                }
        
        }
        elseif(isset($_GET["supprimer"])){
            $idCategorie = intval($_GET["id_cat"]);
            $reponse = supprimerCategorie($idCategorie);
            if($reponse){
                    $couleur = "green";
                    $messageDalerte= "Suppression réussie";
                    $idCategorie = 0;
                    $nomCategorie = "";
            }
            else{
                $couleur = "red";
                $messageDalerte= "Echec de la suppression";
            }
        }
        else{
            $couleur = "#f5f5f5";
            $messageDalerte= "";
            $idCategorie = 0;
            $nomCategorie = "";
        }
        
?>


<!--Definition du contenue de la page: l'aside bar et le menu principal -->
<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <div class="main">
        <h1>LES CATEGORIES DE CONSOMMABLES</h1>
        <article class= "main-article" id= "categories-main">
            

            <div class= "card-main">
                <form action="" method="get" class= formulaire style="border : 2 red">
                    <legend class=formulaire-legend>
                        Formulaire
                    </legend>

                    <div class ="alerte" style = "background-color : <?php echo $couleur; ?>;"> 
                        <?php echo $messageDalerte  ;?>
                    </div>
                    <!--le formulaire de gestion des services -->
                    <div>
                            <table class= table-formulaire>
                                <tr>
                                    <td>ID <span>*</span> </td>
                                    <td><input type="number" name="id_cat" id="id_cat" value =" <?php  if(isset($idCategorie)) echo intval($idCategorie); ?>"></td>
                                </tr>
                                <tr>
                                    <td>Nom <span>*</span></td>
                                    <td><input type="text" name="nom_cat" id="nom_cat" value = "<?php  if(isset($nomCategorie)) echo $nomCategorie; ?>"></td>
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
        
            <div class="card-main">
                <h2>Liste des catégories de consommables </h2>
                <table class="table-liste">
                    <thead class="table-header">
                        <tr >
                            <td>ID  </td>
                            <td>Nom</td>
                        </tr>
                    </thead>

                    <tbody class = "table-body">
                        <?php  

                            //Importation des services
                            $categories = getAllCategories();
                        
                            foreach($categories as  $categorie){
                                echo <<<TR
                                    <tr>
                                        <td> {$categorie['id_cat']}</td>
                                        <td> {$categorie['nom_cat']}</td>
                                    </tr>
                                TR;
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </article>
    </div>
</div>
