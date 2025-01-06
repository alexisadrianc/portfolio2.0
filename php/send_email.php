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
        // ✅ Asunto optimizado
        $mail->Subject = "¡Nuevo mensaje desde tu Portfolio! - {$name} te ha contactado";


        $mail->isHTML(true);
        $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #ddd; max-width: 600px; margin: auto;'>
                <h2 style='color: #007BFF; text-align: center;'>Nuevo mensaje de contacto</h2>
                
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='background-color: #007BFF; color: white; padding: 10px; font-weight: bold; text-align: center;'>
                            Detalles del Mensaje
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; background-color: white;'>
                            <p><strong>📛 Nombre:</strong> {$name}</p>
                            <p><strong>📧 Email:</strong> {$email}</p>
                            <p><strong>📝 Mensaje:</strong></p>
                            <blockquote style='border-left: 3px solid #007BFF; padding-left: 10px; margin-left: 0; color: #555;'>
                                {$message}
                            </blockquote>
                        </td>
                    </tr>
                </table>

                <hr style='border: none; border-top: 1px solid #ddd;'>
                
                <p style='text-align: center; color: #888; font-size: 14px;'>
                    📬 Este mensaje fue enviado desde el <strong>Portfolio de Alexis</strong>.
                </p>
            </div>
        ";

        $mail->send();
        $response = ["status" => "success", "message" => "Your message has been sent successfully!"];
    } catch (Exception $e) {
        $response = ["status" => "error", "message" => "Error sending message. Mailer Error: {$mail->ErrorInfo}"];
    }
}

echo json_encode($response); // Enviar respuesta JSON al JavaScript
exit();

