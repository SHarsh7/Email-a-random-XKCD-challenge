<?php
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
	<meta charset='UTF-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<meta name='description' content="It's basically a newsletter website which sends webcomic rather than sending news.">
	<title>XKCD</title>

	<!-- main css -->
	<link rel='stylesheet' href='./Assets/style.css' />
</head>

<body>
	<main>
		<div class='container'>
			<!-- title -->
			<div class='title'>
				<h2>Join Us</h2>
				<div class='title-underline'></div>
			</div>
			<!-- Form-->
			<div class='form-container'>
				<div class='img-container'>
					<img src='./Assets/Images/msg.png' class='img' id='person-img' alt='' />
				</div>

				<?php
				$id = 'alert';
				if (isset($_SESSION['msg'])) {
					echo '<h4 id="' . $id . '">' . $_SESSION['msg'] . '</h4>';
				}

				?>
				<h4 id='alert'></h4>
				<form method='POST' action='register.php' onSubmit='return validateemail()'>

					<input type='email' name='email' id='email' placeholder='Enter Email' />
					<button type='submit' class='btn' id='sButton'>Subscribe</button>
				</form>

				<p class='info'>
					After you subscribe for our comic, you will receive an email (for verification) containing a link, click on it and you are good to go!
				</p>
			</div>
		</div>
	</main>
	<script src='./JS/valid.js' async></script>
</body>

</html>