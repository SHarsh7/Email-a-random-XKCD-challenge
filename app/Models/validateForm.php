<?php
namespace app\Models;
class validateForm
{
	public function validateEmail($email)
	{
		function test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		if ($email == "") {
			$_SESSION['msg']  = "Please Enter your Email ID";
			return false;
		} else {
			//* Data sanitization
			$email = test_input($email);
			// * check if e-mail address is proper
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$_SESSION['msg'] = "Invalid email format ";
				return false;
			} else {
				return true;
			}
		}
	}
}
