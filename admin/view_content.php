<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:playlist.php');
}

if (isset($_POST['delete_content'])) {
    $delete_id = $_POST['content_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
    $verify_content->execute([$delete_id]);

    if ($verify_content->rowCount() > 0) {
        $fetch_content = $verify_content->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_content['thumb']);
        unlink('../uploaded_files/' . $fetch_content['video']);

        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
        $delete_comment->execute([$delete_id]);
        $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
        $delete_likes->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
        $delete_content->execute([$delete_id]);
        header('location:contents.php');
    } else {
        $message[] = 'content already deleted!';
    }
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
    } else {
        $message[] = 'comment already deleted!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
    <?php include '../components/admin_header.php'; ?>

    <section class="view-content">

        <?php
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
        $select_content->execute([$get_id]);
        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $content_id = $fetch_content['id'];

                $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ? AND content_id = ?");
                $count_likes->execute([$tutor_id, $content_id]);
                $total_likes = $count_likes->rowCount();

                $count_comment = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ? AND content_id = ?");
                $count_comment->execute([$tutor_id, $content_id]);
                $total_comments = $count_comment->rowCount();

                ?>
                <div class="content">
                    <video src="../uploaded_files/<?= $fetch_content['video']; ?>"
                        poster="../uploaded_files/<?= $fetch_content['thumb']; ?>" controls autoplay></video>
                    <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></div>
                    <h3 class="title"><?= $fetch_content['title']; ?></h3>
                    <div class="flex">
                        <div><i class="fas fa-heart"></i><span><?= $total_likes; ?></span></div>
                        <div><i class="fas fa-comment"></i><span><?= $total_comments; ?></span></div>
                    </div>
                    <p class="description"><?= $fetch_content['description']; ?></p>
                    <form action="" method="POST" class="flex-btn">
                        <input type="hidden" name="content_id" value="<?= $content_id; ?>">
                        <input type="submit" value="delete content" name="delete_content" class="delete-btn">
                        <a href="update_content.php?get_id=<?= $content_id; ?>" class="option-btn">update content</a>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">content was not found!</p>';
        }
        ?>

    </section>

    <section class="comments">

        <h1 class="heading">user comments</h1>

        <div class="box-container">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ? AND tutor_id = ?");
            $select_comments->execute([$get_id, $tutor_id]);
            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $comment_id = $fetch_comment['user_id'];
                    $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_commentor->execute([$comment_id]);
                    $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <div class="box" style="margin-bottom: 1rem;">
                        <div class="user">
                            <img src="../uploaded_files/<?= $fetch_commentor['image']; ?>" style="margin-right: 1rem;" alt="">
                            <div>
                                <h3><?= $fetch_commentor['name']; ?></h3>
                                <span><?= $fetch_comment['date']; ?></span>
                            </div>

                        </div>
                        <p class="comment-box"><?= $fetch_comment['comment']; ?></p>
                        <form action="" method="POST">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                            <input type="submit" value="delete comment" name="delete_comment" class="inline-delete-btn"
                                onclick="return confirm('delete this comment?');">
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no comments added yet!</p>';
            }
            ?>
        </div>
    </section>



    <?php include '../components/admin_footer.php'; ?>
    <script src="../js/admin_script.js"></script>
</body>

</html>