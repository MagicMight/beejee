<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/public/scripts/jquery.min.js"></script>
	<script src="/public/bootstrap/js/bootstrap.min.js"></script>
	<script src="/public/scripts/home.js"></script>
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/public/styles/home.css">
	<title>Список задач</title>
</head>

<body>
	<div class="container-fluid"></div>
		<?php
		include 'views/header.php';
		getPageHeader('Список задач'); 
		?>
		<div class="row mt-5">
			<div class="col-xl-8 offset-xl-2">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-around">
						<ul class="sortpanel navbar-nav center">
							<div class="nav-item ml-2 mr-2 align-self-center">Сортировка</div>
							<button 
								data-val="name" 
								onclick="sortSelect(this)" 
								class="btn ml-2 mr-2 nav-item  nav-link">Имя пользователя <span>↑</span><span>↓</span></button>
							<button 
								data-val="email" 
								onclick="sortSelect(this)"
								class="btn ml-2 mr-2 nav-item nav-link">E-mail <span>↑</span><span>↓</span></button>
							<button 
								data-val="status" 
								onclick="sortSelect(this)" 
								class="btn ml-2 mr-2 nav-item  nav-link">Статус <span>↑</span><span>↓</span></button>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
				<div class="container-fluid mt-2">
					<div class="row text-center">
						<?php if (!$tasklist) { ?>
						<div class="col mt-5">На этой странице нет записей!</div>

						<?php } else { foreach( $tasklist as $task ) {?>
						<div class="col-lg-4 col-md-12 p-2  mt-3">
							<div class="container-fluid text-left border taskitem <?php if($task['isComplete'] == '1') echo 'complete '; if($task['edited'] == '1') echo 'edited' ?>">
								<div class="row">
									<div class="col-6 data-field text-left" title="<?php echo $task['login'] ?>"><small class="font-weight-bold"><?php echo $task['login'] ?></small></div>
									<div class="col-6 data-field text-right" title="<?php echo $task['email'] ?>"><small><?php echo $task['email'] ?></small></div>
									<div class="col-12 data-field font-weight-bold" title="<?php echo $task['title'] ?>"><?php echo htmlspecialchars_decode($task['title']) ?></div>
								</div>
								<div class="row">
									<div class="col-12 p-2 content-field">
										<div class="textarea form-control" disabled><?php echo htmlspecialchars_decode($task['content']) ?></div>
									</div>
								</div>

								<div class="row border-top">
								<?php if( $_COOKIE['editor_mode'] == 'yes') {?>
									<div class="col-12 data-field text-right">
										<a class="btn w-100" href="/?page=editor&taskid=<?php echo $task['id'] ?>">Редактировать</a>
									</div>
									<?php } ?>
								</div>

										
							</div>
						</div>
						<?php } } ?>

					</div>
					<div class="row text-center links-navigation">
						<div class="col-12 mb-2">
							<?php
							$total = getPagesCount();
							if ($p!=1) $pervpage = '<a class="btn btn-outline-primary"  href= /?p=1>Первая</a> <a class="btn btn-outline-primary"  href= /?p='. ($p-1) .'>←</a> ';
							if ($p!= $total) $nextpage = ' <a class="btn btn-outline-primary"  href= /?p='.($p+1).'>→</a> <a class="btn btn-outline-primary"  href= /?p='.$total.'>Последняя</a>';

							if($p-2 > 0) $page2left = ' <a class="btn btn-outline-primary"  href= /?p='. ($p-2) .'>'. ($p-2).'</a>';
							if($p-1 > 0) $page1left = '<a class="btn btn-outline-primary"  href= /?p='. ($p-1) .'>'. ($p-1) .'</a>';
							if($p+2 <= $total) $page2right = '<a class="btn btn-outline-primary"  href= /?p='. ($p+2) .'>'. ($p+2) .'</a>';
							if($p+1 <= $total) $page1right = '<a class="btn btn-outline-primary"  href= /?p='. ($p+1) .'>'. ($p+1) .'</a>';
							?>
							<div class="btn-group" role="group">
								<?php echo $pervpage.$page2left.$page1left.'<a href="#" class="btn btn-primary">'.$p.'</a>'.$page1right.$page2right.$nextpage; ?>
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
</body>

</html>