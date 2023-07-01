<?php
// Pfad zur anzeige.csv-Datei
$csvFile = 'anzeige.csv';

// Produktinformationen aus der POST-Anfrage erhalten
$code = $_POST['code'];
$name = $_POST['name'];
$price = $_POST['price'];

// Neue Zeile in die CSV-Datei schreiben
$line = "$code,$name,$price\n";
file_put_contents($csvFile, $line, FILE_APPEND);

// Erfolgsantwort an den Client senden
echo "success";
?>
