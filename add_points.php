<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $amount = $_POST["amount"];

    // CSV-Datei öffnen und aktualisieren
    $filename = "kunden.csv";
    $file = fopen($filename, "a+");

    if ($file) {
        // Überprüfen, ob der Benutzer bereits in der CSV-Datei vorhanden ist
        $isUserExists = false;
        $data = array();
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] == $username) {
                $isUserExists = true;
                $row[1] += $amount;
            }
            $data[] = $row;
        }

        // Wenn der Benutzer nicht gefunden wurde, eine neue Zeile hinzufügen
        if (!$isUserExists) {
            fclose($file);

            // Überprüfen, ob der Benutzername existiert
            $existingUsernames = array_column($data, 0);
            if (!in_array($username, $existingUsernames)) {
                echo "error: Benutzername existiert nicht";
                exit;
            }

            $file = fopen($filename, "a+");  // Datei erneut öffnen, um Zeile hinzuzufügen
            $data[] = [$username, $amount];
        }

        // CSV-Datei leeren und mit aktualisierten Daten wieder schreiben
        ftruncate($file, 0);
        rewind($file);
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        echo "success";
    } else {
        echo "error: Datei konnte nicht geöffnet werden";
    }
}
?>
