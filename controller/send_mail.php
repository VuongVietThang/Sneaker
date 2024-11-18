<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Hàm gửi mail
function sendMail($address, $subject, $message){
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();  // Sử dụng SMTP
        $mail->Host = 'smtp.gmail.com';  // Đặt máy chủ SMTP
        $mail->SMTPAuth = true;  // Kích hoạt xác thực SMTP
        $mail->Username = 'esmart211203@gmail.com';  // Tên đăng nhập SMTP
        $mail->Password = 'akfn xnvo ussx ikzx';  // Mật khẩu SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Kích hoạt mã hóa TLS
        $mail->Port = 587;  // Cổng TCP kết nối đến

        // Nhận email
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($address);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->CharSet = 'UTF-8';
        // Gửi email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Ví dụ gọi hàm sendMail
sendMail('hope211203@gmail.com', 'Register successfully!', 'This is the HTML message body <b>in bold!</b>');
?>
