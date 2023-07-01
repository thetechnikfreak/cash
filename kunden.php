<!DOCTYPE html>
<html>
  <meta name="viewport" content="width=device-width, initial-scale=0.7">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        
        h1 {
            margin-bottom: 1px;
        }
        
        .hidden {
            display: true;
        }
        
        img {
            max-width: 200%;
            height: 500;
            display: block;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0px;
        }
        
        .product {
            font-size: 25px;
            font-weight: bold;
        }
        
        .price {
            font-size: 25px;
        }
        
        .total-price {
            font-size: 30px;
            margin-top: 1px;
        }
    </style>
</head>
<body>
    <div>
        <!-- Hier werden die Produktinformationen aus der anzeigen.csv-Datei eingefügt -->
        <?php
        $file = fopen("anzeige.csv", "r");
        $products = array();
        $totalPrice = 0;
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $product = $data[1];
            $price = $data[2];
            $totalPrice += (float)$price;
            $products[] = array('product' => $product, 'price' => $price);
        }
            fclose($file);
            $lastThreeProducts = array_slice($products, -3);
            foreach ($lastThreeProducts as $productInfo) {
              echo '<div class="product-info">';
              echo '<p class="product">' . $productInfo['product'] . '</p>';
              echo '<p class="price">' . $productInfo['price'] . ' €</p>';
              echo '</div>';
            }


            if ($totalPrice === 0) {
                echo '<div class="hidden">
                        <img src="logo.png" alt="Logo">
                    </div>';
            } else {
                echo '<p class="total-price">Gesamtpreis: '.$totalPrice.' Euro</p>';
            }
        ?>
    </div>
      <script>
        setInterval(function(){
                location.reload();
            }, 5000);
        
      </script>

</body>
</html>
