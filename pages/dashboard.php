<?php
  session_start();
  include '../includes/functions.php';

  if (!is_logged_in()) {
      header("Location: login.php");
      exit;
  }

  include '../includes/header.php';
?>

<div class="text-center">
  <h2 class="mb-4">Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['hasta_ad'] ?? 'Kullanıcı'); ?></h2>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="list-group">
        <a href="randevu_al.php" class="list-group-item list-group-item-action">Randevu Al</a>
        <a href="randevularim.php" class="list-group-item list-group-item-action">Randevularım</a>
        <a href="doktor_sorgu.php" class="list-group-item list-group-item-action">Doktora Göre Sorgu</a>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger">Çıkış Yap</a>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
