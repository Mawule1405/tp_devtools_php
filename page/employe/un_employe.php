

<?php
    include "fenetre_modal_emp.php";
    
    function transformPathToRelative($absolutePath) {
        // Extraire le nom de fichier depuis le chemin absolu
        $fileName = basename($absolutePath);
    
        // Construire le chemin relatif
        $relativePath = "../../image/photo_employe/" . $fileName;
    
        return $relativePath;
    }

function buildEmploye($employe) {
    $photoProfile = transformPathToRelative($employe['photo_emp']);
    echo <<<EMP
    <div id="employe.{$employe['id_emp']}" class="employe-card">
        <form action="" method="post" id ="forme-card">
            <div class="photo-card">
                <p><img src="{$photoProfile}" alt="Photo de profil" id="photo_emp"></p>
                <p>{$employe['nom_emp']} {$employe['prenom_emp']}</p>
            </div>
            <div class="information-card">
                <table>
                    <tr><td>Sexe: </td><td>{$employe['Sexe']}</td></tr>
                    <tr><td>Nationalité: </td><td>{$employe['nationalite_emp']}</td></tr>
                    <tr><td>Lieu de résidence: </td><td>{$employe['lieu_res_emp']}</td></tr>
                    <tr><td>Salaire : </td><td>{$employe['salaire_emp']} FCFA</td></tr>
                    <tr><td>Email: </td><td>{$employe['email_emp']}</td></tr>
                    <tr><td>Téléphone: </td><td>{$employe['contact_emp']}</td></tr>
                    <tr><td>Date de naissance: </td><td>{$employe['date_nais_emp']}</td></tr>
                    <tr><td>Date d'embauche: </td><td>{$employe['date_embau_emp']}</td></tr>
                    <tr><td>Service: </td><td>{$employe['nom_serv']}</td></tr>
                    <tr><td>Niveau d'étude: </td><td>{$employe['niveau_etu_emp']}</td></tr>
                </table>
            </div>
            <div class="button-group">
                <button type="button" onclick="openModalWithData('{$employe['id_emp']}', '{$employe['nom_emp']}', '{$employe['prenom_emp']}', '{$employe['Sexe']}', '{$employe['nationalite_emp']}', '{$employe['lieu_res_emp']}', '{$employe['salaire_emp']}', '{$employe['email_emp']}', '{$employe['contact_emp']}', '{$employe['date_nais_emp']}', '{$employe['date_embau_emp']}', '{$employe['nom_serv']}', '{$employe['niveau_etu_emp']}', '{$photoProfile}')">Modifier</button>
                <button type="submit" name='action' value='exporterEmployeInfo'>Exporter</button>
                <button type="button" name='action' valeur='supprimerEmploye'>Supprimer</button>
            </div>
        </form>
    </div>
    EMP;
}



function buildEmployeReduite($employeReduite){
    $photoProfile = transformPathToRelative($employeReduite['photo_emp']);
    echo <<<EMP
        <a href="#employe.{$employeReduite['id_emp']}" class="employe-reduite-card">
            <img src="{$photoProfile}" alt="Icone de la photo de profile" width="50" height="50">
            <p class="employe-nom">{$employeReduite['nom_emp']} {$employeReduite['prenom_emp']}</p>
        </a>
    EMP;
}





   
?>


<script src="script_employe.js"></script>