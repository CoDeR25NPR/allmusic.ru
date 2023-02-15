<?php
    include('login.htm');
    session_start();
    include('config.php');
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            echo '<p class="error">Неверные пароль или имя пользователя!</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                echo '<p class="success">Поздравляем, вы прошли авторизацию!</p>';
            } else {
                echo '<p class="error"> Неверные пароль или имя пользователя!</p>';
            }
        }
    }
?>

<!DOCTYPE html>
<html ru-RU>
<head>
    <meta http-equiv="Content-Type">
    <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <title>Главная</title>
</head>
<body>
    <img src="img/logo.png" class="logo"></img>
        <div class="container">
            <div class="header">
                <div class="navigation">
                    <ul>
                        <a href="index.htm" ><li class="nav">Главная</li></a>
                        <a href="block/category.htm"><li class="nav">Категории</li></a>
                        <a href="block/chart.htm"><li class="nav">Чарт</li></a>
                        <a href="block/novelties.htm"><li class="nav">Новинки</li></a>
                        <a href="block/the_best.htm"><li class="nav">Лучшие</li></a>
                        <a href="block/news.htm"><li class="nav">Новости</li></a>
                    </ul>
                </div>
            </div>
        </div>
<form method="post" action="" name="signin-form">
  <div class="form-element">
    <label>Username</label>
    <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
  </div>
  <div class="form-element">
    <label>Password</label>
    <input type="password" name="password" required />
  </div>
  <button type="submit" name="login" value="login">Log In</button>
</form>
</body>
</html>