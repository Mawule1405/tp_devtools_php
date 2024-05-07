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
            "Approvisionnement" =>["approvisionner-id", "./approvisionnement.php"]
        );
    
        
        echo create_nav_bar($menuItems);

        $messageDalerte = "";
        $couleur = "#f5f5f5";

        $idEmploye = 0;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
            $data = json_decode(file_get_contents("php://input"), true);
            $file = 'demande_data.txt'; // Nom du fichier de sauvegarde
            $fileContent = ''; // Contenu à écrire dans le fichier
        
            // Ajouter chaque entrée au contenu du fichier
            foreach ($data as $entry) {
                $mysqlDate = date("Y-m-d", strtotime($entry['date']));
                insererDemande($entry['id_emp'], $entry['id_cons'], $entry['qte'], $mysqlDate);
                $fileContent .= "ID Employé: " . $entry['id_emp'] . " | ID Consommable: " . $entry['id_cons'] . " | Quantité: " . $entry['qte'] . " | Date: " . $entry['date'] . PHP_EOL;
            }
        
            // Écrire le contenu dans le fichier
            file_put_contents($file, $fileContent, FILE_APPEND);
        
            // Envoyer une réponse au client (JavaScript) si nécessaire
            echo "Données enregistrées avec succès dans le fichier demande_data.txt!";
            exit; // Arrêter l'exécution du script PHP après le traitement des données
        }
        
?>


<!--Definition du contenue de la page: l'aside bar et le menu principal -->
<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <div class="main">

        <h1>Attribution de comsommables aux employés</h1>
        <article class= "main-article-forme" id= "consommables-main">
            

            <div class= "card-main">
                <form action="" method="get" class= formulaire >
                    <legend class=formulaire-legend>
                        Formulaire
                    </legend>

                    <div class ="alerte" style = "background-color : <?php echo $couleur; ?>; padding: 30px 0; color: #fff; font-size 20px; text-align: center; font-weight: 800"> 
                        <?php echo $messageDalerte  ;?>
                    </div>
                    <!--le formulaire de gestion des consices -->
                    <div>
                            <table class= table-formulaire>
                                <tr>
                                    <td>Employé </td>
                                    <td colspan = 4>
                                        <select name="employe" id="employe">
                                            <option value='0'> Choisir un responsable </option>
                                            <?php 
                                                $options = getAllEmployees();
                                                $selected = "";
                                            
                                                // Vérifier si l'option est sélectionnée  
                                                foreach($options as $index){
                                                    
                                                        // Vérifier si l'option est sélectionnée
                                                        $selected = ($index["id_emp"] == $idEmploye) ? "selected" : "";
                                                        echo  "<option value='{$index["id_emp"]}' $selected> {$index["id_emp"]} {$index["nom_emp"]} {$index["prenom_emp"]}</option>";
                                                }
                                                
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>ID</td>
                                    <td colspan=4>Nom</td>
                                    <td colspan=2>Qte en stock</td>
                                    <td colspan=2>Qte en seuil</td>
                                    <td>Qte à attribuer</td>
                                    <td>sélectionner</td>
                                </tr>
                                
                                <?php 
                                    $categories = getAllCategories();
                                    foreach ($categories as $index=> $cat) { 
                                        construireTableau($cat['id_cat']);
                                    }
                                   
                                ?>
                               
                                <?php
                                /*
                                <tr>
                                    <td class = "formulaire-btn"><input type="submit" name="apercu"  value="Voir les sélections" onclick="alert(getSelectedFields())"></td>
                                    <td class = "formulaire-btn"><input type="submit" name="modifier"    value="Modifier           "></td>
                                    <td class = "formulaire-btn"><input type="submit" name="enregistrer" value="Enregistrer        "></td>
                                </tr>
                                */
                                ?>
                            </table>
                    </div>

                </form>

                <button onclick="openModal(getSelectedFields())">Afficher les champs sélectionnés</button>
            </div>
            
            
        </article>

        <div class = "main-article-forme" >
            <!-- HTML de la fenêtre modale -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Champs Sélectionnés</h2>
                    <p id="selectedFields"></p>
                    <button onclick="saveSelection()">Enregistrer</button>
                </div>
            </div>

            <!-- Utilisez ce bouton pour déclencher l'affichage de la fenêtre modale -->
            
        </div>
    </div>
</div>




<!-- CSS pour styliser la fenêtre modale -->


<!-- JavaScript pour gérer l'ouverture et la fermeture de la fenêtre modale -->
<script>
  function openModal(selectedFields) {
    var modal = document.getElementById("myModal");
    var selectedFieldsElement = document.getElementById("selectedFields");
    selectedFieldsElement.innerHTML = ''; // Efface le contenu précédent de la fenêtre modale
    
    // Création du tableau HTML
    var table = document.createElement('table');
  

    // Ajout de la ligne pour afficher les informations de l'employé
    var employeeRow = table.insertRow();
    var idEmpCell = employeeRow.insertCell();
    idEmpCell.innerHTML = "<b>ID Employé:</b> ";
    var idEmpValueCell = employeeRow.insertCell();
    idEmpValueCell.colSpan = 2;
    idEmpValueCell.textContent = document.getElementById('employe').value;

    var nomEmpRow = table.insertRow();
    var nomEmpCell = nomEmpRow.insertCell();
    nomEmpCell.innerHTML = "<b>Nom et Prénom :</b> ";
    var nomEmpValueCell = nomEmpRow.insertCell();
    nomEmpValueCell.colSpan = 2;
    nomEmpValueCell.textContent = document.getElementById('employe').options[document.getElementById('employe').selectedIndex].text;

    var dateDemandeRow = table.insertRow();
    var dateDemandeCell = dateDemandeRow.insertCell();
    dateDemandeCell.innerHTML = "<b>Date:</b> ";
    var dateDemandeValueCell = dateDemandeRow.insertCell();
    dateDemandeValueCell.colSpan = 2;
    var currentDate = new Date();
    dateDemandeValueCell.textContent =  currentDate.toLocaleDateString();

    // Création de la ligne d'en-tête du tableau pour les consommables sélectionnés
    var headerRow = table.insertRow();
    var idConsHeader = headerRow.insertCell();
    idConsHeader.innerHTML = "<b>ID Consommable</b>";
    var nomConsHeader = headerRow.insertCell();
    nomConsHeader.innerHTML = "<b>Nom du consommable</b>";
    var qteHeader = headerRow.insertCell();
    qteHeader.innerHTML = "<b>Quantité demandée</b>";

    // Parcours des champs sélectionnés pour les ajouter au tableau
    selectedFields.forEach(function(field) {
        var row = table.insertRow(); // Crée une nouvelle ligne dans le tableau
        var idConsCell = row.insertCell(); // Crée une cellule pour l'ID Consommable
        idConsCell.textContent = field.idCons; // Ajoute l'ID Consommable à la cellule
        var nomConsCell = row.insertCell();
        nomConsCell.textContent = field.nomCons;
        var qteCell = row.insertCell(); // Crée une cellule pour la quantité demandée
        qteCell.textContent = field.qte; // Ajoute la quantité demandée à la cellule
    });

    selectedFieldsElement.appendChild(table); // Ajoute le tableau à la fenêtre modale
    modal.style.display = "block"; // Afficher la fenêtre modale
}



  // Fonction pour fermer la fenêtre modale
  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none"; // Cacher la fenêtre modale
  }
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("input[type='checkbox']").change(function(){
            if($(this).is(":checked")){
                $(this).closest("tr").find(".input-number").prop("disabled", false);
            } else {
                $(this).closest("tr").find(".input-number").prop("disabled", true);
            }
        });
    });


</script>

<script>
    function getSelectedFields() {
    var selectedFields = [];

    // Sélectionnez tous les éléments de case à cocher
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Parcourir chaque case à cocher pour voir si elle est cochée
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            // Si la case est cochée et la quantité est différente de 0, ajoutez les données de la ligne associée à la liste des champs sélectionnés
            var row = checkbox.closest('tr');
            var idCons = row.getAttribute('data-idcons'); // Obtenez la valeur de l'attribut data-idcons
            var nomCons = row.getAttribute('data-nomcons');
            var qteInput = row.querySelector('input[type="number"]'); // Sélectionnez l'élément de saisie de quantité dans la ligne
            var qte = parseFloat(qteInput.value); // Obtenez la quantité saisie par l'utilisateur

            if (qte !== 0 && !isNaN(qte)) { // Vérifie si la quantité est différente de 0 et est un nombre valide
                // Ajoutez les valeurs à l'objet selectedFields
                selectedFields.push({
                    idCons: idCons,
                    nomCons: nomCons,
                    qte: qte
                });
            }
        }
    });

    // Retournez la liste des champs sélectionnés
    return selectedFields;
}

</script>


<!-- JavaScript pour gérer le déplacement de la fenêtre modale -->
<script>
    var modal = document.getElementById("myModal");
    var modalContent = document.getElementsByClassName("modal-content")[0];
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;

    modalContent.onmousedown = dragMouseDown;

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // obtenir la position de la souris au début du déplacement
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // appeler une fonction à chaque fois que le curseur bouge
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculer la nouvelle position de la boîte modale
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // définir la nouvelle position de la boîte modale
        modal.style.top = (modal.offsetTop - pos2) + "px";
        modal.style.left = (modal.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
        // arrêter le déplacement lorsque le bouton de la souris est relâché
        document.onmouseup = null;
        document.onmousemove = null;
    }


    function uncheckAllFields() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
    });
    }


    function saveSelection() {
    var selectedFields = getSelectedFields(); // Récupérer les champs sélectionnés
    var selectedEmployee = document.getElementById('employe').value; // Récupérer l'ID de l'employé sélectionné

    if (selectedFields.length > 0 && selectedEmployee !== '0') {
        // Si des champs sont sélectionnés et l'employé est sélectionné, les enregistrer
        var dataToSave = [];
        var currentDate = new Date().toLocaleDateString(); // Obtenir la date du jour

        // Ajouter les informations de chaque champ sélectionné à la liste à sauvegarder
        selectedFields.forEach(function(field) {
            dataToSave.push({
                id_emp: selectedEmployee,
                id_cons: field.idCons,
                qte: field.qte,
                date: currentDate
            });
        });

        // Envoyer les données vers un script PHP via XMLHttpRequest
        var xhr = new XMLHttpRequest();
        var url = "attribution.php"; // Nom du fichier PHP pour enregistrer les données
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Réponse du serveur (si nécessaire)
                
                document.querySelector('.alerte').style.backgroundColor = "green";
                document.querySelector('.alerte').innerText = "Enrégistrement réussie";
                        
                closeModal();
                uncheckAllFields();
                location.reload(true);
            }
        };
        xhr.send(JSON.stringify(dataToSave)); // Envoyer les données JSON à PHP
    } else {
        document.querySelector('.alerte').style.backgroundColor = "red";
        document.querySelector('.alerte').innerText = "Enrégistrement Echoué";
       closeModal();
    }
}


</script>



<?php 






    

?>