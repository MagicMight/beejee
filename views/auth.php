<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/public/scripts/jquery.min.js"></script>
	<script src="/public/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/public/styles/auth.css">
	<script src="/public/scripts/auth.js"></script>
	<title>Авторизация</title>
</head>
<body>
<div class="container-fluid h-100">
	<?php
	include 'views/header.php';
	getPageHeader('Авторизация'); 
	?>
	<div class="row content h-75 align-content-center border">
		<div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 border">
			<div id="auth-form" class="panel panel-primary  pl-3 pr-3 pt-3 pb-3">
				<form class="panel-body mt-2" action="/?page=auth&action=authorize" method="POST" onsubmit="authSubmit(event, this)">
					<small id="errors" class="text-danger">&nbsp;</small>
					<input type="text" name="login" class="form-control mt-1" placeholder="Логин">
					<input type="password" name="pwd" class="form-control mt-1" placeholder="Пароль">
					<button type="submit" class="btn btn-info mt-3 w-100">Вход</button>
				</form>
			</div>
		</div>
	</div>
</div>	

</body>
</html>