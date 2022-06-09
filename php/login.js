function open_log_modal() {
	document.getElementById("modal").style.display = "flex";
	go_login();
}

function close_log_modal() {
	document.getElementById("modal").style.display = "none";
}

function go_login() {
	document.getElementById("login").style.display = "flex";
	document.getElementById("register").style.display = "none";
}
function go_register() {
	document.getElementById("login").style.display = "none";
	document.getElementById("register").style.display = "flex";
}
if (localStorage.getItem("token") === null || localStorage.getItem("token") === "") {
	document.getElementById("action_botton").innerHTML = "Login";
	document.getElementById("buttons-div").style.display = "none";
	document.getElementById("action_botton").onclick = function () {
		open_log_modal();
	};
} else {
	document.getElementById("action_botton").innerHTML = "Logout";
	document.getElementById("action_botton").onclick = function () {
		logout();
	};
}
function logout() {
	localStorage.setItem("token", "");
	document.getElementById("action_botton").innerHTML = "Login";
	document.getElementById("buttons-div").style.display = "none";
	deselect();
	document.getElementById("action_botton").onclick = function () {
		open_log_modal();
	};
}
function login() {
	var email = document.getElementById("log_email").value;
	var password = document.getElementById("log_password").value;
	$.ajax({
		url: "./methods/login.php",
		type: "POST",
		data: {
			email,
			password,
		},
		success: function (data) {
			console.log(data.token);
			if (data.success == true) {
				localStorage.setItem("token", data.token);
				document.getElementById("action_botton").innerHTML = "Logout";
				document.getElementById("action_botton").onclick = function () {
					logout();
				};
				document.getElementById("buttons-div").style.display = "block";
				document.getElementById("login").style.display = "none";
				document.getElementById("register").style.display = "none";
				document.getElementById("modal").style.display = "none";
				clean_inputs();
			} else {
				alert("Wrong email or password");
			}
		},
	});
}

function check_auth() {
	$.ajax({
		url: "./methods/utils/auth.php",
		type: "POST",
		headers: {
			Authorization: `Bearer ${localStorage.getItem("token")}`,
		},
		success: function (data) {
			console.log(data);
		},
	});
}

// clean inputs
function clean_inputs() {
	document.getElementById("log_email").value = "";
	document.getElementById("log_password").value = "";
	document.getElementById("reg_email").value = "";
	document.getElementById("reg_password").value = "";
	document.getElementById("reg_repassword").value = "";
}

function register() {
	var email = document.getElementById("reg_email").value;
	var password = document.getElementById("reg_password").value;
	var repassword = document.getElementById("reg_repassword").value;
	if (password != repassword) {
		alert("Passwords don't match");
		return;
	}
	$.ajax({
		url: "./methods/register.php",
		type: "POST",
		data: {
			email,
			password,
		},
		success: function (data) {
			console.log(data);
			if (data.success == true) {
				localStorage.setItem("token", data.token);
				document.getElementById("action_botton").innerHTML = "Logout";
				document.getElementById("action_botton").onclick = function () {
					logout();
				};
				document.getElementById("buttons-div").style.display = "block";
				document.getElementById("login").style.display = "none";
				document.getElementById("register").style.display = "none";
				document.getElementById("modal").style.display = "none";
				clean_inputs();
			} else {
				alert("Email already exists");
			}
		},
	});
}
