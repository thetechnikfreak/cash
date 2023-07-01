<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];
    $produkt = $_POST['produkt'];
    $preis = $_POST['preis'];

    // Daten in CSV-Format konvertieren
    $data = $barcode . ',' . $produkt . ',' . $preis . PHP_EOL;

    // Daten in die Datei schreiben
    file_put_contents('produkte.csv', $data, FILE_APPEND | LOCK_EX);
    file_put_contents('produktenormal.csv', $data, FILE_APPEND | LOCK_EX);

    // Erfolgsmeldung anzeigen
    echo 'Die Daten wurden erfolgreich gespeichert!';
}
?>

<!DOCTYPE html>
<html>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<head>
    <title>Produkte Formular</title>
</head>
<body>
    <h1>Produkte Formular</h1>
    <form method="POST" action="">
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" id="barcode" required><br>

        <label for="produkt">Produkt:</label>
        <input type="text" name="produkt" id="produkt" required><br>

        <label for="preis">Preis:</label>
        <input type="text" name="preis" id="preis" required><br>

        <input type="submit" value="Speichern">
    </form>
   <button onclick="window.location.href = 'https://cash.schlumpf123cool.repl.co';">Zurück zur Kasse</button>

</body>
</html>
