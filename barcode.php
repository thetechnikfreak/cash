<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];

    // UPC ItemDB-API verwenden, um den Produktnamen und Preis abzurufen
    $apiUrl = "https://api.upcitemdb.com/prod/trial/lookup?upc=" . $barcode;
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if (isset($data['items']) && !empty($data['items'])) {
        $product = $data['items'][0];
        $name = $product['title'];
        $price = $product['lowest_recorded_price'];

        // Ergebnisse in CSV-Datei speichern
        $file = fopen('produkte.csv', 'a');
        $row = $barcode . ',' . $name . ',' . $price . "\n";
        fwrite($file, $row);
        fclose($file);
        echo $data;
        echo "<h2>Ergebnisse</h2>";
        echo "<p>Produktname: " . $name . "</p>";
        echo "<p>Preis: " . $price . "</p>";
    } else {
        echo "<h2>Keine Ergebnisse gefunden</h2>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produktsuche</title>
</head>
<body>
    <h1>Produktsuche</h1>
  
    <form method="POST" action="">
        <label for="barcode">Barcode:</label>
        <input type="text" id="barcode" name="barcode" placeholder="Barcode eingeben" required>
        <input type="submit" value="Suchen">
    </form>
     <button onclick="window.location.href = 'https://cash.schlumpf123cool.repl.co';">Zurück zur Kasse</button>
</body>
</html>
