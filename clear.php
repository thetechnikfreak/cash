<?php
$file = 'anzeige.csv';

// Öffne die Datei im Schreibmodus
$handle = fopen($file, 'w');

if ($handle) {
    // Lösche den Inhalt der Datei
    fwrite($handle, '');

    // Schließe die Datei
    fclose($handle);

    echo 'Die Datei "anzeige.csv" wurde erfolgreich geleert.';
} else {
    echo 'Fehler beim Öffnen der Datei.';
}
?>
