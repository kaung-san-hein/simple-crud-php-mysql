<?php
require_once 'utils/menu.php';
require_once 'config/connection.php';

$alert = null;

if (isset($_POST['add'])) {
    $tm = md5(time());
    $fnm = $_FILES['image']['name'];
    $dst = "images/" . $tm . $fnm;
    move_uploaded_file($_FILES['image']['tmp_name'], $dst);

    $sql = "INSERT INTO `students` (`name`, `roll_no`, `major`, `image`) VALUES (:name, :roll_no, :major, :image)";
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $query->bindParam(':roll_no', $_POST['roll_no'], PDO::PARAM_STR);
    $query->bindParam(':major', $_POST['major'], PDO::PARAM_STR);
    $query->bindParam(':image', $dst, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $conn->lastInsertId();
    if ($lastInsertId > 0) {
        $alert = 'Student was added successfully.';
    } else {
        $alert = 'Student adding was failed.';
    }
}
?>

<div class="form-bg" style="width: 30%; margin-left: 500px; margin-top: 100px;">
    <h1>Add Student Form</h1>
    <p>
        <?php
        if (isset($alert)) {
            echo $alert;
        }
        ?>
    </p>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Student Name</label>
        <input type="text" required id="name" name="name" placeholder="Enter student's name..">

        <label for="roll_no">Roll No</label>
        <input type="text" required id="roll_no" name="roll_no" placeholder="Enter student's roll no..">

        <label for="major">Major</label>
        <input type="text" required id="major" name="major" placeholder="Enter student's major..">

        <label for="image">Image</label>
        <input type="file" required id="image" name="image">

        <input style="background-color: #4caf50;" type="submit" name="add" value="Add">
        <input style="background-color: #3c30e9;" type="reset" value="Cancel">
    </form>
</div>

<?php require_once 'utils/footer.php'; ?>