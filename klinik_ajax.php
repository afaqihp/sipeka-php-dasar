<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

//Dapatkan data user 
$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);

$keyword = $_GET['keyword'];
$query = "SELECT * FROM clinic_registration 
        WHERE (user_id = '$row[id]') AND
        (id LIKE '%$keyword%' OR 
        details LIKE '%$keyword%' OR 
        schedule LIKE '%$keyword%')";
$clinic_registrations = query($query);
?>
<table>

    <tr>
        <th>Registration ID</th>
        <th>Details</th>
        <th>Schedule</th>
        <th>Action</th>
    </tr>
    <?php foreach ($clinic_registrations as $row) : ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['details'] ?></td>
            <td><?= date_format(date_create($row['schedule']), "d-m-Y") ?></td>
            <td>
                <a href="klinik_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are your sure want to delete?'); ">
                    <img src="./assets/image/delete.png" alt="" />
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>