<!DOCTYPE html>
<html>
<head>
    <title>Buttonkasse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 50px;
        }

        #cart {
            max-width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            position: fixed;
            top: 50px;
            right: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #cart h2 {
            margin: 0 0 10px;
        }

        #cart-items {
            margin-bottom: 10px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }

        #total-price {
            font-weight: bold;
            margin-bottom: 5px;
        }

        #payment-btn {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #payment-btn:hover {
            background-color: #45a049;
        }

        #product-list {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 10px;
            max-width: 700px;
            margin-top: 20px;
        }

        .product-btn {
            font-size: 17px;
            padding: 10px;
            width: 100%;
            background-color: #337ab7;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product-btn:hover {
            background-color: #23527c;
        }

        #audio-tab {
            max-width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #audio-tab h2 {
            margin: 0 0 10px;
        }

        .audio-btn {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .audio-btn:hover {
            background-color: #45a049;
        }

        .volume-slider {
            width: 100%;
            margin-top: 5px;
        }

        .manage-products-btn,
        .number-kasse-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px;
            background-color: #337ab7;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .manage-products-btn:hover,
        .number-kasse-btn:hover {
            background-color: #23527c;
        }
        .page-switcher-btn {
            display: inline-block;
            margin-right: 20px;
            background-color: #337ab7;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

    </style>
</head>
<body>
    <div class="container">
        <div id="cart">
            <h2>Warenkorb</h2>
            <div id="cart-items"></div>
            <div id="total-price">Gesamtpreis: 0 €</div>
            <button id="payment-btn" onclick="pay()">Bezahlen</button>
        </div>
    </div>
  <input type="text" id="search-input" placeholder="Produkt suchen">
<button id="search-button" onclick="searchProduct()">Suchen</button>

    <div id="product-list"></div>
<button class="page-switcher-btn" onclick="goToPreviousPage();">«</button>
<button class="page-switcher-btn" onclick="goToNextPage();">»</button>

    <button class="manage-products-btn" onclick="window.location.href = '/produkte.php';">Produkte Verwalten</button>
    <button class="number-kasse-btn" onclick="window.location.href = '/barcode.php';">AI Produkte Verwalten</button>
    <button class="number-kasse-btn" onclick="window.location.href = '/einlösen.php';">Kundenkarten Goodies</button>
  <button class="number-kasse-btn" onclick="addFruitOrVegetableToCart()">Obst/Gemüse hinzufügen</button>
      <button class="number-kasse-btn" onclick="window.location.href = 'manege_deals.php';">Deals Verwalten</button>


    <div id="audio-tab">
        <h2>Audio</h2>
        <button class="audio-btn" id="playButton">Musik</button>
        <input class="volume-slider" type="range" id="musicVolumeSlider" min="0" max="1" step="0.1" value="0.05">
        <button class="audio-btn" id="playButton2">Kasse Schließt</button>
        <input class="volume-slider" type="range" id="kasseVolumeSlider" min="0" max="1" step="0.1" value="1">
        <button class="audio-btn" id="playButton3">Werbung</button>
        <input class="volume-slider" type="range" id="randomAudioVolumeSlider" min="0" max="1" step="0.1" value="1">
    <button class="audio-btn" id="startMicrophoneButton">Mikro starten</button>
    <button class="audio-btn" id="stopMicrophoneButton">Mikro stoppen</button>
      </div>
      
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><script>
      
        var audio = new Audio("http://stream.laut.fm/chilled-beats");
        audio.volume = 0.05;
        var audio2 = new Audio("kasseschliest.mp3");
        var mp3s = [
            "werbung_minieis.mp3",
            "werbung_pringels.mp3",
            "werbung_somat.mp3",
        ];

        function playAudio() {
            audio.play();
        }
        
        function playAudio2() {
            audio2.play();
        }

        function playRandomMP3() {
            var randomIndex = Math.floor(Math.random() * mp3s.length);
            var randomAudio = new Audio(mp3s[randomIndex]);
            randomAudio.volume = document.getElementById('randomAudioVolumeSlider').value;
            randomAudio.play();
        }
      function searchProduct() {
    let searchInput = document.getElementById('search-input').value.toLowerCase();
    let filteredProducts = products.filter(function(product) {
        return product.name.toLowerCase().includes(searchInput);
    });
    showFilteredProducts(filteredProducts);
}
function showFilteredProducts(filteredProducts) {
    productListElement.innerHTML = '';

    for (let i = 0; i < filteredProducts.length; i++) {
        let product = filteredProducts[i];
        let button = document.createElement('button');
        button.innerText = product.name + ' - ' + product.price.toFixed(2) + ' €';
        button.classList.add('product-btn');
        button.onclick = function () {
            addToCart(product);
        };
        productListElement.appendChild(button);
    }
}


        $(document).ready(function() {
            $('#playButton').on('click', function() {
                playAudio();
            });

            $('#playButton2').on('click', function() {
                playAudio2();
            });

            $('#playButton3').on('click', function() {
                playRandomMP3();
            });

            setInterval(function() {
                playRandomMP3();
            }, 420000); // Every 7 minutes (420000 milliseconds)

            $('#musicVolumeSlider').on('input', function() {
                audio.volume = $(this).val();
            });

            $('#kasseVolumeSlider').on('input', function() {
                audio2.volume = $(this).val();
            });

            $('#randomAudioVolumeSlider').on('input', function() {
                // Adjust the volume of the random audio currently playing (if any)
                var randomAudios = document.querySelectorAll('audio:not(#playButton2)');
                randomAudios.forEach(function(audio) {
                    audio.volume = $(this).val();
                });
            });
        });

        let products = [];
        let cartItems = [];

        // CSV-Datei einlesen und Produkte speichern
        $.ajax({
            url: "produkte.csv",
            async: false,
            success: function (csv) {
                let lines = csv.split("\n");
                for (let i = 0; i < lines.length; i++) {
                    let values = lines[i].split(",");
                    let product = {
                        code: values[0],
                        name: values[1],
                        price: parseFloat(values[2])
                    };
                    products.push(product);
                }
            }
        });

        // Produktliste erstellen
let productListElement = document.getElementById('product-list');
let currentPage = 1;
let itemsPerPage = 36;

function showProducts(page) {
    productListElement.innerHTML = '';

    let startIndex = (page - 1) * itemsPerPage;
    let endIndex = startIndex + itemsPerPage;

    for (let i = startIndex; i < endIndex && i < products.length; i++) {
        let product = products[i];
        let button = document.createElement('button');
        button.innerText = product.name + ' - ' + product.price.toFixed(2) + ' €';
        button.classList.add('product-btn');
        button.onclick = function () {
            addToCart(product);
        };
        productListElement.appendChild(button);
    }
}

function goToPage(page) {
    if (page < 1 || page > Math.ceil(products.length / itemsPerPage)) {
        return;
    }
    currentPage = page;
    showProducts(currentPage);
}

function goToNextPage() {
    if (currentPage < Math.ceil(products.length / itemsPerPage)) {
        goToPage(currentPage + 1);
    }
}

function goToPreviousPage() {
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
}

showProducts(currentPage);




        // Zum Warenkorb hinzufügen
        function addToCart(product) {
    cartItems.push(product);
    addToCSV(product);
    updateCart();
    // Clear search input after adding the product to cart
    document.getElementById('search-input').value = '';
}

        // Warenkorb aktualisieren
        function updateCart() {
    let cartItemsElement = document.getElementById('cart-items');
    cartItemsElement.innerHTML = '';
    let totalPrice = 0;
    let startIndex = Math.max(0, cartItems.length - 8);
    let searchInput = document.getElementById('search-input').value.toLowerCase();
    let filteredCartItems = cartItems.filter(function(item) {
        return item.name.toLowerCase().includes(searchInput);
    });// Startindex basierend auf den letzten 8 Produkten
    for (let i = startIndex; i < cartItems.length; i++) {
        let item = cartItems[i];
        let itemElement = document.createElement('div');
        itemElement.classList.add('cart-item');
        let nameElement = document.createElement('span');
        nameElement.innerText = item.name;
        let priceElement = document.createElement('span');
        priceElement.innerText = item.price.toFixed(2) + ' €';
        itemElement.appendChild(nameElement);
        itemElement.appendChild(priceElement);
        cartItemsElement.appendChild(itemElement);
        totalPrice += item.price;
    }
    let totalPriceElement = document.getElementById('total-price');
    totalPriceElement.innerText = 'Gesamtpreis: ' + totalPrice.toFixed(2) + ' €';
}
      // Funktion zum Hinzufügen von Obst und Gemüse zum Warenkorb
function addFruitOrVegetableToCart() {
    var grams = prompt("Bitte geben Sie die Grammzahl ein:");
    if (grams) {
        var price = parseFloat(grams) * 0.20;
        var product = {
            name: "Obst/Gemüse (" + grams + " g)",
            price: price
        };
        addToCart(product);
    }
}



        // Bezahlen
        function pay() {
          
          if (cartItems.length === 0) {
              alert('Der Warenkorb ist leer.');
          } else {
              let totalPrice = 0;
              let itemList = [];
              for (let i = 0; i < cartItems.length; i++) {
                  let item = cartItems[i];
                  totalPrice += item.price;
                  itemList.push(item.name + ': ' + item.price + '€'); // Artikelname und Preis zur Liste hinzufügen
              }
              let username = prompt("Bitte geben Sie Ihre Benutzer-ID ein:");
              if (username) {
                let amount = totalPrice;
                addPointsToUser(username, amount);
                sendEmailToUser(username, totalPrice,itemList)
                saveSalesDataToCSV(itemList); 
              }
              alert('Bezahlt ' + totalPrice.toFixed(2) + ' €.');
              cartItems = [];
              updateCart();
              $.ajax({
                    url: "clear.php",
                    type: "POST",
                    success: function (response) {
                        console.log("Shopping cart cleared successfully.");
                    },
                    error: function (xhr, status, error) {
                        console.error("Error clearing shopping cart:", error);
                    }
              });
         }
      }
      function saveSalesDataToCSV(itemList) {
        let csvContent = ""; // CSV-Header
        for (let i = 0; i < itemList.length; i++) {
            let itemData = itemList[i].split(': ');
            let itemName = itemData[0];
            let itemPrice = itemData[1].replace('€', '');
            csvContent += itemName + ',' + itemPrice + '\n'; // Artikelname und Preis zur CSV-Datei hinzufügen
        }
        $.ajax({
          url: "save_sales_data.php",
          type: "POST",
          data: { csvContent: csvContent },
          success: function (response) {
            console.log("Sales data saved successfully.");
          },
          error: function (xhr, status, error) {
            console.error("Error saving sales data:", error);
          }
        });
      }
      
        let users = {};

        // Benutzer-IDs aus der CSV-Datei laden und in users-Objekt speichern
        $.ajax({
            url: "kunden.csv",
            async: false,
            success: function (csv) {
                let lines = csv.split("\n");
                for (let i = 0; i < lines.length; i++) {
                    let values = lines[i].split(",");
                    let username = values[0];
                    let points = parseInt(values[1]);
                    users[username] = points;
                }
            }
        });
      function addPointsToUser(username, amount) {
        $.ajax({
            url: "add_points.php",
            type: "POST",
            data: {
                username: username,
                amount: amount
            },
            success: function (response) {
                console.log("Punkte wurden erfolgreich hinzugefügt.");
            },
            error: function (xhr, status, error) {
                console.error("Fehler beim Hinzufügen von Punkten:", error);
            }
        });
    }
              // Die 'sendEmailToUser'-Funktion für den Versand der Rechnung per E-Mail
        function sendEmailToUser(username, totalPrice,products) {
            // Die E-Mail-Adresse aus der 'kunden2.csv'-Datei abrufen
            let email = getEmailFromCSV(username);
            if (email) {
                // E-Mail-Nachricht erstellen
                let subject = "Rechnung";
                let total = totalPrice.toFixed(2)
                let message = products;

                // E-Mail über einen serverseitigen Service oder API versenden
                $.ajax({
                    url: "send_email.php",
                    type: "POST",
                    data: {
                        email: email,
                        items: message,
                        total: total
                    },
                    success: function (response) {
                        console.log("Rechnung per E-Mail an " + email + " gesendet.");
                    },
                    error: function (xhr, status, error) {
                        console.error("Fehler beim Senden der Rechnung per E-Mail:", error);
                    }
                });
            }
        }

        // Die 'getEmailFromCSV'-Funktion, um die E-Mail-Adresse aus der 'kunden2.csv'-Datei abzurufen
        function getEmailFromCSV(username) {
            let email = null;
            $.ajax({
                url: "kunden.csv",
                async: false,
                success: function (csv) {
                    let lines = csv.split("\n");
                    for (let i = 0; i < lines.length; i++) {
                        let parts = lines[i].split(",");
                        let user = parts[0].trim();
                        if (user === username) {
                            email = parts[2].trim();
                          console.log(email)
                            break;
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Fehler beim Abrufen der E-Mail-Adresse:", error);
                }
            });
            return email;
        }
      function addToCSV(product) {
            $.ajax({
                url: "add_to_cart.php",
                type: "POST",
                data: {
                    code: product.code,
                    name: product.name,
                    price: product.price.toFixed(2)
                },
                success: function (response) {
                    console.log("Product was successfully added to the shopping cart.");
                },
                error: function (xhr, status, error) {
                    console.error("Error adding product to the shopping cart:", error);
                }
            });
        }

    </script>
</body>
</html>
