<?php
$barcode = $_POST['barcode'];
$rabattpreis = $_POST['rabattpreis'];

// Speichern des Deals in deals.csv
$dealData = "$barcode,$rabattpreis\n";
file_put_contents('deals.csv', $dealData, FILE_APPEND);

// Aktualisieren des Preises in produkte.csv
$produkteData = file('produkte.csv');
foreach ($produkteData as &$produkt) {
    $produktData = explode(',', $produkt);
    $produktBarcode = trim($produktData[0]);
    $produktName = trim($produktData[1]);
    $produktPreis = trim($produktData[2]);

    if ($produktBarcode === $barcode) {
        $produktPreis = $rabattpreis;
        $produkt = "$produktBarcode,$produktName,$produktPreis\n";
        break;
    }
}

file_put_contents('produkte.csv', implode('', $produkteData));
header('Location: manege_deals.php');
echo "Deal erstellt und Preise aktualisiert.";
?>
