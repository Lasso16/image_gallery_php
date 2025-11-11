<?php

use dwes\app\exceptions\MailException;
use dwes\app\utils\MyMail;
use dwes\core\App;

$mensaje = "";
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim(htmlspecialchars($_POST['nombre'])) ?? "";
        $apellidos = trim(htmlspecialchars($_POST['apellidos'])) ?? "";
        $email = trim(htmlspecialchars($_POST['email'])) ?? "";
        $asunto = trim(htmlspecialchars($_POST['asunto'])) ?? "";
        $mensaje = trim(htmlspecialchars($_POST['mensaje'])) ?? "";
        if ($nombre != "" && $email != "" && $asunto != "") {
            $mail = new MyMail();
            $mail->send($email, $nombre . ' ' . $apellidos, $asunto, $mensaje);
            $mensaje = "Mensaje enviado correctamente.";
        } else {
            $mensaje = "Faltan campos por rellenar: Nombre, Email y Asunto.";
        }
    }
} catch (MailException $mailException) {
    $mensaje = $mailException->getMessage();
}
require_once __DIR__ . '/../views/contact.view.php';
