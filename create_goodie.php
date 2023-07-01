<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfen, ob sowohl der Text als auch der PIN gesendet wurden
    if (isset($_POST["text"]) && isset($_POST["pin"])) {
        // Den Text und den PIN aus den POST-Daten abrufen
        $text = $_POST["text"];
        $pin = $_POST["pin"];

        // Überprüfen, ob die CSV-Datei existiert und sie zum Schreiben öffnen
        $file = fopen("goodie.csv", "a");
        if ($file) {
            // Den Text und den PIN zur CSV-Datei hinzufügen
            $data = array($pin, $text);
            fputcsv($file, $data);
            fclose($file);
            echo "Daten wurden erfolgreich gespeichert!";
        } else {
            echo "Fehler beim Öffnen der Datei!";
        }
    } else {
        echo "Fehlende Parameter!";
    }
}
?>
