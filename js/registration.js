function cancel(event) {
	window.location.assign('index.php');
	return false;
}

function deleteRegistration(event) {
	if (confirmMessage("Segur que vols eliminar aquesta inscripció?")) {
		var email = document.getElementById('email').value;
		var dataToSend = "email=" + email + "&function=deleteRegistration";
		send(dataToSend, AJAXCONTROLLER, deleteRegistrationReturn);
		return false;
	}
}

function deleteRegistrationReturn(msg) {
	
}