function validateForm() {
	var title = document.getElementById("title");
	if (getElemValue(title).length == 0) {
		alert("El títol no pot estar buit");
		title.focus();
		return false;
	}
	var message = document.getElementById("message");
	if (getElemValue(message).length == 0) {
		alert("El missatge no pot estar buit");
		message.focus();
		return false;
	}
	return true;
}

function clearForm() {
	setElemValue(document.getElementById("title"), "");
	setElemValue(document.getElementById("message"), "");
	setElemValue(document.getElementById("group"), 0);
}

function enableSend() {
	document.getElementById('sendNotification').setAttribute("enabled", true);
}

function disableSend() {
	document.getElementById('sendNotification').setAttribute("enabled", false);
}

function sendNotification() {
	if (validateForm()) {
		var id = document.getElementById('staffName').getAttribute('staffId');
		var title = getElemValue(document.getElementById("title"));
		var message = getElemValue(document.getElementById("message"));
		var body = message;
		var group = new Array(getElemValue(document.getElementById('group')));
		var dataToSend = "id=" + id + "&title=" + title + "&message=" + message + "&body=" + body + "&group=" + group + "&function=addNotification";
		send(dataToSend, AJAXCONTROLLER, sendNotificationReturn);
		disableSend();
	}
}

function sendNotificationReturn(msg) {
	enableSend();
	clearForm();
	msg = JSON.parse(msg);
	if (msg[0]) {
		alert("S'han enviat " + (msg[1].sent + msg[1].failed) + " notificacions, amb " + msg[1].failed + " errors");
		if (msg[1].sent > 0) window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

