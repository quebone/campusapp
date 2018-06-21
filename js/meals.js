function toggleTbodyView(event) {
	var table = getElementContainer(event.target, 'table');
	var tbody = table.querySelector('tbody');
	var expandMore = table.querySelector('.expand-more')
	var expandLess = table.querySelector('.expand-less')
	if (tbody.hasAttribute('hidden')) {
		tbody.removeAttribute('hidden');
		expandMore.setAttribute('hidden', '');
		expandLess.removeAttribute('hidden');
	} else {
		tbody.setAttribute('hidden', '');
		expandMore.removeAttribute('hidden');
		expandLess.setAttribute('hidden', '');
	}
}

function showDiners(event) {
	var id = getElementContainerId(event.target, 'table');
	var dataToSend = "id=" + id + "&function=getDiners";
	send(dataToSend, AJAXCONTROLLER, showDinersReturn);
}

function showDinersReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		var rows = msg[1];
		var container = document.querySelector('#modal .container-fluid');
		var table = container.querySelector('table');
		if (table != null) container.removeChild(table);
		table = document.createElement("TABLE");
		var thead = document.createElement("THEAD");
		var th = document.createElement("TH");
		th.innerHTML = 'Nom';
		thead.appendChild(th);
		th = document.createElement("TH");
		th.innerHTML = 'Data';
		thead.appendChild(th);
		table.appendChild(thead);
		var tbody = document.createElement("TBODY");
		for (var i = 0; i < rows.length; i++) {
			var tr = document.createElement("TR");
			tr.className = rows[i].assisted ? "assisted" : "pending";
			var td = document.createElement("TD");
			td.innerHTML = rows[i].name + " " + rows[i].surnames;
			tr.appendChild(td);
			td = document.createElement("TD");
			td.innerHTML = rows[i].assisted ? rows[i].date : "";
			tr.appendChild(td);
			tbody.appendChild(tr);
		}
		table.appendChild(tbody);
		container.appendChild(table);
		$('#modal').modal('show');
	} else {
		errorMessage(msg[1]);
	}
}