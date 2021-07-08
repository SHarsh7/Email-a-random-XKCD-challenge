function validateemail() {
	let email = document.getElementById("email").value;
	let alert = document.getElementById("alert");
	let atposition = email.indexOf("@");
	let dotposition = email.lastIndexOf(".");
	if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
		alert.innerText = "Enter a valid e-mail address";
		return false;
	} else {
		alert.innerText = "";
		return true;
	}
}
