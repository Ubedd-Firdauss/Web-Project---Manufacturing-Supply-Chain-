<?php
require __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

// Cek apakah parameter ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);

// 1. AMBIL DATA ORDER YANG INGIN DI-EDIT
$query_order = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
$order = mysqli_fetch_assoc($query_order);

// Jika data tidak ditemukan di database, tendang kembali ke dashboard
if (!$order) {
    header("Location: dashboard.php");
    exit;
}

// 2. AMBIL DATA CLIENT UNTUK PILIHAN DI DROP-DOWN
$query_client = mysqli_query($conn, "SELECT id, nama FROM users WHERE role = 'client' ORDER BY nama ASC");

$success_message = null;
$error_message = null;

// 3. PROSES KETIKA FORM DI-SUBMIT (TOMBOL UPDATE DIKLIK)
if (isset($_POST['update'])) {
    /** @var mysqli $conn */
    
    $kode_order     = mysqli_real_escape_string($conn, $_POST['kode_order']);
    $client_id      = intval($_POST['client_id']);
    $produk         = mysqli_real_escape_string($conn, $_POST['produk']);
    $statusprogress = mysqli_real_escape_string($conn, $_POST['statusprogress']);

    // Cek apakah kode order diubah dan bentrok dengan kode order lain yang sudah ada
    $cek_kode = mysqli_query($conn, "SELECT id FROM orders WHERE kode_order = '$kode_order' AND id != $id");
    
    if (mysqli_num_rows($cek_kode) > 0) {
        $error_message = "Gagal! Kode Order tersebut sudah digunakan oleh pesanan lain.";
    } else {
        // Jalankan query update
        $update = mysqli_query(
            $conn, 
            "UPDATE orders SET 
                kode_order = '$kode_order', 
                client_id = $client_id, 
                produk = '$produk', 
                statusprogress = '$statusprogress' 
             WHERE id = $id"
        );

        if ($update) {
            $success_message = "Data order berhasil diperbarui!";
            // Refresh data terbaru agar langsung tampil di form
            $query_order = mysqli_query($conn, "SELECT * FROM orders WHERE id = $id");
            $order = mysqli_fetch_assoc($query_order);
        } else {
            $error_message = "Gagal memperbarui order: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Order - Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

  <?php include 'includes/sidebar.php'; ?>

  <div class="content">
    <h1>Edit Data Order</h1>
    <a href="dashboard.php" class="btn-kembali">← Kembali ke Dashboard</a>

    <div class="form-container">
      <?php if ($success_message): ?>
      <p style="color: green; font-weight: bold;"><?= $success_message; ?></p>
      <?php endif; ?>
      <?php if ($error_message): ?>
      <p style="color: red; font-weight: bold;"><?= $error_message; ?></p>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="kode_order">Kode Order</label>
          <input type="text" id="kode_order" name="kode_order" value="<?= htmlspecialchars($order['kode_order']); ?>"
            required>
        </div>

        <div class="form-group">
          <label for="client_id">Perusahaan Client</label>
          <select id="client_id" name="client_id" required>
            <?php while($client = mysqli_fetch_assoc($query_client)): ?>
            <option value="<?= $client['id']; ?>" <?= ($client['id'] == $order['client_id']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($client['nama']); ?>
            </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="produk">Produk (Alat Berat)</label>
          <select id="produk" name="produk" required>
            <option value="Mining Excavator 100-Ton"
              <?= ($order['produk'] == 'Mining Excavator 100-Ton') ? 'selected' : ''; ?>>Mining Excavator 100-Ton
            </option>
            <option value="Heavy Duty Dump Truck 150T"
              <?= ($order['produk'] == 'Heavy Duty Dump Truck 150T') ? 'selected' : ''; ?>>Heavy Duty Dump Truck 150T
            </option>
            <option value="Crawler Bulldozer D375"
              <?= ($order['produk'] == 'Crawler Bulldozer D375') ? 'selected' : ''; ?>>Crawler Bulldozer D375</option>
            <option value="Mobile Crushing Plant v2"
              <?= ($order['produk'] == 'Mobile Crushing Plant v2') ? 'selected' : ''; ?>>Mobile Crushing Plant v2
            </option>
            <option value="Motor Grader GD825" <?= ($order['produk'] == 'Motor Grader GD825') ? 'selected' : ''; ?>>
              Motor Grader GD825</option>
            <option value="Wheel Loader WA600" <?= ($order['produk'] == 'Wheel Loader WA600') ? 'selected' : ''; ?>>
              Wheel Loader WA600</option>
          </select>
        </div>

        <div class="form-group">
          <label for="statusprogress">Status & Progres Kerja</label>
          <select id="statusprogress" name="statusprogress" required>
            <option value="Pending (Procurement)"
              <?= ($order['statusprogress'] == 'Pending (Procurement)') ? 'selected' : ''; ?>>1. Pending (Procurement) -
              15%</option>
            <option value="In Production (Welding)"
              <?= ($order['statusprogress'] == 'In Production (Welding)') ? 'selected' : ''; ?>>2. In Production
              (Welding) - 35%</option>
            <option value="In Production (Assembly)"
              <?= ($order['statusprogress'] == 'In Production (Assembly)') ? 'selected' : ''; ?>>3. In Production
              (Assembly) - 55%</option>
            <option value="In Production (Coating)"
              <?= ($order['statusprogress'] == 'In Production (Coating)') ? 'selected' : ''; ?>>4. In Production
              (Coating) - 75%</option>
            <option value="In Production (QC Testing)"
              <?= ($order['statusprogress'] == 'In Production (QC Testing)') ? 'selected' : ''; ?>>5. In Production (QC
              Testing) - 85%</option>
            <option value="In Transit (Shipping)"
              <?= ($order['statusprogress'] == 'In Transit (Shipping)') ? 'selected' : ''; ?>>6. In Transit (Shipping) -
              90%</option>
            <option value="Completed (Delivered)"
              <?= ($order['statusprogress'] == 'Completed (Delivered)') ? 'selected' : ''; ?>>7. Completed (Delivered) -
              100%</option>
          </select>
        </div>

        <button type="submit" name="update" class="btn-submit">Perbarui Order</button>
      </form>
    </div>
  </div>

</body>

</html>