<?php
require './functions.php';

if (isset($_POST["register"])) {
    if (create_account($_POST) > 0) {
        echo "
            <script>
                alert('Registrasi berhasil');
                document.location.href = 'login.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Akun gagal dibuat!');
                document.location.href = 'register.php';
            </script>
        ";
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
    <script src="./assets/js/validationScript.js"></script>
    <link rel="icon" href="./assets/image/logo.png" type="image/x-icon">
    <title>Register | SIPEKA STIS</title>
</head>

<body>
    <!-- Bagian kontainer -->
    <div id="main" class="container">
        <!-- Bagian header -->
        <div id="my-header" class="header">
            <div class="nav">
                <span><img style="width: 48px" src="./assets/image/logo.png" alt="" /></span>
                <div class="header-title">
                    <h1>SIPEKA STIS</h1>
                </div>
            </div>
        </div>
        <!-- Akhir header -->

        <!-- Awal konten -->
        <div class="content">
            <div class="content-2">
                <div class="main-content">
                    <div class="title">
                        <h2>Registration Page</h2>
                    </div>

                    <div class="form">
                        <form name="regForm" action="" method="POST">
                            <h3>SIPEKA STIS</h3>
                            <br><br>

                            <label for="name">Full Name</label>
                            <input type="text" placeholder="Full Name" id="name" name="name" required pattern="[a-zA-Z ]+" title="Nama hanya berupa alfabet dan spasi saja!">

                            <label for="username">Username</label>
                            <input type="text" placeholder="Username" id="username" name="username" required pattern="[a-zA-Z][a-zA-Z0-9-_]{3,24}" title="Panjang 4 sampai 24 karakter dan gunakan huruf sebagai karakter pertama">

                            <label for="password">Password</label>
                            <input type="password" placeholder="Password" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}" title="Password harus memiliki minimal 1 huruf kapital dan 1 huruf kecil, panjang minimal 4 karakter!">

                            <label for="password2">Konfirmasi Password</label>
                            <input type="password" placeholder="Konfirmasi Password" name="password2" id="password" required>

                            <button type="submit" name="register" class="btn">Buat Akun</button>
                            <br> <br>
                            <p>Sudah memiliki akun? <br> <br><a href="login.php" class="btn">Login Akun</a> </p>
                        </form>
                    </div>

                </div>
            </div>
            <!-- Akhir konten -->

            <!-- Bagian footer -->
            <?php include './footer.php'; ?>
            <!-- Akhir footer -->
        </div>
        <!-- Akhir kontainer -->
</body>

</html>