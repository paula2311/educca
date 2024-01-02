<?php
if (isset($message)) {
    foreach($message as $msg){
        echo '
            <div class="message">
                <span>'.$msg.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        
        ';
    }
}


?>
<!-- header section starts -->
<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">Educa.</a>

        <form action="search_course.php" method="post" class="search-form">
            <input type="text" name="search_box" placeholder="Search..." 
                maxlen="100" required/>
            <button type="submit" class="fas fa-search" name="search_btn"> </button>
        </form>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id=?");
                $select_profile->execute([$user_id]);
                if($select_profile->rowCount() > 0){
                    $fetch_profile =  $select_profile->fetch(PDO::FETCH_ASSOC) ;
                
            ?>
            <img src="uploaded_files/<?= $fetch_profile['image'];?>" alt="">
            <h3><?= $fetch_profile['name'];?></h3>
            <span>student</span>
            <a href="profile.php" class="btn">view profile</a>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">login</a>
                <a href="register.php" class="option-btn">register</a>
            </div>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?')" class="delete-btn">logout</a>

            <?php 
            
                }else{
            ?>    
                    <h3>please login first</h3>
                    <div class="flex-btn">
                        <a href="login.php" class="option-btn">login</a>
                        <a href="register.php" class="option-btn">register</a>
                    </div>
            
            <?php 
                

                }
            ?>
        </div>
    </section>
</header>
<!-- header section ends -->


<!-- side bar section start -->
<div class="side-bar">
        <div class="close-side-bar">
            <i class="fas fa-times"></i>
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id=?");
                $select_profile->execute([$user_id]);
                if($select_profile->rowCount() > 0){
                    $fetch_profile =  $select_profile->fetch(PDO::FETCH_ASSOC) ;
                
            ?>
            <img src="uploaded_files/<?= $fetch_profile['image'];?>" alt="">
            <h3><?= $fetch_profile['name'];?></h3>
            <span>student</span>
            <a href="profile.php" class="btn">view profile</a>
            

            <?php 
            
                }else{
            ?>    
                    <h3>please login first</h3>
                    <div class="flex-btn">
                        <a href="login.php" class="option-btn">login</a>
                        <a href="register.php" class="option-btn">register</a>
                    </div>
            
            <?php 
                

                }
            ?>
        </div>
        <nav class="navbar">
            <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
            <a href="about.php"><i class="fas fa-question"></i><span>about</span></a>
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
            <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
            <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
        </nav>
</div>
<!-- side bar section end -->