<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {

    $id = create_unique_id();
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist_id = $_POST['playlist'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);

    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = create_unique_id() . '.' . $thumb_ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/' . $rename_thumb;

    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = create_unique_id() . '.' . $video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/' . $rename_video;

    $verify_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_content->execute([$tutor_id, $title, $description]);

    if ($verify_content->rowCount() > 0) {
        $message[] = 'content already created!';
    } else {
        if ($thumb_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $add_content = $conn->prepare("INSERT INTO `content` (id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES(?,?,?,?,?,?,?,?)");
            $add_content->execute([$id, $tutor_id, $playlist_id, $title, $description, $rename_video, $rename_thumb, $status]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            move_uploaded_file($video_tmp_name, $video_folder);
            $message[] = 'new content created!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
    <?php include '../components/admin_header.php'; ?>

    <section class="crud-form">

        <h1 class="heading">add content</h1>

        <form action="" method="POST" enctype="multipart/form-data">

            <p>content status<span>*</span></p>
            <select name="status" required class="box">
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>

            <p>content title<span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" placeholder="enter content title" required>

            <p>content description<span>*</span></p>
            <textarea name="description" class="box" cols="30" required placeholder="enter content description"
                maxlength="1000" rows="10"></textarea>

            <select name="playlist" class="box" required>
                <option value="" disabled selected>--select playlist</option>
                <?php
                $selet_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
                $selet_playlist->execute([$tutor_id]);
                if ($selet_playlist->rowCount() > 0) {
                    while ($fetch_playlist = $selet_playlist->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                        <option value="<?= $fetch_playlist['id'] ?>"><?= $fetch_playlist['title'] ?></option>
                        <?php
                    }
                } else {
                    echo '<option value="" disabled>no playlist created yet!</option>';
                }
                ?>
            </select>
            <p>select thumbnail <span>*</span></p>
            <input type="file" name="thumb" required accept="image/*" class="box">
            <p>select video <span>*</span></p>
            <input type="file" name="video" required accept="video/*" class="box">
            <input type="submit" value="add content" class="btn" name="submit">

        </form>
    </section>


    <?php include '../components/admin_footer.php'; ?>
    <script src="../js/admin_script.js"></script>
</body>

</html>