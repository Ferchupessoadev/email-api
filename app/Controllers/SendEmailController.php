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
        [$to, $subject, $message] = $this->getBody();
        $response = $this->send($to, $subject, $message, 'ferchudev.com', 'fernandomatiaspessoa471@gmail.com');
        return $response;
    }

    /**
     * Get the body of the request
     *
     * @return array<string, string>
     */
    private function getBody(): array
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        $to = $data['to'] ?? '';
        $subject = $data['subject'] ?? '';
        $message = $data['message'] ?? '';
        return [
            $to,
            $subject,
            $message
        ];
    }

    /**
     * Send an email to uniontkd
     *
     * @return array<string, string>
     */
    public function uniontkd(): array
    {
        [$to, $subject, $message] = $this->getBody();
        $response = $this->send($to, $subject, $message, 'uniontkd.com.ar', 'lcponti@gmail.com');
        return $response;
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

    /**
     * Send an email
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $website
     * @param string $recipient
     * @return array<string, string>
     */
    private function send(
        string $to,
        string $subject,
        string $message,
        string $website,
        string $recipient
    ): array {
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
            $mail->setFrom($_ENV['EMAIL'], $website);
            $mail->addAddress($_ENV['EMAIL'], $website);
            $mail->addAddress($recipient, $website);

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = htmlspecialchars($subject);
            $mail->Body = $this->view('email', ['to' => $to, 'subject' => $subject, 'message' => $message]);
            $mail->send();
        } catch (Exception $e) {
            error_log('Email sending failed: ' . $e->getMessage());
            return ['message' => 'Error al enviar el correo'];
        }

        return ['message' => 'Email enviado corretamente!'];
    }
}
