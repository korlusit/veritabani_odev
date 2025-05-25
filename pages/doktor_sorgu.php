<?php
  include '../includes/functions.php';
  include '../includes/db.php';
  include '../includes/header.php';

  if (!is_logged_in()) header("Location: login.php");
?>

<h3>Doktorun Randevu Takvimi</h3>

<form method="get" class="mb-4">
  <div class="mb-3">
    <label for="doktor_id" class="form-label">Doktor Seçin</label>
      <select name="doktor_id" class="form-select" required>
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
  <button type="submit" class="btn btn-primary">Sorgula</button>
</form>

<?php
  if (isset($_GET['doktor_id']) && is_numeric($_GET['doktor_id'])) {
      $doktor_id = intval($_GET['doktor_id']);

      $saatler = [];
      for ($hour = 9; $hour <= 16; $hour++) {
          $saatler[] = sprintf("%02d:00", $hour);
      }

      echo "<h4 class='text-secondary mt-5'>Doktorun Randevu Takvimi</h4>";

      for ($gun = 0; $gun <= 10; $gun++) {
          $tarih = date('Y-m-d', strtotime("+$gun day"));

          echo "<div class='mt-4'>";
          echo "<h5 class='text-primary'>" . date('d.m.Y', strtotime($tarih)) . "</h5>";
          echo "<div class='d-flex flex-wrap gap-2'>";

          foreach ($saatler as $saat) {
              $stmt = $conn->prepare("SELECT id FROM randevular WHERE doktor_id = ? AND tarih = ? AND saat = ?");
              $stmt->bind_param("iss", $doktor_id, $tarih, $saat);
              $stmt->execute();
              $stmt->store_result();

              if ($stmt->num_rows > 0) {
                  echo "<button class='btn btn-danger disabled'>$saat</button>";
              } else {
                  echo "<button class='btn btn-success disabled'>$saat</button>";
              }

              $stmt->close();
          }

          echo "</div></div>";
      }
  }

  include '../includes/footer.php';
?>
