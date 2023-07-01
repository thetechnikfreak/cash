<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Startseite - Lilo Supermarkt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #48C9B0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .content {
            text-align: center;
            background-color: #48C9B0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        h1, h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
            text-align: center;
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
      .add-to-list-button {
            background-color: #78f4b5;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>

    <script>
        // JavaScript-Code für die Suchfunktion

        // Funktion zum Durchsuchen der Produkte
        function searchProducts() {
            // Eingabefeld für die Suchanfrage abrufen
            var searchQuery = document.getElementById('searchInput').value.toLowerCase();

            // Alle Produktelemente abrufen
            var productList = document.getElementsByClassName('product');

            // Über die Produktliste iterieren und nach Übereinstimmungen suchen
            for (var i = 0; i < productList.length; i++) {
                var product = productList[i];
                var productName = product.getElementsByClassName('name')[0].innerText.toLowerCase();

                // Überprüfen, ob das Produkt den Suchbegriff enthält
                if (productName.includes(searchQuery)) {
                    // Produkt anzeigen, wenn Übereinstimmung gefunden wurde
                    product.style.display = 'block';
                } else {
                    // Produkt ausblenden, wenn keine Übereinstimmung gefunden wurde
                    product.style.display = 'none';
                }
            }
        }
      
          function addToShoppingList(username, product) {
  // Überprüfen, ob ein Cookie mit dem Benutzernamen existiert
  if (getCookie(username) === "") {
    if (username === "") {
      // Weiterleitung zur Login-Seite
      window.location.href = "login.php";
    } else {
      // AJAX-Anfrage zum Hinzufügen des Produkts zur Einkaufsliste
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "add_to_shopping_list.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Erfolgreiche Antwort erhalten
          console.log("Produkt zur Einkaufsliste hinzugefügt: " + product);
        }
      };
      xhr.send("username=" + username + "&product=" + product);
    }
  } else {
    // AJAX-Anfrage zum Hinzufügen des Produkts zur Einkaufsliste
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_shopping_list.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Erfolgreiche Antwort erhalten
        console.log("Produkt zur Einkaufsliste hinzugefügt: " + product);
      }
    };
    xhr.send("username=" + username + "&product=" + product);
  }
}


        // Funktion zum Abrufen des Cookie-Werts anhand des Namens
        function getCookie(name) {
            var cookieName = name + "=";
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.indexOf(cookieName) === 0) {
                    return cookie.substring(cookieName.length, cookie.length);
                }
            }
            return "";
        }
      
    </script>
</head>
<body>
    
        <div class="logo">
          <img src="logo.png" alt="Logo">
        </div>
        <div class="menu">
            <a href="/web.php">Startseite</a>
            <a href="/deals.php">Angebote</a>
            <a href="/account.php">Account</a>
        </div>
      

        <div class="content">    
            <form>
                <label for="searchInput">Produktsuche:</label>
                <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Produktname eingeben...">
            </form>

            <ul>
                <?php
error_reporting(E_ERROR | E_PARSE);
            $file = fopen('produkte.csv', 'r');
            if ($file) {
                while (($line = fgetcsv($file)) !== false) {
                    $barcode = $line[0];
                    $name = $line[1];
                    $price = $line[2];
                    echo '<li class="product"><span class="name">' . $name . '</span> - <span class="price">' . $price . ' €' . '</span> <button class="add-to-list-button" type="button" onclick="addToShoppingList(\'' . $_COOKIE["username"] . '\', \'' . $name . '\')">Zur Einkaufsliste hinzufügen</button></li>';
                }
                fclose($file);
            }
            ?>
            </ul>
        </div>
    </div>
</body>
</html>
