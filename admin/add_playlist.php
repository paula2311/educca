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
        $id             = create_unique_id();
    
        $status         = $_POST['status'];
        $status         = filter_var($status, FILTER_SANITIZE_STRING);
        
        $title          = $_POST['title'];
        $title          = filter_var($title, FILTER_SANITIZE_STRING);
        
        $description    = $_POST['description'];
        $description    = filter_var($description, FILTER_SANITIZE_STRING);

        $thumb          = $_FILES['thumb']['name'];
        $thumb          = filter_var($thumb, FILTER_SANITIZE_STRING);
        
        $ext            = pathinfo($thumb, PATHINFO_EXTENSION);
        $rename         = create_unique_id().'.'.$ext;
        $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
        $thumb_size     = $_FILES['thumb']['size'];
        $thumb_folder   = '../uploaded_files/'.$rename;

        $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id =? AND title =? AND description =? ");
        $verify_playlist -> execute([$tutor_id, $title, $description]);

        if ($verify_playlist->rowCount() > 0) {
            $message[] = 'playlist already created!';
        }
        else{
            $add_playlist = $conn->prepare("INSERT INTO `playlist` (id, tutor_id, title, description, thumb, status)
                                            VALUES (?,?,?,?,?,?)");
            $add_playlist -> execute([$id, $tutor_id, $title, $description, $rename, $status]);            
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            $message[] = 'new playlist created!';
            
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../components/admin_header.php';
?>


<!-- add playlist section start -->
<section class="crud-form">
    <h1 class="heading">add playlist</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <p>playlist status <span>*</span></p>
        
        <select name="status" class="box" required>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        
        <p>playlist title <span>*</span></p>
        <input type="text" name="title" placeholder="enter playlist title" class="box" maxlength="100" required>
        
        <p>playlist description <span>*</span></p>
        <textarea name="description" placeholder="enter playlist description" class="box" maxlength="1000" required cols="30" rows="10"></textarea>
    
        <p>playlist thumbnail <span>*</span></p>
        <input type="file" name="thumb"  class="box" accept="image/*" required>
    
        <input type="submit" name="submit"  value="create playlist" class="btn">
    
    </form>
</section>
<!-- add playlist section end -->









<!-- footer section -->
<?php 
        include '../components/footer.php';
?>
<script src="../js/admin_script.js"></script>
</body>
</html>