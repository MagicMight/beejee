<?php

function logout( $session_key ) {
	global $db;
		
	$sql = 'UPDATE users
			SET session_key = NULL
			WHERE session_key = :session_key';

	$query = $db->prepare($sql);
	$query->bindParam(":session_key", htmlspecialchars($session_key), PDO::PARAM_STR);
	$query->execute();

	setcookie('session_key','', time() - 3600);
	setcookie('login', '', time() - 3600);
	setcookie('editor_mode', 'no', time() + 3600);

}

function authorize($login, $pwd) {
	global $db;

	// Если пользователю уже назначен токен сессии, то удалить прошлую сессию из базы данных
	if( isset($_COOKIE['session_key']) ) {
		logout( htmlspecialchars($_COOKIE['session_key']) );
	}

	// Проверка, есть ли такая пара логин-пароль в базе данных, если да, то получение ID
	$pwdHash = hash('sha256', $pwd.'databasesaltvalue');
	$qGetUser = $db->prepare('SELECT id, status FROM users WHERE login = :login AND pwd = :pwd');
	$qGetUser->bindParam(":login", $login, PDO::PARAM_STR);
	$qGetUser->bindParam(":pwd", $pwdHash, PDO::PARAM_STR);
	$qGetUser->execute();
	$qUser = $qGetUser->fetchAll( PDO::FETCH_ASSOC );
	$qUserId = count($qUser) == 1 ? $qUser[0]['id'] : false;

	// Если такой пользователь не найден, возвращаем ошибку авторизации
	if( !$qUserId ) {
		return array('auth' => false, 'data' => 'Неверный логин или пароль');
	}
	
	// Проверям, является ли пользователь администратором
	if( $qUser[0]['status'] == 'admin' ) {
		setcookie('editor_mode', 'yes', time() + 3600);
	}

	// Создание уникального ключа сессии
	$session_key = '';
	while( true ) {
		$session_key = hash('sha256', rand().'hashsalt'.rand().$pwd.$login);
		$query = $db->prepare('SELECT EXIST( SELECT 1 FROM users WHERE session_key = :session_key ) exSession');
		$query->bindParam(":session_key", $session_key, PDO::PARAM_STR);
		$query->execute();
		if( $query->fetchAll( PDO::FETCH_ASSOC )[0]['exSession'] == 0 ) {
			break;
		}
	}


	// Назначение сессии пользователю в базе данных и на клиенте
	$query = $db->prepare('UPDATE users SET session_key=:session_key WHERE id=:id');
	$query->bindParam(":session_key", $session_key, PDO::PARAM_STR);
	$query->bindParam(":id", $qUserId, PDO::PARAM_STR);
	$query->execute();

	return array('auth' => true, 'sess' =>  $session_key, 'login' => $login);
}


?>