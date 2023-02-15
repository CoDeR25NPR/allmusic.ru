<?php
    session_start();
    include('config.php');
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            echo '<p class="error">Этот адрес уже зарегистрирован!</p>';
        }
        if ($query->rowCount() == 0) {
            $query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                echo '<p class="success">Регистрация прошла успешно!</p>';
            } else {
                echo '<p class="error">Неверные данные!</p>';
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
			<form method="post" action="" name="signup-form">
				<div class="form-element">
					<label>Имя пользователя</label>
					<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
				</div>
				<div class="form-element">
					<label>Ваша почта</label>
					<input type="email" name="email" required />
				</div>
				<div class="form-element">
					<label>Пароль</label>
					<input type="password" name="password" required />
				</div>
				<button type="submit" name="register" value="register">Регистрация</button>
			</form>
		</div>
</body>
</html>
