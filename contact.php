<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $verify_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $verify_contact->execute([$name, $email, $number, $msg]);

    if($verify_contact->rowCount() > 0){
        $message[] = 'message sent already!';
    }else{
        $send_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
        $send_message->execute([$name, $email, $number, $msg]);
        $message[] = 'message send successfully';
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <section class="contact">

        <div class="row">

            <div class="image">
                <img src="images/contact-img.svg" alt="">
            </div>

            <form action="" method="POST">
                <h3>get in touch</h3>
                <input type="text" placeholder="please enter your name" required maxlength="50" name="name" class="box">
                <input type="email" placeholder="please enter your email" required maxlength="50" name="email" class="box">
                <input type="number" placeholder="enter your number" required maxlength="11" name="number" class="box" min="0" max="9999999999">
                <textarea name="msg" class="box" placeholder="enter your message" required maxlength="1000" cols="30" rows="10"></textarea>
                <input type="submit" value="send message" class="inline-btn" name="submit">
            </form>
        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>phone number</h3>

                <a href="tel:+2348027369848">+2348027369848</a>
                <a href="tel:+2349025783055">+2349025783055</a>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>email address</h3>

                <a href="mailto:horlarmedeydurodola@gmail.com">horlarmedeydurodola@gmail.com</a>
                <a href="mailto:durodolaabdulhameed2021@gmail.com">durodolaabdulhameed2021@gmail.com</a>
            </div>

            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>office address</h3>
                <a href="#">flat no. 1, a-1 building, jogeshari, mumbai, india - 400104</a>
            </div>
        </div>
    </section>






    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>