<?php
session_start();
if (!isset($_COOKIE['auth'])) {
    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
    <div>
        <ul>
            <li><a href="logout.php">LOGOUT</a></li>
            <li><a href="add_student.php">ADD STUDENTS</a></li>
            <li style="border-left: 1px solid #bbb"><a href="index.php">ALL STUDENTS</a></li>
            <li style="float: left"><a href="index.php">WELCOME <?php echo strtoupper($_SESSION['name']); ?></a></li>
        </ul>
    </div>