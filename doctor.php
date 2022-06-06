<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

$doctor = query("SELECT * FROM doctor");

//Dapatkan data user 
$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <link rel="stylesheet" href="./assets/css/loginstyle.css" />
    <script src="./assets/js/myScript.js"></script>
    <link rel="icon" href="./assets/image/logo.png" type="image/x-icon">
    <title>Doctor | SIPEKA STIS</title>
</head>

<body>
    <!-- Include sidemenu -->
    <?php
    include './sidemenu.php';
    ?>

    <!-- Bagian kontainer -->
    <div id="main" class="container">

        <!-- Include header -->
        <?php
        include './header.php';
        ?>

        <!-- Awal konten -->
        <div class="content">
            <div class="content-2">

                <div class="main-content">

                    <div class="title">
                        <h2>List Doctor</h2>
                    </div>

                    <div class="search">
                        <input type="text" placeholder="Search.." id="keyword" name="keyword" />
                        <button type="submit" name="search" id="search"><img src="./assets/image/search.png" alt="" /></button>
                    </div>

                    <!-- Untuk tabel -->
                    <div id="table-doctor">
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
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <!-- Akhir tabel -->
                </div>
            </div>
        </div>
        <!-- Akhir konten -->

        <?php
        include 'footer.php';
        ?>

    </div>
    <!-- Akhir kontainer -->
    <script src="./assets/js/scriptDoctorAjax.js"></script>
</body>

</html>