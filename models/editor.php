<?php

// Функция проверки на наличие административных полномочий у пользователя, запросившего редактирование
function validateAuth() {
	global $db;
	if( isset($_COOKIE['session_key']) ) {
		$session_key = htmlspecialchars($_COOKIE['session_key']);
		$sql = 'SELECT users.status, users.id FROM users WHERE session_key=:session_key';

		$query = $db->prepare($sql);
		$query->bindParam(":session_key", $session_key, PDO::PARAM_STR);
		$query->execute();
		$status = $query->fetchAll( PDO::FETCH_ASSOC );

		if( count($status) == 0 ) {
			return [false, 'Для редактирования записи необходима авторизация'];
		}

		if( $status[0]['status'] == 'admin' ) {
			return [true, '', $status[0]['id']];
		}
		else {
			return [false, 'Нет полномочий для редактирования записей'];
		}
	}
	else return [false, 'Для редактирования записи необходима авторизация'];
}


// Вернуть задачу для редактирования
function getTaskToEdit( $taskid ) {
	global $db;
	$validate = validateAuth();
	if( !$validate[0] ) { return false; }
	$sql = 'SELECT
				tasks.id,
				tasks.title,
				tasks.content,
				tasks.isComplete,
				users.login,
				IFNULL(tasks.email, users.email) email
			FROM tasks 
				INNER JOIN users 
					ON tasks.user_id = users.id
			WHERE tasks.id = :task_id';

	$query = $db->prepare($sql);
	$query->bindParam(":task_id", htmlspecialchars($taskid), PDO::PARAM_INT);
	$query->execute();

	$task = $query->fetchAll( PDO::FETCH_ASSOC );
	if( count($task) == 0 ) {
		return false;
	}
	else {
		return $task[0];
	}
}

// Сохранить заметку
function saveTask( $taskid, $title, $content, $isComplete ) {
	global $db;

	try {
		$validate = validateAuth();
		if( !$validate[0] ) { return false; }


		// Проверяем наличие записи
		$query = $db->prepare('SELECT 1 FROM tasks WHERE id=:taskid');
		$query->bindParam(":taskid", htmlspecialchars($taskid), PDO::PARAM_INT);
		$query->execute();
		if( count($query->fetchAll( PDO::FETCH_ASSOC )) == 0 ) return false;
	
		$sql = 'UPDATE tasks
				SET title = :title,
					content = :content,
					isComplete = :isComplete,
					edited = 1
				WHERE id = :taskid';
	
		$query = $db->prepare($sql);
		$query->bindParam(":title", htmlspecialchars($title), PDO::PARAM_STR);
		$query->bindParam(":content", htmlspecialchars($content), PDO::PARAM_STR);
		$query->bindParam(":isComplete", htmlspecialchars($isComplete), PDO::PARAM_INT);
		$query->bindParam(":taskid", htmlspecialchars($taskid), PDO::PARAM_INT);
		$query->execute();
		return true;
	}
	catch( Exception $e ) {
		return false;
	}
}

// Создать заметку
function createTask( $title, $content, $email, $isComplete ) {
	global $db;

	try {
		$validate = validateAuth();
		$user_id = '';
		if( !$validate[0] ) { $user_id = 1; } 	// Неавторизованный пользователь
		else { $user_id = $validate[2]; }			// ID, по которому пользователь авторизован

		$query = $db->prepare('INSERT INTO tasks(user_id, email, title, content, isComplete) VALUES(:user_id, :email, :title, :content, :isComplete)');	
	
		$query->bindParam(":user_id", 		$user_id, PDO::PARAM_INT);
		$query->bindParam(":email", 		$email, PDO::PARAM_STR);
		$query->bindParam(":title", 		$title, PDO::PARAM_STR);
		$query->bindParam(":content", 		$content, PDO::PARAM_STR);
		$query->bindParam(":isComplete", 	$isComplete, PDO::PARAM_INT);
		$query->execute();

		return true;
	}
	catch( Exception $e ) {
		return false;
	}
}
?>