<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

$id = $_GET['id'];

if (delete_doctor($id) > 0) {
    echo "
    <script>
        alert('Dokter berhasil dihapus!');
        document.location.href = 'doctor.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Dokter gagal dihapus!');
        document.location.href = 'doctor.php';
    </script>
    ";
}
