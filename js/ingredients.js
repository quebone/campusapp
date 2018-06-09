function setVisible(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name').innerHTML;
	var dataToSend = "id=" + id + "&name=" + name + "&visible=" + event.target.checked + "&function=setIngredient";
	send(dataToSend, AJAXCONTROLLER, setVisibleReturn);
}

function setVisibleReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function addIngredient() {
	var name = promptMessage("Escriu el nom de l'ingredient");
	if (name != null) {
		var dataToSend = "name=" + name + "&function=addIngredient";
		send(dataToSend, AJAXCONTROLLER, addIngredientReturn);
	}
}

function addIngredientReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

function deleteIngredient(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name').innerHTML;
	if (confirmMessage('Segur que vols eliminar ' + name + '?')) {
		var dataToSend = "id=" + id + "&function=deleteIngredient";
		send(dataToSend, AJAXCONTROLLER, deleteIngredientReturn);
	}
}

function deleteIngredientReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

function editIngredient(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name');
	var newName = promptMessage("Escriu el nom de l'ingredient", name.innerHTML);
	if (newName != null) {
		var visible = tr.querySelector('input').checked;
		var dataToSend = "id=" + id + "&name=" + newName + "&visible=" + visible + "&function=setIngredient";
		send(dataToSend, AJAXCONTROLLER, editIngredientReturn, [name, newName]);
	}
}

function editIngredientReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		options[0].innerHTML = options[1];
	} else {
		errorMessage(msg[1]);
	}
}

