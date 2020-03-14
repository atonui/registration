<?php
require 'config.php';
$password_err = $confirm_password_err ='';

//in this page we have already confirmed that the user is exists in the db so we check the link then allow them to update
if (isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['hash']) and !empty($_GET['hash'])){
//    verify the link data
    $email = $_GET['email'];
    $hash = $_GET['hash'];

    $sql = "SELECT `email`, `hash` FROM `users` WHERE email='$email' AND hash='$hash'";
    $results = mysqli_query($conn,$sql);
    if (mysqli_num_rows($results) > 0){
//        this means that the link is valid so allow user to update password

        header("location:password_reset_form.php?email=$email");

    }

}
?>



