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