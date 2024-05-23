<?php 
    include "graphi_print_cons.php";
?>

<!-- Fenêtre modale pour enrégistrer un nouveau catégorie -->
<div id="categoryModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeCategoryModalBtn" onclick="closeModal('categoryModal')">&times;</span>
        <h2>Enregistrer une catégorie</h2>
        <form id="categoryForm" action="" method="post">
            <label for="nom_categorie">Nom de la catégorie:</label><br><br>
            <input type="text" id="nom_categorie_input" class="nom_categorie_input" name="nomCategorie" required><br><br>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionCategorie" value="enregistrerCategorie">Enregistrer</button>
                <button type="button" class="cancel-button" onclick="closeModal('categoryModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Fenetre modal pour modifier un catégorie -->
<div id="categoryModalModify" class="modal">
    <div class="modal-content">
        <span class="close" id="closeCategoryModalBtn" onclick="closeModal('categoryModalModify')">&times;</span>
        <h2>Modifier le nom de la catégorie</h2>
        <form id="categoryForm" action="" method="post">
            <input type="text" id="id_categorie_modifier" class="nom_categorie_input" name="idCategorie" readonly><br><br>
            <label for="nom_categorie">Nom de la catégorie:</label><br><br>
            <input type="text" id="nom_categorie_modifier" class="nom_categorie_input" name="nomCategorie" required><br><br>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionCategorie" value="modifierCategorie">Modifier</button>
                <button type="button" class="cancel-button" onclick="closeModal('categoryModalModify')">Annuler</button>
            </div>
        </form>
    </div>
</div>



<!-- Fenetre modal pour modifier un catégorie si la catégorie est supprimable -->
<div id="categoryModalDelete" class="modal">
    <div class="modal-content">
        <span class="close" id="closeCategoryModalBtn" onclick="closeModal('categoryModalDelete')">&times;</span>
        <h2>Veillez confirmer la suppression</h2>
        <form id="categoryForm" action="" method="post">
            <label for="nom_categorie">ID de la catégorie:</label><br><br>
            <input type="text" id="id_categorie_delete" class="nom_categorie_input" name="idCategorie" readonly><br><br>
            <label for="nom_categorie">Nom de la catégorie:</label><br><br>
            <input type="text" id="nom_categorie_delete" class="nom_categorie_input" name="nomCategorie" readonly><br><br>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionCategorie" value="deleteCategorie">Confirmer</button>
                <button type="button" class="cancel-button" onclick="closeModal('categoryModalDelete')">Annuler</button>
            </div>
        </form>
    </div>
</div>


<!-- Fenetre modal pour modifier un catégorie si la catégorie n'est pas supprimable -->
<div id="categoryModalDeleteImpossible" class="modal">
    <div class="modal-content">
        <span class="close" id="closeCategoryModalBtn" onclick="closeModal('categoryModalDeleteImpossible')">&times;</span>
        <h2>Impossible de supprimer cette catégorie. </h2>
        <h4>Elle contient des consommables.</h4>
        <form id="categoryForm" action="" method="post">
            
            <div class="button-group" style="text-align:center">
                
                <button type="submit" class="submit-button" onclick="closeModal('categoryModalDeleteImpossible')">Ok</button>
                
            </div>
        </form>
    </div>
</div>

<!--Fenêtre modal pour enrégistrer un nouveau consonsommable -->
<div id="addNewConsommableModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addNewConsommableModal')">&times;</span>
        <h2>Ajouter un nouveau consommable</h2>
        <form id="addNewConsommableForm" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <img id="photoPreview" src="#" alt="Aperçu de l'image" style="display: none;">
                <label for="photo_consommable">Photo :</label>
                <input type="file" id="photo_consommable" name="photo_consommable" accept="image/*" onchange="previewImage(event)">
                
            </div>
            <div class="form-group">
                <label for="nom_consommable">Nom :</label>
                <input type="text" id="nom_consommable" name="nom_consommable" required>
            </div>

            <div class="form-group">
                <label for="categorie_consommable">Catégorie :</label>
                <select id="categorie_consommable" name="categorie_consommable" required>
                    <!-- Ajoutez ici les options de catégorie dynamiquement -->
                    <option value="" disabled selected>Choisissez une catégorie</option>
                    <?php
                    $categories = getAllCategories();
                    foreach ($categories as $category) {
                        echo "<option value='{$category["id_cat"]}'>{$category["nom_cat"]}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prix_unitaire">Prix unitaire :</label>
                <input type="number" id="prix_unitaire" name="prix_unitaire" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="quantite_seuil">Quantité seuil :</label>
                <input type="number" id="quantite_seuil" name="quantite_seuil" min="0" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionConsommable" value="addNewConsommable">Enregistrer</button>
                <button type="button" class="cancel-button" onclick="closeModal('addNewConsommableModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>


<!-- Fenetre d'attribution de consommable    --->
<div id="attributConsommableModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('attributConsommableModal')">&times;</span>
        <h2>Attribuer ce consommable à un employé</h2>
        <form id="attributConsommableForm" action="" method="post">
            <div class="form-group">
                <label for="employe_select">Employé :</label>
                <select id="employe_select" name="employe_select" required>
                    <!-- Les options doivent être dynamiquement générées -->
                    <option value="" selected disabled>Sélectionner un employé</option>
                    <?php
                    // Supposons que vous ayez une fonction qui récupère tous les employés
                    $employes = getAllEmployes();
                    foreach ($employes as $employe) {
                        echo "<option value='{$employe['id_emp']}'>{$employe['nom_emp']} {$employe['prenom_emp']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" min="1" max="100" required>
                <input type="number" id="id_consommable" name="id_consommable" style="display:none;">
                <!-- Remplacer max="100" par la quantité en stock réelle -->
            </div>
            <div class="form-group">
                <label for="date_attribution">Date :</label>
                <input type="date" id="date_attribution" name="date_attribution" required>
            </div>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionConsommable" value="attribuerConsommable">Attribuer</button>
                <button type="button" class="cancel-button" onclick="closeModal('attributConsommableModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>


<!-- Fenêtre de commande d'un consommable spécifique -->
<div id="commandConsommableModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('commandConsommableModal')">&times;</span>
        <h2>Commander ce Consommable</h2>
        <form id="commandConsommableForm" action="" method="post">
            <div class="calculator-display">
                <input type="text" id="montant_total" name="montant_total" readonly>
            </div>
            <div class="form-group">
                <label for="employe_select">Employé :</label>
                <select id="employe_select" name="employe_select" required>
                    <option value="" selected disabled>Sélectionner un employé</option>
                    <?php
                    // Supposons que vous ayez une fonction qui récupère tous les employés
                    $employes = getAllEmployes();
                    foreach ($employes as $employe) {
                        echo "<option value='{$employe['id_emp']}'>{$employe['nom_emp']} {$employe['prenom_emp']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fournisseur_select">Fournisseur :</label>
                <select id="fournisseur_select" name="fournisseur_select" required>
                    <option value="" selected disabled>Sélectionner un fournisseur</option>
                    <?php
                    // Supposons que vous ayez une fonction qui récupère tous les fournisseurs
                    $fournisseurs = getAllFournisseurs();
                    foreach ($fournisseurs as $fournisseur) {
                        echo "<option value='{$fournisseur['id_four']}'>{$fournisseur['nom_four']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_commande">Date :</label>
                <input type="date" id="date_commande" name="date_commande" required>
            </div>
            <div class="form-group">
                <label for="quantite_commande">Quantité :</label>
                <input type="number"  id="quantite_commande" name="quantite_commande" min="1" required>
            </div>
            <div class="form-group">
                <input type="number" style="display: none" id="idConsommable" name="id_consommable">
                <input type="number" style="display: none" id="prix_consommable" name="prix_consommable">
            </div>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionConsommable" value="commanderConsommable">Commander</button>
                <button type="button" class="cancel-button" onclick="closeModal('commandConsommableModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>




<!--Fenêtre modal pour editer un nouveau consonsommable -->
<div id="editConsommableModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editConsommableModal')">&times;</span>
        <h2>Ajouter un nouveau consommable</h2>
        <form id="addNewConsommableForm" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <img id="photoPreviewA" src="#" alt="Aperçu de l'image">
                <label for="photo_consommable">Photo :</label>
                <input type="file" id="photo_consommableA" name="photo_consommable" accept="image/*" onchange="previewImageA(event)">
                
            </div>
            <div class="form-group">
                <label for="nom_consommable">Nom :</label>
                <input type="text" id="nom_consommableA" name="nom_consommable" required>
            </div>

            <div class="form-group">
                <label for="categorie_consommable">Catégorie :</label>
                <select id="categorie_consommableA" name="categorie_consommable" required>
                    <!-- Ajoutez ici les options de catégorie dynamiquement -->
                    <option value="" disabled selected>Choisissez une catégorie</option>
                    <?php
                    $categories = getAllCategories();
                    foreach ($categories as $category) {
                        echo "<option value='{$category["id_cat"]}' id='category{$category["id_cat"]}'>{$category["nom_cat"]}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prix_unitaire">Prix unitaire :</label>
                <input type="number" id="prix_unitaireA" name="prix_unitaire" min="0" step="0.01" required>
                <input type="number" id="id_consommableA" name="id_consommable"  required style="display:none">
            </div>
            

            <div class="button-group">
                <button type="submit" class="submit-button" name="actionConsommable" value="editConsommable">Enregistrer</button>
                <button type="button" class="cancel-button" onclick="closeModal('editConsommableModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>





<!-- Fenetre modal pour supprimer si le consommable est supprimable -->
<div id="consommableModalDelete" class="modal">
    <div class="modal-content">
        <span class="close" id="closeConsommableModalBtn" onclick="closeModal('consommableModalDelete')">&times;</span>
        <h2>Veuillez confirmer la suppression</h2>
        <form id="categoryForm" action="" method="post">
            <label for="nom_categorie">ID de la catégorie:</label><br><br>
            <input type="text" id="id_consommable_delete" class="nom_consommable_input" name="idConsommable" readonly><br><br>
            <label for="nom_categorie">Nom de la catégorie:</label><br><br>
            <input type="text" id="nom_consommable_delete" class="nom_consommable_input" name="nomConsommable" readonly><br><br>
            <div class="button-group">
                <button type="submit" class="submit-button" name="actionConsommable" value="deleteConsommable">Confirmer</button>
                <button type="button" class="cancel-button" onclick="closeModal('consommableModalDelete')">Annuler</button>
            </div>
        </form>
    </div>
</div>


<!-- Fenetre modal pour modifier un supprimer si le consommable n'est pas supprimable -->
<div id="consommableModalDeleteImpossible" class="modal">
    <div class="modal-content">
        <span class="close" id="closeConsommableModalBtn" onclick="closeModal('consommableModalDeleteImpossible')">&times;</span>
        <h2>Impossible de supprimer cette consommable. </h2>
        <h4>Elle fait appartir des commandes effectuées par la société!.</h4>
        <form id="categoryForm" action="" method="post">
            
            <div class="button-group" style="text-align:center">
                
                <button type="button" class="submit-button" onclick="closeModal('consommableModalDeleteImpossible')">Ok</button>
                
            </div>
        </form>
    </div>
</div>



<style>
   /* Style général de la fenêtre modale */
.modal {
    display: none; /* Masquée par défaut */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.2);
}

/* Contenu de la fenêtre modale */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 300px;
    border-radius: 8px;
    box-shadow: 2px 2px 2px #555;
}

/* Bouton pour fermer la fenêtre modale */
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

/*Input de consommable */
.nom_categorie_input{
    width : 100%;
    height: 50px;
    border-radius: 5px;

}

/* Bouton de soumission */
.submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: auto;
}

.submit-button:hover {
    background-color: #45a049;
}

/* Bouton d'annulation */
.cancel-button {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: auto;
}

.cancel-button:hover {
    background-color: #d32f2f;
}

/* Groupement des boutons */
.button-group {
    display: flex;
    justify-content: space-between;
}


#photoPreview,
#photoPreviewA {
    width: 100px;
    height: 100px;
    margin-top: 10px;
}



/* Style des formulaires */
.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="file"],
input[type="date"],
select, option {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 5px;
}

input[type="file"] {
    margin-top: 0;
}


.calculator-display {
    text-align: center;
    margin-bottom: 20px;
}

.calculator-display input {
    font-size: 24px;
    font-weight: bold;
    border: none;
    text-align: center;
    background: none;
    color: #333;
    width: 100%;
}
</style>