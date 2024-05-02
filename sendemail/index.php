<?php
header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function send_email()
{
	require './env.php';

	$mail = new PHPMailer(true);
	// caso: 1
	if (
		empty($_GET["name"])
		or empty($_GET["surname"])
		or empty($_GET["email"])
		or empty($_GET["message"])
	) {
		$response = [
			"message" => "Campos incompletos",
		];
		return json_encode($response);
	}

	// Caso principal.
	try {
		//Server settings
		$mail->SMTPDebug = 0; // 1 para el modo debug.
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'your_email_address';
		$mail->Password   = $token_gmail;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port       = 465;

		// Recipients
		$mail->setFrom('your_email_address', 'Fernando Pessoa');
		$mail->addAddress('fernandomatiaspessoa471@gmail.com');     //Add a recipient
		$mail->CharSet = "UTF-8";

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = "Oferta laboral de $_GET[name] $_GET[surname]";
		$mail->Body    = "Email: $_GET[email]<br>$_GET[message]";

		$mail->send();
	} catch (Exception) {
		$response = [
			"message" => "Ups, lo sentimos ocurrio un error.",
		];

		return json_encode($response);
	}

	$response = [
		"message" => "Email enviado correctamente.",
	];

	return json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$response = send_email();
	echo $response;
}
