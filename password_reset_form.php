<?php
require 'config.php';
require 'mail.php';
$password = $confirm_password = $password_err = $confirm_password_err = '';
$email = $_GET['email'];

if (isset($_POST['reset-password']) and !empty($_POST['password']) and !empty($_POST['confirm_password'])){
//    grab passwords from the form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

//    validate password rules
    if (!empty(passwordChecker($password,$confirm_password))){
        $password_err = passwordChecker($password,$confirm_password);
    }else{
//        update password in db and redirect user to login
        $password = md5($password);
        $sql = "UPDATE `users` SET `password`='$password' WHERE email='$email'";
        if (mysqli_query($conn,$sql)){
            header('location:login.php');
        }else{
            echo mysqli_error($conn);
        }

    }

}

?>

<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
    <fieldset>
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
        <button type="submit" class="btn btn-block btn-info" name="reset-password">Reset Password</button>
    </fieldset>
</form>