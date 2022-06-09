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
    $age = null;
    $height = null;
    $weight = null;
    $id = "";
    //Default role sebagai user biasa
    $role_id = 2;

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

    //Pakai prepared statement untuk menghindari sql injection
    $stmt = mysqli_prepare($conn, "INSERT INTO user VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isssiddi", $id, $username, $password, $name, $age, $height, $weight, $role_id);
    mysqli_stmt_execute($stmt);

    // // Tanpa prepared statement
    // $query = "INSERT INTO user VALUES ('', '$username', '$password', '$name', null, null, null)";
    // mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk registrasi klinik
function clinic_register($data)
{
    global $conn;
    $id_user = htmlspecialchars($data["id"]);
    $clinic_id = htmlspecialchars($data["clinic_id"]);
    $details = htmlspecialchars($data["details"]);
    $date = htmlspecialchars($data["date"]);

    //Schecule check not before today
    if ($date < date("Y-m-d")) {
        echo "<script>
            alert('Tanggal tidak boleh sebelum hari ini!');
        </script>";
        return false;
    }

    //Pakai prepared statement untuk menghindari sql injection
    $stmt = mysqli_prepare($conn, "INSERT INTO clinic_registration (clinic_id, user_id, details, schedule) VALUES(?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "siss", $clinic_id, $id_user, $details, $date);
    mysqli_stmt_execute($stmt);

    // //Tanpa prepared statement
    // $query = "INSERT INTO clinic_registration VALUES ('','$clinic_id ', '$id_user', '$details', '$date')";
    // mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk menghapus registrasi klinik
function delete_clinic_registration($id)
{
    global $conn;

    //Pakai prepared statement untuk menghindari sql injection
    $stmt = mysqli_prepare($conn, "DELETE FROM clinic_registration WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // mysqli_query($conn, "DELETE FROM clinic_registration WHERE id = $id");

    return mysqli_affected_rows($conn);
}

//Fungsi untuk menambahkan dokter
function add_new_doctor($data)
{
    global $conn;
    $name = htmlspecialchars($data["name"]);
    $age = htmlspecialchars($data["age"]);
    $specialty = htmlspecialchars($data["specialty"]);
    $contact = htmlspecialchars($data["contact"]);
    $clinic_id = htmlspecialchars($data["clinic_id"]);
    $id = "";

    //Regex check Untuk Umur
    if (!preg_match("/^[0-9]*$/", $age)) {
        echo "<script>
            alert('Umur hanya boleh angka!');
        </script>";
        return false;
    }

    //Regex nomor hp diawali dengan 08
    if (!preg_match("/^08[0-9]*$/", $contact)) {
        echo "<script>
            alert('Nomor HP harus diawali dengan 08!');
        </script>";
        return false;
    }

    //Regex check Untuk Spesialis
    if (!preg_match("/^[a-zA-Z ]*$/", $specialty)) {
        echo "<script>
            alert('Spesialis hanya boleh huruf dan spasi!');
        </script>";
        return false;
    }

    //Pakai prepared statement untuk menghindari sql injection
    $stmt = mysqli_prepare($conn, "INSERT INTO doctor VALUES(?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isissi", $id, $name, $age, $specialty, $contact, $clinic_id);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk menghapus dokter
function delete_doctor($id)
{
    global $conn;

    //Pakai prepared statement untuk menghindari sql injection  
    $stmt = mysqli_prepare($conn, "DELETE FROM doctor WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn);
}

//Fungsi untuk mengedit dokter
function edit_doctor($data)
{
    global $conn;
    $id = htmlspecialchars($data["id"]);
    $name = htmlspecialchars($data["name"]);
    $age = htmlspecialchars($data["age"]);
    $specialty = htmlspecialchars($data["specialty"]);
    $contact = htmlspecialchars($data["contact"]);
    $clinic_id = htmlspecialchars($data["clinic_id"]);

    //Regex check Untuk Umur
    if (!preg_match("/^[0-9]*$/", $age)) {
        echo "<script>
            alert('Umur hanya boleh angka!');
        </script>";
        return false;
    }

    //Regex check Untuk No. HP
    if (!preg_match("/^[0-9]*$/", $contact)) {
        echo "<script>
            alert('No. HP hanya boleh angka!');
        </script>";
        return false;
    }

    //Regex check Untuk Spesialis
    if (!preg_match("/^[a-zA-Z ]*$/", $specialty)) {
        echo "<script>
            alert('Spesialis hanya boleh huruf dan spasi!');
        </script>";
        return false;
    }

    //Pakai prepared statement untuk menghindari sql injection
    $stmt = mysqli_prepare($conn, "UPDATE doctor SET name = ?, age = ?, specialty = ?, contact = ?, clinic_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sisssi", $name, $age, $specialty, $contact, $clinic_id, $id);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn);
}
