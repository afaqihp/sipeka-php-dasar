<?php
session_start();
require './functions.php';

//Cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //Ambil username dan role berdasarkan id
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //Cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role_id'];
    }
}

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}



if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //Pakai prepared statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    //Cek username
    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        //Cek password apakah sama dengan hash nya
        // if (password_verify($password, $row["password"])) {
        if (md5($password) === $row["password"]) {
            //Set session
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];
            $_SESSION['role'] = $row['role_id'];

            // Cek remember me
            if (isset($_POST['remember'])) {
                setcookie('id', $row['id'], time() + 60 * 5);
                setcookie('key', hash('sha256', $row['username']), time() + 60 * 5);
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true;
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
    <title>Login | SIPEKA STIS</title>
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
                        <h2>Login Page</h2>
                    </div>

                    <div class="form">
                        <form action="" method="POST">
                            <h3>SIPEKA STIS</h3>
                            <br>

                            <div id="error-message"></div>

                            <?php
                            if (isset($error)) : ?>
                                <p style="color: red; font-weight:bold;">Username atau Password salah</p>
                            <?php endif; ?>
                            <label for="username">Username</label>
                            <input type="text" placeholder="Username" id="username" name="username" required>

                            <label for="password">Password</label>
                            <input type="password" placeholder="Password" id="password" name="password" required>
                            <br>
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" id="check-label">Remember Me</label>

                            <button type="submit" name="login" class="btn">Login</button>
                            <br> <br>
                            <p>Belum memiliki akun? <br> <br><a href="register.php" class="btn">Buat Akun</a> </p>
                        </form>
                    </div>
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