<?php
    session_start();

    include '../includes/db.php';
    include '../includes/functions.php';

    if (is_logged_in()) {
        header("Location: dashboard.php");
        exit;
    }

    $hata = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $sifre = $_POST['sifre'];

        $stmt = $conn->prepare("SELECT * FROM hastalar WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $sonuc = $stmt->get_result();

        if ($sonuc->num_rows === 1) {
            $hasta = $sonuc->fetch_assoc();

            if (password_verify($sifre, $hasta['sifre'])) {
                $_SESSION['hasta_id'] = $hasta['id'];
                $_SESSION['hasta_ad'] = $hasta['ad'];
                header("Location: dashboard.php");
                exit;
            } else {
                $hata = "E-posta veya şifre hatalı!";
            }
        } else {
            $hata = "E-posta veya şifre hatalı!";
        }
    }
?>


<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Giriş Yap</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body class="bg-light">

        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="card shadow p-4" style="min-width: 360px; max-width: 420px; width: 100%;">
                
                <div class="text-center mb-4">
                    <img src="../assets/logo.png" alt="Logo" style="width: 80px; height: 80px; object-fit: contain;" />
                </div>

                <h2 class="text-center mb-4">Giriş Yap</h2>

                <?php if ($hata): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($hata); ?></div>
                <?php endif; ?>

                <form method="post" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                required
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            />
                    </div>

                    <div class="mb-3">
                        <label for="sifre" class="form-label">Şifre</label>
                        <input type="password" id="sifre" name="sifre" class="form-control" required />
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                </form>

                <hr />
                <div class="text-center">
                    <a href="register.php" class="btn btn-outline-secondary w-100">Hesabın yok mu? Kayıt Ol</a>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
