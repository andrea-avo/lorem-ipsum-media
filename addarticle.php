<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content  = mysqli_real_escape_string($conn, $_POST['content']);

    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    $sql = "INSERT INTO article (title, releasedate, content, category, image)
            VALUES ('$title', NOW(), '$content', '$category', '$imageName')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Artikel berhasil disimpan!');window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan artikel: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Article</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>

  <body class="bg-base-200 text-base-content">
    <nav class="navbar bg-base-100 shadow-md sticky top-0 z-50">
      <div class="flex-1 ml-10">
        <a href="dashboard.php" class="font-bold text-2xl text-violet-500 hover:text-violet-600">Admin Dashboard</a>
      </div>
      <div class="flex-none mr-10">
        <a href="login.php" class="btn btn-sm btn-primary">Logout</a>
      </div>
    </nav>

    <main class="container mx-auto px-6 lg:px-12 py-20">
      <section class="card bg-base-100 shadow-lg border border-violet-100 rounded-xl p-8">
        <h2 class="text-2xl font-bold text-violet-500 mb-6">Add New Article</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
          <div>
            <label class="label">Title</label>
            <input type="text" name="title" class="input input-bordered w-full" placeholder="Article title" required />
          </div>
          <div>
            <label class="label">Category</label>
            <input type="text" name="category" class="input input-bordered w-full" placeholder="e.g. coding, culinary" required />
          </div>
          <div>
            <label class="label">Image</label>
            <input type="file" name="image" class="file-input file-input-bordered w-full" />
          </div>
          <div>
            <label class="label">Content</label>
            <textarea name="content" class="textarea textarea-bordered w-full h-40" placeholder="Write your article here..." required></textarea>
          </div>
          <div class="flex justify-end gap-3">
            <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Article</button>
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