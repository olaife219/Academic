<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('location:playlist.php');
}

if(isset($_POST['update'])){
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $update_playlist = $conn->prepare("UPDATE `playlist` SET title = ?, description = ?, status = ? WHERE id = ?");
    $update_playlist->execute([$title, $description, $status, $get_id]);
    $message[] = 'playlist updated!';

    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/' . $rename;

    if(!empty($thumb)){
        if($thumb_size > 2000000){
            $message[] = 'image size is too large';
        }else{
            $update_thumb = $conn->prepare("UPDATE `playlist` SET thumb = ? WHERE id = ?");
            $update_thumb->execute([$rename, $get_id]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            if($old_thumb != '' AND $old_thumb != $rename){
                unlink('../uploaded_files/'.$old_thumb);
            }
        }
    }
}

if(isset($_POST['delete_playlist'])){

    $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ?");
    $verify_playlist->execute([$get_id]);

    if($verify_playlist->rowCount() > 0){
        $fetch_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
        $prev_thumb = $fetch_thumb['thumb'];
        if($prev_thumb != ''){
            unlink('../uploaded_files/'.$prev_thumb);
        }
        $delete_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
        $delete_bookmark->execute([$get_id]);
        $delete_playlist = $conn->prepare("DELETE FROM `playlist` WHERE id = ?");
        $delete_playlist->execute([$get_id]);
        header('location:playlist.php');
    }else{
        $message[] = 'playlist was already deleted!';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Playlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
    <?php include '../components/admin_header.php'; ?>

    <section class="crud-form">

        <h1 class="heading">update playlist</h1>

        <?php
            $selet_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ?");
            $selet_playlist->execute([$get_id]);
            if ($selet_playlist->rowCount() > 0) {
                while ($fetch_playlist = $selet_playlist->fetch(PDO::FETCH_ASSOC)) {
                    $playlist_id = $fetch_playlist['id'];

                    ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="old_thumb" value="<?= $fetch_playlist['thumb']; ?>">
            <p>update status</p>
            <select name="status" required class="box" required>
            <option value="<?= $fetch_playlist['status']; ?>" selected><?= $fetch_playlist['status']; ?></option>
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>
            <p>update title</p>
            <input type="text" class="box" required name="title" maxlength="100" placeholder="enter playlist title" value="<?= $fetch_playlist['title']; ?>">
            <p>update description</p>
            <textarea name="description" class="box" required cols="30"  placeholder="enter playlist description"
                maxlength="1000" row="10"><?= $fetch_playlist['description']; ?></textarea>
            <p>update thumbnail</p>
            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="" class="media">
            <input type="file" name="thumb"  accept="image/*" class="box">
            <input type="submit" value="update playlist" class="btn" name="update">
            <div class="flex-btn">
                <input type="submit" value="delete playlist" name="delete_playlist" class="delete-btn">
                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">view playlist</a>
            </div>
        </form>
        <?php
                }
            } else {
                echo '<p class="empty">playlist not found!</p>';
            }
            ?>
    </section>

    <?php include '../components/admin_footer.php'; ?>
<script src="../js/admin_script.js"></script>
</body>
</html>