<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

$id = $_GET['id'];

if (delete_clinic_registration($id) > 0) {
    echo "
    <script>
        alert('Registrasi klinik berhasil dihapus!');
        document.location.href = 'klinik.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Registrasi klinik gagal dihapus!');
        document.location.href = 'klinik.php';
    </script>
    ";
}
