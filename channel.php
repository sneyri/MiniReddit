<?php
require("config.php");

$current_user = '';

if (isset($_SESSION['user_id'])) {
    $current_user = $_SESSION['username'];
} else {
    header("Location: /auth/register.php");
    exit();
}

$author = '';

if ($_GET['channel']) {
    $author = mysqli_real_escape_string($conn, $_GET['channel']);
    $sql = "SELECT * FROM posts WHERE author='$author'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Канал <?= $author ?></title>

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <a href="../index.php">Вернуться на главную</a>

    <?php if ($author == $current_user): ?>
        <h1>Добро пожаловать <?= $author ?>!</h1>
    <?php else: ?>
        <h1>Добро пожаловать на канал <?= $author ?></h1>
    <?php endif; ?>
    
    <?php if ($result): ?>
        <?php if (!mysqli_num_rows($result)): ?>
            <h3>Постов пока что нету(</h3>
        <?php endif;?>
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <p>Автор публикации: <?= $post['author'] ?></p>
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <small>Дата публикации: <?= $post['created_at'] ?></small><br></br>

                <?php if ($post['author'] == $current_user): ?>
                    <a class="delete-button"
                        href="posts/delete_post.php?id=<?= $post['id'] ?>">Удалить</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</body>

</html>