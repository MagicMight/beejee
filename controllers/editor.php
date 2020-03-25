<?php 

include 'models/editor.php';
$task_id 		= filter_input(INPUT_GET, 'taskid', FILTER_SANITIZE_SPECIAL_CHARS);
$savechanges 	= filter_input(INPUT_GET, 'savechanges', FILTER_SANITIZE_SPECIAL_CHARS) == 'true';
$new 			= filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);

$title 			= isset($_POST['title']) ? filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) : false;
$email 			= isset($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS) : false;
$content 		= isset($_POST['content']) ? filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS) : false;
$complete 		= filter_input(INPUT_POST, 'isComplete', FILTER_SANITIZE_SPECIAL_CHARS) == '1' ? 1 : 0;




$task = false;

if( $new == 'save' && ( !isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['email']) || !isset($_POST['isComplete'])) ) {
	header('Content-type:application/json;charset=utf-8');
	
	$servresponse = array();

	if(strlen($title) == 0) 		{ $servresponse = array('save' => false, 'reason' =>  'Заголовок не должен быть пустым'); } 
	elseif(strlen($title) > 120) 	{ $servresponse = array('save' => false, 'reason' =>  'Длина заголовка не должна превышать 120 символов'); } 

	elseif(strlen($content) == 0) 	{ $servresponse = array('save' => false, 'reason' =>  'Заметка не должна быть пустой'); }
	elseif(strlen($content) > 2000) { $servresponse = array('save' => false, 'reason' =>  'Длина заметки не должна превышать 2000 символов'); }

	elseif(strlen($email) == 0) 	{ $servresponse = array('save' => false, 'reason' =>  'E-mail не должен быть пустой'); }
	elseif(strlen($email) > 50) 	{ $servresponse = array('save' => false, 'reason' =>  'E-mail не должен превышать 50 символов'); }
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) 	
									{ $servresponse = array('save' => false, 'reason' =>  'Недопустимый e-mail'); }
	else { 
		if(createTask( $title, $content, $email, $complete )) 
				{ $servresponse = array('save' => true, 'reason' => 'Заметка успешно создана!'); }
		else	{ $servresponse = array('save' => false, 'reason' =>  'Ошибка создания заметки'); }
	}
	
	echo json_encode($servresponse);
}
elseif( $new == 'create' ) {
	include 'views/editor.php';
}
elseif( $savechanges && !$task_id && ( !isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['complete']) )) {
	header('Location: /');
}

elseif( $savechanges) {
	header('Content-type:application/json;charset=utf-8');
	$servresponse = array();

	if(strlen($title) == 0) 		{ $servresponse = array('save' => false, 'reason' =>  'Заголовок не должен быть пустым'); } 
	elseif(strlen($title) > 120) 	{ $servresponse = array('save' => false, 'reason' =>  'Длина заголовка не должна превышать 120 символов'); } 

	elseif(strlen($content) == 0) 	{ $servresponse = array('save' => false, 'reason' =>  'Заметка не должна быть пустой'); }
	elseif(strlen($content) > 2000) { $servresponse = array('save' => false, 'reason' =>  'Длина заметки не должна превышать 2000 символов'); } 
	else { 
		if( saveTask($task_id, $title, $content, $complete) ) 
				{ $servresponse = array('save' => true, 'reason' => 'Запись успешно обновлена'); }
		else	{ $servresponse = array('save' => false, 'reason' =>  'Ошибка сохранения записи'); }
	}
	echo json_encode($servresponse);
}
elseif ( !$task_id && !$savechanges ) {
	header('Location: /');
}
else {
	$task = getTaskToEdit( $task_id );
	include 'views/editor.php';
}





?>