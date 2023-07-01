<!DOCTYPE html>
<html>
<head>
    <title>Deal Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 200px;
            padding: 5px;
        }

        select {
            width: 205px;
            padding: 5px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Deal Management</h1>

    <h2>Erstelle einen Deal:</h2>
    <form action="create_deal.php" method="POST">
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" id="barcode"><br>
        <label for="rabattpreis">Rabattpreis:</label>
        <input type="text" name="rabattpreis" id="rabattpreis"><br>
        <input type="submit" value="Deal erstellen">
    </form>

    <h2>Lösche einen Deal:</h2>
    <form action="delete_deal.php" method="POST">
        <label for="deal">Deal auswählen:</label>
        <select name="deal" id="deal">
            <?php
            $deals = file('deals.csv');
            foreach ($deals as $deal) {
                $dealData = explode(',', $deal);
                $barcode = trim($dealData[0]);
                $rabattpreis = trim($dealData[1]);
                echo "<option value=\"$barcode|$rabattpreis\">$barcode - Rabattpreis: $rabattpreis</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Deal löschen">
    </form>

    <h2>Aktive Deals:</h2>
    <table>
        <tr>
            <th>Barcode</th>
            <th>Rabattpreis</th>
        </tr>
        <?php
        foreach ($deals as $deal) {
            $dealData = explode(',', $deal);
            $barcode = trim($dealData[0]);
            $rabattpreis = trim($dealData[1]);
            echo "<tr><td>$barcode</td><td>$rabattpreis</td></tr>";
        }
        ?>
    </table>
     <button onclick="window.location.href = 'https://cash.schlumpf123cool.repl.co';">Zurück zur Kasse</button>
</body>
</html>
