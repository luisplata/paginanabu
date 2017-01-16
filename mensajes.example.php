<?php

require_once "recapchalib.php";
//opteniendo los datos del formulario
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$mensaje = trim($_POST['mensaje']);

//validando la capcha
// tu clave secreta
$secret = "yourApiKey";
 
// respuesta vacía
$response = null;
 
// comprueba la clave secreta
$reCaptcha = new ReCaptcha($secret);

// si se detecta la respuesta como enviada
if ($_POST["g-recaptcha-response"]) {
$response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
if ($response != null && $response->success) {
	//colocando en el archivo
	$mensajes = fopen("mensajes.txt", "a");
	$delimitador = "\n--------------------------------------------------------- \n";
	fputs($mensajes, $name."\n".$email."\nmensaje: ".$mensaje.$delimitador);
	//cuando se lea el arvhivo hay que cortar en la primera y la segunda y lo que quede es el mensaje
	fclose($mensajes);
	Header("Location: index.php?mensaje=mensaje%20enviado%20con%20Éxito&tipo=success");
}else{
	Header("Location: index.php?mensaje=Envío%20fallido,%20coloque%20el%20captcha%20correctamente&tipo=error#contact");
}
