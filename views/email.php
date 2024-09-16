<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

		h2 {
			color: #000;
		}

		p {
			color: #131313;
			font-size: 22px;
		}
    </style>
</head>
<body>
    <div class="container">
		<p><b>Correo:</b> <?= $to ?></p>
		<p><b>Asunto:</b> <?= $subject ?></p>
		<h2>Mensaje</h2>
		<p><?= $message ?></p>
    </div>
</body>
</html>
