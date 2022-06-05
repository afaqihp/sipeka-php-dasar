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
<table>
    <tr>
        <th>Name</th>
        <th>Specialty</th>
        <th>Contact</th>
    </tr>
    <?php foreach ($doctor as $doct) : ?>
        <tr>
            <td><?= $doct['name']; ?></td>
            <td><?= $doct['specialty']; ?></td>

            <?php
            $countrycode = "+62";
            $number = $doct['contact'];
            $international_number = preg_replace('/^0/', $countrycode, $number);
            ?>

            <td>
                <a href="https://wa.me/<?= $international_number ?>/?text=Hello, I'm using SIPEKA STIS and I want to having a consultation with you. Can you please accept my request? Thank You" target="_blank" class="btn">Contact</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>