<?php
require 'config.php';
require 'header.php';
require 'mail.php';

$email = '';

if (isset($_POST['submit']) and !empty($_POST['email'])){
    $email = $_POST['email'];
//check if user actually exists in db
    $sql = "SELECT * FROM `users` WHERE email = '$email'";
    $results = mysqli_query($conn,$sql);
    if (mysqli_num_rows($results) > 0 ){
//        user exists so email them a unique link to allow them reset the password
        $hash = md5(rand(0,1000));
        $subject = "Password Reset";
        $message = "
            You can reset your account by following the link below or copying and pasting it in a new browser tab search bar.
            http://localhost/registration/update_password.php?email=$email&hash=$hash";
//        update hash row in db
        $sql = "UPDATE `users` SET `hash`='$hash' WHERE email = '$email'";
        if (mysqli_query($conn,$sql)){
            sendMail($message,$email,$subject);  //send email after updating db
        }

    }else{
        //user is not registered so register user
        echo "
                <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
                 You are not a registered user. Please register <a href='signup.php'>Here</a>
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
            ";
    }
}



?>
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <label>Email</label>
    <input type="email" name="email" required placeholder="Email">

    <button type="submit" name="submit">Submit</button>

</form>

<?php
require 'footer.php';
?>