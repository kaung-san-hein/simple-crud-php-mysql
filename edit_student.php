<?php
require_once 'utils/menu.php';
require_once 'config/connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM `students` WHERE id = $id";
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$row = $result[0];
?>

<div class="form-bg" style="width: 30%; margin-left: 500px;">
    <h1>Edit Student Form</h1>

    <div style="text-align: center;margin-bottom: 10px;">
        <img src="<?php echo $row['image']; ?>" width="150" height="150">
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="name">Student Name</label>
        <input type="text" required id="name" name="name" value="<?php echo $row['name']; ?>" placeholder="Enter student's name..">

        <label for="roll_no">Roll No</label>
        <input type="text" required id="roll_no" name="roll_no" value="<?php echo $row['roll_no']; ?>" placeholder="Enter student's roll no..">

        <label for="major">Major</label>
        <input type="text" required id="major" name="major" value="<?php echo $row['major']; ?>" placeholder="Enter student's major..">

        <label for="image">Image</label>
        <input type="file" id="image" name="image">

        <input style="background-color: #4caf50;" type="submit" name="submit" value="Edit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $pimage = $_FILES['image']['name'];
        if ($pimage == "") {
            $sql = "UPDATE `students` SET `name` = :name, `roll_no` = :roll_no, `major` = :major WHERE `students`.`id` = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
            $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $query->bindParam(':roll_no', $_POST['roll_no'], PDO::PARAM_STR);
            $query->bindParam(':major', $_POST['major'], PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                header("Location:index.php");
                exit();
            }
        } else {
            $tm = md5(time());
            $fnm = $_FILES['image']['name'];
            $dst = "images/" . $tm . $fnm;
            move_uploaded_file($_FILES['image']['tmp_name'], $dst);
            unlink($row['image']);

            $sql = "UPDATE `students` SET `name` = :name, `roll_no` = :roll_no, `major` = :major, `image` = :image WHERE `students`.`id` = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
            $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $query->bindParam(':roll_no', $_POST['roll_no'], PDO::PARAM_STR);
            $query->bindParam(':major', $_POST['major'], PDO::PARAM_STR);
            $query->bindParam(':image', $dst, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                header("Location:index.php");
                exit();
            }
        }
    }
    ?>
</div>

<?php require_once 'utils/footer.php'; ?>