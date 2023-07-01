<?php
$selectedDeal = $_POST['deal'];
$selectedDealData = explode('|', $selectedDeal);
$barcode = $selectedDealData[0];
$rabattpreis = $selectedDealData[1];

// Löschen des Deals aus deals.csv
$dealsData = file('deals.csv');
foreach ($dealsData as $key => $deal) {
    $dealData = explode(',', $deal);
    $dealBarcode = trim($dealData[0]);
    $dealRabattpreis = trim($dealData[1]);

    if ($dealBarcode === $barcode && $dealRabattpreis === $rabattpreis) {
        unset($dealsData[$key]);
        break;
    }
}

file_put_contents('deals.csv', implode('', $dealsData));

// Aktualisieren des Preises in produkte.csv
$produkteData = file('produkte.csv');
$produkteNormalData = file('produktenormal.csv');

foreach ($produkteData as &$produkt) {
    $produktData = explode(',', $produkt);
    $produktBarcode = trim($produktData[0]);
    $produktName = trim($produktData[1]);
    $produktPreis = trim($produktData[2]);

    if ($produktBarcode === $barcode) {
        foreach ($produkteNormalData as $produktNormal) {
            $produktNormalData = explode(',', $produktNormal);
            $produktNormalBarcode = trim($produktNormalData[0]);
            $produktNormalName = trim($produktNormalData[1]);
            $produktNormalPreis = trim($produktNormalData[2]);

            if ($produktNormalBarcode === $barcode) {
                $produktPreis = $produktNormalPreis;
                break;
            }
        }

        $produkt = "$produktBarcode,$produktName,$produktPreis\n";
        break;
    }
}

file_put_contents('produkte.csv', implode('', $produkteData));
header('Location: manege_deals.php');
echo "Deal gelöscht und Preise aktualisiert.";
?>
