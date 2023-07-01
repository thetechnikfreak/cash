<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Lilo Supermarkt</title>
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

    h1, h2 {
        color: #333;
    }

    ul {
        list-style-type: none;
        padding: 0;
        margin-top: 20px;
        text-align: left;
    }

    li {
        margin-bottom: 10px;
    }

    label {
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="password"] {
        width: 200px;
        padding: 5px;
        text-align: center;
        border: 1px solid #ccc;
    }

    input[type="submit"] {
        background-color: #78f4b5;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
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
          <a href="/login.php">Account</a>
    </div>
        <h1>Aktuelle Deals</h1>
        <?php
        function readDealsFromCSV() {
            $deals = [];
            $file = fopen('deals.csv', 'r');
            if ($file) {
                while (($data = fgetcsv($file)) !== false) {
                    $deals[] = $data;
                }
                fclose($file);
            }
            return $deals;
        }

        function getProductDetails($barcode) {
            $products = [];
            $file = fopen('produktenormal.csv', 'r');
            if ($file) {
                while (($data = fgetcsv($file)) !== false) {
                    if ($data[0] == $barcode) {
                        $products[$data[1]] = [
                            'name' => $data[1],
                            'barcode' => $data[0],
                            'normal_price' => $data[2]
                        ];
                        return $products[$data[1]];
                    }
                }
                fclose($file);
            }
            return false;
        }

        function displayDeals($deals) {
            if (!empty($deals)) {
                echo '<ul>';
                foreach ($deals as $deal) {
                    $barcode = $deal[0];
                    $discountedPrice = $deal[1];

                    $product = getProductDetails($barcode);
                    if ($product) {
                        echo '<li>' . $product['name'] . ' - ' . $discountedPrice . '€' . ' (Normaler Preis: ' . $product['normal_price'] . ')</li>';
                    } else {
                        echo '<li>Produkt mit Barcode ' . $barcode . ' nicht gefunden</li>';
                    }
                }
                echo '</ul>';
            } else {
                echo '<p>Keine Deals verfügbar.</p>';
            }
        }

        $currentDeals = readDealsFromCSV();
        displayDeals($currentDeals);
        ?>

        <h2>Kundenkarte erstellen oder anmelden</h2>

        <form action="kundenkarte.php" method="POST">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" required><br>

            <label for="password">Passwort:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Anmelden">
        </form>

        <p>Noch keinen Account? <a href="create_account.php">Hier</a> eine Kundenkarte erstellen.</p>
    </div>
</body>
</html>
