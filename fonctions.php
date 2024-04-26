<?php
    function build_employe($employe){
        if($employe["photo_emp"])
        {   
            echo "<div> <img src='" . $employe["photo_emp"] . "' alt='' srcset=''> </div>";
        }
    }

    function localPathToUrl($localPath) {
        // Remplacez le chemin racine local par le domaine de votre site web
        $webRoot = ""; // Remplacez example.com par votre nom de domaine
        // Remplacez les backslashes par des slashes
        $url = str_replace('\\', '/', $localPath);
        // Supprimez la partie du chemin local jusqu'au répertoire racine de votre site web
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], $webRoot, $url);
        return $url;
    }
    function create_employe_options($employees){
        $liste = [];

        foreach($employees as $emp => $val){
            $liste[$val["id_emp"]] = $val["id_emp"]." ".$val["nom_emp"]." ".$val["prenom_emp"];
        }

        return $liste;
    }

    function create_service_options($services){
        $liste = [];

        foreach($services as $serv => $val){
            $liste[$val["id_serv"]] = $val["id_serv"]." ".$val["nom_serv"];
        }

        return $liste;
    }
?>
