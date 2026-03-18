<?php
require("../config.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_REQUEST["username"]);
    $password = $_REQUEST["password"];
    $confirm_password  = $_REQUEST["confirm_password"];

    if (empty($password) || empty($username)) {
        $error = 'Все поля должны быть заполнены!';
    } else {
        if ($password == $confirm_password ) {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

        if(mysqli_num_rows($result) > 0){
            $error = 'Такой пользователь уже существует!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(username, password) VALUES ('$username', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = mysqli_insert_id($conn);

                header("Location: ../index.php");
                exit();
            } else {
                $error = 'Ошибка: ' . mysqli_connect_error() . '!';
            }
        }
    } else {
        $error = 'Пароли должны быть одинаковыми!';
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

    <link rel="stylesheet" href="../styles.css">
</head>
<body class="page page--register">
    <form class="form form--register" action="" method="post">
        <?php if ($error): ?>
            <div class="message message--error">
                <p class="message__text"><?= $error ?></p>
            </div>
        <?php endif;?>

        <div class="form__field">
            <label class="form__label" for="username">Имя пользователя</label>
            <input class="form__input" type="text" id="username" name="username" placeholder="Введите имя пользователя" required>
        </div>

        <div class="form__field">
            <label class="form__label" for="password">Пароль</label>
            <input class="form__input" type="password" id="password" name="password" placeholder="Введите пароль" required>
        </div>

        <div class="form__field">
            <label class="form__label" for="confirm_password">Повторите пароль</label>
            <input class="form__input" type="password" id="confirm_password" name="confirm_password" placeholder="Повторите пароль" required>
        </div>

        <button class="button button--primary button--register" type="submit">Создать</button>

        <p class="form__footer-text">
            Уже есть аккаунт? 
            <a class="link link--login" href="login.php">Войти</a>
        </p>
    </form>
</body>
</html>