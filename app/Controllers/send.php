<?php

namespace App\Controllers;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Send
{
    public function index(): string
    {
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL'];
            $mail->Password = $_ENV['PASSWORD_EMAIL'];
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom($_ENV['EMAIL'], $_ENV['NAME_EMAIL']);
            $mail->addAddress('fernandomatiaspessoa471@gmail.com', 'Fernando');
            $mail->isHTML(true);
            $mail->Subject = 'mail de trabajo';
            $mail->Body = 'Email body';
            $mail->send();
        } catch (Exception) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        return json_encode(['success' => true]);
    }
}
