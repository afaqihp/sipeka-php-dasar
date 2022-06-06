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

//Tampil history registrasi klinik
$clinic_registrations = query("SELECT * FROM clinic_registration WHERE user_id = '$row[id]'");
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
                    <div class=" title">
                        <h2>Clinic</h2>
                    </div>

                    <div class="form">
                        <form action="klinik_add.php" method="POST">
                            <h3>Clinic Registration <br> Polstat STIS</h3>

                            <input type="hidden" name="id" id="id" value="<?= $row['id'] ?>" />

                            <label for="clinic_id">Clinic</label>
                            <select name="clinic_id" id="clinic_id" class="form-control" required>
                                <option value="">Choose Clinic</option>
                                <?php
                                $clinics = query("SELECT * FROM clinic");
                                foreach ($clinics as $clinic) {
                                    echo "<option value='$clinic[id]'>$clinic[name]</option>";
                                }
                                ?>
                            </select>

                            <label for="details">Details</label>
                            <input type="text" name="details" id="details" placeholder="Eg. Konsultasi sakit ...." name="details" required />

                            <label for="date">Schedule</label>
                            <input type="date" placeholder="Date" id="date" name="date" required />

                            <button type="submit" name="register">Register</button>
                            <br />
                            <br />
                        </form>
                    </div>

                    <div class="title" id="clinic-history">
                        <h2>Clinic Registration History</h2>
                    </div>

                    <div class="search">
                        <input type="text" placeholder="Search.." id="keyword" name="keyword" />
                        <button type="submit" name="search" id="search"><img src="./assets/image/search.png" alt="" /></button>
                    </div>

                    <div id="table-clinic">
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