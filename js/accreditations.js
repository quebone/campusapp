function printAccreditations() {
	var rows = document.querySelectorAll('tbody tr');
	var ids = [];
	for (var i=0; i<rows.length; i++) {
		var check = rows[i].querySelector('input[type=checkbox]');
		if (check.checked) {
			ids.push(rows[i].id.split('-')[1]);
		}
	}
	if (ids.length > 0) {
		window.open('accreditations.php?ids=' + ids);
	}
}

function printAccreditation(elem) {
	var ids = [getElementContainerId(elem, 'tr')];
	window.open('accreditations.php?ids=' + ids);
}

