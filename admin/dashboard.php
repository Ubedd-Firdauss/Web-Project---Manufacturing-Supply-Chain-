<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

$query_client = mysqli_query($conn, "SELECT id, nama FROM users WHERE role = 'client' ORDER BY nama ASC");

$success_message = '';
$error_message = '';

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
        $showModal = true;
    } else {
        // Jalankan query insert ke tabel orders
        $insert = mysqli_query(
            $conn, 
            "INSERT INTO orders (kode_order, client_id, produk, statusprogress, created_at) 
             VALUES ('$kode_order', $client_id, '$produk', '$statusprogress', '$created_at')"
        );

        if ($insert) {
            $success_message = "Order baru berhasil ditambahkan!";
            $showModal = true;
        } else {
            $error_message = "Gagal menambahkan order: " . mysqli_error($conn);
            $showModal = true;
        }
    }
}

$query = mysqli_query(
  $conn,
  "SELECT
        orders.*,
        users.nama
    FROM orders
    JOIN users
    ON orders.client_id = users.id
    ORDER BY orders.id DESC"
);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<div class="modal" id="deleteModal">

  <div class="modal-content">

    <h3>Delete Order</h3>

    <p>
      Apakah Anda yakin ingin menghapus data ini?
    </p>

    <div class="modal-buttons">

      <button class="btn-cancel" onclick="closeModal()">
        Cancel
      </button>

      <a id="confirmDelete" href="#" class="btn-confirm">
        Delete
      </a>

    </div>

  </div>

</div>

<script>
function showDeleteModal(id) {

  document
    .getElementById("deleteModal")
    .classList.add("show");

  document
    .getElementById("confirmDelete")
    .href = "hapus_order.php?id=" + id;
}

function closeModal() {

  document
    .getElementById("deleteModal")
    .classList.remove("show");
}
</script>

<script>
function openAddModal() {

  document
    .getElementById('addOrderModal')
    .classList.add('show');
}

function closeAddModal() {

  document
    .getElementById('addOrderModal')
    .classList.remove('show');
}
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
  let table = $('#orderTable').DataTable({

    responsive: true,

    autoWidth: false,

    scrollX: true,

    pageLength: 5,

    lengthMenu: [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "All"]
    ]

  });

  $('#statusFilter').on('change', function() {
    table
      .column(3)
      .search(this.value)
      .draw();
  });

  $('#clientFilter').on('change', function() {
    table
      .column(1)
      .search(this.value)
      .draw();
  });
});
</script>

<?php if(!empty($showModal)): ?>

<script>
document.addEventListener('DOMContentLoaded', function() {

  document
    .getElementById('addOrderModal')
    .classList.add('show');

});
</script>

<?php endif; ?>

<body>

  <?php include 'includes/sidebar.php'; ?>
  <!-- Hamburger Menu -->
  <div class="hamburger" onclick="toggleSidebar()">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <!-- Overlay (Klik untuk tutup sidebar) -->
  <div class="overlay" onclick="toggleSidebar()"></div>

  <script>
  function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.overlay').classList.toggle('active');
    document.querySelector('.hamburger').classList.toggle('active');
  }
  </script>

  <div class="content">

    <h1>Data Order</h1>

    <a href="#" class="btn-tambah" onclick="openAddModal()">
      Tambah Order
    </a>

    <div class="table-filters">

      <select id="statusFilter">

        <option value="">
          Semua Status
        </option>

        <option value="Pending">
          Pending
        </option>

        <option value="Welding">
          Welding
        </option>

        <option value="Assembly">
          Assembly
        </option>

        <option value="Coating">
          Coating
        </option>

        <option value="QC">
          QC Testing
        </option>

        <option value="Shipping">
          Shipping
        </option>

        <option value="Completed">
          Completed
        </option>

      </select>

      <select id="clientFilter">

        <option value="">
          Semua Client
        </option>

        <?php

        $clients = mysqli_query(
            $conn,
            "SELECT DISTINCT nama
             FROM users
             WHERE role='client'
             ORDER BY nama ASC"
        );

        while($c = mysqli_fetch_assoc($clients)):

        ?>

        <option value="<?= $c['nama']; ?>">
          <?= $c['nama']; ?>
        </option>

        <?php endwhile; ?>

      </select>

    </div>

    <div class="modal" id="addOrderModal">

      <div class="modal-content modal-form">
        <div class="modal-header">
          <span class="close-modal" onclick="closeAddModal()">

            &times;

          </span>

        </div>

        <h2>Tambah Order Baru</h2>

        <?php if(!empty($success_message)): ?>

        <div class="alert-success">
          <?= $success_message; ?>
        </div>

        <?php endif; ?>

        <?php if(!empty($error_message)): ?>

        <div class="alert-error">
          <?= $error_message; ?>
        </div>

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


    <div class="table-responsive">

      <table id="orderTable" class="display">

        <thead>

          <tr>

            <th>Kode</th>
            <th>Client</th>
            <th>Produk</th>
            <th>Status Manufaktur</th>
            <th>Progress Bar</th>
            <th>Aksi</th>

          </tr>

        </thead>

        <tbody>

          <?php while ($row = mysqli_fetch_assoc($query)): ?>

          <tr>

            <td><?= htmlspecialchars($row['kode_order']); ?></td>

            <td><?= htmlspecialchars($row['nama']); ?></td>

            <td><?= htmlspecialchars($row['produk']); ?></td>

            <td><?= htmlspecialchars($row['statusprogress']); ?></td>

            <?php

              $status_text = $row['statusprogress'];
              $persen = 0;

              if (strpos($status_text, 'Pending') !== false) {
                $persen = 15;
              } elseif (strpos($status_text, 'Welding') !== false) {
                $persen = 35;
              } elseif (strpos($status_text, 'Assembly') !== false) {
                $persen = 55;
              } elseif (strpos($status_text, 'Coating') !== false) {
                $persen = 75;
              } elseif (strpos($status_text, 'QC Testing') !== false) {
                $persen = 85;
              } elseif (strpos($status_text, 'Shipping') !== false) {
                $persen = 90;
              } elseif (strpos($status_text, 'Completed') !== false) {
                $persen = 100;
              }

              ?>

            <td>

              <div class="progress-wrapper">

                <div class="progress-fill" style="width:<?= $persen ?>%;"></div>

              </div>

              <span class="progress-text">
                <?= $persen ?>%
              </span>

            </td>

            <td>

              <a href="edit_order.php?id=<?= $row['id']; ?>" class="btn-edit">
                Edit
              </a>

              <a href="#" class="btn-delete" onclick="showDeleteModal(<?= $row['id']; ?>)">
                Delete
              </a>

            </td>

          </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

    </div>

</body>

</html>