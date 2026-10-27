<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = isset($_POST['name'])    ? trim($_POST['name'])    : '';
    $email   = isset($_POST['email'])   ? trim($_POST['email'])   : '';
    $mobile  = isset($_POST['mobile'])  ? trim($_POST['mobile'])  : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Contact Form';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '' || $email === '' || $mobile === '' || $message === '') {
        echo "Error: All required fields must be filled.";
        exit;
    }

    $mailSubject = "GMHS Website Contact: " . $subject;
    $mailBody  = "Name: " . $name . "\r\n";
    $mailBody .= "Email: " . $email . "\r\n";
    $mailBody .= "Mobile: " . $mobile . "\r\n";
    $mailBody .= "Subject: " . $subject . "\r\n";
    $mailBody .= "Message:\r\n" . $message . "\r\n";
	    // ----------------------------
    // Simple log of submitted messages
    // ----------------------------
    $logLine  = date('Y-m-d H:i:s') . " | ";
    $logLine .= "Name: " . $name . " | ";
    $logLine .= "Email: " . $email . " | ";
    $logLine .= "Mobile: " . $mobile . " | ";
    $logLine .= "Subject: " . $subject . " | ";
    $logLine .= "Message: " . str_replace(array("\r","\n"), ' ', $message) . PHP_EOL;

    $logFile = __DIR__ . '/contact-log.txt';
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
    $mail = new PHPMailer(true);

    try {
        // SMTP settings from your hosting email info:
        // Username: info@gmhskjassu.in
        // Password: Test@1234gmhs
        // SMTP Server: panel.freehosting.com port 587
        $mail->isSMTP();
        $mail->Host       = 'panel.freehosting.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@gmhskjassu.in';
        $mail->Password   = 'Test@1234gmhs';
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS for port 587
        $mail->Port       = 587;

        // Sender & recipients
        $mail->setFrom('info@gmhskjassu.in', 'GMHS Website');
        //$mail->addAddress('puneet94kumar@yahoo.com');
        $mail->addAddress('puneet94kumar@gmail.com');
		$mail->addAddress('kjassugmms@gmail.com');
		$mail->addReplyTo($email, $name);

        $mail->Subject = $mailSubject;
        $mail->Body    = $mailBody;

        if ($mail->send()) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Message Sent - GMHS Khudda Jassu</title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f5f7fa;
                margin: 0;
                padding: 0;
            }
            .confirm-wrapper{
                max-width: 600px;
                margin: 80px auto;
                text-align: center;
            }
            .confirm-box{
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                padding: 30px 40px;
            }
            .confirm-title{
                font-size: 22px;
                font-weight: 700;
                color: #0066cc;
                margin-bottom: 10px;
            }
            .confirm-text{
                font-size: 14px;
                color: #333333;
                margin-bottom: 20px;
            }
            .confirm-links a{
                display: inline-block;
                margin: 0 10px;
                padding: 10px 18px;
                border-radius: 4px;
                text-decoration: none;
                font-size: 14px;
            }
            .btn-primary{
                background-color: #f57c00;
                color: #ffffff;
            }
            .btn-secondary{
                background-color: #e0e0e0;
                color: #333333;
            }
        </style>
    </head>
    <body>
        <div class="confirm-wrapper">
            <div class="confirm-box">
                <div class="confirm-title">Thank you!</div>
                <p class="confirm-text">
                    Your message has been sent successfully.<br />
                    Our team at GMHS, Khudda Jassu will review your query and get back to you soon.
                </p>
                <div class="confirm-links">
                    <a href="../website_pages/contactus.html" class="btn-primary">Back to Contact Page</a>
                    <a href="../index.html" class="btn-secondary">Go to Home</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Error Sending Message - GMHS Khudda Jassu</title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f5f7fa;
                margin: 0;
                padding: 0;
            }
            .confirm-wrapper{
                max-width: 600px;
                margin: 80px auto;
                text-align: center;
            }
            .confirm-box{
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                padding: 30px 40px;
            }
            .confirm-title{
                font-size: 22px;
                font-weight: 700;
                color: #cc0000;
                margin-bottom: 10px;
            }
            .confirm-text{
                font-size: 14px;
                color: #333333;
                margin-bottom: 20px;
            }
            .confirm-links a{
                display: inline-block;
                margin: 0 10px;
                padding: 10px 18px;
                border-radius: 4px;
                text-decoration: none;
                font-size: 14px;
            }
            .btn-primary{
                background-color: #f57c00;
                color: #ffffff;
            }
            .btn-secondary{
                background-color: #e0e0e0;
                color: #333333;
            }
        </style>
    </head>
    <body>
        <div class="confirm-wrapper">
            <div class="confirm-box">
                <div class="confirm-title">Sorry, something went wrong</div>
                <p class="confirm-text">
                    We were unable to send your message due to a temporary email issue.<br />
                    Please try again in a few minutes or contact the school office directly at
                    +91-172-2789339.
                </p>
                <div class="confirm-links">
                    <a href="../website_pages/contactus.html" class="btn-primary">Back to Contact Page</a>
                    <a href="../index.html" class="btn-secondary">Go to Home</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}

    } catch (Exception $e) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Error Sending Message - GMHS Khudda Jassu</title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                background-color: #f5f7fa;
                margin: 0;
                padding: 0;
            }
            .confirm-wrapper{
                max-width: 600px;
                margin: 80px auto;
                text-align: center;
            }
            .confirm-box{
                background: #ffffff;
                border-radius: 10px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                padding: 30px 40px;
            }
            .confirm-title{
                font-size: 22px;
                font-weight: 700;
                color: #cc0000;
                margin-bottom: 10px;
            }
            .confirm-text{
                font-size: 14px;
                color: #333333;
                margin-bottom: 20px;
            }
            .confirm-links a{
                display: inline-block;
                margin: 0 10px;
                padding: 10px 18px;
                border-radius: 4px;
                text-decoration: none;
                font-size: 14px;
            }
            .btn-primary{
                background-color: #f57c00;
                color: #ffffff;
            }
            .btn-secondary{
                background-color: #e0e0e0;
                color: #333333;
            }
        </style>
    </head>
    <body>
        <div class="confirm-wrapper">
            <div class="confirm-box">
                <div class="confirm-title">Sorry, something went wrong</div>
                <p class="confirm-text">
                    We were unable to send your message due to a temporary email issue.<br />
                    Please try again in a few minutes or contact the school office directly at
                    +91-172-2789339.
                </p>
                <div class="confirm-links">
                    <a href="../website_pages/contactus.html" class="btn-primary">Back to Contact Page</a>
                    <a href="../index.html" class="btn-secondary">Go to Home</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}

} else {
    echo "Invalid request.";
}
?>