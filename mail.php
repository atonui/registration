<?php

require("PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/src/SMTP.php");

function sendMail($message, $email, $subject){

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP

    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "pythonapps17@gmail.com";
    $mail->Password = "**************";
    $mail->SetFrom("pythonapps17@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($email);

    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "
                <div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
                 Please check your email inbox for instructions.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
            ";
    }
}

function passwordChecker($password, $confirm_password){
    $password_err ='';
    if ($password != $confirm_password) {
        $password_err = 'Oops! Your passwords do not seem to match';
    } elseif (strlen($password) < 8) {
        $password_err = 'Your password is less than 8 characters';

        //check for password strength using regex
    } elseif (!(preg_match('/[\'^£$!%&*()}{@#~?><>,|=_+¬-]/', $password))) { //regex pattern to check if password contains special characters
        $password_err = 'Your password does not contain any special characters';
    }
    return $password_err;
}
?>