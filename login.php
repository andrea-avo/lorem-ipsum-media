<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if (password_verify($password, $data['password'])) {
            $_SESSION['id']    = $data['id'];
            $_SESSION['email'] = $data['email'];

            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan!";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@5/dist/full.css"
      rel="stylesheet"
      type="text/css"
    />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Login</title>
  </head>
  <body class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="card w-full max-w-md shadow-lg bg-base-100">
      <div class="card-body p-8">
        <h2 class="text-center text-2xl font-bold text-violet-500 mb-6">
          Login
        </h2>

        <?php if (!empty($_SESSION['error'])) : ?>
          <div class="alert alert-error mb-4">
            <?= $_SESSION['error'] ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
          <div class="form-control">
            <label class="label">
              <span class="label-text font-medium">Email</span>
            </label>
            <input
              type="email"
              name="email"
              class="input w-full border rounded-sm mt-2 border-gray-300 p-2"
              required
            />
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text font-medium">Password</span>
            </label>
            <input
              type="password"
              name="password"
              class="input w-full border rounded-sm mt-2 border-gray-300 p-2"
              required
            />
          </div>

          <button
            type="submit"
            class="btn btn-primary w-full bg-violet-500 hover:bg-violet-600 rounded-sm p-2 text-white"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  </body>
</html>