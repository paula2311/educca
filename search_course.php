<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
else{
    $user_id = '';
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- header section start -->
<?php include 'components/user_header.php';?>
<!-- header section end -->

<!-- courses section start -->
<section class="courses">
    <h1 class="heading">search results</h1>
    <div class="box-container">
        <?php
            if (isset($_POST['search_btn']) || isset($_POST['search_box']) ) {
                $search_box = $_POST['search_box'];
            
                $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search_box}%' AND status = ? ORDER BY date DESC");
                $select_courses->execute(['active']);
                if ($select_courses->rowCount() > 0) {
                    while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                        $course_id = $fetch_course['id'];

                        $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                        $count_course->execute([$course_id]);
                        $total_courses = $count_course->rowCount();

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->execute([$fetch_course['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
        ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="uploaded_files/<?=$fetch_tutor['image']?>" alt="">
                                <div>
                                    <h3><?=$fetch_tutor['name']?></h3>
                                    <span><?=$fetch_course['date']?></span>
                                </div>
                            </div>
                            
                            <div class="thumb">
                                <span><?=$total_courses?></span>
                                <img src="uploaded_files/<?=$fetch_course['thumb']?>" alt="">
                            </div>
                            <h3 class="title"><?=$fetch_course['title']?></h3>
                            <a href="playlist.php?get_id=<?=$course_id?>" class="inline-btn">view course</a>
                        </div>
            
        <?php
                    }
                } else{
                    echo "<p class='empty'>courses not found!</p>";
                }
            }
            else{
                echo '<p class="empty">☝️ search something! ☝️</p>';
            }  
        ?>
    </div>

</section>
<!-- courses section end -->


<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->

<script src="js/script.js"></script>
</body>
</html>