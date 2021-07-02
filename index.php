<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta
  name="description"           
  content="It's basically a newsletter website which send XKCD images rather then sending news.">
	<title>XKCD Random Comic</title>
	<link rel="preload" href="./Assets/style.css" as="style"/>
	<link rel="stylesheet" href="./Assets/style.css" />
</head>

<body>
	<img class="bg" src="./Assets/Images/background.jpg" alt="" />
	<div class="login-container">
		<img  class="hero-img" src="./Assets/Images/LoginImg.jpg" alt="Can't"  loading="lazy"/>

		<div class="form-container">
			<img class="msgIcon" src="./Assets/Images/msg.png" alt=""  loading="lazy" />
			<p>Join us</p>

			<form class="formDetail" method="POST" action="register.php" onSubmit="return validateemail()">
				
					<p class="alertMsg hidden" id="msg"></p>
					<?php
					$Class = "alertMsg";
					if (isset($_SESSION['msg'])) {
						echo '<p class="' . $Class . '">' . $_SESSION["msg"] . '</p>';
					}

					?>

				<input type="email" class="email" name="email" id="email" placeholder="Enter Email" />

				<button type="submit" class="btn" id="sButton">Subscribe</button>
			</form>
			<p class="instruct"><b>Instructions:</b>After you subscribe for our product you will recieve an email contaning a link click on it and you are good to go!</p>
		</div>
	</div>
	<script src="./JS/valid.js" async></script>
</body>

</html>