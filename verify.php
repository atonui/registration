<?php
require 'config.php';
require 'header.php';

if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])){
    //verify data
    $email = $_GET['email'];
    $hash = $_GET['hash'];

    $sql = "SELECT `email`, `hash`, `active` FROM `users` WHERE email='$email' AND hash='$hash'";
    $results = mysqli_query($conn,$sql);
    if (mysqli_num_rows($results) > 0){
//        change active to 1 and take them to login page
        $sql = "UPDATE `users` SET `active`= 1";
        header('location:login.php');
    }

}else{
    //invalid url
}



require 'footer.php';
?>
