function initForm() {
	initEgsData();
	setElemValue(document.getElementById('accommodation'), 0);
	setElemValue(document.getElementById('thursdayDinner'), false);
	setElemValue(document.getElementById('fridayLunch'), false);
	setElemValue(document.getElementById('fridayDinner'), false);
	setElemValue(document.getElementById('saturdayLunch'), false);
	setElemValue(document.getElementById('saturdayDinner'), false);
	setElemValue(document.getElementById('sundayLunch'), false);
	setElemValue(document.getElementById('diet'), 0);
}

function initEgsData() {
	var members = document.getElementById('members');
	setElemValue(members, 0);
	members.removeAttribute('disabled');
	var email = document.getElementById('email');
	setElemValue(email, "");
	email.removeAttribute('disabled');
	setElemValue(document.getElementById('name'), "");
	setElemValue(document.getElementById('surnames'), "");
}

function validateForm(form) {
	var name = document.getElementById('name');
	var surnames = document.getElementById('surnames');
	var email = document.getElementById('email');
	if (name.value.length == 0) {
		errorMessage("El nom no pot estar buit");
		name.focus();
	} else if (surnames.value.length == 0) {
		errorMessage("Els cognoms no poden estar buits");
		surnames.focus();
	} else if (email.value.length == 0 || !validateEmail(email.value)) {
		errorMessage("Email incorrecte");
		email.focus();
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
		initEgsData();
	}
}

function addAttendance() {
	initForm();
	$('#modal').modal('show');
}

function saveAttendance() {
	if (validateForm()) {
		var name = getElemValue(document.getElementById('name'));
		var surnames = getElemValue(document.getElementById('surnames'));
		var email = getElemValue(document.getElementById('email'));
		var accommodation = getElemValue(document.getElementById('accommodation'));
		var thursdayDinner = getElemValue(document.getElementById('thursdayDinner'));
		var fridayLunch = getElemValue(document.getElementById('fridayLunch'));
		var fridayDinner = getElemValue(document.getElementById('fridayDinner'));
		var saturdayLunch = getElemValue(document.getElementById('saturdayLunch'));
		var saturdayDinner = getElemValue(document.getElementById('saturdayDinner'));
		var sundayLunch = getElemValue(document.getElementById('sundayLunch'));
		var diet = getElemValue(document.getElementById('diet'));
		var dataToSend = "name=" + name + "&surnames=" + surnames + "&email=" + email + "&accommodation=" + accommodation + "&diet=" + diet +
			"&thursdayDinner=" + thursdayDinner + "&fridayLunch=" + fridayLunch +
			"&fridayDinner=" + fridayDinner + "&saturdayLunch=" + saturdayLunch + "&saturdayDinner=" + saturdayDinner + "&sundayLunch=" + sundayLunch +
			"&function=addAttendance";
		send(dataToSend, AJAXCONTROLLER, saveAttendanceReturn);
	}
}

function saveAttendanceReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	}
	else {
		errorMessage(msg[1]);
	}
}

function editAttendance(event) {
	var id = getElementContainerId(event.target, 'tr');
	var dataToSend = "id=" + id + "&function=getAttendance";
	send(dataToSend, AJAXCONTROLLER, getAttendanceReturn);
}

function getAttendanceReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		var members = document.getElementById('members');
		setElemValue(members, msg[1].user.joomId);
		members.setAttribute("disabled", "");
		var name = document.getElementById('name');
		setElemValue(name, msg[1].user.name);
		var surnames = document.getElementById('surnames');
		setElemValue(surnames, msg[1].user.surnames);
		var email = document.getElementById('email');
		setElemValue(email, msg[1].user.email);
		email.setAttribute("disabled", "");
		setElemValue(document.getElementById('accommodation'), msg[1].attendance.accommodation);
		setElemValue(document.getElementById('thursdayDinner'), msg[1].attendance.thursdayDinner);
		setElemValue(document.getElementById('fridayLunch'), msg[1].attendance.fridayLunch);
		setElemValue(document.getElementById('fridayDinner'), msg[1].attendance.fridayDinner);
		setElemValue(document.getElementById('saturdayLunch'), msg[1].attendance.saturdayLunch);
		setElemValue(document.getElementById('saturdayDinner'), msg[1].attendance.saturdayDinner);
		setElemValue(document.getElementById('sundayLunch'), msg[1].attendance.sundayLunch);
		setElemValue(document.getElementById('diet'), msg[1].attendance.diet);
		$('#modal').modal('show');
	} else {
		errorMessage(msg[1]);
	}
}

function deleteAttendance(event) {
	if (confirmMessage("Segur que vols eliminar aquesta assistència?")) {
		var id = getElementContainerId(event.target, 'tr');
		var dataToSend = "id=" + id + "&function=deleteAttendance";
		send(dataToSend, AJAXCONTROLLER, deleteAttendanceReturn);
	}
}

function deleteAttendanceReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		
	} else {
		errorMessage(msg[1]);
	}
}
