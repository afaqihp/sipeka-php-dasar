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
    <title>Home | SIPEKA STIS</title>
</head>

<body>
    <!-- Include sidemenu -->
    <?php
    include './sidemenu.html';
    ?>

    <!-- Bagian kontainer -->
    <div id="main" class="container">

        <!-- Include header -->
        <?php
        include './header.html';
        ?>

        <!-- Awal konten -->
        <div class="content">

            <div class="content-2">

                <div class="main-content">
                    <div class="title">
                        <h2 onclick="showError('tres')">Home</h2>
                    </div>

                    <div id="error-message"></div>

                    <div class="title2">
                        <h3>Welcome <?= $_SESSION["username"] ?>, have a great day!</h3>
                    </div>

                    <div class="text">
                        <p><strong>SIPEKA STIS</strong> merupakan suatu platform kesehatan yang bertujuan untuk mengelola kesehatan para Civitas Akademika Polstat STIS. Situs ini diluncurkan pada Juni 2022 sebagai salah satu projek tugas akhir untuk mata kuliah Pemrograman Berbasis Web dengan Dosen Pengampu <strong>Ibu Dr. Eng. Lya Hulliyyatus Suadaa SST., MT.</strong>
                        </p>
                        <br>
                        <p>Situs ini terdiri dari beberapa fitur seperti pengelolaan profil beberapa <strong>data kesehatan user</strong>, integrasi dengan <strong>klinik</strong> kesehatan kampus Polstat STIS untuk pendaftaran klinik kesehatan, serta fitur untuk berkonsultasi dengan <strong>dokter</strong> terkait secara online. Kedepannya diharapkan pengembangan website ini lebih lanjut dapat menjadi media yang bermanfaat bagi Civitas Akademika Polstat STIS.
                        </p>
                    </div>

                    <div class="title">
                        <h2>Your Health Info</h2>
                    </div>

                    <?php
                    if (!isset($row['age']) || !isset($row['height']) || !isset($row['weight'])) {
                        echo
                        "<div class='title2'>
                        <h3 style='display: inline;'>Please complete your profile <a href='profile.php' class='btn'>here</a></h3>  
                        </div>";
                    }

                    ?>

                    <!-- Summary stats -->
                    <div class="cards">
                        <div class="card">
                            <div class="box">
                                <h1><?= $row['age'] ?></h1>
                                <h3>Age</h3>
                            </div>
                            <div class="icon-case">
                                <img src="./assets/image/age-group.png" alt="" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="box">
                                <h1><?= $row['weight'] ?></h1>
                                <h3>Weight</h3>
                            </div>
                            <div class="icon-case">
                                <img src="./assets/image/scale.png" alt="" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="box">
                                <h1><?= $row['height'] ?></h1>
                                <h3>Height</h3>
                            </div>
                            <div class="icon-case">
                                <img src="./assets/image/height.png" alt="" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="box">
                                <?php
                                try {
                                    // $bmi = $row['weight'] / (pow($row['height'] / 100, 2));
                                    $bmi = $row['weight'] / (pow($row['height'] / 100, 2));
                                    echo "<h1>" . round($bmi, 2) . "</h1>";
                                } catch (DivisionByZeroError $e) {
                                    echo "<h1>Null</h1>";
                                }
                                ?>
                                <h3>BMI</h3>
                            </div>
                            <div class="icon-case">
                                <img src="./assets/image/body-mass-index.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <!-- Akhir summary -->


                </div>




            </div>
        </div>
        <!-- Akhir konten -->

        <?php
        include 'footer.html';
        ?>

    </div>
    <!-- Akhir kontainer -->
</body>

</html>