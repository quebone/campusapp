function initForm() {
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	email.value = "";
	password.value = "";
	email.focus();
}

function validateForm(form) {
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	if (email.value.length == 0 || !validateEmail(email.value)) {
		errorMessage("Email incorrecte");
		email.focus();
	} else if (password.value.length < 8) {
		errorMessage("La contrasenya ha de tenir 8 caràcters mínim");
		password.focus();
	} else {
		return true;
	}
	return false;
}

function isLogged() {
	var dataToSend = "function=isLogged";
	send(dataToSend, AJAXCONTROLLER, isLoggedReturn);
}

function isLoggedReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.assign('staff.php');
	} else {
		openLoginForm();
	}
}

function openLoginForm() {
	initForm();
	$('#modalLogin').modal('show');
}

function login() {
	if (validateForm()) {
		var email = document.getElementById('email').value;
		var password = document.getElementById('password').value;
		var dataToSend = "email=" + email + "&password=" + password + "&function=login";
		send(dataToSend, AJAXCONTROLLER, loginReturn);
	}
}

function loginReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.assign('staff.php');
	} else {
		errorMessage(msg[1]);
	}
}
