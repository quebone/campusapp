window.onload = function () {
	getMostOrderedIngredients();	
}

function setVisible(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name').innerHTML;
	var dataToSend = "id=" + id + "&name=" + name + "&visible=" + event.target.checked + "&function=setIngredient";
	send(dataToSend, AJAXCONTROLLER, setVisibleReturn);
}

function setVisibleReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function setCrepsShopEnabled(elem) {
	var crepsShopEnabled = elem.checked;
	var dataToSend = "crepsEnabled=" + crepsShopEnabled + "&function=setCrepsEnabled";
	send(dataToSend, AJAXCONTROLLER, setCrepsShopEnabledReturn);
}

function setCrepsShopEnabledReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function setCrepsManagerEnabled(elem) {
	var crepsManagerEnabled = elem.checked;
	var dataToSend = "crepsManagerEnabled=" + crepsManagerEnabled + "&function=setCrepsManagerEnabled";
	send(dataToSend, AJAXCONTROLLER, setCrepsEnabledReturn);
}

function setCrepsEnabledReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function setCrepsManagerPassword(elem) {
	var crepsManagerPassword = getElemValue(elem);
	var dataToSend = "password=" + crepsManagerPassword + "&function=setCrepsManagerPassword";
	send(dataToSend, AJAXCONTROLLER, setCrepManagerPasswordReturn);
}

function setCrepManagerPasswordReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function setMaxPendingCreps(elem) {
	var maxPendingCreps = getElemValue(elem);
	var dataToSend = "maxPendingCreps=" + maxPendingCreps + "&function=setMaxPendingCreps";
	send(dataToSend, AJAXCONTROLLER, setMaxPendingCrepsReturn);
}

function setMaxPendingCrepsReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
	} else {
		errorMessage(msg[1]);
	}
}

function addIngredient() {
	var name = promptMessage("Escriu el nom de l'ingredient");
	if (name != null) {
		var dataToSend = "name=" + name + "&function=addIngredient";
		send(dataToSend, AJAXCONTROLLER, addIngredientReturn);
	}
}

function addIngredientReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

function deleteIngredient(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name').innerHTML;
	if (confirmMessage('Segur que vols eliminar ' + name + '?')) {
		var dataToSend = "id=" + id + "&function=deleteIngredient";
		send(dataToSend, AJAXCONTROLLER, deleteIngredientReturn);
	}
}

function deleteIngredientReturn(msg) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		window.location.reload();
	} else {
		errorMessage(msg[1]);
	}
}

function editIngredient(event) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.name');
	var oldName = name.innerHTML;
	var newName = promptMessage("Escriu el nom de l'ingredient", name.innerHTML);
	if (newName != null && newName != oldName) {
		var visible = tr.querySelector('input').checked;
		var dataToSend = "id=" + id + "&name=" + newName + "&oldname=" + oldName + "&visible=" + visible + "&function=setIngredient";
		send(dataToSend, AJAXCONTROLLER, editIngredientReturn, [name, newName]);
	}
}

function editIngredientReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		options[0].innerHTML = options[1];
	} else {
		errorMessage(msg[1]);
	}
}

function editLanguage(event, lang) {
	var tr = getElementContainer(event.target, 'tr');
	var id = tr.id.split('-')[1];
	var name = tr.querySelector('.' + lang);
	var original = tr.querySelector(".name");
	var oldName = name.innerHTML;
	var translated = promptMessage("Escriu la traducció de " + original.innerHTML, name.innerHTML);
	if (translated != null && translated != oldName) {
		var dataToSend = "original=" + original.innerHTML + "&translated=" + translated + "&lang=" + lang + "&function=translateIngredient";
		send(dataToSend, AJAXCONTROLLER, editLanguageReturn, [name, translated]);
	}
}

function editLanguageReturn(msg, options) {
	msg = JSON.parse(msg);
	if (msg[0]) {
		options[0].innerHTML = options[1];
	} else {
		errorMessage(msg[1]);
	}
}

function getMostOrderedIngredients() {
	var dataToSend = "function=getMostOrderedIngredients";
	send(dataToSend, AJAXCONTROLLER, getMostOrderedIngredientsReturn);
}

function getMostOrderedIngredientsReturn(msg) {
			if (DEBUG) console.log(msg);
	msg = JSON.parse(msg);
	if (msg[0]) {
		if (msg[1].length > 0) {
			$('#modal').modal('show');
			drawIngredientsChart(msg[1]);
		}
	} else {
		errorMessage(msg[1]);
	}
}

function drawIngredientsChart(ingredients) {
	// Load the Visualization API and the corechart package.
	google.charts.load('current', {'packages':['corechart']});
	
	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);
	
	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart() {
	
	  // Create the data table.
	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Ingredient');
	  data.addColumn('number', 'Orders');
	  for (var i=0; i<ingredients.length; i++) {
		  data.addRows([
		    [ingredients[i].name, ingredients[i].number], 
		  ]);
		}
	
	  // Set chart options
	  var options = {
			is3D: true,
			chartArea: {
				top: 0,
				left: 0,
				width: 700,
			},
      width: 700,
      height: 600
    };
	
	  // Instantiate and draw our chart, passing in some options.
	  var chart = new google.visualization.PieChart(document.getElementById('chart-ingredients'));
	  chart.draw(data, options);
	}
}