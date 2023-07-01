<!DOCTYPE html>
<html>
<head>
    <title>Numberkasse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-top: 50px;
        }

        #preview {
            width: 300px;
            height: auto;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        #camera-select {
            margin-bottom: 10px;
        }

        /* Weitere CSS-Stile hier einfügen */

    </style>
</head>
<body>
    <div class="container">
        <video id="preview"></video>
        <select id="camera-select"></select>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner;
        let currentBarcode = '';
        let cartItems = [];

        function initializeScanner(cameraId) {
            scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
            scanner.addListener('scan', function (content) {
                let product = findProductByCode(content);
                if (product) {
                    addToCart(product);
                } else {
                    alert("Produkt nicht gefunden!");
                }
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    if (cameraId && cameraId < cameras.length) {
                        scanner.start(cameras[cameraId]);
                        updateCameraSelect(cameras, cameraId);
                    } else {
                        scanner.start(cameras[0]);
                        updateCameraSelect(cameras, 0);
                    }
                } else {
                    console.error('Es wurde keine Kamera gefunden!');
                }
            }).catch(function (e) {
                console.error(e);
            });
        }

        function updateCameraSelect(cameras, selectedCameraId) {
            let selectElement = document.getElementById('camera-select');
            selectElement.innerHTML = '';
            for (let i = 0; i < cameras.length; i++) {
                let optionElement = document.createElement('option');
                optionElement.value = i;
                optionElement.text = cameras[i].name;
                if (i === selectedCameraId) {
                    optionElement.selected = true;
                }
                selectElement.appendChild(optionElement);
            }
        }

        function changeCamera() {
            let selectElement = document.getElementById('camera-select');
            let selectedCameraId = selectElement.value;
            scanner.stop();
            initializeScanner(selectedCameraId);
        }

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

        // Weitere Funktionen hier einfü
              initializeScanner(); 


    // Produkt anhand des Barcodes finden
    function findProductByCode(code) {
        for (let i = 0; i < products.length; i++) {
            if (products[i].code === code) {
                return products[i];
            }
        }
        return null;
    }

    // Produkt zum Warenkorb hinzufügen
    function addToCart(product) {
        cartItems.push(product);

        let cartItemsElement = document.getElementById('cart-items');
        let cartItemElement = document.createElement('div');
        cartItemElement.classList.add('cart-item');
        cartItemElement.innerHTML = `
            <div>${product.name}</div>
            <div>${product.price.toFixed(2)} €</div>
        `;
        cartItemsElement.appendChild(cartItemElement);
        updateTotalPrice();
    }

    // Barcode an index.php senden
    function sendBarcodeToIndexPhp(barcode) {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {
                barcode: barcode
            },
            success: function (response) {
                console.log("Barcode successfully sent to index.php.");
            },
            error: function (xhr, status, error) {
                console.error("Error sending barcode to index.php:", error);
            }
        });
    }

    // Zahl zum Barcode-Code hinzufügen
    function enterNumber(number) {
        currentBarcode += number.toString();
    }

    // Produkt bestätigen und zum Warenkorb hinzufügen
    function confirmProduct() {
        if (currentBarcode.length > 0) {
            let product = findProductByCode(currentBarcode);
            if (product) {
                addToCart(product);
                currentBarcode = '';
            } else {
                alert("Produkt nicht gefunden!");
            }
        }
    }

    // Bezahlvorgang
    function pay() {
        if (cartItems.length > 0) {
            // Implementiere hier den Bezahlvorgang
            alert("Bezahlvorgang wird durchgeführt...");
            clearCart();
        } else {
            alert("Warenkorb ist leer. Es gibt nichts zu bezahlen.");
        }
    }

    // Gesamtpreis aktualisieren
    function updateTotalPrice() {
        let totalPrice = 0;
        for (let i = 0; i < cartItems.length; i++) {
            totalPrice += cartItems[i].price;
        }
        let totalPriceElement = document.getElementById('total-price');
        totalPriceElement.textContent = 'Gesamtpreis: ' + totalPrice.toFixed(2) + ' €';
    }

    // Warenkorb leeren
    function clearCart() {
        cartItems = [];
        let cartItemsElement = document.getElementById('cart-items');
        while (cartItemsElement.firstChild) {
            cartItemsElement.removeChild(cartItemsElement.firstChild);
        }
        updateTotalPrice();
    }
</script>

</body>
</html>
