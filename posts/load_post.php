<?php
require('../config.php');

$posts_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $posts_per_page;

$sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $posts_per_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

while ($post = mysqli_fetch_assoc($result)):
?>
    <div class="post">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <small>Дата публикации: <?= $post['created_at'] ?></small>
        <a class="delete-button"
            href="posts/delete_post.php?id=<?= $post['id'] ?>">Удалить</a>
    </div>
<?php endwhile; ?>