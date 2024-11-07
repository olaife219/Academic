<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $verify_user->execute([$email, $pass]);
    $row = $verify_user->fetch(PDO::FETCH_ASSOC);

        if ($verify_user->rowCount() > 0) {
            setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            header('location:home.php');
        } else {
            $message[] = 'incorrect email or password!';
        }
    
}


?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>


    <section class="form-container">
        <form action="" method="post" class="login" enctype="multipart/form-data">
            <h3>welcome back!</h3>
            <p>your email <span>*</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="enter your email" class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box">
            <input type="submit" name="submit" class="btn" value="login now">
        </form>
    </section>





    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>