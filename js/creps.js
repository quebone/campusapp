const colors = ['pending', 'ready', 'done', 'warning', 'disabled'];

const states = [
	['pending', 'pending', 'disabled', 'disabled'],	//pending
	['ready', 'ready', 'warning', 'disabled'],			//ready
	['ready', 'ready', 'done', 'warning'],					//warned
	['done', 'done', 'done', 'done'],								//served
];

var showDoneNotification = true;
var cols = [];

window.onload = function () {
	getOrders();
}

function getOrders() {
	var rows = document.querySelectorAll('table tr.active');
	var ids = [];
	for (var i = 0; i < rows.length; i++) {
		ids.push(rows[i].id.split('-')[1]);
	}
	var dataToSend = "ids=" + ids + "&function=getOrdersNotSent";
	send(dataToSend, AJAXCONTROLLER, getOrdersReturn);
}

function getOrdersReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		addOrders(msg[1]);
		toggleServed(document.getElementById('toggleServed'));
	} else {
		console.log(msg[1]);
	}
}

function addOrders(orders) {
	var tbody = document.querySelector('tbody');
	var template = document.querySelector('tr.template');
	for (var i = 0; i < orders.length; i++) {
		var newRow = template.cloneNode(true);
		newRow.id = 'tr-' + orders[i].id;
		setCols(newRow);
		cols[0].innerHTML = orders[i].id;
		var ingredients = "";
		for (var j = 0; j < orders[i].ingredients.length; j++) {
			ingredients += orders[i].ingredients[j];
			if (j < orders[i].ingredients.length - 1) ingredients += ", ";
		}
		cols[1].innerHTML = ingredients;
		setOrderColors(orders[i]);
		newRow.classList.remove('template');
		tbody.appendChild(newRow);
	}
}

function setCols(row) {
	cols[0] = row.querySelector('.col-order');
	cols[1] = row.querySelector('.col-ingredients');
	cols[2] = row.querySelector('.col-warned');
	cols[3] = row.querySelector('.col-served');
}

function cleanRowColors() {
	for (var i = 0; i < cols.length; i++) {
		for (var j = 0; j < colors.length; j++) {
			cols[i].classList.remove(colors[j]);
		}
	}
}

function setOrderColors(order) {
	if (!order.done) {
		colorState = 0;
	} else if (!order.warned) {
		colorState = 1;
	} else if (!order.served) {
		colorState = 2;
	} else colorState = 3;
	cleanRowColors();
	for (var i=0; i<cols.length; i++) {
		cols[i].classList.add(states[colorState][i]);
	}
}

function checkState() {
	for (var i = 0; i < states.length; i++) {
		var found = true;
		var j = 0;
		while (found && j < cols.length) {
			if (!cols[j].classList.contains(states[i][j])) found = false;
			j++;
		}
		if (found) return i;
	}
	return false;
}

function showWarnedInfo(id) {
	if (checkState() === 2 && showDoneNotification) {
		infoMessage("S'ha enviat una notificació per la comanda " + id);
	}
	showDoneNotification = true;
}

function done(event) {
	if (event.target.classList.contains('pending') || event.target.classList.contains('ready')) {
		if (event.target.classList.contains('ready')) showDoneNotification = false;
		var id = getElementContainerId(event.target, 'tr');
		var dataToSend = "id=" + id + "&function=done";
		send(dataToSend, AJAXCONTROLLER, doneReturn, [event.target]);
	}
}

function doneReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		setCols(getElementContainer(options[0], 'tr'), msg[1]);
		setOrderColors(msg[1]);
		showWarnedInfo(getElementContainerId(options[0], 'tr'));
	} else {
		console.log(msg[1]);
	}
}

function warn(event) {
	if (event.target.classList.contains('disabled')) return false;
	var id = getElementContainerId(event.target, 'tr');
	var dataToSend = "id=" + id + "&function=warn";
	send(dataToSend, AJAXCONTROLLER, warnReturn, [event.target]);
}

function warnReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		setCols(getElementContainer(options[0], 'tr'), msg[1]);
		setOrderColors(msg[1]);
		showWarnedInfo(getElementContainerId(options[0], 'tr'));
	} else {
		console.log(msg[1]);
	}
}

function serve(event) {
	if (event.target.classList.contains('disabled') || event.target.classList.contains('done')) return false;
	var id = getElementContainerId(event.target, 'tr');
	var dataToSend = "id=" + id + "&function=serve";
	send(dataToSend, AJAXCONTROLLER, serveReturn, [event.target]);
}

function serveReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		var tr = getElementContainer(options[0], 'tr'); 
		setCols(tr, msg[1]);
		setOrderColors(msg[1]);
		checkServed(tr);
	} else {
		console.log(msg[1]);
	}
}

function toggleServed(elem) {
	var served = document.querySelectorAll('tr td.col-order.done');
	for (var i =0; i < served.length; i++) {
		var tr = getElementContainer(served[i], 'tr');
		if (elem.checked) tr.setAttribute('hidden', true);
		else tr.removeAttribute('hidden');
	}
}

function checkServed(tr) {
	if (document.getElementById('toggleServed').checked) {
		if (tr.querySelector('td.col-order').classList.contains('done')) {
			tr.setAttribute('hidden', true);
		}
	}
}
