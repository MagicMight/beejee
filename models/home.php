<?php
function getTasklist( $page ) {
	global $db;

	if( is_numeric($page)  && $page > 0 ) {
		$page = (($page << 0)-1)*3;

		// Если явно не заданы параметры сортровки (или заданы невалидные)
		// то сортировать по возрастанию ID заметки
		switch( $_COOKIE['sort_value'] ) {
			case 'email':
				$sort_val = 'users.email';
			break;

			case 'name':
				$sort_val = 'users.login';
			break;

			case 'status':
				$sort_val = 'tasks.isComplete';
			break;

			default:
				$sort_val = 'tasks.id';
		}

		$sort_dir = $_COOKIE['sort_direction'] == 'true' ? 'ASC' : 'DESC';

		// Тут можно обойтись без бинда параметров сортировки, так как данные провалидированы
		// и решается проблема с подстановкой в ORDER BY значений через PDO

		$sql = 'SELECT
					tasks.id,
					tasks.title,
					tasks.content,
					tasks.isComplete,
					users.login,
					tasks.edited,
					IFNULL(tasks.email, users.email) email
				FROM tasks 
			 		INNER JOIN users 
			 		ON tasks.user_id = users.id
				ORDER BY '.$sort_val.' '.$sort_dir.'
				LIMIT :from, 3';

		$query = $db->prepare($sql);
		$query->bindParam(":from", $page, PDO::PARAM_INT);
		$query->execute();
		$tasks = $query->fetchAll( PDO::FETCH_ASSOC );

		if( !count($tasks) ) return false;
		else return $tasks;
	}
	else {
		return false;
	}
}	


// Получить количество страниц
function getPagesCount() {
	global $db;
	$query = $db->prepare('SELECT COUNT(1) pages FROM tasks INNER JOIN users on tasks.user_id = users.id');
	$query->execute();
	return ceil($query->fetchAll( PDO::FETCH_ASSOC )[0]['pages'] / 3);
}
?>