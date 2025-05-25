<?php
include '../includes/functions.php';
include '../includes/db.php';
include '../includes/header.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['hasta_id'];
$id = (int)$id;

$sql = "
    SELECT r.tarih, r.saat, d.ad AS doktor_ad 
    FROM randevular r 
    JOIN doktorlar d ON r.doktor_id = d.id 
    WHERE r.hasta_id = $id 
    ORDER BY r.tarih DESC, r.saat DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Hatası: " . $conn->error);
}
?>

<div class="container mt-4">
    <h3 class="mb-4">Randevularım</h3>

    <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Tarih</th>
                <th>Saat</th>
                <th>Doktor</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tarih']); ?></td>
                    <td><?php echo htmlspecialchars($row['saat']); ?></td>
                    <td>Dr. <?php echo htmlspecialchars($row['doktor_ad']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-info">Henüz randevunuz yok.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
