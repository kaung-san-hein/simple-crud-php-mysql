<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'testdb');
define('DB_PASSWORD', '');

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASSWORD,
    );
} catch (PDOException $e) {
    exit('Error ' . $e->getMessage());
}
