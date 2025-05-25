<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (is_logged_in()) {
    header("Location: dashboard.php");
    exit;
}

$hata = "";
$basari = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = trim($_POST['ad']);
    $email = trim($_POST['email']);
    $sifre = trim($_POST['sifre']);

    if (empty($ad) || empty($email) || empty($sifre)) {
        $hata = "Lütfen tüm alanları doldurun.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hata = "Geçerli bir e-posta adresi girin.";
    } else {       
        $kontrol = $conn->prepare("SELECT id FROM hastalar WHERE email = ?");
        $kontrol->bind_param("s", $email);
        $kontrol->execute();
        $result = $kontrol->get_result();

        if ($result->num_rows > 0) {
            $hata = "Bu e-posta adresi zaten kayıtlı.";
        } else {
            $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);
            $ekle = $conn->prepare("INSERT INTO hastalar (ad, email, sifre) VALUES (?, ?, ?)");
            $ekle->bind_param("sss", $ad, $email, $hashed_password);

            if ($ekle->execute()) {
                header("Location: login.php?kayit=ok");
                exit;
            } else {
                $hata = "Kayıt sırasında bir hata oluştu.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="min-width: 360px; max-width: 420px; width: 100%;">
        
        <div class="text-center mb-4">
            <img src="../assets/logo.png" alt="Logo" style="width: 80px; height: 80px; object-fit: contain;" />
        </div>

        <h2 class="text-center mb-4">Kayıt Ol</h2>

        <?php if ($hata): ?>
            <div class="alert alert-danger"><?php echo $hata; ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <div class="mb-3">
                <label for="ad" class="form-label">Ad Soyad</label>
                <input type="text" id="ad" name="ad" class="form-control" required value="<?php echo htmlspecialchars($_POST['ad'] ?? ''); ?>" />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
            </div>

            <div class="mb-3">
                <label for="sifre" class="form-label">Şifre</label>
                <input type="password" id="sifre" name="sifre" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-success w-100">Kayıt Ol</button>
        </form>

        <hr />
        <div class="text-center">
            <a href="login.php" class="btn btn-outline-primary w-100">Zaten hesabın var mı? Giriş Yap</a>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
