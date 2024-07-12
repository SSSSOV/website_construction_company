<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из запроса
    $data = json_decode(file_get_contents('php://input'), true);
    $recipient = $data['recipient'];
    $phone = $data['phone'];
    $message = $data['message'];

    // Проверка данных
    if (empty($recipient) || empty($phone) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Пожалуйста, заполните все поля.']);
        exit;
    }

    // Настройки для отправки письма
    $to = $recipient;
    $subject = 'Новое сообщение с сайта';
    $headers = "From: no-reply@yourwebsite.com\r\n";
    $headers .= "Reply-To: no-reply@yourwebsite.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $email_message = "<html><body>";
    $email_message .= "<h2>Новое сообщение</h2>";
    $email_message .= "<p><strong>Получатель:</strong> $recipient</p>";
    $email_message .= "<p><strong>Телефон:</strong> $phone</p>";
    $email_message .= "<p><strong>Сообщение:</strong><br>$message</p>";
    $email_message .= "</body></html>";

    // Отправка письма
    if (mail($to, $subject, $email_message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при отправке сообщения.']);
    }
}
?>
