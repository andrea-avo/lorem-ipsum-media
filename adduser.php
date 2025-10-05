<?php 
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];
    $pass2 = $_POST['password_confirm'];

    if ($pass !== $pass2) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } elseif (strlen($pass) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        $password_hashed = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (email, password) VALUES ('$email', '$password_hashed')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('User berhasil ditambahkan!');window.location='dashboard.php';</script>";
            exit;
        } else {
            $error = "Gagal menambahkan user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add User</title>
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
        <h2 class="text-2xl font-bold text-violet-500 mb-6">Add New User</h2>

        <?php if (!empty($error)): ?>
          <div class="alert alert-error mb-4">
            <span><?php echo htmlspecialchars($error); ?></span>
          </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6" autocomplete="off">
          <div>
            <label class="label">Email</label>
            <input
              type="email"
              name="email"
              class="input input-bordered w-full"
              placeholder="user@example.com"
              required
              value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
            />
          </div>

          <div>
            <label class="label">Password</label>
            <div class="relative">
              <input
                type="password"
                name="password"
                id="password"
                class="input input-bordered w-full pr-12"
                placeholder="Enter password"
                required
              />
              <button type="button"
                onclick="togglePassword('password')"
                class="btn btn-ghost btn-sm absolute right-1 top-1/2 -translate-y-1/2">
                👁️
              </button>
            </div>
          </div>

          <div>
            <label class="label">Confirm Password</label>
            <div class="relative">
              <input
                type="password"
                name="password_confirm"
                id="password_confirm"
                class="input input-bordered w-full pr-12"
                placeholder="Confirm password"
                required
              />
              <button type="button"
                onclick="togglePassword('password_confirm')"
                class="btn btn-ghost btn-sm absolute right-1 top-1/2 -translate-y-1/2">
                👁️
              </button>
            </div>
          </div>

          <div class="flex justify-end gap-3">
            <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Save User</button>
          </div>
        </form>
      </section>
    </main>

    <footer class="footer footer-center bg-primary p-12 shadow-lg text-white mt-20">
      <p class="font-bold text-lg">© 2025 Admin Dashboard</p>
      <p class="text-sm opacity-80">All rights reserved</p>
    </footer>

    <script>
      function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
          input.type = "text";
        } else {
          input.type = "password";
        }
      }
    </script>
  </body>
</html>