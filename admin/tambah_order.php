<?php
require 'includes/auth.php';
require __DIR__ . '/../config/db.php';

// 1. AMBIL DATA CLIENT UNTUK PILIHAN DI DROP-DOWN OPTION
$query_client = mysqli_query($conn, "SELECT id, nama FROM users WHERE role = 'client' ORDER BY nama ASC");

$success_message = null;
$error_message = null;

// 2. PROSES KETIKA FORM DI-SUBMIT
if (isset($_POST['tambah'])) {
    /** @var mysqli $conn */
    
    // Amankan data inputan form
    $kode_order     = mysqli_real_escape_string($conn, $_POST['kode_order']);
    $client_id      = intval($_POST['client_id']); // Pastikan diconvert ke integer
    $produk         = mysqli_real_escape_string($conn, $_POST['produk']);
    $statusprogress = mysqli_real_escape_string($conn, $_POST['statusprogress']);
    $created_at     = date('Y-m-d H:i:s'); // Mengambil waktu saat ini secara otomatis

    // Cek apakah kode order sudah pernah ada (karena kode order harus unik)
    $cek_kode = mysqli_query($conn, "SELECT kode_order FROM orders WHERE kode_order = '$kode_order'");
    
    if (mysqli_num_rows($cek_kode) > 0) {
        $error_message = "Gagal! Kode Order sudah terpakai, gunakan kode lain.";
    } else {
        // Jalankan query insert ke tabel orders
        $insert = mysqli_query(
            $conn, 
            "INSERT INTO orders (kode_order, client_id, produk, statusprogress, created_at) 
             VALUES ('$kode_order', $client_id, '$produk', '$statusprogress', '$created_at')"
        );

        if ($insert) {
            $success_message = "Order baru berhasil ditambahkan!";
        } else {
            $error_message = "Gagal menambahkan order: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Order - Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

  <?php include 'includes/sidebar.php'; ?>

  <div class="content">
    <h1>Tambah Order Baru</h1>

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
          <input type="text" id="kode_order" name="kode_order" placeholder="Contoh: ORD-HE-2026-031" required>
        </div>

        <div class="form-group">
          <label for="client_id">Perusahaan Client</label>
          <select id="client_id" name="client_id" required>
            <option value="">-- Pilih Client Tambang --</option>
            <?php while($client = mysqli_fetch_assoc($query_client)): ?>
            <option value="<?= $client['id']; ?>"><?= htmlspecialchars($client['nama']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="produk">Produk (Alat Berat)</label>
          <select id="produk" name="produk" required>
            <option value="">-- Pilih Unit Manufaktur --</option>
            <option value="Mining Excavator 100-Ton">Mining Excavator 100-Ton</option>
            <option value="Heavy Duty Dump Truck 150T">Heavy Duty Dump Truck 150T</option>
            <option value="Crawler Bulldozer D375">Crawler Bulldozer D375</option>
            <option value="Mobile Crushing Plant v2">Mobile Crushing Plant v2</option>
            <option value="Motor Grader GD825">Motor Grader GD825</option>
            <option value="Wheel Loader WA600">Wheel Loader WA600</option>
          </select>
        </div>

        <div class="form-group">
          <label for="statusprogress">Status & Progres Kerja</label>
          <select id="statusprogress" name="statusprogress" required>
            <option value="Pending (Procurement)">1. Pending (Procurement) - 15%</option>
            <option value="In Production (Welding)">2. In Production (Welding) - 35%</option>
            <option value="In Production (Assembly)">3. In Production (Assembly) - 55%</option>
            <option value="In Production (Coating)">4. In Production (Coating) - 75%</option>
            <option value="In Production (QC Testing)">5. In Production (QC Testing) - 85%</option>
            <option value="In Transit (Shipping)">6. In Transit (Shipping) - 90%</option>
            <option value="Completed (Delivered)">7. Completed (Delivered) - 100%</option>
          </select>
        </div>

        <button type="submit" name="tambah" class="btn-submit">Simpan Order</button>
      </form>
    </div>
  </div>

</body>

</html>