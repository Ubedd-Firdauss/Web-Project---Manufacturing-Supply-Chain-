<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

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

function showDeleteModal(id){

  document
    .getElementById("deleteModal")
    .classList.add("show");

  document
    .getElementById("confirmDelete")
    .href = "hapus_order.php?id=" + id;
}

function closeModal(){

  document
    .getElementById("deleteModal")
    .classList.remove("show");
}

</script>

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

    <a href="tambah_order.php" class="btn-tambah">
      Tambah Order
    </a>

    <div class="table-responsive">

      <table border="1">

        <tr>
          <th>Kode</th>
          <th>Client</th>
          <th>Produk</th>
          <th>Status Manufaktur</th>
          <th>Progress Bar</th>
          <th>Aksi</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($query)): 

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
      } elseif (strpos($status_text, 'In Transit') !== false) {
          $persen = 90;
      } elseif (strpos($status_text, 'Completed') !== false) {
          $persen = 100;
      }
    ?>

        <tr>

          <td><?= htmlspecialchars($row['kode_order']); ?></td>

          <td><?= htmlspecialchars($row['nama']); ?></td>

          <td><?= htmlspecialchars($row['produk']); ?></td>

          <td><?= htmlspecialchars($row['statusprogress']); ?></td>

          <td><?= $persen; ?>%</td>

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

      </table>

    </div>

</body>

</html>