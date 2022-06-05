<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require './functions.php';

//Insert registrasi klinik
if (isset($_POST['register'])) {
    if (clinic_register($_POST) > 0) {
        echo "<script>
        alert('Registrasi klinik berhasil');
        document.location.href = 'klinik.php?#clinic-history';
        </script>";
    } else {
        echo "<script>
        alert('Registrasi klinik gagal');
        document.location.href = 'klinik.php';
        </script>";
    }
}
