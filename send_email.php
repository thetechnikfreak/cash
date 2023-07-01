<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// E-Mail-Parameter aus dem Formular erhalten
$to = $_POST['email'];
$subject = $_POST['subject'];
$total = $_POST['total'];
$items = $_POST['products'];
$message = 'Vielen Dank für Ihren Einkauf.';

// Laden Sie den Composer Autoloader
require 'vendor/autoload.php';

// Öffnen Sie die CSV-Datei
$file = fopen("anzeige.csv", "r");

$products = array();
$totalPrice = 0;

// Durchlaufen Sie die CSV-Daten
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $product = $data[1];
    $price = $data[2];
    $totalPrice += (float)$price;
    $products[] = array('product' => $product, 'price' => $price);
}

fclose($file);

// Erstellen Sie eine Instanz von PHPMailer
$mail = new PHPMailer(true);

try {
    // Servereinstellungen
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Aktivieren Sie detaillierte Debug-Ausgabe
    $mail->isSMTP();                                            // Versenden über SMTP
    $mail->Host       = 'smtp.zoho.eu';                          // Setzen Sie den SMTP-Server
    $mail->SMTPAuth   = true;                                   // Aktivieren Sie SMTP-Authentifizierung
    $mail->Username   = 'no-reply@thetechnikfreak.is-a.dev';     // SMTP-Benutzername
    $mail->Password   = '3R$klmtw';                              // SMTP-Passwort
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             // Aktivieren Sie die implizite TLS-Verschlüsselung
    $mail->Port       = 465;                                    // TCP-Port für die Verbindung; verwenden Sie 587, wenn Sie `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` festgelegt haben

    // Absender und Empfänger
    $mail->setFrom('no-reply@thetechnikfreak.is-a.dev', 'Loli Rechnung'); // Absenderadresse
    $mail->addAddress($to);               // Empfängeradresse

    // Anhänge
    $timestamp = time();
    $datum = date("d.m.Y");

    // E-Mail-Inhalt
    $mail->isHTML(true);                                  // Setzen Sie das E-Mail-Format auf HTML
    $mail->Subject = 'Rechnung vom  ' . $datum;

    // Erstellen Sie den E-Mail-Body
    $emailBody = '<h1>Rechnung</h1>';
    $emailBody .= '<table>';
    $emailBody .= '<tr><th>Produkt</th><th>Preis</th></tr>';
    foreach ($products as $product) {
        $emailBody .= '<tr><td style="border: 1px solid black; padding: 8px;">' . $product['product'] . '</td><td style="border: 1px solid black; padding: 8px;">' . $product['price'] . '</td></tr>';
    }
    $emailBody .= '</table>';
    $emailBody .= '<h2>Gesamtpreis: ' . $total . ' Euro</h2>';
    $emailBody .= '<h2>Vielen Dank fuer Ihren Einkauf.</h2>';
    $mail->Body    = $emailBody;
    $mail->AltBody = 'Bitte aktivieren Sie HTML, um diese E-Mail anzuzeigen.';

    $mail->send();
    echo 'Die Nachricht wurde gesendet.';
} catch (Exception $e) {
    echo "Die Nachricht konnte nicht gesendet werden. Fehlermeldung: {$mail->ErrorInfo}";
}
?>
