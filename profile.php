<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

//Dapatkan data user untuk diedit
$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);

//Update data user
if (isset($_POST['edit'])) {
    // $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $height = htmlspecialchars($_POST['height']);
    $weight = htmlspecialchars($_POST['weight']);

    // Validate age hanya numerik
    if (!is_numeric($age)) {
        echo "
        <script>
            alert('Umur harus berupa angka!');
            document.location.href = 'profile.php';
        </script>
        ";
        exit;
    }

    // Validate height
    if (!is_numeric($height)) {
        echo "
        <script>
            alert('Tinggi badan harus berupa angka!');
            document.location.href = 'profile.php';
        </script>
        ";
        exit;
    }

    // Validate weight
    if (!is_numeric($weight)) {
        echo "
        <script>
            alert('Berat badan harus berupa angka!');
            document.location.href = 'profile.php';
        </script>
        ";
        exit;
    }

    //Update data user
    $query = "UPDATE user SET name = '$name', age = '$age', height = '$height', weight = '$weight' WHERE username = '$username'";
    mysqli_query($conn, $query);


    header("Location: index.php");
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
    <title>Profile | SIPEKA STIS</title>
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
                        <h2>Profile</h2>
                        <!-- <a href="#" class="btn">Insert Student</a> -->
                    </div>



                    <div class="form">
                        <form action="" method="POST">
                            <h3>Your Profile</h3>

                            <label for="nama">Name</label>
                            <input type="text" placeholder="Full Name" id="nama" name="name" value="<?= $row["name"] ?>" />

                            <label for="age">Age</label>
                            <input type="text" placeholder="Age" id="age" name="age" value="<?= $row["age"] ?>" required />

                            <label for="height">Height</label>
                            <input type="text" placeholder="Height (cm)" id="height" name="height" value="<?= $row["height"] ?>" required />

                            <label for="weight">Weight</label>
                            <input type="text" placeholder="Weight (kg)" id="weight" name="weight" value="<?= $row["weight"] ?>" required />
                            <button type="submit" name="edit">Edit Profile</button>
                            <br />
                            <br />
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Akhir konten -->

        <?php
        include './footer.html';
        ?>
    </div>
    <!-- Akhir kontainer -->
</body>

</html>