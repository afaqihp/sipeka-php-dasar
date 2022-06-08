<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

//Tampil history registrasi klinik
$clinic_registrations = query("SELECT * FROM clinic_registration");
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
    <title>Clinic | SIPEKA STIS</title>
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
                        <h2>All Clinic Registration History</h2>
                    </div>
                    <br>
                    <a href="klinik.php" class="btn">Back</a>

                    <div class="search">
                        <input type="text" placeholder="Search.." id="keyword" name="keyword" />
                        <button type="submit" name="search" id="search"><img src="./assets/image/search.png" alt="" /></button>
                    </div>

                    <div id="table-clinic">
                        <table>

                            <tr>
                                <th>Registration ID</th>
                                <th>User ID</th>
                                <th>Details</th>
                                <th>Schedule</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($clinic_registrations as $row) : ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['user_id']; ?></td>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir konten -->
        <?php
        include './footer.php';
        ?>
    </div>
    <!-- Akhir kontainer -->

    <script src="./assets/js/scriptClinicAjax.js"></script>
</body>

</html>