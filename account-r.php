<?php
error_reporting(E_ERROR | E_PARSE);
// Überprüfung der Benutzername und Passwort
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pfad zur CSV-Datei
    $csvFile = 'kunden.csv';

    // Überprüfung der Anmeldedaten
    if (($handle = fopen($csvFile, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $csvUsername = $data[0];
            $csvPassword = $data[3];

            // Überprüfung, ob der Benutzername und das Passwort übereinstimmen
            if ($username === $csvUsername && $password === $csvPassword) {
                // Cookie mit dem Benutzernamen erstellen
                setcookie('username', $username, time() + (86400 * 30), '/'); // Gültigkeit: 30 Tage (86400 Sekunden pro Tag)
                fclose($handle);
                header('Location: account.php');
                exit();
            }
        }
        fclose($handle);
    }

    // Weiterleitung zur Login-Seite bei falschen Anmeldeinformationen oder wenn die CSV-Datei nicht geöffnet werden konnte
    header('Refresh: 5; URL=login.php');
    exit("Falsches Passwort oder Benutzername. Du wirst in 5 Sekunden zurückgeleitet.");
} else {
    // Weiterleitung zur Login-Seite (wenn keine POST-Anfrage gesendet wurde oder das Cookie nicht vorhanden ist)
    if (!isset($_COOKIE['username'])) {
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

</body>
</html>