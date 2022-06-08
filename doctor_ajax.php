<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

$keyword = $_GET['keyword'];
$query = "SELECT * FROM doctor 
        WHERE 
        name LIKE '%$keyword%' OR 
        specialty LIKE '%$keyword%' OR 
        contact LIKE '%$keyword%'";
$doctor = query($query);

?>
<div id="table-doctor">
    <table>
        <tr>
            <th>Name</th>
            <th>Specialty</th>
            <th>Contact</th>
            <?php if ($_SESSION['role'] == 1) { ?>
                <th>Action</th>
            <?php } ?>
        </tr>
        <?php foreach ($doctor as $doct) : ?>
            <tr>
                <td><?= $doct['name']; ?></td>
                <td><?= $doct['specialty']; ?></td>
                <!-- <td><?= $doct['contact']; ?></td> -->

                <?php
                $countrycode = "+62";
                $number = $doct['contact'];
                $international_number = preg_replace('/^0/', $countrycode, $number);
                // $text = "Hello $doct[name], My name is $row[name] I'm and using SIPEKA STIS and I want to having a consultation with you. Can you please accept my request? Thank You";
                ?>

                <td>
                    <a href="https://wa.me/<?= $international_number ?>/?text=Hello, I'm using SIPEKA STIS and I want to having a consultation with you. Can you please accept my request? Thank You" target="_blank" class="btn">Contact</a>
                </td>

                <?php if ($_SESSION['role'] == 1) { ?>
                    <td>
                        <a href="doctor_edit.php?id=<?= $doct['id'] ?>">
                            <img src="./assets/image/pencil.png" alt="" />
                        </a>

                        <a href="doctor_delete.php?id=<?= $doct['id'] ?>" onclick="return confirm('Are your sure want to delete?'); ">
                            <img src="./assets/image/delete.png" alt="" />
                        </a>
                    </td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
    </table>