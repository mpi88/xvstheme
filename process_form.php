<?php

// Подключение библиотеки PHPMailer
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

// Проверка Google reCAPTCHA
$recaptchaResponse = $_POST['g-recaptcha-response'];
$recaptchaSecretKey = '6Lek6WAnAAAAAIlvh2PJIzdKMw1pxpeQSLyoSJob';
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaResponse");
$response = json_decode($response);

if (!$response->success) {
    echo "error";
    exit;
}

// Получение данных из AJAX запроса
$fullName = $_POST["fullName"];
$email = $_POST["email"];
$telegram = $_POST["telegram"];
$whatsapp = $_POST["whatsapp"];
$message = $_POST["message"];

// Параметры для отправки почты через Gmail
$smtpHost = 'mail.xvstheme.com';
$smtpPort = 587;
$smtpUsername = '_mainaccount@xvstheme.com'; // Замените на ваш Gmail email
$smtpPassword = 'aCp506QRo4'; // Замените на ваш Gmail пароль

// Настройка PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->setFrom($smtpUsername, 'XVStheme.com'); // Замените на имя вашего сайта или отправителя
$mail->CharSet = 'UTF-8';

// Добавление получателя и темы письма
$mail->addAddress('m.palamarchuk1988@gmail.com'); // Замените на ваш Gmail email
$mail->Subject = 'Новое сообщение с формы связи';

// Форматирование тела письма
$mail->isHTML(true);
$mail->Body = "<p><strong>Полное имя:</strong> $fullName</p>
               <p><strong>Email:</strong> $email</p>
               <p><strong>Telegram:</strong> $telegram</p>
               <p><strong>WhatsApp:</strong> $whatsapp</p>
               <p><strong>Сообщение:</strong><br>$message</p>";


// Отправка письма
if ($mail->send()) {
    echo "success";
} else {
    echo "error";
}
