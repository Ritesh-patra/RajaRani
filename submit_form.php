<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = htmlspecialchars($_POST['fullName']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $flatType = htmlspecialchars($_POST['flatType']);
    $apartment = htmlspecialchars($_POST['apartment']); // New field
    $message = htmlspecialchars($_POST['message']);

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change if using another provider
        $mail->SMTPAuth = true;
        $mail->Username = 'patrasagarika654@gmail.com'; // Replace with your email
        $mail->Password = 'stma rtzg lfyy hsxu'; // Use App Password, NOT direct password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Settings
        $mail->setFrom('patrasagarika654@gmail.com', 'Website Contact');
        $mail->addAddress('patrasagarika654@gmail.com'); // Your target email
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission";

        // Email Body with the new apartment field
        $mail->Body = "
            <h2>Contact Form Details</h2>
            <p><strong>Full Name:</strong> $fullName</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Flat Type:</strong> $flatType</p>
            <p><strong>Apartment:</strong> $apartment</p>
            <p><strong>Message:</strong> $message</p>
        ";

        // Send the email
        $mail->send();

        // Success message and redirect
        echo "<script>
                alert('Your message has been sent successfully!');
                window.location.href = 'index.html';
              </script>";
    } catch (Exception $e) {
        // Error message and redirect
        echo "<script>
                alert('Error sending email. Please try again later.');
                window.location.href = 'index.html';
              </script>";
    }
} else {
    // Invalid request handling
    echo "<script>
            alert('Invalid request.');
            window.location.href = 'index.html';
          </script>";
}
?>