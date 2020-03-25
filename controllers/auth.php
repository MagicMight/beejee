<?php
require_once('models/auth.php');

if( $db )
{
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);

	switch( $action ) {
		
		case 'authorize':
			header('Content-type:application/json;charset=utf-8');

			$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
			$pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_SPECIAL_CHARS);

			$auth = authorize($login, $pwd);

			if( $auth['auth'] ) {
				setcookie("session_key", $auth['sess'], time()+3600);
				setcookie("login", $auth['login'], time()+3600);
				echo json_encode(array('auth' => true));
			}
			else {
				echo json_encode(array('auth' => false, 'reason' => $auth['data']));
			}
		break;

		case 'logout':
			logout( htmlspecialchars($_COOKIE['session_key']) );
			header('Location: /?page=auth');
		break;

		default:
			include 'views/auth.php';
	}
}


?>