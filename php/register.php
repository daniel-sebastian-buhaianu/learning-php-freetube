<?php  

include 'config.php';
include 'db.php';

$error['alert'] = '';
$error['email'] = '';
$error['password'] = '';
$error['confirm_password'] = '';

$input['email'] = '';
$input['password'] = '';
$input['confirm_password'] = '';
$input['email'] = '';


if (!isset($_POST['submit']))
{
	include '../views/v_register.php';	
}
else
{

	$input['email'] = htmlentities($_POST['email'], ENT_QUOTES);
	$input['password'] = htmlentities($_POST['password'], ENT_QUOTES);
	$input['confirm_password'] = htmlentities($_POST['confirm_password'], ENT_QUOTES);

	if (!isInputValid($input['email'], $input['password'], $input['confirm_password']))
	{
		include '../views/v_register.php';	
	}
	else
	{

	}


}

function isInputValid($email, $password, $confirm_password)
{
	global $error;

	if ($email == '' || $password == '' || $confirm_password == '')
	{
		if ($email == '') { $error['email'] = 'required!'; }
		if ($password == '') { $error['password'] = 'required!'; }
		if ($confirm_password == '') { $error['confirm_password'] = 'required!'; }

		$error['alert'] = 'Please fill in required fields!';

		return false;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$error['email'] = 'invalid format';
		$error['alert'] = 'Please enter a valid email address!';

		return false;
	}

	if ($password != $confirm_password)
	{
		$error['alert'] = '[Password] and [Confirm Password] fields must be the same!';

		return false;
	}

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
	{
	    $error['alert'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';

	    return false;
	}

	return true;
}

?>