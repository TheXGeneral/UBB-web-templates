let selected_element_id = 0;
function fillTable(data) {
	document.getElementById("mytbody").innerHTML = "";
	data.forEach((element) => {
		document.getElementById(
			"mytbody"
		).innerHTML += `<tr id="${element.id}"><td>${element.id}</td><td>${element.name}</td><td>${element.genre}</td><td>${element.format}</td><td>${element.path}</td><td><button onclick="select_element(${element.id})">Select</button></td></tr>`;
	});
}

function select_element(id) {
	selected_element_id = id;
	document.getElementById("itemid").innerHTML = id;
	// populate form with data
	document.getElementById("name").value = document.getElementById(id).children[1].innerHTML;
	document.getElementById("genre").value = document.getElementById(id).children[2].innerHTML;
	document.getElementById("format").value = document.getElementById(id).children[3].innerHTML;
	document.getElementById("path").value = document.getElementById(id).children[4].innerHTML;
	document.getElementById("file_frame").src = document.getElementById(id).children[4].innerHTML;
}

function deselect() {
	selected_element_id = 0;
	document.getElementById("itemid").innerHTML = "";
	document.getElementById("name").value = "";
	document.getElementById("genre").value = "";
	document.getElementById("format").value = "";
	document.getElementById("path").value = "";
	document.getElementById("file_frame").src = "";
}

function delete_element() {
	if (selected_element_id == 0) {
		alert("Please select an element");
		return;
	}
	if (!confirm("Are you sure you want to delete this element?")) {
		return;
	}
	$.ajax({
		url: "./methods/protected_routes/delete.php",
		type: "DELETE",
		headers: {
			Authorization: `Bearer ${localStorage.getItem("token")}`,
			id: selected_element_id,
		},
		success: function (data) {
			if (data.success) {
				alert("Element deleted");
				deselect();
				getData();
			} else {
				alert(data.message);
			}
		},
	});
}
function getData() {
	$.ajax({
		url: "./methods/getData.php",
		type: "GET",
		headers: {
			search: document.getElementById("search").value,
		},
		success: function (data) {
			fillTable(data);
		},
	});
}

function add_element() {
	let name = document.getElementById("name").value;
	let genre = document.getElementById("genre").value;
	let format = document.getElementById("format").value;
	let path = document.getElementById("path").value;
	$.ajax({
		url: "./methods/protected_routes/addItem.php",
		type: "POST",
		headers: {
			Authorization: `Bearer ${localStorage.getItem("token")}`,
		},
		data: {
			name: name,
			genre: genre,
			format: format,
			path: path,
		},
		success: function (data) {
			if (data.success) {
				alert("Element added");
				deselect();
				getData();
			} else {
				alert(data.message);
			}
		},
	});
}
function update_element() {
	if (selected_element_id == 0) {
		alert("Please select an element");
		return;
	}
	if (!confirm("Are you sure you want to update this element?")) {
		return;
	}
	let name = document.getElementById("name").value;
	let genre = document.getElementById("genre").value;
	let format = document.getElementById("format").value;
	let path = document.getElementById("path").value;
	$.ajax({
		url: "./methods/protected_routes/updateItem.php",
		headers: {
			Authorization: `Bearer ${localStorage.getItem("token")}`,
		},
		type: "POST",
		data: {
			id: selected_element_id,
			name: name,
			genre: genre,
			format: format,
			path: path,
		},
		success: function (data) {
			if (data.success) {
				alert("Element updated");
				deselect();
				getData();
			} else {
				alert(data.message);
			}
		},
	});
}

getData();
