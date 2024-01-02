<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
else{
    $user_id = '';
    header("Location: index.php");
}
if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $verify_comment->execute([$delete_id]);

    if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'comment deleted successfully!';
    }
    else{
        $message[] = 'comment already deleted!';
    }
}

if (isset($_POST['edit_comment'])) {
    $edit_id = $_POST['edit_id'];
    $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
    
    $comment_box = $_POST['comment_box'];
    $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

    $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id=? AND comment=?");
    $verify_edit_comment->execute([$edit_id, $comment_box]);
    if ($verify_edit_comment->rowCount() >0) {
        $message[] = 'comment already added!';
    }
    else{
        $update_comment = $conn->prepare('UPDATE `comments` SET comment = ? WHERE id = ?');
        $update_comment->execute([$comment_box, $edit_id]);
        $message[] = 'comment updated successfully!';
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- header section start -->
<?php include 'components/user_header.php';?>
<!-- header section end -->

<?php
    if(isset($_POST['update_comment'])){
        $update_id = $_POST['comment_id'];
        $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);

        $select_update_comment = $conn->prepare("SELECT * FROM `comments` WHERE id =? LIMIT 1 ");
        $select_update_comment->execute([$update_id]);
        $fetch_update_comment = $select_update_comment->fetch(PDO::FETCH_ASSOC);


?>
<section class="comment-form">
    <h1 class="heading">update comment</h1>
    <form action="" method="POST">
    <input type="hidden" name="edit_id" value="<?= $fetch_update_comment['id']; ?>">
        <textarea name="comment_box" class="box" required maxlength="1000" cols="30" row="10" placeholder="write a comment...">
            <?= $fetch_update_comment['comment']?>
        </textarea>
        <input type="submit" value="edit comment" name="edit_comment" class="inline-btn">
    </form>
</section>
<?php
}
?>
<!-- comments section start -->
<section class="comments">
    <h1 class="heading">your comments</h1>
    <div class="show-comments">
        <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id=?");
            $select_comments->execute([$user_id]);
            if ($select_comments->rowCount() > 0) {
                while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){
                    $comment_id = $fetch_comment['id'];
                    
                    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id=?");
                    $select_content->execute([$fetch_comment['content_id']]);
                    $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
            <div class="comment-content">
                <p>  <?= $fetch_content['title']?> </p>
                <a href="watchVideo.php?get_id=<?=$fetch_content['id'];?>">view content</a>
            </div>

                <p class="text"><?= $fetch_comment['comment'];?></p>
                    <form action="" method="post">
                        <input type="hidden" name="comment_id" value="<?= $comment_id?>">
                        <input type="submit" name="update_comment" value="update comment" class="inline-option-btn">
                        <input type="submit" name="delete_comment" value="delete comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">
                    </form>
                
            </div>
            <?php
                }
            }   
            else{
                echo '<p class="empty">no comments added yet!</p>';
            }
        ?>
    </div>
</section>

<!-- comments section end -->





<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->

<script src="js/script.js"></script>
</body>
</html>