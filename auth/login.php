<?php
require("../config.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_REQUEST["username"]);
    $password = $_REQUEST["password"];

    if (empty($password) || empty($username)) {
        $error = 'Все поля должны быть заполнены!';
    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];

                header("Location: ../index.php");
                exit();
            } else {
                $error = 'Неверный пароль!';
            }
        } else {
            $error = 'Такого пользователя не существует!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в аккаунт</title>

    <link rel="stylesheet" href="../styles.css">
</head>

<body class="page page--login">
    <div class="container">
        <div class="form-container">
            <h1 class="page__title">Добро пожаловать!</h1>
            
            <form class="form form--login" action="" method="post">
                <?php if ($error): ?>
                    <div class="alert alert--error">
                        <p class="alert__message"><?= $error ?></p>
                    </div>
                <?php endif; ?>

                <div class="form__field">
                    <label class="form__label" for="username">Имя пользователя</label>
                    <input class="form__input" 
                           type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Введите имя пользователя" 
                           value="<?= htmlspecialchars($username ?? '') ?>"
                           required>
                </div>

                <div class="form__field">
                    <label class="form__label" for="password">Пароль</label>
                    <input class="form__input" 
                           type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Введите пароль" 
                           required>
                </div>

                <div class="form__actions">
                    <button class="button button--primary button--login" type="submit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Войти
                    </button>
                </div>

                <div class="form__footer">
                    <p class="form__footer-text">
                        Нет аккаунта? 
                        <a class="link link--register" href="register.php">
                            Зарегистрироваться
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>