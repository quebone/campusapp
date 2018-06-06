function initForm() {
	var members = document.getElementById('members');
	setElemValue(members, 0);
	members.removeAttribute('disabled');
	var email = document.getElementById('email');
	setElemValue(email, "");
	email.removeAttribute('disabled');
	setElemValue(document.getElementById('name'), "");
	setElemValue(document.getElementById('surnames'), "");
	setElemValue(document.getElementById('password'), "");
	setElemValue(document.getElementById('password-repeat'), "");
}

function validateForm(form) {
	var name = document.getElementById('name');
	var surnames = document.getElementById('surnames');
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	var passwordRepeat = document.getElementById('password-repeat');
	if (name.value.length == 0) {
		errorMessage("El nom no pot estar buit");
		name.focus();
	} else if (surnames.value.length == 0) {
		errorMessage("Els cognoms no poden estar buits");
		surnames.focus();
	} else if (email.value.length == 0 || !validateEmail(email.value)) {
		errorMessage("Email incorrecte");
		email.focus();
	} else if (password.value.length < 8 && password.value.length > 0) {
		errorMessage("La contrasenya ha de tenir 8 caràcters mínim");
		password.focus();
	} else if (passwordRepeat.value != password.value) {
		errorMessage("Les contrasenyes han de ser iguals");
		passwordRepeat.focus();
	} else {
		return true;
	}
	return false;
}

function getEgsData(event) {
	var id = getElemValue(event.target);
	var dataToSend = "id=" + id + "&function=getEgsData";
	send(dataToSend, AJAXCONTROLLER, getEgsDataReturn);
}

function getEgsDataReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		var email = document.getElementById('email');
		setElemValue(email, msg[1].email);
		email.setAttribute('disabled', "");
		setElemValue(document.getElementById('name'), msg[1].name);
		setElemValue(document.getElementById('surnames'), msg[1].surnames);
	} else {
		initForm();
	}
}

function addMember() {
	initForm();
	$('#modal').modal('show');
}

function saveMember() {
	if (validateForm()) {
		var name = getElemValue(document.getElementById('name'));
		var surnames = getElemValue(document.getElementById('surnames'));
		var email = getElemValue(document.getElementById('email'));
		var password = getElemValue(document.getElementById('password'));
		var dataToSend = "name=" + name + "&surnames=" + surnames + "&email=" + email + "&password=" + password + "&function=addStaff";
		send(dataToSend, AJAXCONTROLLER, saveMemberReturn);
	}
}

function saveMemberReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

function editMember(event) {
	var id = getElementContainerId(event.target, 'tr');
	var dataToSend = "id=" + id + "&function=getMember";
	send(dataToSend, AJAXCONTROLLER, editMemberReturn);
}

function editMemberReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		var members = document.getElementById('members');
		setElemValue(members, msg[1].joomId);
		members.setAttribute('disabled', "");
		var email = document.getElementById('email');
		setElemValue(email, msg[1].email);
		email.setAttribute('disabled', "");
		setElemValue(document.getElementById('name'), msg[1].name);
		setElemValue(document.getElementById('surnames'), msg[1].surnames);
		$('#modal').modal('show');
	} else {
		errorMessage(msg[1]);
	}
}

function deleteMember(event) {
	if (confirmMessage("Segur que vols eliminar aques usuari?")) {
		var id = getElementContainerId(event.target, 'tr');
		var dataToSend = "id=" + id + "&function=deleteStaff";
		send(dataToSend, AJAXCONTROLLER, deleteMemberReturn);
	}
}

function deleteMemberReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

