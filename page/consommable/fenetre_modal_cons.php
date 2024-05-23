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

</style>