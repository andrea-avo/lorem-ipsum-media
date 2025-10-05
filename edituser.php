<?php
include "db.php";

if (!isset($_GET['id'])) {
    die("User tidak ditemukan.");
}
$id = intval($_GET['id']);

$sql = "SELECT * FROM user WHERE iduser = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    die("User tidak ada di database.");
}
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];

    if (!empty($password_input)) {
        $password = password_hash($password_input, PASSWORD_DEFAULT);
        $update = "UPDATE user SET email='$email', password='$password' WHERE iduser=$id";
    } else {
        $update = "UPDATE user SET email='$email' WHERE iduser=$id";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('User berhasil diperbarui!');window.location='dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update user: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-base-200 text-base-content">
  <nav class="navbar bg-base-100 shadow-md sticky top-0 z-50">
    <div class="flex-1 ml-10">
      <a href="dashboard.php" class="font-bold text-2xl text-violet-500">Dashboard</a>
    </div>
    <div class="flex-none mr-10">
      <a href="login.php" class="btn btn-sm btn-primary">Logout</a>
    </div>
  </nav>

  <main class="container mx-auto px-6 lg:px-12 py-20">
    <section class="card bg-base-100 shadow-lg border border-violet-100 rounded-xl p-8">
      <h2 class="text-2xl font-bold text-violet-500 mb-6">Edit User</h2>

      <form method="POST" class="space-y-6">
        <div>
          <label class="label">Email</label>
          <input
            type="email"
            name="email"
            class="input input-bordered w-full"
            value="<?= htmlspecialchars($user['email']) ?>"
            required
          />
        </div>

        <div>
          <label class="label">Password</label>
          <input
            type="password"
            name="password"
            class="input input-bordered w-full"
            placeholder="Isi jika ingin mengganti password"
          />
        </div>

        <div class="flex justify-end gap-3">
          <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer footer-center bg-primary p-12 shadow-lg text-white mt-20">
    <p class="font-bold text-lg">© 2025 Admin Dashboard</p>
    <p class="text-sm opacity-80">All rights reserved</p>
  </footer>
</body>
</html>