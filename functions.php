<?php

//Koneksi ke database local
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "projek_pbw";

//Koneksi ke database server
// $db_hostname = "localhost";
// $db_username = "222011345";
// $db_password = "PoemReal061";
// $db_database = "mhs_222011345";
$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

//Fungsi untuk mengambil data dari database
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//Fungsi untuk membuat akun baru
function create_account($data)
{
    global $conn;
    $name = htmlspecialchars($data["name"]);
    $username = htmlspecialchars($data["username"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirm_password = mysqli_real_escape_string($conn, $data["password2"]);

    //====Proses validasi lanjutan agar lebih kuat, sebenarnya di html juga sudah ada validasi

    //Regex check Untuk Name
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        echo "<script>
            alert('Nama hanya boleh huruf dan spasi!');
        </script>";
        return false;
    }

    //Cek username udah pernah dipake apa belum
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Username sudah terdaftar!');
        </script>";
        return false;
    }

    //Username panjang 4 sampai 24 karakter dan gunakan huruf sebagai karakter pertama
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9-_]{3,24}$/", $username)) {
        echo "<script>
            alert('Username harus memiliki panjang 4 sampai 24 karakter dan gunakan huruf sebagai karakter pertama!');
        </script>";
        return false;
    }

    //Password Minimal harus memuat satu huruf kapital dan non kapital, panjang minimal 4 karakter
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.{4,})/", $password)) {
        echo "<script>
            alert('Password harus memiliki minimal 1 huruf kapital dan 1 huruf kecil, panjang minimal 4 karakter!');
        </script>";
        return false;
    }

    //Cek konfirmasi password
    if ($password !== $konfirm_password) {
        echo "<script>
            alert('Konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }

    //Enkripsi password
    // $password = password_hash($password, PASSWORD_DEFAULT);
    // $password = password_hash($password, PASSWORD_BCRYPT);
    $password = md5($password);

    //Tambahkan user baru ke database
    $query = "INSERT INTO user VALUES ('', '$username', '$password', '$name', null, null, null)";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk registrasi klinik
function clinic_register($data)
{
    global $conn;
    $id_user = htmlspecialchars($data["id"]);
    $details = htmlspecialchars($data["details"]);
    $date = htmlspecialchars($data["date"]);

    //Schecule check not before today
    if ($date < date("Y-m-d")) {
        echo "<script>
            alert('Tanggal tidak boleh sebelum hari ini!');
        </script>";
        return false;
    }

    $query = "INSERT INTO clinic_registration VALUES ('', '$id_user', '$details', '$date')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk menghapus registrasi klinik
function delete_clinic_registration($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM clinic_registration WHERE id = $id");

    return mysqli_affected_rows($conn);
}
