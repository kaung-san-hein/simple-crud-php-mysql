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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $selectSql = "SELECT * FROM `admins` WHERE email = :email";
    $query = $conn->prepare($selectSql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $encryption = $result[0]['password'];
        $decryption = openssl_decrypt(
            $encryption,
            CIPHERING,
            KEY,
            OPTIONS,
            IV
        );
        if ($decryption == $password) {
            $_SESSION['name'] = $result[0]['name'];
            setcookie("auth", true, time() + 86400, "/", "", false, false);
            header("Location:index.php");
            exit();
        } else {
            $alert = "Invalid Credential!";
        }
    } else {
        $alert = "Invalid Credential!";
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
        <h1>Login Form</h1>
        <p>
            <?php
            if (isset($alert)) {
                echo $alert;
            }
            ?>
        </p>
        <form action="" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email..">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password..">

            <input style="background-color: #4caf50;" type="submit" name="submit" value="Login">
        </form>
        <p>You don't have account? <a href="register.php">Register</a></p>
    </div>

</body>

</html>