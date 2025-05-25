<?php
include 'functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!is_logged_in()) {
    header("Location: ../pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Randevu Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/logo.png" type="image/png">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../assets/logo.png" alt="Logo" width="40" height="40" class="me-2">
      Randevu Sistemi
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../pages/dashboard.php"><i class="fa-solid fa-hospital"></i>  Ana Sayfa</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/randevu_al.php"><i class="fa-solid fa-notes-medical"></i>  Randevu Al</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/randevularim.php"><i class="fa-solid fa-stethoscope"></i>  Randevularım</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/doktor_sorgu.php"><i class="fa-solid fa-user-doctor"></i>  Doktor Sorgu</a></li>
      </ul>

      <span class="navbar-text text-light me-3">
        <?php
        echo "" . ($_SESSION['hasta_ad'] ?? 'Bilinmeyen') . " (ID: " . ($_SESSION['hasta_id'] ?? '-') . ")";
        ?>
      </span>

      <a href="../pages/logout.php" class="btn btn-outline-light"><i class="fa-solid fa-right-from-bracket"></i>  Çıkış</a>
    </div>
  </div>
</nav>


<div class="container mt-4">
