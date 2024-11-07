<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $verify_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
    $verify_tutor->execute([$email, $pass]);
    $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);

        if ($verify_tutor->rowCount() > 0) {
            setcookie('tutor_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            header('location:dashboard.php');
        } else {
            $message[] = 'incorrect email or password!';
        }
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body style="padding-left: 0; height: 100vh; overflow: hidden;">

<?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
    <div class="message form">
        <span>' . $message . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
';
        }
    }
    ?>

    <section class="form-container">
        <form action="" method="post" class="login" enctype="multipart/form-data">
            <h3>welcome back!</h3>
            <p>your email <span>*</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="enter your email" class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box">
            <input type="submit" name="submit" class="btn" value="login now">
            <p class="link">don't have an account? <a href="register.php">register new</a></p>
        </form>
    </section>



    <script src="../js/admin_script.js"></script>
</body>

</html>