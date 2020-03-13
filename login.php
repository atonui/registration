<?php
require 'config.php';
require 'header.php';

$username = $password = '';

$username_err = $password_err = '';

if (isset($_POST['btn-login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)){
        $username_err = 'Please fill in your username';
    }elseif(empty($password)){
        $password_err = 'Please enter your password';
    }else {
        $password = md5($password);
        $sql = "SELECT `id`,`active` FROM `users` WHERE username = '$username' AND password = '$password'"; //select active from table, if set to 1 the proceed, if set to 0 then activate account
        //results from db come as a table with rows
        $results = mysqli_query($conn, $sql);
    }
        if (mysqli_num_rows($results) > 0 && (mysqli_fetch_assoc($results))['active'] == 1){
            //extract data from the results from db query
            while ($rows = mysqli_fetch_assoc($results)){
                session_start();
                $_SESSION['id'] = $rows['id'];
                $_SESSION['logged_in'] = true;
            }
            header('location:index.php');
        }elseif (empty(mysqli_fetch_assoc($results)['password'])){  //user entered the wrong password
            $password_err = "You entered the wrong password, please try again.";
        }
        elseif (!isset(mysqli_fetch_assoc($results)['active'])){
//            user has not confirmed their email address
            echo "
                <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
                 You have not confirmed your email address. Please check your inbox for instructions.
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
            ";
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

<body>
<?php
    if (isset($_GET['msg'])){
        echo "
            <div class=\"alert alert-primary\" role=\"alert\">
                You are already registered, please login here!
            </div>
        
        ";
    }
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-8 col-lg-8 col-xl-8"></div>
            <div class="col col-md-4 col-lg-4 col-xl-4">
                <div class="container">
                    <div class="form-group container" style="padding: 80px 0px; margin: 0 auto;">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                            <fieldset>
                                <div class="form-group" style="padding: 15px 0px;">
                                    <small style="color:orangered!important;" class="text-muted"><?php echo $username_err?></small><br>
                                    <label for="">Username</label>
                                    <input type="text" name="username" required class="form-control" placeholder="Username">
                                </div>

                                <div class="form-group" style="padding: 15px 0px;">
                                    <small style="color:orangered!important;" class="text-muted"><?php echo $password_err?></small><br>
                                    <label for="">Password</label>
                                    <input type="password" name="password" required class="form-control" placeholder="Password">
                                </div>
                                <button class="btn btn-block btn-info" name="btn-login">Log In</button><br>
                                <a href="reset_password.php">Forgot password?</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
require 'footer.php';
?>