<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si des données JSON ont été envoyées dans la requête POST
    $data = json_decode(file_get_contents("php://input"), true);
    $file = 'appro.txt'; // Nom du fichier de sauvegarde
    $fileContent = ''; // Contenu à écrire dans le fichier
    if (isset($data)) {
        // Traiter les données JSON ici
        var_dump($data);
        foreach($data as $entry){
            $date = date("Y-m-d", strtotime($entry["date"]));
            //insererCommande();
            //insererAppartenir();
            $fileContent .= "ID Employé: " . $entry['id_emp'] . " | Quantité: " . $entry['qte'] . " | Date: " . $entry['date'] . PHP_EOL;
        }

        file_put_contents($file, $fileContent, FILE_APPEND);
    } else {
        echo "Aucune donnée JSON n'a été envoyée dans la requête POST.";
    }
} 
else {
    echo "Cette page ne peut être accédée que via une requête POST.";
}