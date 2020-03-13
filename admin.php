<?php
require 'config.php';
require 'header.php';
$name = $description = $price = $image = "";
$name_err = $description_err = $price_err = $image_err = "";

if (isset($_POST['btn_addProduct'])){
    if (empty($_POST['name'])){
        $name_err = "Please input product name";
    }else{
        $name = $_POST['name'];
    }

    if (empty($_POST['description'])){
        $description_err = "Please input product description";
    }else{
        $description = $_POST['description'];
    }

    if (empty($_POST['price'])){
        $price_err = "Please input product price";
    }else{
        $price = $_POST['price'];
    }
    if (isset($_FILES['image'])) {
//        the global variable $_FILES is set once an input of type 'file' is declared
//        it is an associative double dimension array that stores all information related to the uploaded file
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_type = $_FILES['image']['type'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); //get file extension type

        $extensions = array("jpeg","jpg","png");

        $image = $file_name;

        if (in_array($file_extension, $extensions) == false){
            $errors[] = "extension not allowed, please choose a jpeg or png file";
        }

        if ($file_size > 4096000){
            $errors[] = "File size must be less than 4MB";
        }

        if (empty($errors)){
            move_uploaded_file($file_tmp,"images/".$file_name);
        }else{
            echo $errors;
        }
//        insert data into db
        $sql = "INSERT INTO `products`(`product_id`, `name`, `description`, `price`, `image`) VALUES (NULL ,'$name','$description','$price','$image')";

        if (mysqli_query($conn,$sql)){
            header('location:admin.php');
        }else{
            echo mysqli_error($conn);
        }

    }

}
?>
<div class="container">
    <div class="row">
    <div class="col col-md-8 col-lg-8 col-xl-8"></div>
    <div class="col col-md-4 col-lg-4 col-xl-4">
        <!--        form to add product-->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Price</label>
                    <input type="number" name="price" class="form-control">
                </div>

                <div class="form-group">
                    <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <label for="">Image</label>
                <input type="file" name="image">
                <button class="btn btn-success btn-block" name="btn_addProduct" style="margin-top: 10px;">Add Product</button>
            </fieldset>
        </form>
    </div>
    </div>
</div>

<?php
require 'footer.php';

?>
