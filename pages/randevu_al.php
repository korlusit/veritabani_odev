<?php
  include '../includes/db.php';
  include '../includes/functions.php';
  include '../includes/header.php';

  if (!is_logged_in()) {
      header("Location: login.php");
      exit;
  }

  $hata = "";
  $mesaj = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doktor_id'], $_POST['tarih'], $_POST['saat'])) {
      $doktor_id = $_POST['doktor_id'];
      $tarih = $_POST['tarih'];
      $saat = $_POST['saat'];
      $hasta_id = $_SESSION['hasta_id'];

      $kontrol = $conn->prepare("SELECT * FROM randevular WHERE doktor_id = ? AND tarih = ? AND saat = ?");
      $kontrol->bind_param("iss", $doktor_id, $tarih, $saat);
      $kontrol->execute();
      $sonuc = $kontrol->get_result();

      if ($sonuc->num_rows > 0) {
          $hata = "Bu saatte seçilen doktora ait başka bir randevu var!";
      } else {
          $ekle = $conn->prepare("INSERT INTO randevular (hasta_id, doktor_id, tarih, saat) VALUES (?, ?, ?, ?)");
          $ekle->bind_param("iiss", $hasta_id, $doktor_id, $tarih, $saat);
          $ekle->execute();
          $mesaj = "Randevunuz başarıyla oluşturuldu.";
      }
  }
?>

<div class="container mt-5">
  <h3 class="mb-4">Randevu Al</h3>

  <?php if ($hata): ?>
    <div class="alert alert-danger"><?php echo $hata; ?></div>
  <?php endif; ?>

  <?php if ($mesaj): ?>
    <div class="alert alert-success"><?php echo $mesaj; ?></div>
  <?php endif; ?>

  <form method="get" class="mb-4">
    <div class="mb-3">
      <label for="doktor_id" class="form-label">Doktor Seçin</label>
      <select name="doktor_id" id="doktor_id" class="form-select" required onchange="this.form.submit()">
        <option value="">Doktor seçiniz...</option>
          <?php
          $doktorlar = $conn->query("SELECT * FROM doktorlar");
          while ($d = $doktorlar->fetch_assoc()) {
              $selected = (isset($_GET['doktor_id']) && $_GET['doktor_id'] == $d['id']) ? "selected" : "";
              echo "<option value='{$d['id']}' $selected>{$d['ad']}</option>";
          }
        ?>
      </select>
    </div>
  </form>

  <?php if (isset($_GET['doktor_id'])): ?>
    <form method="post" class="mb-4">
      <input type="hidden" name="doktor_id" value="<?php echo htmlspecialchars($_GET['doktor_id']); ?>">

      <div class="mb-3">
        <label for="tarih" class="form-label">Tarih</label>
        <input type="date" name="tarih" id="tarih" class="form-control" required 
          min="<?php echo date('Y-m-d'); ?>" 
          max="<?php echo date('Y-m-d', strtotime('+10 days')); ?>">
      </div>

      <div class="mb-3">
        <label for="saat" class="form-label">Saat Seçin</label>
        <select name="saat" id="saat" class="form-select" required>
          <?php
          $saatler = range(9, 16);
          foreach ($saatler as $s) {
              $ss = $s . ":00";
              echo "<option value='$ss'>$ss</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Randevu Al</button>
    </form>

    <?php
        $doktor_id = intval($_GET['doktor_id']);
        echo "<h5 class='mt-4'>Doktorun Randevu Takvimi</h5>";

        $saatler = [];
        for ($hour = 9; $hour <= 16; $hour++) {
            $saatler[] = sprintf("%02d:00", $hour);
        }

        for ($i = 0; $i < 10; $i++) {
            $tarih = date('Y-m-d', strtotime("+$i day"));
            echo "<div class='mt-3'>";
            echo "<h6>" . date('d.m.Y', strtotime($tarih)) . "</h6>";
            echo "<div class='d-flex flex-wrap gap-2'>";

            foreach ($saatler as $saat) {
                $stmt = $conn->prepare("SELECT id FROM randevular WHERE doktor_id = ? AND tarih = ? AND saat = ?");
                $stmt->bind_param("iss", $doktor_id, $tarih, $saat);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    echo "<button type='button' class='btn btn-danger disabled'>$saat</button>";
                } else {
                    echo "<button type='button' class='btn btn-success randevu-btn' data-tarih='$tarih' data-saat='$saat'>$saat</button>";
                }

                $stmt->close();
            }

            echo "</div></div>";
        }
    ?>
  <?php endif; ?>
</div>

<script>
document.querySelectorAll('.randevu-btn').forEach(button => {
  button.addEventListener('click', () => {
    const tarih = button.getAttribute('data-tarih');
    const saat = button.getAttribute('data-saat');

    document.getElementById('tarih').value = tarih;
    document.getElementById('saat').value = saat;

    document.querySelectorAll('.randevu-btn').forEach(btn => btn.classList.remove('btn-warning'));
    button.classList.add('btn-warning');
  });
});
</script>

<?php include '../includes/footer.php'; ?>
