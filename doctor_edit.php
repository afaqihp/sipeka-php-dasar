<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

$id = $_GET['id'];

//Data dokter
$doctor = query("SELECT * FROM doctor WHERE id = $id")[0];

if (isset($_POST['edit'])) {
    if (edit_doctor($_POST) > 0) {
        echo "<script>
        alert('Data dokter berhasil diubah');
        document.location.href = 'doctor.php';
        </script>";
    } else {
        echo "<script>
        alert('Data dokter gagal diubah');
        document.location.href = 'doctor.php';
        </script>";
    }
}
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
                    <div class=" title">
                        <h2>Add New Doctor</h2>
                    </div>


                    <br>
                    <a href="doctor.php" class="btn">Back</a>

                    <div class="form">
                        <form action="" method="POST">
                            <h3>Edit Doctor</h3>

                            <input type="hidden" name="id" id="id" value="<?= $doctor['id']; ?>">

                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?= $doctor["name"] ?>" placeholder="Name" required>

                            <label for="age">Age</label>
                            <input type="text" name="age" id="age" value="<?= $doctor["age"] ?>" required pattern="[0-9]+" placeholder="Eg. 46" title="Umur hanya berupa digit">

                            <label for="specialty">Specialty</label>
                            <input type="text" name="specialty" id="specialty" value="<?= $doctor["specialty"] ?>" placeholder="Eg. General, Dentist, etc" required>

                            <label for="contact">Contact</label>
                            <input type="text" name="contact" id="contact" value="<?= $doctor["contact"] ?>" placeholder="Eg. 08527262xxx" required>

                            <input type="hidden" name="clinic_id" id="clinic_id" value="<?= $doctor["clinic_id"] ?>">

                            <button type="submit" name="edit">Edit</button>
                            <br />
                            <br />
                        </form>
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
</body>

</html>