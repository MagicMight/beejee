const authSubmit = (e, form) => {
	e.preventDefault();
	let errors = document.getElementById('errors');

	if( form.login.value.length === 0 ) {
		errors.innerText = 'Логин не должен быть пустым!';
		form.login.focus();
	}
	else if( form.pwd.value.length === 0 ) {
		errors.innerText = 'Пароль не должен быть пустым!';
		form.pwd.focus();
	}
	else {
		$.post('/?page=auth&action=authorize',
			{login: form.login.value, pwd: form.pwd.value},
			(data) => {
				if(data.auth === true) {
					errors.innerText = 'Авторизация успешна! Сейчас Вы будете перенаправлены на главную страницу..';
					setTimeout(()=>{window.location='/'}, 1500);
				}
				else {
					errors.innerText = data.reason;
				}
			}, 'json');

	}

}