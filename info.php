<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump(($_POST));
    if (isset($_FILES['photo_emp']) && $_FILES['photo_emp']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo_emp']['tmp_name'];
        $fileName = $_FILES['photo_emp']['name'];
        $fileSize = $_FILES['photo_emp']['size'];
        $fileType = $_FILES['photo_emp']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Définir les extensions autorisées
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $fileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                echo 'Le fichier est téléchargé avec succès.';
            } else {
                echo 'Erreur lors du téléchargement du fichier.';
            }
        } else {
            echo 'Type de fichier non supporté.';
        }
    } else {
        echo 'Erreur lors du téléchargement du fichier.';
    }
}
?>


<form id="uploadForm" enctype="multipart/form-data">
    <label for="photo_emp">Choisir une photo :</label>
    <input type="file" id="photo_emp" name="photo_emp">
    <button type="button" onclick="uploadFile()">Télécharger</button>
</form>


<script>
    function uploadFile() {
    const form = document.getElementById('uploadForm');
    const formData = new FormData(form);

    fetch('info.php.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log('Success:', result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>