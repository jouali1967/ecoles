<?php
$file = __DIR__ . '/uploads/test.txt';
$result = file_put_contents($file, 'test');
if ($result === false) {
    echo "Erreur : impossible d'écrire dans le dossier uploads.";
} else {
    echo "Succès : écriture possible dans le dossier uploads.";
}
?>