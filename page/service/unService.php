<?php

include "fenetre_modal_service.php";

function transformPathToRelative($absolutePath) {
    // Extraire le nom de fichier depuis le chemin absolu
    $fileName = basename($absolutePath);

    // Construire le chemin relatif
    $relativePath = "../../image/photo_employe/" . $fileName;

    return $relativePath;
}
function buildService($id) {
    $service = getOneServiceWithId($id)[0];
    $imageResponsable = transformPathToRelative($service['photo_emp']);
    $id_serv = htmlspecialchars($service['id_serv']);
    $id_emp_resp = htmlspecialchars($service['id_emp_resp']);
    $nom_serv = htmlspecialchars($service['nom_serv'], ENT_QUOTES, 'UTF-8');
    $date_serv = htmlspecialchars($service['date_serv']);
    $description_serv = htmlspecialchars($service['description_serv'], ENT_QUOTES, 'UTF-8');

    // Créer un tableau associatif avec les données du service
    $service_data = [
        'id_serv' => $id_serv,
        'id_emp_resp' => $id_emp_resp,
        'nom_serv' => $nom_serv,
        'date_serv' => $date_serv,
        'description_serv' => $description_serv
    ];

    // Convertir ce tableau en JSON
    $json_service_data = json_encode($service_data);

    echo <<<SER
    <div class="service-container">
        <h2 class="service-title" id="service.$id_serv">$nom_serv</h2>
        <div class="service-details">
            <div class="responsable-section">
                <img class="responsable-photo" src="$imageResponsable" alt="Photo du responsable" width="100px" height="100px"> <br>
                <h5 class="responsable-title">Responsable</h5>
            </div>
            <div class="service-info">
                <p class="service-id"><strong>ID service</strong>: $id_serv</p>
                <p class="service-date"><strong>Créé le</strong>: $date_serv</p>
                <p class="service-mission"><strong>Mission</strong>: $description_serv</p>
            </div>
            <div class="service-actions">
                <button class="action-button" name="actionService" type="button" onclick='editService($json_service_data)'>Modifier</button>
                <br>
                <button class="action-button" name="actionService" type="button" onclick= 'confirmerSuppression($json_service_data)'>Supprimer</button>
            </div>
        </div>
    </div>
    SER;
}


function buildServiceReduite($id){
    $service = getOneServiceWithId($id)[0];
    echo <<<SER
    <div class="service-link-container" class="service-reduite-container">
        <a href="#service.{$service['id_serv']}" class="service-link">
            <h3 class="service-title">{$service['nom_serv']}</h3>
        </a>
    </div>

    SER; 
}


?>


<script src="script_service.js"></script>