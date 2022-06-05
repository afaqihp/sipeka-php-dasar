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
