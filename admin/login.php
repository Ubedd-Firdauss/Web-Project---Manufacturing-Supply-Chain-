<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($conn)) {
    die('Database connection not established.');
}

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'"
    );

    if(mysqli_num_rows($query) > 0){
        $admin = mysqli_fetch_assoc($query);
        $_SESSION['login'] = true;
        $_SESSION['admin_login'] = true;
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nama'] = $admin['nama'];

        header("Location: dashboard.php");
        exit;
    }

    $error = "Login Gagal! Username atau password salah.";
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="login-body">

  <div class="login-container">
    <div class="login-box">
      <div class="login-header">
        <h2>Admin Login</h2>
        <p>Masukkan username dan password</p>
      </div>

      <?php if(isset($error)): ?>
      <div class="login-error">
        <?= $error; ?>
      </div>
      <?php endif; ?>

      <form method="POST" class="login-form">
        <div class="form-group">
          <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="form-group">
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="btn-login">
          Login
        </button>
      </form>

      <div class="login-footer">
        <a href="../index.php">← Kembali ke Beranda</a>
      </div>
    </div>
  </div>

</body>

</html>