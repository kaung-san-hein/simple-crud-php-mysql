<?php
require_once 'config/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $selectSql = "SELECT * FROM `students` WHERE id = $id";
    $query = $conn->prepare($selectSql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $image = $result[0]['image'];

    $deleteSql = "DELETE FROM `students` WHERE `id`=:id";
    $query = $conn->prepare($deleteSql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    unlink($image);

    header('Location:index.php');
}
