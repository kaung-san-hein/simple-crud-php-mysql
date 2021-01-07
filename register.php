<?php
session_start();
if (isset($_COOKIE['auth'])) {
    header('Location:index.php');
    exit();
}
require_once 'config/connection.php';
require_once 'config/key.php';

$alert = null;

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $selectSql = "SELECT * FROM `admins` WHERE email = :email";
    $query = $conn->prepare($selectSql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $alert = "Email has already exist!";
    } else {
        openssl_cipher_iv_length(CIPHERING);
        $encryption = openssl_encrypt(
            $password,
            CIPHERING,
            KEY,
            OPTIONS,
            IV
        );
        $sql = "INSERT INTO `admins` (`name`, `email`, `password`) VALUES (:name, :email, :password)";
        $query = $conn->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $encryption, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $conn->lastInsertId();
        if ($lastInsertId > 0) {
            header('Location:Login.php');
            exit();
        } else {
            $alert = 'Registration was failed.';
        }
    }
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

    <div class="form-bg" style="width: 30%; position: absolute; top: 90px; left: 500px;">
        <h1>Registation Form</h1>
        <p>
            <?php
            if (isset($alert)) {
                echo $alert;
            }
            ?>
        </p>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" required id="name" name="name" placeholder="Enter your name..">

            <label for="email">Email</label>
            <input type="email" required id="email" name="email" placeholder="Enter your email..">

            <label for="password">Password</label>
            <input type="password" required id="password" name="password" placeholder="Enter your password..">

            <input style="background-color: #4caf50;" type="submit" name="submit" value="Register">
        </form>
        <p>You have already account? <a href="login.php">Login</a></p>
    </div>

</body>

</html>