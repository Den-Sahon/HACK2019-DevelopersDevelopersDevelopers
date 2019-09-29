<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'phpqrcode/qrlib.php';

$db = new mysqli("localhost", 'root', '111', 'hack');

function r($data){
	global $db;
	return $db -> real_escape_string($data);
}

if (isset($_REQUEST['check'])){
	$data = file_get_contents('php://input');
	$data = explode('/', $data);
	$phone = $data[1];
	$code = $data[0];
	file_put_contents('text.txt', $phone . ' : ' . $code .' ' . date('H:i') . "\n", FILE_APPEND);
	$db -> query("INSERT INTO codes_data VALUES (null, '$code', '$phone', 0)");
	exit;
}

if (isset($_COOKIE['at'])){
	$res = $db -> query("SELECT * FROM users WHERE user_token='".r($_COOKIE['at'])."'");
	if ($res -> num_rows > 0){
		$user = $res -> fetch_object();
	}
}

if (isset($_REQUEST['api'])){
	require_once 'api.php';
}




ini_set('display_erros', 1);
error_reporting(E_ALL);

?><!doctype html>
<html lang="ru">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<base href="/">
		<title>m4me</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="inc/style.css">
		<link rel="stylesheet" href="inc/don_sahon.css">
		<link rel="shortcut icon" href="inc/logo_M4ME.png">
	</head>
	<body>
<?php if (!isset($user)): ?>
		<video class="logo-video" src="inc/logo.mp4" autoplay muted loop></video>
		<div class="main-content">
			<div class="title-main">
				<img src="inc/logo_M4ME.png" />
			</div>
			<div class="auth-form">
				<input type="password" class="nice-input-text auth-field" data-placeholder="Single-login"> 
				<div class="container">
					<div class="row text-center mt-3">
						<div class="col-6 switch login-btn active">
							Авторизация
						</div>
						<div class="col-6 switch signin-btn">
							Регистрация
						</div>
					</div>
				</div>
				<div class="auth-form-bottom container">
					Зарегистрируйтесь или авторизуйтеся чтобы создать свой графический код.
				</div>
			</div>
			<div class="copy">DevelopersDevelopersDevelopers</div>
		</div>
<?php else: ?>
		<div class="main-content authed">
			<div class="container">
				<div class="card nav-card mb-4">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-6">
								Ваш логин: <a href="#" class="show-login">Показать</a>
							</div>
							<div class="col-6 text-right">
								<a href="?api=logout">Выйти</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="card">
							<div class="card-body">
								<h3 class="mb-3">Ваши рекламные акции</h3>
								<ul class="projects-list">
<?php
	$res = $db -> query("SELECT * FROM projects WHERE user_id='{$user -> id}'");
	$first = true;
	while ($p = $res -> fetch_object()){
		if ($first){
			$project = $p;
		}
		
		echo '<li><a href="#" data-id="'.$p -> id.'" class="select-project '.(($first) ? 'active': '').'"># '.$p -> project_name.'</a><div data-id="'.$p -> id.'" class="remove-project">&times;</div></li>';
		$first = false;
	}
?>
									<li><a href="#" class="add-project">+ Добавить</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="card">
							<div class="card-body right-side">
								<?php require_once 'right_side.php'; ?>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
<?php endif; ?>
	
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="inc/main.js"></script>
	</body>
</html>





