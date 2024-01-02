<?php
include '../components/connect.php';
    if (isset($_COOKIE['tutor_id'])) {
        $tutor_id = $_COOKIE['tutor_id'];
    }
    else {
        $tutor_id = '';
        header("Location: login.php");
        exit();
    }

    if (isset($_POST['submit'])) {

        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id =? LIMIT 1");
        $select_tutor->execute([$tutor_id]);
        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

        $prev_pass      = $fetch_tutor['password'];
        $prev_image     = $fetch_tutor['image'];
        
        $name           = $_POST['name'];
        $name           = filter_var($name, FILTER_SANITIZE_STRING);
        
        $profession     = $_POST['profession'];
        $profession     = filter_var($profession, FILTER_SANITIZE_STRING);
        
        $email          = $_POST['email'];
        $email          = filter_var($email, FILTER_SANITIZE_STRING);
        
        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `tutors` SET name=? WHERE id=?");
            $update_name->execute([$name, $tutor_id]);
            $message[] = 'name updated successfully!';
        }
        if (!empty($profession)) {
            $update_profession = $conn->prepare("UPDATE `tutors` SET profession=? WHERE id=?");
            $update_profession->execute([$profession, $tutor_id]);
            $message[] = 'profession updated successfully!';
        }
        if (!empty($email)) {
            $select_tutor_email = $conn->prepare("SELECT * FROM `tutors` WHERE email=?");
            $select_tutor_email->execute([$email]);
            if ($select_tutor_email->rowCount() > 0) {
                $message[] = 'email already taken!';
            }else{
                $update_email = $conn->prepare("UPDATE `tutors` SET email=? WHERE id=?");
                $update_email->execute([$email, $tutor_id]);
                $message[] = 'email updated successfully!';
            }
            
        }
        

        
        $image          = $_FILES['image']['name'];
        $image          = filter_var($image, FILTER_SANITIZE_STRING);
        
        $ext            = pathinfo($image, PATHINFO_EXTENSION);
        $rename         = create_unique_id().'.'.$ext;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size     = $_FILES['image']['size'];
        $image_folder   = '../uploaded_files/'.$rename;

        if (!empty($image)) {
            if ($image_size > 2000000) {
                $message[] = 'image is too large!';
            }else{
                $update_image = $conn->prepare("UPDATE `tutors` SET `image`=? WHERE id=?");
                $update_image->execute([$rename, $tutor_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($prev_image != '' && $prev_image != $rename) {
                    unlink('../uploaded_files/'.$prev_image);
                }
                $message[] = 'image updated successfully!';
            }
        }

        $empty_pass     = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // كود التفشير بتاعة الاسترنج الفاضي
        $old_pass       = sha1($_POST['old_pass']);
        $old_pass       = filter_var($old_pass, FILTER_SANITIZE_STRING);
        
        $new_pass       = sha1($_POST['new_pass']);
        $new_pass       = filter_var($new_pass, FILTER_SANITIZE_STRING);
        
        $c_pass         = sha1($_POST['c_pass']);
        $c_pass         = filter_var($c_pass, FILTER_SANITIZE_STRING);
        
        if ($old_pass != $empty_pass) {
            if ($old_pass != $prev_pass) {
                $message[] = "old password not matched!";
            }elseif ($new_pass != $c_pass) {
                $message[] = "confirm password  not matched!";
            }else {
                if ($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE `tutors` SET password=? WHERE id=?");
                    $update_pass->execute([$c_pass, $tutor_id]);
                    $message[] = 'password updated successfully!';
                }else{
                    $message[] = 'please enter new password!';
                }
            }
        }
    
    
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../components/admin_header.php';
?>


<!-- update section start -->
<section class="form-container">   
    <form action="" method="post" enctype="multipart/form-data">
        <h3>update profile</h3>
        <div class="flex">
            <div class="col">
                <p>your name </p>
                <input type="text" name="name" maxlength="50" 
                placeholder="<?=$fetch_profile['name'];?>" class="box">

                <p>your profession </p>
                <select type="text" name="profession"  class="box">
                <option value="<?=$fetch_profile['profession'];?>" selected><?=$fetch_profile['profession'];?></option>
                <option value="developer">Developer</option>
                <option value="english teacher">English Teacher</option>
                <option value="math teacher">Math Teacher</option>
                <option value="bio teacher">Bio Teacher</option>
                <option value="spanish teacher">Spanish Teacher</option>
                </select>

                <p>your email </p>
                <input type="email" name="email" maxlength="50" 
                placeholder="<?=$fetch_profile['email'];?>" class="box">
            </div>

            <div class="col">
            <p>old password </p>
                <input type="password" name="old_pass" maxlength="20" 
                placeholder="enter your old password" class="box">

                <p>your new password </p>
                <input type="password" name="new_pass" maxlength="20" 
                placeholder="enter your new password" class="box">

                <p>confirm password </p>
                <input type="password" name="c_pass" maxlength="20" 
                placeholder="confirm your new password" class="box">

            </div>
        </div>
        <p>update pic </p>
        <input type="file" name="image" class="box" 
        accept="image/*">
        <input type="submit" name="submit" value="update" class="btn">
    </form>
</section>     
<!-- update section end -->









<!-- footer section -->
<?php 
        include '../components/footer.php';
?>
<script src="../js/admin_script.js"></script>
</body>
</html>