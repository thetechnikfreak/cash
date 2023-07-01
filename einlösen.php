<!DOCTYPE html>
<html>
<head>
    <title>Kundenkarten Goodies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        h1 {
            color: #333;
            text-align: center;
        }
        
        h2 {
            color: #555;
            margin-bottom: 20px;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type="text"],
        select {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .success-message {
            color: green;
            margin-top: 10px;
        }
        
        .error-message {
            color: red;
            margin-top: 10px;
        }

        .number-kasse-btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Funktion zum Laden der Kundenpunkte aus der CSV-Datei
    function loadCustomerPoints()
    {
        $customers = array();

        // Pfad zur Kunden-CSV-Datei
        $csvFile = 'kunden.csv';

        // CSV-Datei öffnen
        $handle = fopen($csvFile, 'r');

        // CSV-Daten einlesen und Kundenpunkte in ein Array laden
        if ($handle !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $username = $data[0];
                $points = $data[1];
                $customers[$username] = $points;
            }
            fclose($handle);
        }

        return $customers;
    }

    // Funktion zum Speichern der Kundenpunkte in der CSV-Datei
    function saveCustomerPoints($customers)
    {
        // Pfad zur Kunden-CSV-Datei
        $csvFile = 'kunden.csv';

        // CSV-Datei zum Schreiben öffnen
        $handle = fopen($csvFile, 'w');

        // Kundenpunkte in die CSV-Datei schreiben
        if ($handle !== false) {
            foreach ($customers as $username => $points) {
                fputcsv($handle, array($username, $points));
            }
            fclose($handle);
        }
    }

    // Punkte von einem Benutzer abziehen
    function decreasePoints($username, $pointsToSubtract)
    {
        $customers = loadCustomerPoints();

        if (isset($customers[$username])) {
            $currentPoints = $customers[$username];
            if ($currentPoints >= $pointsToSubtract) {
                $newPoints = $currentPoints - $pointsToSubtract;
                $customers[$username] = $newPoints;
                saveCustomerPoints($customers);
                return true;
            }
        }

        return false;
    }

    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    function createCode($text) {
        $n = 3;
        $url = 'https://cash.thetechnikfreak.repl.co/create_goodie.php';
        $data = 'text=' . $text . '&pin=' . getName($n);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Überprüfen, ob das Formular gesendet wurde
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $goodie = $_POST['goodie'];

        if ($goodie == 'stempel') {
            if (decreasePoints($username, 15)) {
                $successMessage = 'Stempel erfolgreich eingelöst!';
                createCode($goodie);
            } else {
                $errorMessage = 'Nicht genügend Punkte für den Stempel.';
            }
        } elseif ($goodie == 'auto') {
            if (decreasePoints($username, 20)) {
                $successMessage = 'Auto erfolgreich eingelöst!';
                createCode($goodie);
            } else {
                $errorMessage = 'Nicht genügend Punkte für das Auto.';
            }
        } elseif ($goodie == 'lkw') {
            if (decreasePoints($username, 35)) {
                $successMessage = 'LKW erfolgreich eingelöst!';
                createCode($goodie);
            } else {
                $errorMessage = 'Nicht genügend Punkte für den LKW.';
            }
        }
    }
    ?>

    <h1>Kundenkarten Goodies</h1>

    <form method="post" action="">
        <label for="username">Benutzername:</label>
        <input type="text" name="username" id="username" required>

        <label for="goodie">Goodie:</label>
        <select name="goodie" id="goodie">
            <option value="stempel">Stempel (15 Punkte)</option>
            <option value="auto">Auto (20 Punkte)</option>
            <option value="lkw">LKW (35 Punkte)</option>
        </select>

        <input type="submit" name="submit" value="Punkte einlösen">

        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php elseif (isset($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </form>

    <script>
        function createCode(text) {
            var n = 3;
            var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var randomString = '';

            for (var i = 0; i < n; i++) {
                var index = Math.floor(Math.random() * characters.length);
                randomString += characters.charAt(index);
            }

            var url = 'https://cash.thetechnikfreak.repl.co/create_goodie.php';
            var data = 'text=' + text + '&pin=' + randomString;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data,
            })
            .then(response => response.text())
            .then(text => console.log(text))
            .catch(error => console.log(error));
        }
    </script>
</body>
</html>
