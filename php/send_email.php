<?php
// Cargar PHPMailer (usando Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ruta relativa al autoloader

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

$response = ["status" => "error", "message" => "Unknown error occurred."];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['contact-name']);
    $email = htmlspecialchars($_POST['contact-email']);
    $message = htmlspecialchars($_POST['contact-message']);

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alexis.adrianc@gmail.com';
        $mail->Password = 'jmqe efkk xsvv ygqp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('alexis.adrianc@gmail.com', 'Portfolio Alexis');
        $mail->addAddress('alexis.adrianc@gmail.com');
        $mail->Subject = 'Nuevo mensaje de contacto';

        $mail->isHTML(true);
        $mail->Body = "
            <h3>Nuevo mensaje de contacto</h3>
            <p><strong>Nombre:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Mensaje:</strong> {$message}</p>
        ";

        $mail->send();
        $response = ["status" => "success", "message" => "Your message has been sent successfully!"];
    } catch (Exception $e) {
        $response = ["status" => "error", "message" => "Error sending message. Mailer Error: {$mail->ErrorInfo}"];
    }
}

echo json_encode($response); // Enviar respuesta JSON al JavaScript
exit();

