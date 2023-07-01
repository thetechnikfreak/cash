<?php
if (isset($_POST['csvContent'])) {
    $csvContent = $_POST['csvContent'];

    // Dateipfad zum Speichern der CSV-Datei
    $filePath = 'verkaufsdaten.csv';

    // CSV-Datei speichern
    if (file_put_contents($filePath, $csvContent, FILE_APPEND | LOCK_EX) !== false) {
        echo "Sales data saved successfully.";
    } else {
        echo "Error saving sales data.";
    }
}
?>
