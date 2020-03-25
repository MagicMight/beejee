const sortSelect = (elem) => {

	let data = elem.getAttribute('data-val');
	let sortParams = localStorage.sort ? JSON.parse( localStorage.sort ) : false;

	// Если в локальном хранилище уже есть созданный параметр для сортировки
	if( sortParams ) {

		// Если была выбрана сортировка по тому же полю, то меняем порядок сортировки,
		// В противном случае ставим "по возрастанию"
		sortParams.direction = sortParams.value === data ? !sortParams.direction : true;

		// Назначаем поле для сортировки
		sortParams.value = data;
	}
	else {
		sortParams = {value: data, direction: true};
	}
	localStorage.sort = JSON.stringify( sortParams );
	document.cookie = `sort_value=${sortParams.value}`;
	document.cookie = `sort_direction=${sortParams.direction}`;
	location = location;
}

window.addEventListener('DOMContentLoaded', ()=> {
	if( localStorage.sort ) {
		let sData = JSON.parse(localStorage.sort);
		let buttons = document.querySelectorAll('.sortpanel > button');
		for(let i=0; i<buttons.length; i++) {
			if( buttons[i].getAttribute('data-val') === sData.value ) {
				buttons[i]
					.getElementsByTagName('span')[ sData.direction === true ? 0 : 1 ]
					.style.setProperty('display', 'inline');
				break;
			}
		}
	}
});