<?php
require __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

// Cek apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    /** @var mysqli $conn */
    // Jalankan perintah hapus berdasarkan ID data order
    $delete = mysqli_query($conn, "DELETE FROM orders WHERE id = $id");

    if ($delete) {
        // Jika berhasil dihapus, langsung kembali ke halaman dashboard utama
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    // Jika diakses tanpa menyertakan ID, balikkan ke dashboard
    header("Location: dashboard.php");
    exit;
}
?>