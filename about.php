<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
else{
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- header section start -->
<?php include 'components/user_header.php';?>
<!-- header section end -->


<!-- about section start -->
<section class="about">
    <div class="row">
        <div class="image">
            <img src="imgs/about-img.svg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Odio quia dolorem eius porro ex natus.
            </p>
            <a href="courses.php" class="inline-btn">our courses</a>
        </div>
    </div>
    <div class="box-container">
        <div class="box">
            <i class="fas fa-graduation-cap"></i>
            <div>
                <h3>+10k</h3>
                <span>online courses</span>
            </div>
        </div>
        
        <div class="box">
            <i class="fas fa-user-graduate"></i>
            <div>
                <h3>+25k</h3>
                <span>students</span>
            </div>
        </div>

        <div class="box">
            <i class="fas fa-chalkboard-user"></i>
            <div>
                <h3>+5k</h3>
                <span>expert teachers</span>
            </div>
        </div>

        <div class="box">
            <i class="fas fa-briefcase"></i>
            <div>
                <h3>100%</h3>
                <span>job placement</span>
            </div>
        </div>

    </div>
</section>
<!-- about section end -->


<!-- reviews section start -->
<section class="reviews">
    <h1 class="heading">student's reviews</h1>
    <div class="box-container">
        <div class="box">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Animi eaque perferendis reiciendis non fugiat ipsa distinctio 
                laboriosam sit deleniti voluptatem.
            </p>
            <div class="user">
                <img src="imgs/paula.jpg" alt="">
                <div>
                    <h3>Paula essam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>                
                </div>
            </div>

        </div>

        <div class="box">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Animi eaque perferendis reiciendis non fugiat ipsa distinctio 
                laboriosam sit deleniti voluptatem.
            </p>
            <div class="user">
                <img src="imgs/paula.jpg" alt="">
                <div>
                    <h3>Paula essam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>                
                </div>
            </div>

        </div>

        <div class="box">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Animi eaque perferendis reiciendis non fugiat ipsa distinctio 
                laboriosam sit deleniti voluptatem.
            </p>
            <div class="user">
                <img src="imgs/paula.jpg" alt="">
                <div>
                    <h3>Paula essam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>                
                </div>
            </div>

        </div>

        <div class="box">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Animi eaque perferendis reiciendis non fugiat ipsa distinctio 
                laboriosam sit deleniti voluptatem.
            </p>
            <div class="user">
                <img src="imgs/paula.jpg" alt="">
                <div>
                    <h3>Paula essam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>                
                </div>
            </div>

        </div>

        <div class="box">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Animi eaque perferendis reiciendis non fugiat ipsa distinctio 
                laboriosam sit deleniti voluptatem.
            </p>
            <div class="user">
                <img src="imgs/paula.jpg" alt="">
                <div>
                    <h3>Paula essam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>                
                </div>
            </div>

        </div>
    </div>
</section>
<!-- reviews section end -->










<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->

<script src="js/script.js"></script>
</body>
</html>