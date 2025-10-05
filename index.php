<?php
include "db.php";

$total_category = mysqli_query($conn, "SELECT COUNT(DISTINCT category) AS total FROM article")->fetch_assoc()['total'];
$total_article = mysqli_query($conn, "SELECT COUNT(*) AS total FROM article")->fetch_assoc()['total'];

$new_articles = mysqli_query($conn, "SELECT * FROM article ORDER BY releasedate DESC LIMIT 3");

$limit = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$all_articles = mysqli_query($conn, "SELECT * FROM article ORDER BY releasedate DESC LIMIT $limit OFFSET $offset");
$total_pages = ceil($total_article / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Blog tentang Lorem Ipsum, artikel terbaru, dan informasi lainnya." />
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-base-200 text-base-content">
  <header>
    <nav class="navbar bg-base-100 shadow-md sticky top-0 z-50">
      <div class="flex-1 ml-10">
        <a href="/" class="font-bold text-2xl text-violet-500 hover:text-violet-600 transition">Lorem Ipsum</a>
      </div>
      <div class="flex-none flex items-center gap-4 mr-10">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="checkbox" class="toggle theme-controller transition-transform duration-200 hover:scale-110"
                 aria-label="Toggle dark mode" value="black" />
        </label>
      </div>
    </nav>

    <section class="hero min-h-[540px] pt-10 bg-gradient-to-b from-violet-200/50 to-transparent">
      <div class="hero-content text-center">
        <div class="max-w-xl">
          <h1 class="mb-5 text-6xl font-extrabold text-violet-500">Lorem Ipsum</h1>
          <p class="mb-6 text-lg opacity-80 leading-relaxed">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores beatae reiciendis dicta suscipit aliquam vel, eos et voluptatem veniam. Nihil dolores eligendi iusto molestias distinctio quam aspernatur, quae asperiores praesentium labore quis dolore aliquam consequatur possimus necessitatibus. Totam tempora fugiat voluptatem. Reprehenderit, recusandae incidunt! Ea quo consequuntur libero sed accusantium.
          </p>
        </div>
      </div>
    </section>
  </header>

  <main class="container mx-auto px-6 lg:px-12 py-20 space-y-20" id="articles">
    <section>
      <div class="stats bg-base-100 shadow-lg rounded-xl p-10 w-full border border-violet-100">
        <div class="stat text-center">
          <h2 class="stat-title font-bold text-xl text-violet-500">Total Category</h2>
          <p class="stat-value text-5xl"><?= $total_category ?></p>
        </div>
        <div class="stat text-center">
          <h2 class="stat-title font-bold text-xl text-violet-500">Total Article</h2>
          <p class="stat-value text-5xl"><?= $total_article ?></p>
        </div>
      </div>
    </section>

    <section>
      <h2 class="text-center text-3xl font-bold mb-12 text-violet-500 tracking-wide">New Article</h2>
      <ul class="space-y-6 max-w-3xl mx-auto">
        <?php while ($row = mysqli_fetch_assoc($new_articles)) : ?>
          <li>
            <article class="flex items-start gap-5 border border-violet-100 bg-base-100 p-6 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition">
              <figure class="shrink-0">
                <img class="size-28 rounded-lg object-cover"
                     src="<?= !empty($row['image']) ? 'uploads/' . $row['image'] : 'uploads/error.png' ?>"
                     alt="Thumbnail artikel" />
              </figure>
              <div class="flex-1">
                <a href="article.php?id=<?= $row['idarticle'] ?>" class="block space-y-2">
                  <h3 class="uppercase font-bold text-lg hover:text-violet-500 transition">
                    <?= htmlspecialchars($row['title']) ?>
                  </h3>
                  <p class="text-xs uppercase font-semibold opacity-70 text-violet-400">
                    <?= htmlspecialchars($row['category']) ?> | <?= date("d M Y", strtotime($row['releasedate'])) ?>
                  </p>
                  <p class="text-sm leading-relaxed opacity-80">
                    <?= substr(strip_tags($row['content']), 0, 120) ?>...
                  </p>
                </a>
              </div>
            </article>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>

    <section>
      <h2 class="text-center text-3xl font-bold my-12 text-violet-500 tracking-wide">All Article</h2>
      <ul class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <?php while ($row = mysqli_fetch_assoc($all_articles)) : ?>
          <li class="h-full">
            <article class="flex flex-col h-full border border-violet-100 bg-base-100 rounded-xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition">
              <figure>
                <img class="w-full h-48 object-cover rounded-lg"
                     src="<?= !empty($row['image']) ? 'uploads/' . $row['image'] : 'uploads/error.png' ?>"
                     alt="Thumbnail artikel" />
              </figure>
              <div class="mt-4 flex flex-col flex-1">
                <a href="article.php?id=<?= $row['idarticle'] ?>" class="block space-y-2">
                  <h3 class="uppercase font-bold text-lg hover:text-violet-500 transition">
                    <?= htmlspecialchars($row['title']) ?>
                  </h3>
                  <p class="text-xs uppercase font-semibold opacity-70 text-violet-400">
                    <?= htmlspecialchars($row['category']) ?> | <?= date("d M Y", strtotime($row['releasedate'])) ?>
                  </p>
                  <p class="text-sm leading-relaxed opacity-80 line-clamp-3">
                    <?= strip_tags($row['content']) ?>
                  </p>
                </a>
              </div>
            </article>
          </li>
        <?php endwhile; ?>
      </ul>

      <div class="join flex justify-center mt-12">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>" class="join-item btn btn-base-300">«</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?page=<?= $i ?>"
             class="join-item btn <?= ($i == $page) ? 'btn-primary' : 'btn-base-300' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
          <a href="?page=<?= $page + 1 ?>" class="join-item btn btn-base-300">»</a>
        <?php endif; ?>
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