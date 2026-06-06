<?php
session_start();
require 'config/db.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT *
        FROM users
        WHERE username='$username'
        AND password='$password'
        AND role='client'"
    );

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        header("Location: tracking.php");
        exit;
    }

    $error = "Username atau Password Salah!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - PT Terradrill</title>

  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar">
    <?php include 'includes/header.php'; ?>
  </nav>
  <section class="login-section">

    <div class="login-container">

      <h2 class="login-title">
        Client Login
      </h2>

      <?php if(isset($error)): ?>
      <p class="error-msg"><?= $error; ?></p>
      <?php endif; ?>

      <form method="POST" class="login-form">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login" class="login-btn">

          Login

        </button>

      </form>

      <div class="login-link">
        Belum punya akun?
        <a href="register.php">Register</a>
      </div>

    </div>

  </section>

</body>

</html>