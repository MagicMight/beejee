const showError = (form, target, text) => {
	let errorfields = document.getElementsByClassName('errorfield');
	for(let i=0; i<errorfields.length; i++) {
		errorfields[i].innerHTML = '&nbsp;';
	}

	document.getElementById( target + '_error').innerHTML = text;

	if(target !== 'content' && target !== 'main') form[target].focus();

}


// Сохранение данных текущей заметки
const saveChanges = (e, form) => {
	e.preventDefault();

	let content = { value: document.getElementById('content').innerText };
	let errors = document.getElementById('error_message');

	if	   ( form.title.value.length === 0 )	{ showError(form, 'title', 'Заголовок не должен быть пустым') }
	else if( form.title.value.length > 120 ) 	{ showError(form, 'title', 'Длина заголовка превышает 120 символов') }

	else if( content.value.length === 0 ) 		{ showError(form, 'content', 'Заметка не должна быть пустой') }
	else if( content.value.length > 2000 ) 		{ showError(form, 'content', 'Длина заметки превышает 2000 символов') }
	
	else if( form.taskid.value == '' ) 			{ errors.value = 'Что-то пошло не так. Необходимо обновить страницу.' }
	else {
		$.post('/?page=editor&taskid='+form.taskid.value+'&savechanges=true',
		{
			title: form.title.value, 
			content: content.value, 
			taskid: form.taskid.value, 
			complete: form.isComplete.value
		},
		(data) => { errors.value = data.reason; setTimeout(()=>{errors.value = ''}, 4000) }, 'json');
	}
}

// Создание новой заметки
const createTask = (e, form) => {
	e.preventDefault();
	let content = { value: document.getElementById('content').innerText };
	let errors = document.getElementById('error_message');
	let emailRX = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	if( form.title.value.length === 0 ) 	{ showError(form, 'title', 'Заголовок не должен быть пустым') }
	else if( form.title.value.length > 120 ) 	{ showError(form, 'title', 'Длина заголовка превышает 120 символов') }

	else if( form.email.value.length === 0 ) 	{ showError(form, 'email', 'E-mail не должен быть пустым') }
	else if( form.email.value.length > 50 ) 	{ showError(form, 'email', 'E-mail превышает 50 символов') }
	else if( !emailRX.test(form.email.value) ) 	{ showError(form, 'email', 'Введен некорректный e-mail') }

	else if( content.value.length === 0 ) 		{ showError(form, 'content', 'Заметка не должна быть пустой') }
	else if( content.value.length > 2000 )		{ showError(form, 'content', 'Длина заметки превышает 2000 символов') }
	
	else {
		$.post('/?page=editor&new=save',
		{
			title: form.title.value, 
			content: content.value, 
			email: form.email.value, 
			complete: form.isComplete.value
		},
		(data) => { errors.value = data.reason + ' Перенаправление на главную страницу...'; setTimeout(()=>{window.location = '/'}, 500) }, 'json');
	}
}
