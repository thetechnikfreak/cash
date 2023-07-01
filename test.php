<!DOCTYPE html>
<html>
<head>
    <title>Button-Ausführung</title>
    <script>
        function executeJavaScript() {
            const url = 'https://cash.thetechnikfreak.repl.co/create_goodie.php';
            const data = "text=hi&pin=124";
        
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data,
            })
            .then(response => response.text())
            .then(text => console.log(text))
            .catch(error => console.log(error));
        }
    </script>
</head>
<body>
    <button onclick="executeJavaScript()">Klick mich!</button>
</body>
</html>
