<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
else{
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $verify_contact = $conn->prepare("SELECT * FROM `contact` WHERE name=? AND email=? AND number=? AND message=?");
    $verify_contact->execute([$name, $email, $number, $msg]);
    if ($verify_contact->rowCount() > 0) {
        $message[] = 'message sent already!';
    }
    else{
        $send_message = $conn->prepare("INSERT INTO `contact` (name,email,number,message) VALUES (?,?,?,?)");
        $send_message->execute([$name,$email,$number,$msg]);
        $message[] = 'message send successfully';
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
        
<!-- header section start -->
<?php include 'components/user_header.php';?>
<!-- header section end -->


<!-- contact section start -->
<section class="contact">
    <div class="row">
        <!-- contact img -->
        <div class="image">
            <img src="imgs/contact-img.svg" alt="" />
        </div>
        <!-- contact form -->
        <form action="" method="post">
            <h3>get in touch</h3>
            <input type="text" name="name" class="box" required
                placeholder="enter your name" maxlength="50">
            <input type="email" name="email" class="box" required
                placeholder="enter your email" maxlength="50">
            <input type="number" name="number" class="box" placeholder="enter your number"
                maxlength="20" required>  
            <textarea class="box" name="msg" id="" cols="30" rows="10" placeholder="enter your message"  maxlength="1000" required></textarea>
            <input type="submit" value="send message" class="inline-btn"
            name="submit">
        </form>
    </div>
    <div class="box-container">
        <div class="box">
            <i class="fas fa-phone"></i>
            <h3>phone number</h3>
            <a href="tel:+201014628698">+201014628698</a>
        </div>
        
        <div class="box">
            <i class="fa-brands fa-whatsapp"></i>
            <h3>whatsapp</h3>
            <a href="https://wa.me/+201014628698">+201014628698</a>
        </div>
        
        <div class="box">
            <i class="fas fa-envelope"></i>
            <h3>email address</h3>
            <a href="mailto:paulaessam8@gmail.com">paulaessam8@gmail.com</a>
        </div>

    </div>
</section>
<!-- contact section end -->












<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->

<script src="js/script.js"></script>
</body>
</html>