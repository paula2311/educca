<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
else{
    $user_id = '';
}

if (isset($_POST['submit'])) {
    // Get the data from form
    $id             = create_unique_id();

    $name           = $_POST['name'];
    $name           = filter_var($name, FILTER_SANITIZE_STRING);
    
    $email          = $_POST['email'];
    $email          = filter_var($email, FILTER_SANITIZE_STRING);
    
    $pass           = sha1($_POST['pass']);
    $pass           = filter_var($pass, FILTER_SANITIZE_STRING);
    
    $c_pass         = sha1($_POST['c_pass']);
    $c_pass         = filter_var($c_pass, FILTER_SANITIZE_STRING);

    $image          = $_FILES['image']['name'];
    $image          = filter_var($image, FILTER_SANITIZE_STRING);
    
    $ext            = pathinfo($image, PATHINFO_EXTENSION);
    $rename         = create_unique_id().'.'.$ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size     = $_FILES['image']['size'];
    $image_folder   = 'uploaded_files/'.$rename;

    // select from database************
    $select_user_email = $conn->prepare("SELECT * FROM `users` WHERE email=?");
    $select_user_email->execute([$email]);
    if ($select_user_email->rowCount() > 0) {
        $message[] = 'email already taken!';
    }
    else{
        if ($pass != $c_pass) {
            $message[] = 'password not matched!'; 
        }
        else{
            if ($image_size > 2000000) {
                $message[] = "Image size is too large.";
            }else{
                // insert tutor into database
                $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image)
                VALUE(?,?,?,?,?)");
                $insert_user->execute([$id, $name, $email, $c_pass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);
            
                $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email=? AND password =? LIMIT 1");
                $verify_user->execute([$email,$c_pass]);
                $row = $verify_user->fetch(PDO::FETCH_ASSOC);
                if($insert_user){
                    if ($verify_user->rowCount() > 0) {
                            setcookie('user_id', $row['id'], time() + 60*60*24*30,'/');
                            header("Location: index.php");
                    }else{
                        $message[] = 'something went wrong!';

                    }
                }
            
            }


        }
    }
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- header section start -->
<?php include 'components/user_header.php';?>
<!-- header section end -->

<!-- register section start -->
<section class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>register as student</h3>
        <div class="flex">
            <div class="col">
                <p>your name <span>*</span></p>
                <input type="text" name="name" maxlength="50" required
                placeholder="enter your name" class="box">

                <p>your email <span>*</span></p>
                <input type="email" name="email" maxlength="50" required
                placeholder="enter your email" class="box">
            </div>

            <div class="col">
                <p>your password <span>*</span></p>
                    <input type="password" name="pass" maxlength="20" required
                    placeholder="enter your password" class="box">
                
                <p>confirm password <span>*</span></p>
                    <input type="password" name="c_pass" maxlength="20" required
                    placeholder="confirm your password" class="box">
                
            </div>
        </div>
        <p>select pic <span>*</span></p>
        <input type="file" name="image" class="box" required
        accept="image/*">

        <input type="submit" name="submit" value="register now" class="btn">
    </form>
</section>
<!-- register section end -->











<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->

<script src="js/script.js"></script>
</body>
</html>