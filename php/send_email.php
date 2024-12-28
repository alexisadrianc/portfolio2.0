<?php
session_start(); // Inicia sesión para manejar los mensajes
// Cargar PHPMailer (usando Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ruta relativa al autoloader

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['contact-name']);
    $email = htmlspecialchars($_POST['contact-email']);
    $message = htmlspecialchars($_POST['contact-message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alexis.adrianc@gmail.com';
        $mail->Password = 'jmqe efkk xsvv ygqp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

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
        $message = 'El mensaje se envió correctamente.';
        $status = 'success';
    } catch (Exception $e) {
        $message = "Error al enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
        $status = 'danger';
    }

    header("Location: ../index.html?message=" . urlencode($message) . "&status=" . $status);
    exit();
}
