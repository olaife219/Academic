<?php

include '../components/connect.php';

setcookie('tutor_id', '', time() - 1, '/');
header('location:../admin/login.php');
?>