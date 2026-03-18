<?php
require("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];

    $safe_title = mysqli_real_escape_string($conn, $title);

    if (strlen($safe_title) > 10000) {
        $_SESSION['message'] = "Длина поста слишком большая! Максимальная длина 10000 символов";
        $_SESSION['message_type'] = "error";
    } else {
        if (isset($_SESSION['user_id'])) {
            $user = $_SESSION['username'];
            $safe_user = mysqli_real_escape_string($conn, $user);
            $sql = "INSERT INTO posts(title, author) VALUES('$safe_title', '$safe_user')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['message'] = "Пост успешно добавился!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Ошибка при добавлении поста...";
                $_SESSION['message_type'] = "error";
            }
        }
    }

    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страничка добавление поста</title>

    <link rel="stylesheet" href="../styles.css">
</head>

<body class="page page--add-post">
    <div class="container">
        <h1 class="page__title">Создание нового поста</h1>
        
        <form class="form form--add-post" action="" method="post">
            <div class="form__field">
                <label class="form__label" for="post-title">Текст поста</label>
                <textarea class="form__textarea" 
                          name="title" 
                          id="post-title" 
                          placeholder="Напишите ваш пост..." 
                          rows="5" 
                          required></textarea>
                <small class="form__hint">Максимум 10000 символов</small>
            </div>

            <div class="form__actions">
                <button class="button button--primary button--submit" type="submit">
                    📝 Опубликовать пост
                </button>
            </div>
        </form>

        <nav class="nav nav--add-post">
            <a class="nav__link nav__link--back" href="../index.php">
                ← Вернуться на главную
            </a>
        </nav>
    </div>
</body>

</html>