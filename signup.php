<?php
require 'config.php';
require 'header.php';

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
        $email = cleanData($_POST['email']);
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

    if ($password != $confirm_password){
        $confirm_password_err = 'Oops! Your passwords do not seem to match';
    }elseif (strlen($password) < 8){
        $password_err = 'Your password is less than 8 characters';

        //add elseif to check for password strength using regex
    }else{
        $password = md5($password);
        //check if user is already registered




        $sql = "INSERT INTO `users`(`id`, `username`, `email`, `password`) VALUES (NULL,'$username','$email','$password')";
        if (mysqli_query($conn,$sql)){
            header('location:login.php');
        }else{
            echo "Data not added: ".mysqli_error($conn);
        }
    }

}

function cleanData($data){
    $data = strtolower($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = mysqli_real_escape_string($data);

    return $data;
}

?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-8 col-lg-8 col-xl-8">
                <div class="container" style="background-color: #d3d3d3;"></div>
            </div>
            <div class="col col-md-4 col-lg-4 col-xl-4">
                <div class="form-group container">
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
