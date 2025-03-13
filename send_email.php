<?php
header('Content-Type: application/json');

// Terima data JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($data['name']) || !isset($data['email']) || !isset($data['subject']) || !isset($data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos deben ser completados.']);
    exit;
}

// Sanitasi input
$name = filter_var($data['name'], FILTER_SANITIZE_STRING);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($data['subject'], FILTER_SANITIZE_STRING);
$message = filter_var($data['message'], FILTER_SANITIZE_STRING);

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Correo electrónico no válido']);
    exit;
}

// cORREO ELECTRONICO DE RECIBO
$to = "rubenroa973299@gmail.com"; // 

// Preparar un mensaje de correo electrónico
$email_content = "Nama: $name\n";
$email_content .= "Email: $email\n";
$email_content .= "Pesan:\n$message";

// Correo electrónico de encabezado
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// enviar un correo electrónico
if (mail($to, $subject, $email_content, $headers)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo enviar el correo electrónico']);
}
?>