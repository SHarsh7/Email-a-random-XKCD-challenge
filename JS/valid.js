function validateemail() {
	let email = document.getElementById("email").value;
	let msg = document.getElementById("msg");
	let atposition = email.indexOf("@");
	let dotposition = email.lastIndexOf(".");
	if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
		msg.classList.remove("hidden");
		msg.innerText = "Enter a valid e-mail address";
		return false;
	} else {
		msg.innerText = "";
		msg.classList.add("hidden");
		return true;
	}
}
