<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}

$count_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$count_bookmark->execute([$user_id]);
$total_bookmarks = $count_bookmark->rowCount();

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$count_likes->execute([$user_id]);
$total_likes = $count_likes->rowCount();

$count_comment = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$count_comment->execute([$user_id]);
$total_comments = $count_comment->rowCount();

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>


    <section class="profile">

        <h1 class="heading">Profile detailes</h1>

        <div class="details">

            <div class="tutor">
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <p><?= $fetch_profile['email']; ?></p>
                <span>student</span>
                <a href="update.php" class="inline-btn">update profile</a>
            </div>


            <div class="box-container">
                <div class="box">
                    <h3><?= $total_bookmarks; ?></h3>
                    <p>playlist bookmarked</p>
                    <a href="bookmark.php" class="btn">view bookmarks</a>
                </div>

                <div class="box">
                    <h3><?= $total_likes; ?></h3>
                    <p>total liked</p>
                    <a href="contents.php" class="btn">view contents</a>
                </div>

                <div class="box">
                    <h3><?= $total_comments; ?></h3>
                    <p>total commented</p>
                    <a href="comments.php" class="btn">view comments</a>
                </div>
            </div>
        </div>
    </section>





    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>