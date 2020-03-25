
<?php
function getPageHeader( $title ) { 
	if( isset($_COOKIE['session_key']) && isset($_COOKIE['login']) && isset($_COOKIE['editor_mode']) ) { ?>
		<div class="row border p-2">
			<div class="col text-right d-flex justify-content-around">
				<div class="btn-group" role="group">
					<button class="btn btn-outline-success pr-5 pl-5" onclick="location='/'">На главную</button>
					<button class="btn btn-success pr-5 pl-5" onclick="location='/?page=editor&new=create'">Создать заметку</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-light disabled border">Вы вошли как:</button>
					<button class="btn btn-light disabled text-danger border"><?php echo htmlspecialchars($_COOKIE['login']); ?></button>
					<button class="btn btn-secondary" onclick="location='/?page=auth&action=logout'">Выйти</button>
				</div>
			</div>
		</div>
	<?php } else { ?>
			<div class="row border p-2">
				<div class="col text-right d-flex justify-content-around">
					<div class="btn-group" role="group">
						<button class="btn btn-outline-success pr-5 pl-5" onclick="location='/'">На главную</button>
						<button class="btn btn-success pr-5 pl-5" onclick="location='/?page=editor&new=create'">Создать заметку</button>
					</div>
					<div class="btn-group" role="group">
						<button class="btn btn-light disabled border">Вы не авторизованы</button>
						<button class="btn btn-secondary" onclick="location='/?page=auth'">Войти</button>
					</div>
				</div>
			</div>
	<?php } ?>
<div class="row mt-1">
	<div class="col text-right"></div>
</div>
<div class="row">
	<div class="col-xl-8 offset-xl-2 text-center p-3">
		<h2 class="display-4"><?php echo $title; ?></h2>
	</div>
</div>
<?php }?>