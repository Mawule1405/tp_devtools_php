<?php
// Obtenir la date courante au format "jour/mois/année"
$date = date('d/m/Y');

// Obtenir l'heure courante au format "heure:minute:seconde"
$heure = date('H:i:s');

?>
<script>
        // Fonction pour mettre à jour l'heure en temps réel
        function updateTime() {
            var date = new Date(); // Obtenir la date et l'heure actuelles
            var dateString = date.toLocaleDateString(); // Formater la date
            var timeString = date.toLocaleTimeString(); // Formater l'heure

            // Mettre à jour les éléments HTML avec la date et l'heure
            document.getElementById('date').textContent = dateString;
            document.getElementById('heure').textContent = timeString;

            // Mettre à jour l'heure toutes les secondes
            setTimeout(updateTime, 1000);
        }

        // Appeler la fonction updateTime au chargement de la page
        window.onload = updateTime;
</script>


<?php
function create_nav_bar($path_of_file) {
    return <<<NAV
    <nav class="nav-bar">
        <ul>
            <li class="select-link"><a href="{$path_of_file["Accueil"]}">Accueil</a></li>
            <li class="select-link"><a href="{$path_of_file["Employe"]}">Employés</a></li>
            <li class="select-link"><a href="{$path_of_file["Ressources"]}">Ressources</a></li>
            <li class="select-link"><a href="{$path_of_file["Statistiques"]}">Statistiques</a></li>
            <li class="select-link"><a href="{$path_of_file["Aides"]}">Aides</a></li>
            <li class="select-link"><span id="date"></span> &nbsp; <span id="heure"></span></li>
        </ul>
    </nav>
NAV;
}
?>


