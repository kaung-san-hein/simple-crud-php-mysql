<?php
require_once 'utils/menu.php';
require_once 'config/connection.php';

if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM `students` WHERE name LIKE :search OR roll_no LIKE :search OR major LIKE :search";
    $query = $conn->prepare($sql);
    $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM `students`";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="form-bg" style="margin: 10px">
    <table id="students">
        <caption>
            <h1>All Students (Total: <?php echo $query->rowCount(); ?>)</h1>
        </caption>
        <tr>
            <form action="" method="POST">
                <td colspan="5">
                    <input type="text" id="search" name="search" placeholder="Enter student's name or roll no or major..">
                </td>
                <td>
                    <input style="background-color: #4caf50;" type="submit" name="submit" value="Search">
                </td>
            </form>
        </tr>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Major</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php if ($query->rowCount() > 0) {
            foreach ($result as $row) {
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['roll_no']; ?></td>
                    <td><?php echo $row['major']; ?></td>
                    <td><img src="<?php echo $row['image']; ?>" width="100" height="100"></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit</a>
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="delete-button">Delete</a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </table>
</div>

<?php require_once 'utils/footer.php'; ?>