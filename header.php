<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
?>

<!-- Bagian header -->
<div id="my-header" class="header">
  <div class="nav">
    <span style="font-size: 30px; cursor: pointer" onclick="openNav()">&#9776;</span>

    <div class="header-title">
      <h1>SIPEKA STIS</h1>
    </div>
    <div class="user">
      <a href="logout.php" class="btn">Logout</a>
    </div>
  </div>
</div>
<!-- Akhir header -->