<?php
include "db.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

$sql = "SELECT * FROM article WHERE idarticle = $id";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    echo "<!DOCTYPE html><html><body><h1>Artikel tidak ditemukan.</h1><p><a href='index.php'>Kembali ke Beranda</a></p></body></html>";
    exit;
}

$sql2 = "SELECT * FROM article WHERE idarticle != $id ORDER BY releasedate DESC LIMIT 2";
$related = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($article['title']); ?></title>
  <meta name="description" content="<?= htmlspecialchars(substr(strip_tags($article['content']), 0, 150)); ?>" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-base-200 text-base-content">
  <header>
    <nav class="navbar bg-base-100 shadow-md sticky top-0 z-50">
      <div class="flex-1 ml-10">
        <a href="index.php" class="font-bold text-2xl text-violet-500 hover:text-violet-600 transition">
          Lorem Ipsum
        </a>
      </div>
    </nav>
  </header>

  <main class="container max-w-3xl mx-auto px-6 py-16">
    <div class="mb-10">
      <a href="index.php"
        class="btn btn-outline btn-sm border-violet-300 text-violet-500 hover:bg-violet-500 hover:border-violet-500 hover:text-white transition">
        ← Back
      </a>
    </div>

    <article class="prose max-w-none">
      <h1 class="text-4xl md:text-5xl font-extrabold text-violet-500 mb-4">
        <?= htmlspecialchars($article['title']); ?>
      </h1>
      <p class="text-sm text-gray-500 mb-6">
        <span class="font-semibold text-violet-400"><?= htmlspecialchars($article['category']); ?></span> |
        <?= date("d F Y", strtotime($article['releasedate'])); ?>
      </p>

      <figure class="mb-8">
        <img src="<?= !empty($article['image']) ? 'uploads/' . htmlspecialchars($article['image']) : 'uploads/error.png'; ?>"
             alt="<?= htmlspecialchars($article['title']); ?>"
             class="w-full rounded-lg shadow-lg" />
        <figcaption class="text-xs text-center text-gray-400 mt-2">
          <?= htmlspecialchars($article['title']); ?>
        </figcaption>
      </figure>

      <div class="space-y-5 text-justify leading-relaxed">
        <?= nl2br($article['content']); ?>
      </div>

      <div class="mt-10 flex flex-wrap gap-3">
        <span class="badge badge-outline badge-lg border-violet-400 text-violet-500">
          #<?= htmlspecialchars($article['category']); ?>
        </span>
      </div>
    </article>

    <section class="mt-16 border-t pt-10">
      <h2 class="text-2xl font-bold mb-8 text-violet-500">Another Article</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <?php while ($row = mysqli_fetch_assoc($related)): ?>
          <a href="article.php?id=<?= $row['idarticle']; ?>"
             class="flex items-center gap-4 p-4 border border-violet-100 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition bg-base-100">
            <img src="<?= !empty($row['image']) ? 'uploads/' . htmlspecialchars($row['image']) : 'uploads/error.png'; ?>"
                 alt="<?= htmlspecialchars($row['title']); ?>"
                 class="w-28 h-20 object-cover rounded-md" />
            <div>
              <h3 class="font-bold text-lg hover:text-violet-500 transition line-clamp-2">
                <?= htmlspecialchars($row['title']); ?>
              </h3>
              <p class="text-sm text-gray-500 mt-1">
                Diposting <?= date("d F Y", strtotime($row['releasedate'])); ?>
              </p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
    </section>
  </main>

  <footer class="footer footer-center bg-violet-200 p-12 shadow-lg text-black mt-20">
    <div>
      <p class="font-bold text-lg">Lorem Ipsum Media.</p>
      <p>Providing quality article since 2025</p>
      <p class="text-sm opacity-80">© 2025 - All rights reserved</p>
    </div>
  </footer>
</body>
</html>