<?php
// Name der Einkaufslistendatei
$einkaufslisteDatei = 'einkaufsliste.csv';

// Funktion zum Hinzufügen eines Produkts zur Einkaufsliste
function addToShoppingList($username, $product)
{
    global $einkaufslisteDatei; // Zugriff auf die globale Variable

    // Einkaufsliste öffnen oder erstellen, falls sie nicht existiert
    $einkaufsliste = fopen($einkaufslisteDatei, 'a+');

    // Produkt zur Einkaufsliste hinzufügen
    fwrite($einkaufsliste, $username . ',' . $product . PHP_EOL);

    // Einkaufsliste schließen
    fclose($einkaufsliste);
}

// Benutzername und Produkte aus den POST-Daten erhalten
if (isset($_POST['username']) && isset($_POST['product'])) {
    $username = $_POST['username'];
    $products = $_POST['product'];

    // Einzelne Produkte aufteilen
    $productArray = explode("\n", $products);

    // Jedes Produkt zur Einkaufsliste hinzufügen
    foreach ($productArray as $product) {
        // Leerzeichen und Zeilenumbrüche entfernen
        $product = trim($product);

        if (!empty($product)) {
            addToShoppingList($username, $product);
        }
    }
}
