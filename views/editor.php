<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/public/scripts/jquery.min.js"></script>
	<script src="/public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/public/scripts/editor.js"></script>
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/public/styles/editor.css">
	<title>Редактирование записи</title>
</head>
<body>
	<div class="container-fluid">
		<?php
		include 'views/header.php';
		getPageHeader( $new == 'create' ? 'Создание записи' : 'Редактирование записи'); 
		?>
		<div class="row">
			<div class="container-fluid">
				<div class="col-xl-8 offset-xl-2 col-md-10 offset-md-1 col-12 mt-3  text-center">
				<?php
					$isnew = $new == 'create';
					if( $isnew  ) {
						$task = array(
							'title' => '',
							'login' => isset($_COOKIE['login']) ? htmlspecialchars($_COOKIE['login']) : 'Unauthorized',
							'content' => '',
							'email' => '',
							'id' => ''
						);
					}
					if( $task ) { ?>
					<form action="/" onsubmit="<?php echo $isnew ? 'createTask' : 'saveChanges'; ?>(event, this)" method="POST" id="taskedit_form">
					<div class="container-fluid taskitem">
						<input type="text" name="taskid" value="<?php echo $task['id']; ?>" hidden>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<small id="" class="errorfield form-text text-danger">&nbsp;</small>
									<input type="text" name="login" disabled class="form-control" value="<?php echo $task['login'] ?>"></span>
									<small class="form-text text-muted">Логин автора заметки изменять нельзя</small>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<small id="title_error" class="errorfield form-text text-danger">&nbsp;</small>
									<input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars_decode($task['title']) ?>">
									<small class="form-text text-muted">Заголовок заметки (до 120 символов)</small>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<small id="email_error" class="errorfield form-text text-danger">&nbsp;</small>
									<input type="text" name="email" class="form-control" value="<?php echo $task['email'] ?>" <?php if(!$isnew) echo 'disabled'; ?>></span>
									<small class="form-text text-muted"><?php echo $isnew ? 'E-mail (до 50 символов)' : 'E-mail автора поста изменять нельзя'; ?></small>
								</div>
							</div>
						</div>
						<div class="row border-top content-row">
							<div class="col-12 p-2 h-100">
								<small id="content_error" class="errorfield form-text text-danger">&nbsp;</small>
								<div id="content" contenteditable="true" class="w-100 h-100 textarea border text-left p-1"><?php echo htmlspecialchars_decode($task['content'])  ?></div>
								<small class="form-text text-muted">Текст заметки (до 2000 символов)</small>
							</div>
						</div>
						<div class="col content-row align-items-center">
							<div class="form-group form-inline">
								<label class="mr-4">Статус</label>
								<select class="form-control mr-4" name="isComplete">
									<option value="1" <?php echo $task['isComplete'] == 1 ? 'selected' : ''; ?>>Выполнено</option>
									<option value="0" <?php echo $task['isComplete'] == 0 ? 'selected' : ''; ?>>Не выполнено</option>
								</select>
								<input type="submit" class="btn form-control btn-primary mr-2" value="<?php echo $isnew ? 'Создать заметку' : 'Сохранить изменения';?>">
								<input type="button" id="error_message" class="btn form-control btn-light disabled text-success" value="">
							</div>
						</div>
					</div>
					</form>

					<?php } else {?><h4 class="mt-3">Невозможно вывести запись</h4><?php } ?>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-xl-8 offset-xl-2 text-center p-3">
				<a href="/" class="btn btn-info form-control">Вернуться на главную</a>
			</div>
		</div>
	</div>
</body>
</html>