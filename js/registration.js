function cancel(event) {
	window.location.assign('index.php');
	return false;
}

function deleteRegistration(event) {
	if (confirmMessage("Segur que vols eliminar aquesta inscripció?")) {
		var email = document.getElementById('email').value;
		var dataToSend = "email=" + email + "&function=deleteRegistration";
		send(dataToSend, AJAXCONTROLLER, deleteRegistrationReturn);
	}
}

function deleteRegistrationReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.assign('registrations.php');
	} else {
		errorMessage(msg[1]);
	}
}