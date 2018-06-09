const DEBUG = true;

const AJAXCONTROLLER = 'AjaxController.php';

// converteix la primera lletra a majúscula
function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

// retorna el nom de la pàgina sense directoris ni extensió
function getCurrentPageName() {
	var path = window.location.pathname;
	var page = path.split("/").pop();
	if (page.length == 0) return 'index';
	return page.split(".")[0];
}

// envia dades POST a un controlador PHP a través d'AJAX
function send(dataToSend, receiver, returnFunction, options = [], method="POST") {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			returnFunction(xmlhttp.responseText, options);
		}
	}
	xmlhttp.open(method, receiver, true);
	//Must add this request header to XMLHttpRequest request for POST
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	dataToSend += '&caller=' +  capitalizeFirstLetter(getCurrentPageName());
	if (DEBUG) console.log(dataToSend);
	xmlhttp.send(dataToSend);
}

function logout() {
	var dataToSend = "function=logout";
	send(dataToSend, AJAXCONTROLLER, logoutReturn);
}

function logoutReturn() {
	window.location.href = 'index.php';
}

function infoMessage(msg) {
	alert(msg);
}

function promptMessage(msg, defaultValue="") {
	return prompt(msg, defaultValue);
}

function confirmMessage(msg) {
	return confirm(msg);
}

function errorMessage(msg) {
	alert(msg);
}

function getElementContainer(elem, tag) {
	while (elem.tagName.toUpperCase() != tag.toUpperCase()) {
		elem = elem.parentElement;
	}
	return elem;
}

function getElementContainerId(elem, tag) {
	return getElementContainer(elem, tag).id.split('-')[1];
}

function getElemValue(elem) {
	switch(elem.tagName) {
		case "INPUT":
			switch(elem.getAttribute("type")) {
				case "checkbox":
					return elem.checked;
				case "TEXT":
				default:
					return elem.value;
			}
		case "SELECT":
		case "TEXTAREA":
		default:
			return elem.value;
	}
}

function setElemValue(elem, value) {
	switch(elem.tagName) {
		case "INPUT":
			switch(elem.getAttribute("type").toUpperCase()) {
				case "CHECKBOX":
					if (value === true) {
						elem.checked = true;
					} else {
						elem.checked = false;
						elem.removeAttribute("checked");
					}
					break;
				case "TEXT":
					if (value != null && isNaN(value)) value = value.replace(/^"(.*)"$/, '$1').replace(/\\"/g, '"');
					elem.value = value;
					break;
				case "NUMBER":
				default:
					elem.value = value;
			}
			break;
		case "TEXTAREA":
			elem.value = value.replace(/^"(.*)"$/, '$1').replace(/\\"/g, '"');
			break;
		case "SELECT":
			var options = elem.querySelectorAll('option');
			for (var i = 0; i < options.length; i++) {
				if (options[i].value == value) {
					options[i].setAttribute("selected", true);
				} else {
					options[i].removeAttribute("selected");
				}
			}
			elem.value = value;
		default:
			elem.value = value;
			elem.setAttribute("value", value);
			elem.setAttribute("oldvalue", value);
	}
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function checkAllToggle(event) {
	var table = getElementContainer(event.target, 'table');
	var checks = table.querySelectorAll('tbody input[type=checkbox]');
	for (var i=0; i<checks.length; i++) {
		checks[i].checked = event.target.checked;
	}
}

function checkToggle(event) {
	var toggleAll = document.getElementById('toggleAll');
	if (event.target.checked) {
		var table = getElementContainer(event.target, 'table');
		var checks = table.querySelectorAll('tbody input[type=checkbox]');
		for (var i=0; i<checks.length; i++) {
			if (!checks[i].checked) {
				toggleAll.checked = false;
				return;
			}
			toggleAll.checked = true;
		}
	} else {
		toggleAll.checked = false;
	}		
} 