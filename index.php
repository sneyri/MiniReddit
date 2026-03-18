<?php
require("config.php");

$current_user = '';

if (isset($_SESSION['user_id'])) {
    $current_user = $_SESSION['username'];
} else {
    header("Location: /auth/register.php");
    exit();
}

$posts_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

$message = '';
$message_type = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG приложение</title>

    <link rel="stylesheet" href="styles.css">
</head>

<body class="page page--main">
    <?php if (isset($message)): ?>
        <div class="alert alert--<?= $message_type ?>">
            <p class="alert__message"><?= $message ?></p>
        </div>
    <?php endif; ?>

    <div class="user-info">
        <span class="user-info__greeting">Привет, <strong class="user-info__username"><?= $current_user ?></strong>!</span>
    </div>
    
    <nav class="nav">
        <a class="nav__link nav__link--logout" href="auth/logout.php">Выйти</a>
        <a class="nav__link nav__link--add" href="posts/add_post.php">➕ Добавить пост</a>
        <a class="nav__link nav__link--channel" href="channel.php?channel=<?= $current_user ?>">Перейти на канал</a>
    </nav>

    <h3 class="section-title section-title--feed">Лента новостей</h3>

    <div id="posts-container" class="posts-container">
        <?php
        $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $posts_per_page";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result)): ?>
            <div class="post post--empty">
                <p class="post__empty-message">Постов пока что нету(</p>
            </div>
        <?php endif;
        while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <p class="post__meta">
                    Автор публикации: 
                    <a class="post__author-link" href="channel.php?channel=<?= $post['author'] ?>">
                        <?= $post['author'] ?>
                    </a>
                </p>
                <h2 class="post__title"><?= htmlspecialchars($post['title']) ?></h2>
                <small class="post__date">Дата публикации: <?= $post['created_at'] ?></small>

                <?php if ($post['author'] == $current_user): ?>
                    <div class="post__actions">
                        <a class="post__delete-btn" href="posts/delete_post.php?id=<?= $post['id'] ?>">
                            Удалить
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="JavaScript.js"></script>
</body>

</html>