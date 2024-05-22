<!-- ============== SERVICES========================== -->
<?php
    include "graphi_print_serv.php";
?>

<div id="myModal" class="modal">
        <!-- Contenu de la modale -->
        <div class="modal-content">
            <span class="close"  onclick="closeModal('myModal')">&times;</span>
            <h2>Modifier le Service</h2>
            <form id="modifyServiceForm" action="" method="post" >
                <label  for="id_service">ID Service:</label>
                <input type="text" id="id_service" name="id_service" readonly><br><br>

                <label for="nom_service">Nom du Service:</label>
                <input type="text" id="nom_service" name="nom_service"><br><br>

                <label for="date_creation">Date de Création:</label>
                <input type="date" id="date_creation" name="date_creation"><br><br>

                <label for="mission">Mission:</label>
                <textarea id="mission" name="mission" row="10"></textarea><br><br>

                <label for="responsable">Responsable:</label>
                
                <select id="responsable" name="responsable">
                    <!-- Les options doivent être dynamiquement générées -->
                    <?php
                    $employes = getAllemployeReduite();
                    foreach($employes as $key => $employe) {
                        $option = $employe["id_emp"]." ".$employe["nom_emp"]." ".$employe["prenom_emp"];
                        echo "<option id='employe_responsable_{$employe["id_emp"]}'> $option </option>";
                    }
                    ?>
                    
                </select><br><br>
                <div class="confirmationBouton">
                    <button type="submit" name="actionService" value="modifierService">Enregistrer</button>
                    <button type="submit" name="actionService" onclick="closeModal('myModal')">Annuler</button>
                </div>
                
            </form>
        </div>
</div>


<!--=======================================================================-->

<div id="myModalNew" class="modal">
        <!-- Contenu de la modale -->
        <div class="modal-content">
            <span class="close"  onclick="closeModal('myModalNew')">&times;</span>
            <h2>Modifier le Service</h2>
            <form id="modifyServiceFormNew" action="" method="post" >
                <label for="id_service_new"> <br><br> </label>
                <input type="hidden" id="id_service_new" name="id_service_new"><br><br>

                <label for="nom_service_new">Nom du Service:</label>
                <input type="text" id="nom_service_new" name="nom_service_new"><br><br>

                <label for="date_creation_new">Date de Création:</label>
                <input type="date" id="date_creation_new" name="date_creation_new"><br><br>

                <label for="mission_new">Mission:</label>
                <textarea id="mission_new" name="mission_new" row="10"></textarea><br><br>

                <label for="responsable_new">Responsable:</label>
                
                <select id="responsable_new" name="responsable_new">
                    <!-- Les options doivent être dynamiquement générées -->
                    <?php
                    $employes = getAllemployeReduite();
                    foreach($employes as $key => $employe) {
                        $option = $employe["id_emp"]." ".$employe["nom_emp"]." ".$employe["prenom_emp"];
                        echo "<option id='employe_responsable_{$employe["id_emp"]}'> $option </option>";
                    }
                    ?>
                    
                </select><br><br>

                <div class=" confirmationBouton">
                    <button type="submit" name="actionService" value="enregistrerNouveauService"  >Enregistrer</button>
                    <button type="submit" name="actionService"  onclick="closeModal('myModalNew')">Annuler</button>
                </div>
                
            </form>
        </div>
</div>    


<!-- ============================================================================-->

<!-- Fenêtre modale de confirmation -->
<div id="confirmationModal" class="modalConfirme">
    <div class="modal-content-Confirme">
        <span class="close" onclick="closeModal('confirmationModal')">&times;</span>
        <h2>Confirmation de suppression</h2>
        <form action="" method="post" >
            <input type="text" name = "serviceConfirmation"  id="idServiceConfirmation" readonly>
        
        <p>Êtes-vous sûr de vouloir supprimer ce service ?</p>
        <div class=" confirmationBouton">
            <button type="submit" name="actionService" id="confirmationDelaSupression"  value="okPourLaSuppressionService">Confirmer</button>
            <button type="submit" name="actionService" onclick="closeModal('confirmationModal')">Annuler</button>
        </div>
        </form>
    </div>
</div>



<style>
 /* Le style pour la fenêtre modale */
.modal {
    display: none; /* Masquée par défaut */
    position: fixed;
    z-index: 1;
    left: 400px;
    top: 0;
    width: 40%;
    height: 100%;
    overflow: hidden; /* Supprimer le défilement */
    background-color: rgba(0,0,0,0.0); /* Fond semi-transparent pour l'effet de superposition */
    padding-top: 0px;
}

.modal-content {
    background-color: #fefefe;
    margin: 10px auto ;
    padding: 0px;
    border: 0px solid #888;
    box-shadow: 5px 5px 5px 5px #333;
    border-radius: 20px;
    width: 80%;
    height: 90%; /* Hauteur ajustée pour s'adapter à la fenêtre modale */
    overflow: hidden; /* Ajouter le défilement interne si le contenu dépasse */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

label {
    font-weight: bold;
}

input, textarea, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 5px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


button[type="submit"] {
    display: inline-block;
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


button[type="submit"]:last-child{
    background-color: #ff0000;
}


button[type="submit"]:last-child:hover{
    background-color: #ff0022;
}


button[type="submit"]:hover {
    background-color: #45a049;
}



/*====================================================*/
/* Le style pour la fenêtre modale */
.modalConfirme {
    display: none; /* Masquée par défaut */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden; /* Empêcher le défilement de la page */
    background-color: rgba(0,0,0,0.4); /* Couleur de fond avec opacité */
    padding-top: 60px;
}

/* Le style pour le contenu de la fenêtre modale */
.modal-content-Confirme {
    background-color: #fefefe;
    margin: 5% auto; /* 5% du haut et du bas, centré horizontalement */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px; /* Limiter la largeur maximale */
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    border-radius: 8px;
}

/* Le style pour le bouton de fermeture */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Le style pour les boutons de confirmation */
.confirmationBouton {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

button[type="submit"] {
    width: 45%; /* Largeur des boutons */
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin: 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

button[type="submit"]:nth-child(2) {
    background-color: #f44336;
}

button[type="submit"]:nth-child(2):hover {
    background-color: #e53935;
}


</style>