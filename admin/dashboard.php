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

    $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
    $count_content->execute([$tutor_id]);
    $total_contents = $count_content->rowCount();
    
    $count_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
    $count_playlist->execute([$tutor_id]);
    $total_playlists = $count_playlist->rowCount();
    
    $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
    $count_likes->execute([$tutor_id]);
    $total_likes = $count_likes->rowCount();
    
    $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
    $count_comments->execute([$tutor_id]);
    $total_comments = $count_comments->rowCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include '../components/admin_header.php';
?>

<!--dashboard section start-->
<section class="dashboard">
    <h1 class="heading">dashboard</h1>
    <div class="box-container">
        <div class="box">
            <h3>welcome!</h3>
            <p><?= $fetch_profile['name'];?></p>
            <a href="profile.php" class="btn">view profile</a>
        </div>

        <div class="box">
            <h3><?= $total_contents;?></h3>
            <p>contents uploaded</p>
            <a href="add_content.php" class="btn">add new content</a>
        </div>

        <div class="box">
            <h3><?= $total_playlists;?></h3>
            <p>playlists uploaded</p>
            <a href="add_playlist.php" class="btn">add new playlist</a>
        </div>

        <div class="box">
            <h3><?= $total_likes;?></h3>
            <p>total likes</p>
            <a href="contents.php" class="btn">view contents</a>
        </div>
        
        <div class="box">
            <h3><?= $total_likes;?></h3>
            <p>total comments</p>
            <a href="comments.php" class="btn">view comments</a>
        </div>

        <div class="box">
            <h3>quick links</h3>
            <p>login | register</p>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">login</a>
                <a href="register.php" class="option-btn">register</a>
            </div>
        </div>

</section>
<!--dashboard section end-->










<!-- footer section -->
<?php 
        include '../components/footer.php';
?>
<script src="../js/admin_script.js"></script>
</body>
</html>