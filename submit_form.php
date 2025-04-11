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
    $apartment = htmlspecialchars($_POST['apartment']);

    // Validate required fields
    if (empty($fullName) || empty($phone) || empty($email) || empty($flatType) || empty($apartment)) {
        echo "<script>
                alert('All required fields must be filled.');
                window.history.back();
              </script>";
        exit();
    }

    // Validate phone number (exactly 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>
                alert('Phone number must be exactly 10 digits.');
                window.history.back();
              </script>";
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Please enter a valid email address.');
                window.history.back();
              </script>";
        exit();
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deelipkumarpatro73@gmail.com';
        $mail->Password = 'dezw ifes gvax tovk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Settings
        $mail->setFrom('deelipkumarpatro73@gmail.com', 'Website Contact Form');
        $mail->addAddress('deelipkumarpatro73@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = "New Inquiry: $apartment - $flatType";

        // Email Body
        $mail->Body = "
            <h2 style='color: #2563eb;'>New Contact Form Submission</h2>
            <p><strong>Apartment:</strong> $apartment</p>
            <p><strong>Flat Type:</strong> $flatType</p>
            <hr style='margin: 15px 0;'>
            <p><strong>Full Name:</strong> $fullName</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <hr style='margin: 15px 0;'>
            <p><small>Submitted at: " . date('Y-m-d H:i:s') . "</small></p>
        ";

        // Send the email
        $mail->send();

        // Success message and redirect
        header("Location: index.html?status=success&message=Thank you! Your inquiry has been submitted successfully.");
        exit();
    } catch (Exception $e) {
        // Error message and redirect
        header("Location: index.html?status=error&message=Error sending your message. Please try again later.");
        exit();
    }
} else {
    // Invalid request handling
    header("Location: index.html?status=error&message=Invalid request method.");
    exit();
}
?>
