<?php
require_once('conf/db.php');

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

switch( $page ) {
	case false:
		include 'controllers/home.php';
	break;

	case 'auth':
		include 'controllers/auth.php';
	break;

	case 'editor':
		include 'controllers/editor.php';
	break;

	default:
		include 'controllers/404.php';
}

?>