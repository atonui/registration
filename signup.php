<?php
require 'config.php';
require 'header.php';
require 'mail.php';

$username = $email = $password = $confirm_password = '';

//variables to hold errors
$username_err = $email_err = $password_err = $confirm_password_err = '';

if (isset($_POST['register-btn'])){
    //get data from the form

    if (isset($_POST['username'])){
        $username = cleanData($_POST['username']);
    }else{
        $username_err = 'Please fill in this field';
    }
    if (isset($_POST['email'])){
        $email = cleanData($_POST['email']);//add regex to check email validity?
    }else{
        $email_err = 'Please fill in this field';
    }
    if (isset($_POST['password'])){
        $password = $_POST['password'];
    }else{
        $password_err = 'Please fill in this field';
    }
    if (isset($_POST['confirm_password'])){
        $confirm_password = $_POST['confirm_password'];
    }else{
        $confirm_password_err = 'Please fill in this field';
    }
    if (!empty(passwordChecker($password,$confirm_password))){
        $password_err = passwordChecker($password,$confirm_password);
    }else {
        //check if user is already registered
        $sql = "SELECT * FROM `users` WHERE email = '$email'";//make usernames unique too?
        $results = mysqli_query($conn,$sql);
        if (mysqli_num_rows($results) > 0){
            //this means that the user already exists so redirect to login
            header('location:login.php?msg');// the msg variable is set so as to inform the user that they are already registered and should just login
            exit();
        }
        $password = md5($password);
//      generate a unique hash to use for verification
        $hash = md5(rand(0,1000));
//        account activation message
        $message = "
            Thanks for signing up!
            Your account has been created, you can activate it by clicking the following link
            http://localhost/registration/verify.php?email=$email&hash=$hash ";
        $subject = "Account Activation";
        $sql = "INSERT INTO `users`(`id`, `username`, `email`, `password`,`hash`) VALUES (NULL,'$username','$email','$password','$hash')";
        if (mysqli_query($conn,$sql)){
//            header('location:login.php');
            sendMail($message,$email,$subject);
            exit();
        }else{
            echo "Data not added: ".mysqli_error($conn);
        }
    }



}

function cleanData($data){
    $data = strtolower($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = mysqli_real_escape_string($data); // escapes special characters usually used for SQL statements, it helps prevent sql injections

    return $data;
}

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-8 col-lg-8 col-xl-8">
                <div class="container">
                    <ion-icon style="font-size: 500px; margin-left: 120px; color: dodgerblue" name="finger-print-outline"></ion-icon>
                </div>
            </div>
            <div class="col col-md-4 col-lg-4 col-xl-4">
                <div class="form-group container" style="padding: 50px 0px;">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <label for="">Username<span style="color: red"> *</span></label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $username_err?></small>
                                    <input type="text" class="form-control" name="username" required placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="">Email<span style="color: red"> *</span></label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $email_err?></small>
                                    <input type="email" class="form-control" name="email" required placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="">Password<span style="color: red"> *</span></label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $password_err?></small>
                                    <input type="password" class="form-control" name="password" required placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password<span style="color: red"> *</span></label>
                                    <small style="color: orangered!important;" class="text-muted"><?php echo $confirm_password_err?></small>
                                    <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm password">
                                </div>
                                <button type="submit" class="btn btn-block btn-info" name="register-btn">Register</button>
                            </fieldset>
                        </form>
                </div>
            </div>
        </div>
    </div>
<?php
require 'footer.php';
?>
