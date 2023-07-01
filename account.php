<?php
error_reporting(E_ERROR | E_PARSE);

// Überprüfung des Benutzernamens und Passworts

// Weiterleitung zur Login-Seite (wenn keine POST-Anfrage gesendet wurde oder das Cookie nicht vorhanden ist)
if (!isset($_COOKIE['username'])) {
    header('Location: login.php');
    exit();
}

function anzeigen($username)
{
    // Pfad zur CSV-Datei
    $datei = 'kunden.csv';

    // CSV-Datei auslesen
    if (($csv = fopen($datei, 'r')) !== FALSE) {
        while (($daten = fgetcsv($csv, 1000, ',')) !== FALSE) {
            if ($daten[0] === $username) {
                echo '<div class="success-message">Aktuelle Punkte: ' . $daten[1] . '</div>';
                echo '<h2>Einkaufsliste</h2>';

                // Einkaufsliste laden
                $einkaufslisteDatei = 'einkaufsliste.csv';
                $einkaufsliste = array();

                if (($handle = fopen($einkaufslisteDatei, 'r')) !== false) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        if ($data[0] === $username) {
                            $produkt = $data[1];
                            $abgehakt = $data[2];

                            // Produkt in der Einkaufsliste anzeigen
                            echo '<div class="product">';
                            echo $produkt;
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="product" value="' . htmlspecialchars($produkt) . '">';
                            echo '<input type="submit" name="check" value="Abhaken">';
                            echo '</form>';
                            echo '</div>';

                            $einkaufsliste[] = array($username, $produkt, $abgehakt);
                        }
                    }
                    fclose($handle);
                }

                // Einkaufsliste speichern
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product']) && isset($_POST['check'])) {
                    $product = $_POST['product'];

                    // Produkt aus der Einkaufsliste entfernen
                    foreach ($einkaufsliste as $key => $item) {
                        if ($item[0] === $username && $item[1] === $product) {
                            unset($einkaufsliste[$key]);
                            break;
                        }
                    }

                    // Einkaufsliste in CSV-Datei speichern
                    if (($handle = fopen($einkaufslisteDatei, 'w')) !== false) {
                        foreach ($einkaufsliste as $row) {
                            fputcsv($handle, $row);
                        }
                        fclose($handle);
                    }
                }

                fclose($csv);
                return;
            }
        }
        fclose($csv);
    }

    echo '<div class="error-message">Keine Kundendaten gefunden.</div>';
}

// Einkaufsliste laden
$einkaufslisteDatei = 'einkaufsliste.csv';
$einkaufsliste = array();

if (($handle = fopen($einkaufslisteDatei, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $usernameInListe = $data[0];
        $produktInListe = $data[1];
        $abgehaktInListe = $data[2];

        // Überprüfe, ob das Produkt nicht abgehakt ist und es dem aktuellen Benutzer gehört
        if ($abgehaktInListe !== '1' || $usernameInListe !== $_COOKIE['username']) {
            $einkaufsliste[] = array($usernameInListe, $produktInListe, $abgehaktInListe);
        }
    }
    fclose($handle);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Lilo Supermarkt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #48C9B0;
        }

        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1,
        h2 {
            color: #333;
        }

        p {
            margin-top: 20px;
            text-align: center;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .logo img {
            width: 200px;
        }

        .menu {
            background-color: #78f4b5;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }

        .menu a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
            font-weight: bold;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product form {
            display: inline;
            margin-left: 10px;
        }

        .product input[type="submit"] {
            background-color: #78f4b5;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .product input[type="submit"]:hover {
            background-color: #48C9B0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Lilo Supermarkt">
        </div>
        <div class="menu">
            <a href="/web.php">Startseite</a>
            <a href="/deals.php">Angebote</a>
            <a href="/logout.php">Logout</a>
        </div>
        <h1>Account</h1>
        <?php anzeigen($_COOKIE['username']); ?>
    </div>
</body>

</html>
