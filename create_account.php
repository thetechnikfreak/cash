<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account erstellen</title>
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
        
        /* Stil für das Logo */
        .logo {
            display: block;
            margin: 20px auto;
            text-align: center;
        }
        
        .logo img {
          width: 200px;
        }

        /* Stil für den Haupttitel */
        h1 {
            text-align: center;
        }

        /* Stil für die Formulare */
        form {
            margin-top: 20px;
            text-align: center;
        }

        /* Stil für die Formulareingaben */
        input[type="text"],
        input[type="password"] {
            padding: 8px;
            width: 200px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Stil für die Schaltflächen */
        input[type="submit"] {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        /* Stil für die Erfolgsmeldung */
        .success-message {
            color: #4CAF50;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        /* Stil für die Fehlermeldung */
        .error-message {
            color: #f44336;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
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
          <a href="/account.php">Account</a>
    </div>
    <h1>Account erstellen</h1>


    <?php
error_reporting(E_ALL & ~E_WARNING);

    // Funktion zum Speichern der Kundendaten
    function speichern($username, $punkte, $email)
    {
        // Pfad zur CSV-Datei
        $datei = 'kunden.csv';

        // Kundendaten
        $kundendaten = array($username, $punkte, $email);

        // Überprüfen, ob der Benutzername bereits existiert
        if (benutzernameExistiert($username)) {
            echo '<div class="error-message">Der Benutzername ' . $username . ' existiert bereits.</div>';
            return;
        }

        // Kundendaten zur CSV-Datei hinzufügen
        $csv = fopen($datei, 'a');
        fputcsv($csv, $kundendaten);
        fclose($csv);
        echo '<div class

="success-message">Account für ' . $username . ' wurden erfolgreich erstellt. ⟫  <a href="/login.php">Zum Login</a> ⟪</div>';

        // Kunden-ID in einem Cookie speichern
        setcookie('kunden_id', $username, time() + (86400 * 30), '/'); // Gültig für 30 Tage, '/' für den gesamten Pfad
    }

    // Funktion zum Anzeigen der Punkte


    // Funktion zum Überprüfen, ob ein Benutzername bereits existiert
    function benutzernameExistiert($username)
    {
        // Pfad zur CSV-Datei
        $datei = 'kunden.csv';

        // CSV-Datei auslesen
        if (($csv = fopen($datei, 'r')) !== FALSE) {
            while (($daten = fgetcsv($csv, 1000, ',')) !== FALSE) {
                if ($daten[0] === $username) {
                    fclose($csv);
                    return true;
                }
            }
            fclose($csv);
        }

        return false;
    }

    // Verarbeite Formulardaten
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $punkte = "0";

        speichern($username, $punkte, $email, $password);
    }

    // Verarbeite Anzeige-Anfrage
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
        $username = $_GET['username'];
        anzeigen($username);
    }
    ?>


    <form method="post" action="">
        <label for="username">Benutzername:</label><br>
        <input type="text" name="username" id="username" required><br>
        <label for="email">Email:</label><br>
        <input type="text" name="email" id="email"><br>
        <label for="password">Passwort:</label><br>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="Account erstellen">
    </form>

</body>
</html>