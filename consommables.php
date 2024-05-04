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
            "Approvisionnement" =>["approvisionner-id", "#"]
        );
    
        
        echo create_nav_bar($menuItems);
        
        $idConso = 0;
        $nomConso = "";
        $puConso = 0;
        $qteStockConso =0;
        $qteSeuilConso = 0;
        $idCategorie =0;

        $couleur = "#f5f5f5";
        $messageDalerte ="";

        if(isset($_GET["rechercher"])){
            
            $idConso = intval($_GET["id_cons"]);
            $consommable = getOneConsommable($idConso);
            
            if(!empty($consommable)){
                $conso = $consommable[0];
                $nomConso = $conso["nom_cons"];
                $puConso = $conso['prix_unitaire_cons'];
                $qteSeuilConso = $conso['qteseuil_cons'];
                $qteStockConso = $conso['qtestock_cons'];
                $idCategorie = $conso['id_cat'];

                $couleur = 'green';
                $messageDalerte = 'Recherche réussie';
            }
            else{
                $couleur = 'red';
                $messageDalerte = 'Echec de la recherche';
            }

        }elseif(isset($_GET["modifier"])){
            $idConso = intval($_GET["id_cons"]);
            $nomConso = $_GET["nom_cons"];
            $idCategorie = intval($_GET["categorie"]);
            $reponse = mettreAjourConsommable($idConso, $nomConso, $idCategorie);

            if($reponse){
                $idConso = intval($_GET["id_cons"]);
                $nomConso = $_GET["nom_cons"];
                $puConso = intval($_GET["pu_cons"]);
                $qteSeuilConso = intval($_GET["qteseuil_cons"]);
                $qteStockConso = intval($_GET["qtestock_cons"]);
                $idCategorie = intval($_GET["categorie"]);


                $couleur = 'green';
                $messageDalerte = 'Recherche réussie <br> Les champs (#) ne seront pas prises en comptes';
            }else{
                $couleur = 'red';
                $messageDalerte = 'Echec de la modification';
            }
        }
        elseif(isset($_GET["enregistrer"])){
            $idConso = intval($_GET["id_cons"]);
            $nomConso = $_GET["nom_cons"];
            $puConso = intval($_GET["pu_cons"]);
            $qteSeuilConso = intval($_GET["qteseuil_cons"]);
            $qteStockConso = intval($_GET["qtestock_cons"]);
            $idCategorie = intval($_GET["categorie"]);

            $validation = $idConso && $nomConso && $puConso && $qteSeuilConso && $qteStockConso && $idCategorie;
            
            if($validation){
                $reponse = insererConsommable($idConso, $nomConso, $puConso, $qteSeuilConso, $qteStockConso, $idCategorie);

                if($reponse)
                {
                    $idConso = 0;
                    $nomConso = "";
                    $puConso = 0;
                    $qteStockConso =0;
                    $qteSeuilConso = 0;
                    $idCategorie =0;
    
                    $couleur = 'green';
                    $messageDalerte = 'Enregistrement réussie';
                }
                else
                {
                    $couleur = 'red';
                    $messageDalerte = "Echec de l'enregistrement";
                }
            }else{
                $couleur = 'red';
                    $messageDalerte = "Echec de l'enregistrement <br> Vérifier les champs obligatoires (*)";
            }
  
        }
        else{
            $couleur = '#f5f5f5';
            $messageDalerte = "";   
        }
        

?>


<!--Definition du contenue de la page: l'aside bar et le menu principal -->
<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <div class="main">

        <h1>LES CONSOMMABLES</h1>
        <article class= "main-article" id= "consommables-main">
            

            <div class= "card-main">
                <form action="" method="get" class= formulaire style="border : 2 red">
                    <legend class=formulaire-legend>
                        Formulaire
                    </legend>

                    <div class ="alerte" style = "background-color : <?php echo $couleur; ?>;"> 
                        <?php echo $messageDalerte  ;?>
                    </div>
                    <!--le formulaire de gestion des consices -->
                    <div>
                            <table class= table-formulaire>
                                <tr>
                                    <td>ID <span>*#</span></td>
                                    <td colspan=2><input type="number" name="id_cons" id="id_cons" value = <?php  if(isset($idConso)) echo $idConso; ?>></td>
                                </tr>
                                <tr>
                                    <td>Nom <span>*</span></td>
                                    <td colspan=2><input type="text" name="nom_cons" id="" value = "<?php  if(isset($nomConso)) echo $nomConso; ?>"></td>
                                </tr>
                                
                                <tr>
                                    <td>Prix unitaire <span>*#</span></td>
                                    <td colspan=2><input type="number" name="pu_cons" id="pu_cons" value = <?php  if(isset($puConso)) echo $puConso; ?>></td>
                                </tr>

                                <tr>
                                    <td>Qte en stock <span>*#</span></td>
                                    <td colspan=2><input type="number" name="qtestock_cons" id="qtestock_cons" value = <?php  if(isset($qteStockConso)) echo $qteStockConso; ?>></td>
                                </tr>

                                <tr>
                                    <td>Qte seuil <span>*#</span></td>
                                    <td colspan=2><input type="number" name="qteseuil_cons" id="qteseuil_cons" value = <?php  if(isset($qteSeuilConso)) echo $qteSeuilConso; ?>></td>
                                </tr>
                                <tr>

                                <td>Catégorie <span>*</span></td>
                                <td colspan = 2>
                                    <select name="categorie" id="categorie">
                                        <option value='0'> Choisir un responsable </option>
                                    
                                    <?php 

                                    
                                        $options = getAllCategories();
                                        $selected = "";
                                    
                                        // Vérifier si l'option est sélectionnée  
                                        foreach($options as $index){
                                               
                                                // Vérifier si l'option est sélectionnée
                                                $selected = ($index["id_cat"] == $idCategorie) ? "selected" : "";
                                                echo  "<option value='{$index["id_cat"]}' $selected> {$index["id_cat"]} {$index["nom_cat"]}</option>";
                                        }
                                        
                                    ?>
                                    </select>
                                </td>
                            </tr>
                        
                                <tr>
                                    <td class = "formulaire-btn"><input type="submit" name="rechercher"  value="Rechercher         "></td>
                                    <td class = "formulaire-btn"><input type="submit" name="modifier"    value="Modifier           "></td>
                                    <td class = "formulaire-btn"><input type="submit" name="enregistrer" value="Enregistrer        "></td>
                                </tr>
                                
                            </table>
                    </div>

                </form>
            </div>

            <!--le tableau présentant la liste des consices -->
        
            <div class="card-main">
                <h2>Liste des catégories de consommables </h2>
                <table class="table-liste">
                    <thead class="table-header">
                        <tr >
                            <td>ID  </td>
                            <td>Nom</td>
                            <td>Prix unitaire</td>
                            <td>Quantité en stock</td>
                            <td>Quantité seuil</td>
                            <td>Catégaries</td>
                        </tr>
                    </thead>

                    <tbody class = "table-body">
                        <?php  

                            //Importation des consices
                            $consos = getAllConsommables();
                        
                            foreach($consos as  $conso){
                                echo <<<TR
                                    <tr>
                                        <td> {$conso['id_cons']}</td>
                                        <td> {$conso['nom_cons']}</td>
                                        <td> {$conso['prix_unitaire_cons']} FCFA</td>
                                        <td> {$conso['qteseuil_cons']}</td>
                                        <td> {$conso['qtestock_cons']}</td>
                                        <td> {$conso['id_cat']}</td>
                                        
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
