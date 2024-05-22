
<!-- Fenêtre modale pour editer les information -->
<?php include "graphi_print_emp.php";
$Services = getAllService();

$id_emp =0;
$nom_emp ="";
$prenom_emp = "";
$date_nais="";

    
?>


<div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Informations de l'employé</h2>
                    <span class="close" onclick="closeModal('myModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post"  enctype="multipart/form-data">
                            <input type="hidden" id="id_emp" name="id_emp">
                           
                            <span>
                                <img id="current_photo" src="" alt="Photo de profil actuelle" style="width: 200px; height: 200px; display: block; margin-bottom: 10px;">
                                <input type="file" id="photo_emp" name="photo_emp" style="display: none;" onchange="previewPhoto(event, 'current_photo')">
                                
                                <button type="button" onclick="document.getElementById('photo_emp').click()">
                                    <img src="../../image/icon/add_icon.svg" alt="Changer photo de profil">
                                </button>
                                <input type="hidden" id="photo_emp_ent" name="photo_emp_ent" valeur="">
                            </span><br>

                            <label for="nom_emp">Nom:</label> <br>
                            <input type="text" id="nom_emp" name="nom_emp" > <br>
                        
                            <label for="prenom_emp">Prénom:</label> <br>
                            <input type="text" id="prenom_emp" name="prenom_emp" > <br>
                       
                            <label for="sexe_emp">Sexe:</label><br>
                            <div>
                                <input type="radio" id="sexe_m" name="sexe_emp" value="Masculin" checked>
                                <label for="sexe_m">Masculin</label>
                                <input type="radio" id="sexe_f" name="sexe_emp" value="Féminin" >
                                <label for="sexe_f">Féminin</label><br>
                            </div>
                        
                            <label for="nationalite_emp">Nationalité:</label><br>
                            <input type="text" id="nationalite_emp" name="nationalite_emp" > <br>

                            <label for="lieu_res_emp">Lieu de résidence:</label><br>
                            <input type="text" id="lieu_res_emp" name="lieu_res_emp" > <br>
                        
                            <label for="salaire_emp">Salaire:</label><br>
                            <input type="number" id="salaire_emp" name="salaire_emp"> <br>
                      
                            <label for="email_emp">Email:</label><br>
                            <input type="email" id="email_emp" name="email_emp" > <br>
                   
                            <label for="contact_emp">Téléphone:</label><br>
                            <input type="text" id="contact_emp" name="contact_emp" > <br>
                      
                            <label for="date_nais_emp">Date de naissance:</label><br>
                            <input type="date" id="date_nais_emp" name="date_nais_emp" > <br>
                      
                            <label for="date_embau_emp">Date d'embauche:</label><br>
                            <input type="date" id="date_embau_emp" name="date_embau_emp" > <br>
                    
                            <label for="nom_serv">Service:</label><br>
                            <select name="nom_serv" id="nom_serv">
                                <?php 
                                
                                    foreach( $Services as $key => $Service ){
                                        echo "<option  valeur = \"{$Service['id_serv']}\"> {$Service['nom_serv']} </option>";
                                    }
                                ?>
                            </select>
                 
                            <label for="niveau_etu_emp">Niveau d'étude:</label> <br>
                            <input type="text" id="niveau_etu_emp" name="niveau_etu_emp" > <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="enregistrerModification" name="action" value="Sauvegarder" onclick ="saveModification()">Sauvegarder</button>
                            <button type="button" onclick="closeModal('myModal')">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
</div>


<!-- FENETRE MODALE D'ENREGISTREMENT/-->

<div id="myModalNew" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Formulaire d'enrégistrement d'un nouvel employé</h2>
                    <span class="close" onclick="closeModal('myModalNew')">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden"  name ="id_emp_new" id="id_emp_new" value="">

                            <span>
                                <img id="current_photo_new" src="" alt="Photo de profil actuelle" style="width: 200px; height: 200px; display: block; margin-bottom: 10px;">
                                <input type="file" id="photo_emp_new" name="photo_emp_new" style="display: none;" onchange="previewPhoto(event, 'current_photo_new')">
                                <button type="button" onclick="document.getElementById('photo_emp_new').click()">
                                    <img src="../../image/icon/add_icon.svg" alt="Changer photo de profil">
                                </button>
                                <input type="text" id="photo_emp_new_ent" name="photo_emp_new_ent" valeur="../../image/icon/add_icon.svg">
                            </span><br>

                            <label for="nom_emp_new">Nom:</label> <br>
                            <input type="text" id="nom_emp_new" name="nom_emp_new" > <br>
                        
                            <label for="prenom_emp_new">Prénom:</label> <br>
                            <input type="text" id="prenom_emp_new" name="prenom_emp_new" > <br>
                       
                            <label for="sexe_emp_new">Sexe:</label><br>
                            <div>
                                <input type="radio" id="sexe_m_new" name="Sexe_new" value="Masculin" checked>
                                <label for="sexe_m_new">Masculin</label>
                                <input type="radio" id="sexe_f_new" name="Sexe_new" value="Féminin" >
                                <label for="sexe_f_new">Féminin</label><br>
                            </div>
                        
                            <label for="nationalite_emp_new">Nationalité:</label><br>
                            <input type="text" id="nationalite_emp_new" name="nationalite_emp_new" > <br>

                            <label for="lieu_res_emp_new">Lieu de résidence:</label><br>
                            <input type="text" id="lieu_res_emp_new" name="lieu_res_emp_new" > <br>
                        
                            <label for="salaire_emp_new">Salaire:</label><br>
                            <input type="number" id="salaire_emp_new" name="salaire_emp_new"> <br>
                      
                            <label for="email_emp_new">Email:</label><br>
                            <input type="email" id="email_emp_new" name="email_emp_new" > <br>
                   
                            <label for="contact_emp_new">Téléphone:</label><br>
                            <input type="text" id="contact_emp_new" name="contact_emp_new" > <br>
                      
                            <label for="date_nais_emp_new">Date de naissance:</label><br>
                            <input type="date" id="date_nais_emp_new" name="date_nais_emp_new" > <br>
                      
                            <label for="date_embau_emp_new">Date d'embauche:</label><br>
                            <input type="date" id="date_embau_emp_new" name="date_embau_emp_new" > <br>
                    
                            <label for="nom_serv_new">Service:</label><br>
                            <select name="nom_serv_new" id="nom_serv_new">
                            <?php 
                                
                                foreach( $Services as $key => $Service ){
                                    echo "<option  valeur = \"{$Service['id_serv']}\"> {$Service['nom_serv']} </option>";
                                }
                            ?>
                        </select>
             
                        <label for="niveau_etu_emp_new">Niveau d'étude:</label> <br>
                        <input type="text" id="niveau_etu_emp_new" name="niveau_etu_emp_new" > <br>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="submit" id="enregistrerModificationNew" name="action" value="enregistrernouvel" onclick ="saveModificationNew()">Enregistrer</button>
                        <button type="button" onclick="closeModal('myModalNew')">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
</div>






<style>
    
    /* Styles pour la fenêtre modale */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #eee;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
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

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .modal-body {
        padding: 20px 0;
    }

    .modal-body form input,
    .modal-body form select{
        display: block;
        width: 100%;
        border-radius: 5px;
        height: 40px;
    }

    .modal-body form select option{
        color: #000;
        height: 15px;
    }

    .modal-body form div{
        display: flex;
        justify-content: start;
    }

    .modal-body form div input{
        width: 10%;
        height: 10px;
    }

    .modal-body form span{
        display: flex;
        flex-direction: column;
        
    }
    .modal-body form span img{
        border-radius: 100%;
        display: block;
        text-align: center;
    }
    .modal-body form span button{
        border: 0 solid;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        translate: 150px -80px ;
        display: inline-block;
        background-color: rgba(255,0,0,0);
        
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .modal-footer button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .modal-footer button:hover {
        background-color: #0056b3;
    }
</style>
