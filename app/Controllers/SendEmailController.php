<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmailController extends Controller
{
    /**
     * Send an email
     *
     * @return array<string, string>
     */
    public function index(): array
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        $to = $data['to'] ?? '';
        $subject = $data['subject'] ?? '';
        $message = $data['message'] ?? '';

        // Validate the inputs
        $response = $this->validate($to, $subject, $message);
        if (!empty($response)) {
            return $response;
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL'];
            $mail->Password = $_ENV['PASSWORD_EMAIL'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;  // 465 for SSL or 587 for TLS

            // Recipients
            $mail->setFrom($_ENV['EMAIL'], 'ferchudev.com');
            $mail->addAddress($_ENV['EMAIL'], 'Fernando Pessoa');
            $mail->addAddress('fernandomatiaspessoa471@gmail.com', 'Fernando Pessoa');

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = 'Ferchudev.com - ' . htmlspecialchars($subject);
            $mail->Body = $this->view('email', ['to' => $to, 'subject' => $subject, 'message' => $message]);
            $mail->send();
        } catch (Exception $e) {
            error_log('Email sending failed: ' . $e->getMessage());
            return ['message' => 'Error al enviar el correo'];
        }

        return ['message' => 'Email enviado corretamente!'];
    }

    /**
     * Validate the inputs
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return array<string, string> An associative array with validation errors
     */
    private function validate(string $to, string $subject, string $message): array
    {
        $errors = [];

        if (empty($to)) {
            $errors['to'] = 'El Correo es requerido';
        } elseif (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $errors['to'] = 'El Correo no es valido';
        } elseif (strlen($to) > 255) {
            $errors['to'] = 'El Correo es muy extenso';
        }

        if (empty($subject)) {
            $errors['subject'] = 'El Asunto es requerido';
        } elseif (strlen($subject) > 255) {
            $errors['subject'] = 'El Asunto es muy extenso';
        }

        if (empty($message)) {
            $errors['message'] = 'El Mensaje es requerido';
        } elseif (strlen($message) > 300) {
            $errors['message'] = 'El Mensaje es muy extenso';
        }

        return $errors;
    }
}
